<?php

use App\Support\SeoAutoPostService;
use App\Support\PosStockSyncService;
use Botble\Blog\Models\Category;
use Botble\Blog\Models\Post;
use Botble\Setting\Facades\Setting;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('seo:auto-post {--count=1} {--dry-run}', function (SeoAutoPostService $service) {
    $count = max(1, (int) $this->option('count'));
    $dryRun = (bool) $this->option('dry-run');

    $this->info(sprintf('Running seo:auto-post count=%d dryRun=%s', $count, $dryRun ? 'true' : 'false'));

    $results = $service->run($count, $dryRun);

    foreach ($results as $row) {
        if ($row['status'] === 'published') {
            $this->line(sprintf(
                'Published: product #%d -> post #%d (%s)',
                $row['product_id'],
                $row['post_id'],
                $row['post_url']
            ));
        } elseif ($row['status'] === 'dry-run') {
            $this->line(sprintf('Dry-run pick: product #%d %s', $row['product_id'], $row['product_name']));
        } else {
            $this->warn($row['message']);
        }
    }
})->purpose('Create blog posts from unpublished products with dedupe protection');

Artisan::command('seo:fix-blog-root-path', function () {
    $postKey = SlugHelper::getPermalinkSettingKey(Post::class);
    $categoryKey = SlugHelper::getPermalinkSettingKey(Category::class);

    Setting::set($postKey, '');
    Setting::set($categoryKey, '');
    Setting::save();

    $updated = DB::table('slugs')
        ->whereIn('reference_type', [Post::class, Category::class])
        ->update(['prefix' => '', 'updated_at' => now()]);

    $this->info("Done. Updated {$updated} slug row(s) to root path.");
    $this->line('Blog post URL format is now: /{slug}');
})->purpose('Force blog URLs to root path (no /blog prefix)');

Schedule::command('seo:auto-post --count=' . (int) env('SEO_AUTO_POST_DAILY_COUNT', 1))
    ->dailyAt((string) env('SEO_AUTO_POST_DAILY_AT', '02:10'))
    ->withoutOverlapping()
    ->runInBackground();

Artisan::command('pos:sync-stock
    {file : CSV file from POS}
    {--apply : Update ecommerce stock. Without this option it only previews changes.}
    {--source=default : POS source name}
    {--name-column=name : CSV column that contains POS product name}
    {--quantity-column=quantity : CSV column that contains stock quantity}
    {--pos-id-column=pos_id : Optional CSV column that contains POS product id/code}', function (PosStockSyncService $service) {
    $stats = $service->syncFromCsv((string) $this->argument('file'), [
        'apply' => (bool) $this->option('apply'),
        'source' => (string) $this->option('source'),
        'name_column' => (string) $this->option('name-column'),
        'quantity_column' => (string) $this->option('quantity-column'),
        'pos_id_column' => (string) $this->option('pos-id-column'),
    ]);

    $this->info(sprintf(
        'POS stock sync %s: rows=%d mapped=%d %s=%d skipped=%d',
        $stats['apply'] ? 'applied' : 'dry-run',
        $stats['rows'],
        $stats['mapped'],
        $stats['apply'] ? 'updated' : 'would_update',
        $stats['updated'],
        $stats['skipped']
    ));

    $preview = array_slice($stats['changes'], 0, 20);
    if ($preview) {
        $this->table(
            ['line', 'product_id', 'old_qty', 'new_qty', 'old_status', 'new_status', 'product_name'],
            array_map(fn (array $row) => [
                $row['line'],
                $row['product_id'],
                $row['old_quantity'],
                $row['new_quantity'],
                $row['old_status'],
                $row['new_status'],
                $row['product_name'],
            ], $preview)
        );
    }

    if (count($stats['changes']) > count($preview)) {
        $this->line(sprintf('... %d more change(s)', count($stats['changes']) - count($preview)));
    }

    if ($stats['errors']) {
        $this->warn('Skipped rows:');
        $this->table(
            ['line', 'name', 'reason'],
            array_map(fn (array $row) => [
                $row['line'] ?? '',
                $row['name'] ?? '',
                $row['reason'] ?? '',
            ], array_slice($stats['errors'], 0, 30))
        );
    }

    if (! $stats['apply']) {
        $this->comment('Dry-run only. Add --apply to update stock and save POS mappings.');
    }
})->purpose('Sync ecommerce stock from POS CSV by saved mapping, with first-time exact normalized name matching');

