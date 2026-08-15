<?php

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$options = getopt('', [
    'dry-run',
    'force',
    'limit:',
    'only-id:',
    'skip-existing',
]);

$dryRun = array_key_exists('dry-run', $options);
$force = array_key_exists('force', $options);
$skipExisting = array_key_exists('skip-existing', $options);
$limit = isset($options['limit']) ? max(1, (int) $options['limit']) : null;
$onlyId = isset($options['only-id']) ? (int) $options['only-id'] : null;

$storageRoot = realpath(__DIR__ . '/../public/storage');
$targetRoot = $storageRoot . '/products/seo';

if (! $storageRoot) {
    fwrite(STDERR, "Cannot resolve public/storage.\n");
    exit(1);
}

if (! is_dir($targetRoot) && ! $dryRun) {
    mkdir($targetRoot, 0775, true);
}

$query = DB::table('ec_products')
    ->select('id', 'name', 'sku', 'image', 'images')
    ->where('is_variation', 0)
    ->where(function ($query) {
        $query->whereNotNull('image')
            ->orWhereNotNull('images');
    })
    ->orderBy('id');

if ($onlyId) {
    $query->where('id', $onlyId);
}

if ($limit) {
    $query->limit($limit);
}

$stats = [
    'products' => 0,
    'updated' => 0,
    'images' => 0,
    'created' => 0,
    'skipped' => 0,
    'missing' => 0,
    'failed' => 0,
];

$tmpFiles = [];

register_shutdown_function(function () use (&$tmpFiles) {
    foreach ($tmpFiles as $file) {
        if (is_file($file)) {
            @unlink($file);
        }
    }
});

foreach ($query->get() as $product) {
    $stats['products']++;

    $rawImages = [];
    if ($product->image) {
        $rawImages[] = $product->image;
    }

    $decodedImages = json_decode((string) $product->images, true);
    if (is_array($decodedImages)) {
        $rawImages = array_merge($rawImages, $decodedImages);
    }

    $rawImages = array_values(array_unique(array_filter($rawImages)));

    if (! $rawImages) {
        continue;
    }

    $slug = product_seo_image_slug($product);
    $productDir = $targetRoot . '/' . $product->id;
    $productPath = 'products/seo/' . $product->id;
    $newImages = [];

    foreach ($rawImages as $index => $source) {
        $sourceFile = resolve_source_image($source, $storageRoot, $tmpFiles);

        if (! $sourceFile || ! is_file($sourceFile)) {
            $stats['missing']++;
            echo "[missing] #{$product->id} {$source}\n";
            continue;
        }

        $sourceInfo = @getimagesize($sourceFile);
        if (! $sourceInfo) {
            $stats['failed']++;
            echo "[invalid] #{$product->id} {$source}\n";
            continue;
        }

        $baseName = sprintf('%s-%02d', $slug, $index + 1);
        $mainPath = "{$productPath}/{$baseName}.webp";
        $mainFile = "{$productDir}/{$baseName}.webp";

        if ($skipExisting && is_file($mainFile)) {
            $stats['skipped']++;
            $newImages[] = $mainPath;
            continue;
        }

        if ($dryRun) {
            echo "[dry] #{$product->id} {$source} -> {$mainPath}\n";
            $newImages[] = $mainPath;
            $stats['created'] += 4;
            continue;
        }

        if (! is_dir($productDir)) {
            mkdir($productDir, 0775, true);
        }

        if (is_file($mainFile) && ! $force) {
            $newImages[] = $mainPath;
            $stats['skipped']++;
            continue;
        }

        $variants = [
            '' => [1200, 1200, 82],
            '-800x800' => [800, 800, 82],
            '-400x400' => [400, 400, 82],
            '-150x150' => [150, 150, 80],
        ];

        foreach ($variants as $suffix => [$width, $height, $quality]) {
            $destFile = "{$productDir}/{$baseName}{$suffix}.webp";
            if (is_file($destFile) && ! $force) {
                continue;
            }

            if (! create_webp_variant($sourceFile, $destFile, $width, $height, $quality)) {
                $stats['failed']++;
                echo "[failed] #{$product->id} {$source} -> {$destFile}\n";
                continue 2;
            }

            $stats['created']++;
        }

        $newImages[] = $mainPath;
        $stats['images']++;
    }

    $newImages = array_values(array_unique($newImages));

    if (! $newImages) {
        continue;
    }

    if (! $dryRun) {
        DB::table('ec_products')
            ->where('id', $product->id)
            ->update([
                'image' => $newImages[0],
                'images' => json_encode($newImages, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
                'updated_at' => now(),
            ]);
    }

    $stats['updated']++;
    echo "[updated] #{$product->id} {$product->name} images=" . count($newImages) . "\n";
}

echo "\nDone\n";
foreach ($stats as $key => $value) {
    echo "{$key}: {$value}\n";
}

function product_seo_image_slug(object $product): string
{
    $slug = DB::table('slugs')
        ->where('reference_type', 'Botble\\Ecommerce\\Models\\Product')
        ->where('reference_id', $product->id)
        ->value('key');

    $base = $slug ?: $product->sku ?: $product->name ?: ('product-' . $product->id);
    $base = Str::slug(str_replace(['|', ':', '/', '\\'], ' ', $base));

    $base = trim($base) !== '' ? $base : 'rubyshop-product-' . $product->id;

    return Str::limit($base, 150, '');
}

function resolve_source_image(string $source, string $storageRoot, array &$tmpFiles): ?string
{
    $source = trim($source);

    if (Str::startsWith($source, ['http://', 'https://'])) {
        return download_source_image($source, $tmpFiles);
    }

    $source = preg_replace('#^/?storage/#', '', $source);
    $source = ltrim($source, '/');

    $candidates = [
        $storageRoot . '/' . $source,
    ];

    $pathInfo = pathinfo($source);
    if (! empty($pathInfo['dirname']) && ! empty($pathInfo['filename'])) {
        $dirname = $pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'] . '/';
        $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
        foreach (['-800x800', '-400x400', '-150x150'] as $suffix) {
            $candidates[] = $storageRoot . '/' . $dirname . preg_replace('/' . preg_quote($suffix, '/') . '$/', '', $pathInfo['filename']) . $extension;
        }
    }

    foreach (array_unique($candidates) as $candidate) {
        if (is_file($candidate)) {
            return $candidate;
        }
    }

    return null;
}

function download_source_image(string $url, array &$tmpFiles): ?string
{
    $tmpFile = tempnam(sys_get_temp_dir(), 'rubyshop-product-image-');
    $tmpFiles[] = $tmpFile;

    $context = stream_context_create([
        'http' => [
            'timeout' => 20,
            'follow_location' => true,
            'ignore_errors' => true,
            'header' => "User-Agent: RubyshopImageSeo/1.0\r\n",
        ],
    ]);

    $content = @file_get_contents($url, false, $context);
    if (! $content) {
        return null;
    }

    file_put_contents($tmpFile, $content);

    return $tmpFile;
}

function create_webp_variant(string $sourceFile, string $destFile, int $width, int $height, int $quality): bool
{
    $source = escapeshellarg($sourceFile);
    $dest = escapeshellarg($destFile);
    $cmd = "convert {$source} -auto-orient -strip -resize {$width}x{$height}\\> -background white -gravity center -extent {$width}x{$height} -quality {$quality} {$dest} 2>&1";
    exec($cmd, $output, $exitCode);

    return $exitCode === 0 && is_file($destFile) && filesize($destFile) > 0;
}
