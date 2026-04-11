<?php

use Botble\Base\Facades\AdminHelper;
use App\Http\Controllers\Admin\LineFeatureController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\AboutCompanyController;
use App\Http\Controllers\AllProductsController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductLandingController;
use App\Http\Controllers\Auth\LineAuthController;
use App\Http\Controllers\HealthController;

// Health check route
Route::get('/health', [HealthController::class, 'check'])->name('health.check');
Route::view('/privacy-policy', 'legal.privacy-policy')->name('privacy.policy');
Route::view('/terms-of-service', 'legal.terms')->name('terms.policy');
Route::view('/return-policy', 'legal.return-policy')->name('return.policy');

// Old route pattern (you can keep this for backward compatibility)
Route::get('/promotion/{promotionName}', [PromotionController::class, 'show'])
    ->where('promotionName', 'promotion[0-9]+')
    ->name('promotion.numeric');

// New route pattern for custom slugs (accepts Thai characters, hyphens, etc.)    
Route::get('/promotion/{slug}', [PromotionController::class, 'show'])
    ->where('slug', '.*')
    ->name('promotion.custom');


    // New route pattern for custom slugs BlogsController    
Route::get('/blogs/{slug}', [BlogsController::class, 'show'])
    ->where('slug', '.*')
    ->name('blogs.custom');

    // New route pattern for custom slugs AboutController   
    Route::get('/aboutcompany/{slug}', [AboutCompanyController::class, 'show'])
    ->where('aboutcompany', '.*')
    ->name('aboutcompany.custom');







// All products listing page
Route::get('/allproducts', [AllProductsController::class, 'index'])->name('allproducts');

// All categories page
Route::get('/categories', [AllProductsController::class, 'categories'])->name('categories');

// Product landing pages
Route::get('/landing', [ProductLandingController::class, 'index'])->name('landing.index');
Route::get('/landing/{slug}', [ProductLandingController::class, 'show'])->name('landing.product');

// Catalog pages
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/page/{page}', [CatalogController::class, 'showPage'])
    ->whereNumber('page')
    ->name('catalog.page');
Route::get('/catalog/file', [CatalogController::class, 'file'])->name('catalog.file');

// Main category page (shows subcategories)
Route::get('/sub/{slug}', [AllProductsController::class, 'mainCategory'])->name('main.category');

// Individual category page (shows products)
Route::get('/product-categories-test/{slug}', [AllProductsController::class, 'category'])->name('product.category');

// Categories overview page
Route::get('/product-categories', [AllProductsController::class, 'categories'])->name('product.categories.index');

// Product detail page - use slug
// Route::get('/products/{slug}', [AllProductsController::class, 'show'])->name('product.detail');




// All products listing page
Route::get('/allproducts', [AllProductsController::class, 'index'])->name('allproducts');

// Product detail page - use your existing controller/route

Route::get('/allproducts/{id}', [AllProductsController::class, 'show'])->name('product.detail');
// Add this route for category pages
Route::get('/allproducts/category/{slug}', [AllProductsController::class, 'category'])->name('allproducts.category');


// Main category page (shows subcategories)
Route::get('/subcat2/{slug}', [AllProductsController::class, 'mainCategory'])->name('main.category');





// Add this route definition
Route::get('/', function () {
    return view('welcome');
})->name('home');

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
});