Artisan::command('pos:sync-stock-db
    {--database=shop_rubyshop_pos : UltimatePOS database name}
    {--apply : Update ecommerce stock. Without this option it only previews changes.}
    {--source= : Mapping source name. Defaults to ultimatepos:{database}.}', function (PosStockSyncService $service) {
    $database = (string) $this->option('database');
    $source = (string) ($this->option('source') ?: 'ultimatepos:' . $database);

    $stats = $service->syncFromUltimatePosDatabase($database, [
        'apply' => (bool) $this->option('apply'),
        'source' => $source,
    ]);

    $this->info(sprintf(
        'POS DB stock sync %s: database=%s rows=%d mapped=%d %s=%d skipped=%d',
        $stats['apply'] ? 'applied' : 'dry-run',
        $database,
        $stats['rows'],
        $stats['mapped'],
        $stats['apply'] ? 'updated' : 'would_update',
        $stats['updated'],
        $stats['skipped']
    ));

    $preview = array_slice($stats['changes'], 0, 25);
    if ($preview) {
        $this->table(
            ['line', 'product_id', 'old_qty', 'new_qty', 'old_status', 'new_status', 'product_name'],
            array_map(fn (array $row) => [
                $row['line'],
                $row['product_id'],
                $row['old_quantity'],
                $row['new_quantity'],
                $row['old_status'],
                $row['new_status'],
                $row['product_name'],
            ], $preview)
        );
    }

    if (count($stats['changes']) > count($preview)) {
        $this->line(sprintf('... %d more change(s)', count($stats['changes']) - count($preview)));
    }

    if ($stats['errors']) {
        $this->warn('Skipped rows:');
        $this->table(
            ['line', 'name', 'reason'],
            array_map(fn (array $row) => [
                $row['line'] ?? '',
                $row['name'] ?? '',
                $row['reason'] ?? '',
            ], array_slice($stats['errors'], 0, 40))
        );
    }

    if (! $stats['apply']) {
        $this->comment('Dry-run only. Add --apply to update ecommerce stock and save POS mappings.');
    }
})->purpose('Sync ecommerce stock directly from UltimatePOS database');

Artisan::command('pos:sync-stock-sma-db
    {--database=rubyshop_co_th_sale_pos : Stock Manager Advance database name}
    {--apply : Update ecommerce stock. Without this option it only previews changes.}
    {--source= : Mapping source name. Defaults to sma:{database}.}', function (PosStockSyncService $service) {
    $database = (string) $this->option('database');
    $source = (string) ($this->option('source') ?: 'sma:' . $database);

    $stats = $service->syncFromSmaDatabase($database, [
        'apply' => (bool) $this->option('apply'),
        'source' => $source,
    ]);

    $this->info(sprintf(
        'SMA POS DB stock sync %s: database=%s rows=%d mapped=%d %s=%d skipped=%d',
        $stats['apply'] ? 'applied' : 'dry-run',
        $database,
        $stats['rows'],
        $stats['mapped'],
        $stats['apply'] ? 'updated' : 'would_update',
        $stats['updated'],
        $stats['skipped']
    ));

    $preview = array_slice($stats['changes'], 0, 25);
    if ($preview) {
        $this->table(
            ['line', 'product_id', 'old_qty', 'new_qty', 'old_status', 'new_status', 'product_name'],
            array_map(fn (array $row) => [
                $row['line'],
                $row['product_id'],
                $row['old_quantity'],
                $row['new_quantity'],
                $row['old_status'],
                $row['new_status'],
                $row['product_name'],
            ], $preview)
        );
    }

    if (count($stats['changes']) > count($preview)) {
        $this->line(sprintf('... %d more change(s)', count($stats['changes']) - count($preview)));
    }

    if ($stats['errors']) {
        $this->warn('Skipped rows:');
        $this->table(
            ['line', 'name', 'reason'],
            array_map(fn (array $row) => [
                $row['line'] ?? '',
                $row['name'] ?? '',
                $row['reason'] ?? '',
            ], array_slice($stats['errors'], 0, 40))
        );
    }

    if (! $stats['apply']) {
        $this->comment('Dry-run only. Add --apply to update ecommerce stock and save POS mappings.');
    }
})->purpose('Sync ecommerce stock directly from Stock Manager Advance POS database');

