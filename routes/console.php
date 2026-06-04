<?php

use App\Support\SeoAutoPostService;
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

Artisan::command('seo:ai-publish {--file= : Path to JSON payload file}', function () {
    $file = $this->option('file');
    if (!$file || !file_exists($file)) {
        $this->error('File not found: ' . $file);
        return 1;
    }

    $payload = json_decode(file_get_contents($file), true);
    if (!is_array($payload)) { $this->error('Invalid JSON'); return 1; }

    $productId   = (int) ($payload['product_id'] ?? 0);
    $title       = trim($payload['title'] ?? '');
    $content     = trim($payload['content'] ?? '');
    $description = \Illuminate\Support\Str::limit($payload['description'] ?? $title, 160);
    $image       = $payload['image'] ?? null;

    if (!$productId || !$title || !$content) { $this->error('Missing fields'); return 1; }

    $exists = DB::table('seo_machine_post_histories')->where('product_id', $productId)->exists();
    if ($exists) { $this->line(json_encode(['status'=>'skipped'])); return 0; }

    $result = DB::transaction(function () use ($productId, $title, $content, $description, $image) {
        $postId = DB::table('posts')->insertGetId([
            'name'=>$title, 'description'=>$description, 'content'=>$content,
            'image'=>$image, 'is_featured'=>false, 'status'=>'published',
            'author_id'=>1, 'author_type'=>'Botble\ACL\Models\User',
            'views'=>0, 'format_type'=>null, 'created_at'=>now(), 'updated_at'=>now(),
        ]);
        $slug = \Illuminate\Support\Str::slug($title);
        DB::table('slugs')->insert([
            'key'=>$slug, 'reference_id'=>$postId,
            'reference_type'=>'Botble\Blog\Models\Post',
            'prefix'=>'blog', 'created_at'=>now(), 'updated_at'=>now(),
        ]);
        $cat = DB::table('categories')->where('status','published')->orderByDesc('is_default')->orderBy('id')->first();
        if ($cat) DB::table('post_categories')->insert(['post_id'=>$postId,'category_id'=>$cat->id]);
        return ['post_id'=>$postId, 'slug'=>$slug];
    });

    $product = DB::table('ec_products')->where('id',$productId)->first(['name']);
    DB::table('seo_machine_post_histories')->insert([
        'product_id'=>$productId, 'post_id'=>$result['post_id'],
        'product_name'=>(string)($product->name ?? ''), 'product_slug'=>'',
        'published_at'=>now(), 'created_at'=>now(), 'updated_at'=>now(),
    ]);

    $url = config('app.url') . '/' . $result['slug'];
    $this->line(json_encode(['status'=>'published','post_id'=>$result['post_id'],'url'=>$url]));
})->purpose('Publish AI-generated blog post from local-ai agent');


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
        ->orderByDesc('pr.id')
        ->first(['pr.id','pr.name','pr.description','pr.content','pr.image','pr.images','pr.price','pr.sale_price','s.key as slug']);
    echo $p ? json_encode($p) : 'null';
})->purpose('Get next product for AI content generation');
