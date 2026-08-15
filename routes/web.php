<?php

use Botble\Base\Facades\AdminHelper;
use App\Http\Controllers\Admin\LineFeatureController;
use App\Http\Controllers\Admin\SeoMachineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\AboutCompanyController;
use App\Http\Controllers\AllProductsController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductLandingController;
use App\Http\Controllers\Rb360LandingController;
use App\Http\Controllers\AirlessHubController;
use App\Http\Controllers\Auth\LineAuthController;
use App\Http\Controllers\HealthController;
use Illuminate\Http\Request;

// Health check route
Route::get('/health', [HealthController::class, 'check'])->name('health.check');
Route::get('/ajax/csrf-token', function (Request $request) {
    return response()->json([
        'token' => csrf_token(),
    ]);
})->name('ajax.csrf-token');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'legal.terms')->name('terms.policy');
Route::view('/return-policy', 'legal.return-policy')->name('return.policy');

// Old route pattern (you can keep this for backward compatibility)
Route::get('/promotion/{promotionName}', [PromotionController::class, 'show'])
    ->where('promotionName', 'promotion[0-9]+')
    ->name('promotion.numeric');

// New route pattern for custom slugs (accepts Thai characters, hyphens, etc.)    
Route::get('/promotions', [PromotionController::class, 'index'])->name('promotion.index');
Route::get('/promotion/{slug}', [PromotionController::class, 'show'])
    ->where('slug', '.*')
    ->name('promotion.custom');


    // New route pattern for custom slugs BlogsController    
Route::get('/blogs/{slug}', [BlogsController::class, 'show'])
    ->where('slug', '.*')
    ->name('blogs.custom');

    // New route pattern for custom slugs AboutController   
    Route::get('/aboutcompany/{slug}', [AboutCompanyController::class, 'show'])
    ->where('slug', '.*')
    ->name('aboutcompany.custom');







// Legacy category indexes. Canonical category index is /product-categories.
Route::redirect('/allproducts', '/product-categories', 301)->name('allproducts');
Route::redirect('/categories', '/product-categories', 301)->name('categories');

// Product landing pages
Route::get('/landing', [ProductLandingController::class, 'index'])->name('landing.index');
Route::get('/landing/{slug}', [ProductLandingController::class, 'show'])->name('landing.product');
Route::get('/lp/rb-360', [Rb360LandingController::class, 'show'])->name('landing.rb360.ads');
Route::get('/lp/rb-360-pro', [Rb360LandingController::class, 'show'])->name('landing.rb360.ads.pro');
Route::get('/lp/rb-360-quote', [Rb360LandingController::class, 'show'])->name('landing.rb360.ads.quote');
Route::get('/lp/rb-899-v2', [PromotionController::class, 'show'])
    ->defaults('slug', 'rb-899-v2')
    ->name('landing.rb899.v2');
Route::get('/lp/airless-sprayer-thailand', [AirlessHubController::class, 'index'])->name('lp.airless-sprayer');
Route::get('/lp/airless-sprayer-price', [AirlessHubController::class, 'priceGuide'])->name('lp.airless-price');
Route::get('/lp/drywall-sander', [App\Http\Controllers\ToolHubController::class, 'drywallSander'])->name('lp.drywall-sander');
Route::get('/lp/wall-chaser', [App\Http\Controllers\ToolHubController::class, 'wallChaser'])->name('lp.wall-chaser');
Route::get('/lp/airless-spray-gun', [App\Http\Controllers\ToolHubController::class, 'sprayGun'])->name('lp.spray-gun');
Route::get('/lp/airless-hose', [App\Http\Controllers\ToolHubController::class, 'airlessHose'])->name('lp.airless-hose');

// Catalog pages
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/page/{page}', [CatalogController::class, 'showPage'])
    ->whereNumber('page')
    ->name('catalog.page');
Route::get('/catalog/file', [CatalogController::class, 'file'])->name('catalog.file');

// Main category page (shows subcategories)
Route::get('/sub/{slug}', [AllProductsController::class, 'mainCategory'])->name('main.category');

// Individual category page (shows products)
Route::redirect('/product-categories-test/{slug}', '/product-categories/{slug}', 301)
    ->where('slug', '.*')
    ->name('legacy.product.category');
Route::redirect('/product-categories/motar-sprayer-220v-380v', '/product-categories/mortar-sprayer-220v-380v', 301)
    ->name('legacy.product.category.motar-sprayer');
Route::redirect('/blog/rb-mt9001-motar-sprayer-pre-order', '/blog/rb-mt9001-mortar-sprayer-pre-order', 301)
    ->name('legacy.blog.motar-sprayer');

// Categories overview page
Route::get('/product-categories', [AllProductsController::class, 'categories'])->name('product.categories.index');
Route::get('/product-categories/{slug}', [AllProductsController::class, 'category'])->name('product.categories.slug');

// Product detail page - product cards use Botble slug URLs such as /products/ruby-shop-rb899.
Route::redirect('/products/filter-motar-sprayer-220v', '/products/filter-mortar-sprayer-220v', 301)
    ->name('legacy.product.filter-motar-sprayer');
Route::get('/products/{slug}', [AllProductsController::class, 'show'])->name('product.detail.slug');

// Legacy product/detail and category URLs. Keep them as 301-only to avoid duplicate indexable pages.
Route::get('/allproducts/{id}', [AllProductsController::class, 'show'])->name('product.detail');
Route::redirect('/allproducts/category/{slug}', '/product-categories/{slug}', 301)
    ->where('slug', '.*')
    ->name('allproducts.category');


// Main category page (shows subcategories)
Route::redirect('/subcat2/{slug}', '/sub/{slug}', 301)
    ->where('slug', '.*')
    ->name('legacy.main.category');





// Add this route definition
Route::view('/', 'welcome')->name('home');

Route::get('auth/line', [LineAuthController::class, 'redirect'])->name('line.login');
Route::get('auth/line/callback', [LineAuthController::class, 'callback'])->name('line.callback');

AdminHelper::registerRoutes(function (): void {
    Route::group([
        'prefix' => 'line-feature',
        'as' => 'line-feature.',
        'permission' => false,
    ], function (): void {
        Route::get('/', [LineFeatureController::class, 'index'])->name('index');
    });

    Route::group([
        'prefix' => 'seo-machine',
        'as' => 'seo-machine.',
        'permission' => false,
    ], function (): void {
        Route::get('/', [SeoMachineController::class, 'index'])->name('index');
        Route::post('/run-now', [SeoMachineController::class, 'runNow'])->name('run-now');
    });
});
