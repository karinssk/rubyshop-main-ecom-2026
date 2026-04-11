<?php

use Botble\Base\Facades\AdminHelper;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Wowy\Http\Controllers\Admin\ProductLandingBuilderController;
use Theme\Wowy\Http\Controllers\Admin\ProductSortController;
use Theme\Wowy\Http\Controllers\WowyController;

Theme::registerRoutes(function (): void {
    Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.', 'controller' => WowyController::class], function (): void {
        Route::get('cart', 'ajaxCart')
            ->name('cart');

        Route::get('quick-view/{id}', 'getQuickView')
            ->name('quick-view')
            ->wherePrimaryKey();

        Route::get('products-by-collection/{id}', 'ajaxGetProductsByCollection')
            ->name('products-by-collection')
            ->wherePrimaryKey();

        Route::get('products-by-category/{id}', 'ajaxGetProductsByCategory')
            ->name('products-by-category')
            ->wherePrimaryKey();

        Route::get('search-products', 'ajaxSearchProducts')
            ->name('search-products');
    });
});

AdminHelper::registerRoutes(function (): void {
    Route::group(['prefix' => 'ecommerce', 'as' => 'ecommerce.'], function (): void {
        Route::get('product-sort/products', [
            'as' => 'product-sort.products.index',
            'uses' => ProductSortController::class . '@productsIndex',
            'permission' => 'products.edit',
        ]);

        Route::post('product-sort/products', [
            'as' => 'product-sort.products.update',
            'uses' => ProductSortController::class . '@productsUpdate',
            'permission' => 'products.edit',
        ]);

        Route::get('product-sort/categories', [
            'as' => 'product-sort.categories.index',
            'uses' => ProductSortController::class . '@categoriesIndex',
            'permission' => 'products.edit',
        ]);

        Route::post('product-sort/categories', [
            'as' => 'product-sort.categories.update',
            'uses' => ProductSortController::class . '@categoriesUpdate',
            'permission' => 'products.edit',
        ]);

        Route::get('landing-builder', [
            'as' => 'landing-builder.index',
            'uses' => ProductLandingBuilderController::class . '@index',
            'permission' => 'products.edit',
        ]);

        Route::post('landing-builder/{product}', [
            'as' => 'landing-builder.update',
            'uses' => ProductLandingBuilderController::class . '@update',
            'permission' => 'products.edit',
        ])->wherePrimaryKey();
    });
});

Theme::routes();