if (env('POS_STOCK_SYNC_FILE')) {
    Schedule::command(sprintf(
        'pos:sync-stock %s --apply --source=%s --name-column=%s --quantity-column=%s --pos-id-column=%s',
        escapeshellarg((string) env('POS_STOCK_SYNC_FILE')),
        escapeshellarg((string) env('POS_STOCK_SYNC_SOURCE', 'default')),
        escapeshellarg((string) env('POS_STOCK_SYNC_NAME_COLUMN', 'name')),
        escapeshellarg((string) env('POS_STOCK_SYNC_QUANTITY_COLUMN', 'quantity')),
        escapeshellarg((string) env('POS_STOCK_SYNC_POS_ID_COLUMN', 'pos_id'))
    ))
        ->everyFifteenMinutes()
        ->withoutOverlapping()
        ->runInBackground();
}

Artisan::command('seo:ai-publish {--file= : Path to JSON payload file}', function () {
    $file = $this->option('file');
    if (!$file || !file_exists($file)) {
        $this->error('File not found: ' . $file);
        return 1;
    }

    $payload = json_decode(file_get_contents($file), true);
    if (!is_array($payload)) { $this->error('Invalid JSON'); return 1; }

    $productId    = (int) ($payload['product_id'] ?? 0);
    $title        = trim($payload['title'] ?? '');
    $content      = trim($payload['content'] ?? '');
    $description  = \Illuminate\Support\Str::limit($payload['description'] ?? $title, 160);
    $image        = $payload['image'] ?? null;
    $seoTitle     = trim($payload['seo_title'] ?? $title);
    $seoDesc      = trim($payload['seo_description'] ?? $description);
    $focusKeyword = trim($payload['focus_keyword'] ?? '');
    $categoryHint = trim($payload['category'] ?? '');

    if (!$productId || !$title || !$content) { $this->error('Missing fields'); return 1; }

    $exists = DB::table('seo_machine_post_histories')->where('product_id', $productId)->exists();
    if ($exists) { $this->line(json_encode(['status' => 'skipped'])); return 0; }

    $result = DB::transaction(function () use ($productId, $title, $content, $description, $image, $seoTitle, $seoDesc, $focusKeyword, $categoryHint) {
        $postId = DB::table('posts')->insertGetId([
            'name'        => $title,
            'description' => $description,
            'content'     => $content,
            'image'       => $image,
            'is_featured' => false,
            'status'      => 'published',
            'author_id'   => 1,
            'author_type' => 'Botble\ACL\Models\User',
            'views'       => 0,
            'format_type' => null,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        // Blog slug with /blog/ prefix
        $slug = \Illuminate\Support\Str::slug($title);
        DB::table('slugs')->insert([
            'key'            => $slug,
            'reference_id'   => $postId,
            'reference_type' => 'Botble\Blog\Models\Post',
            'prefix'         => 'blog',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // SEO meta: title, description, index
        $seoMeta = json_encode([[
            'seo_title'       => $seoTitle,
            'seo_description' => $seoDesc,
            'index'           => 'index',
        ]]);
        DB::table('meta_boxes')->insert([
            'meta_key'       => 'seo_meta',
            'meta_value'     => $seoMeta,
            'reference_id'   => $postId,
            'reference_type' => 'Botble\Blog\Models\Post',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Focus keyword (stored as separate meta)
        if ($focusKeyword) {
            DB::table('meta_boxes')->insert([
                'meta_key'       => 'focus_keyword',
                'meta_value'     => json_encode([$focusKeyword]),
                'reference_id'   => $postId,
                'reference_type' => 'Botble\Blog\Models\Post',
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }

        // time_to_read placeholder
        DB::table('meta_boxes')->insert([
            'meta_key'       => 'time_to_read',
            'meta_value'     => json_encode([null]),
            'reference_id'   => $postId,
            'reference_type' => 'Botble\Blog\Models\Post',
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // Assign category — match by hint keywords, fallback to เครื่องมือช่าง-Tools
        $cat = null;
        if ($categoryHint) {
            $keywords = preg_split('/[\s\-\/]+/u', mb_strtolower($categoryHint));
            $allCats  = DB::table('categories')->where('status', 'published')->get(['id', 'name']);
            $best     = null;
            $bestScore = 0;
            foreach ($allCats as $c) {
                $catName = mb_strtolower($c->name);
                $score   = 0;
                foreach ($keywords as $kw) {
                    if (mb_strlen($kw) >= 2 && mb_strpos($catName, $kw) !== false) {
                        $score++;
                    }
                }
                if ($score > $bestScore) { $bestScore = $score; $best = $c; }
            }
            $cat = ($bestScore > 0) ? $best : null;
        }
        // fallback: เครื่องมือช่าง-Tools (#7) or first published category
        if (!$cat) {
            $cat = DB::table('categories')->where('status', 'published')
                ->where('name', 'like', '%เครื่องมือช่าง%')->first()
                ?? DB::table('categories')->where('status', 'published')->orderBy('id')->first();
        }
        if ($cat) {
            DB::table('post_categories')->insert(['post_id' => $postId, 'category_id' => $cat->id]);
        }

        return ['post_id' => $postId, 'slug' => $slug];
    });

    $product = DB::table('ec_products')->where('id', $productId)->first(['name']);
    DB::table('seo_machine_post_histories')->insert([
        'product_id'   => $productId,
        'post_id'      => $result['post_id'],
        'product_name' => (string) ($product->name ?? ''),
        'product_slug' => '',
        'published_at' => now(),
        'created_at'   => now(),
        'updated_at'   => now(),
    ]);

    $url = config('app.url') . '/blog/' . $result['slug'];
    $this->line(json_encode([
        'status'   => 'published',
        'post_id'  => $result['post_id'],
        'url'      => $url,
        'product'  => (string) ($product->name ?? ''),
        'score'    => $payload['score'] ?? null,
    ]));
})->purpose('Publish AI-generated blog post from local-ai agent');


Artisan::command('seo:get-post {id}', function () {
    $post = DB::table('posts as p')
        ->leftJoin('slugs as s', function($j){
            $j->on('s.reference_id','=','p.id')
              ->where('s.reference_type','Botble\Blog\Models\Post');
        })
        ->where('p.id', (int)$this->argument('id'))
        ->first(['p.id','p.name','p.description','p.content','p.image','s.key as slug']);
    echo $post ? json_encode($post) : 'null';
})->purpose('Get existing blog post data for AI rewrite');


Artisan::command('seo:find-product {term}', function () {
    $term = $this->argument('term');
    $p = DB::table('ec_products as pr')
        ->leftJoin('slugs as s', function($j){
            $j->on('s.reference_id','=','pr.id')
              ->where('s.reference_type','Botble\Ecommerce\Models\Product');
        })
        ->where('pr.status','published')
        ->where('pr.is_variation',0)
        ->where(function($q) use ($term){
            $q->where('pr.name','like',"%{$term}%")
              ->orWhere('pr.description','like',"%{$term}%");
        })
        ->orderByDesc('pr.price')
        ->first(['pr.id','pr.name','pr.description','pr.content','pr.image','pr.images','pr.price','pr.sale_price','s.key as slug']);
    echo $p ? json_encode($p) : 'null';
})->purpose('Find product by search term for AI fix');


Artisan::command('seo:ai-fix-post {--file= : Path to JSON payload}', function () {
    $file = $this->option('file');
    if (!$file || !file_exists($file)) { $this->error('File not found'); return 1; }

    $payload = json_decode(file_get_contents($file), true);
    if (!is_array($payload)) { $this->error('Invalid JSON'); return 1; }

    $postId       = (int)($payload['post_id'] ?? 0);
    $content      = trim($payload['content'] ?? '');
    $description  = \Illuminate\Support\Str::limit(trim($payload['description'] ?? ''), 160);
    $image        = $payload['image'] ?? null;
    $seoTitle     = trim($payload['seo_title'] ?? '');
    $seoDesc      = trim($payload['seo_description'] ?? $description);
    $focusKeyword = trim($payload['focus_keyword'] ?? '');

    if (!$postId) { $this->error('Missing post_id'); return 1; }

    $update = ['updated_at' => now()];
    if ($content)     $update['content']     = $content;
    if ($description) $update['description'] = $description;
    if ($image)       $update['image']       = $image;

    DB::table('posts')->where('id', $postId)->update($update);

    // Upsert seo_meta
    if ($seoTitle || $seoDesc) {
        $seoMeta = json_encode([['seo_title' => $seoTitle, 'seo_description' => $seoDesc, 'index' => 'index']]);
        $exists = DB::table('meta_boxes')
            ->where('reference_id',$postId)->where('reference_type','Botble\Blog\Models\Post')
            ->where('meta_key','seo_meta')->exists();
        if ($exists) {
            DB::table('meta_boxes')
                ->where('reference_id',$postId)->where('reference_type','Botble\Blog\Models\Post')
                ->where('meta_key','seo_meta')
                ->update(['meta_value'=>$seoMeta,'updated_at'=>now()]);
        } else {
            DB::table('meta_boxes')->insert([
                'meta_key'=>'seo_meta','meta_value'=>$seoMeta,
                'reference_id'=>$postId,'reference_type'=>'Botble\Blog\Models\Post',
                'created_at'=>now(),'updated_at'=>now(),
            ]);
        }
    }

    // Upsert focus_keyword
    if ($focusKeyword) {
        DB::table('meta_boxes')
            ->where('reference_id',$postId)->where('reference_type','Botble\Blog\Models\Post')
            ->where('meta_key','focus_keyword')->delete();
        DB::table('meta_boxes')->insert([
            'meta_key'=>'focus_keyword','meta_value'=>json_encode([$focusKeyword]),
            'reference_id'=>$postId,'reference_type'=>'Botble\Blog\Models\Post',
            'created_at'=>now(),'updated_at'=>now(),
        ]);
    }

    $slug = DB::table('slugs')->where('reference_id',$postId)
        ->where('reference_type','Botble\Blog\Models\Post')->value('key');
    $url  = config('app.url').'/blog/'.($slug ?? '');
    $this->line(json_encode(['status'=>'fixed','post_id'=>$postId,'url'=>$url]));
})->purpose('Update existing blog post with AI-improved content');


Artisan::command('seo:next-product', function () {
    $p = DB::table('ec_products as pr')
        ->leftJoin('slugs as s', function($j) {
            $j->on('s.reference_id', '=', 'pr.id')
               ->where('s.reference_type', 'Botble\Ecommerce\Models\Product');
        })
        ->where('pr.status', 'published')
        ->where('pr.is_variation', 0)
        ->whereNotExists(function($q) {
            $q->selectRaw('1')
              ->from('seo_machine_post_histories as h')
              ->whereColumn('h.product_id', 'pr.id');
        })
        ->orderByDesc('pr.price')
        ->first(['pr.id','pr.name','pr.description','pr.content','pr.image','pr.images','pr.price','pr.sale_price','s.key as slug']);
    echo $p ? json_encode($p) : 'null';
})->purpose('Get next product for AI content generation');
