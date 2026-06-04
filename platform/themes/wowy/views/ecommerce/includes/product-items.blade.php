@php
    $layout = theme_option('product_list_layout');

    $requestLayout = request()->input('layout');
    if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
        $layout = $requestLayout;
    }

    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';
@endphp
<style>
    .product-grid,
    .products-listing .product-grid {
        width: 100%;
        margin: 0 !important;
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    .product-grid > div[class*="col-"] {
        width: 100% !important;
        max-width: 100% !important;
        padding-right: 0 !important;
        padding-left: 0 !important;
        margin-bottom: 0 !important;
        min-width: 0 !important;
    }

    .product-grid + .ruby-global-loader,
    .shop-product-filter {
        display: flex;
        align-items: center;
        flex-wrap: nowrap;
        gap: 8px;
        margin-bottom: 16px;
    }

    .shop-product-filter {
        justify-content: space-between;
    }

    .shop-product-filter .total-product {
        flex: 1 1 auto;
        min-width: 0;
    }

    .shop-product-filter .total-product p,
    .shop-product-filter .total-product strong,
    .shop-product-filter .total-product span {
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 991px) {
        .product-grid,
        .products-listing .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }
    }

    @media (max-width: 767px) {
        .product-grid,
        .products-listing .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px;
            min-width: 0 !important;
        }

        .product-grid > div[class*="col-"] {
            padding-right: 0 !important;
            padding-left: 0 !important;
        }

        .shop-product-filter {
            gap: 10px;
            flex-wrap: nowrap;
            align-items: center;
        }

        .shop-product-filter .total-product {
            white-space: nowrap;
            min-width: 0;
        }

        .shop-product-filter .total-product p {
            display: block;
            line-height: 1.35;
        }
    }
</style>

<div class="list-content-loading">
    <div class="ruby-global-loader loader" role="status"></div>
</div>

@if($products->isNotEmpty())
    <div class="shop-product-filter">
        <div class="total-product">
            <p>{!! BaseHelper::clean(__('We found :total items for you!', ['total' => '<strong class="text-brand">' . $products->total() . '</strong>'])) !!}</p>
        </div>
        @include(Theme::getThemeNamespace() . '::views/ecommerce/includes/sort')
    </div>
@endif

<input type="hidden" name="page" data-value="{{ $products->currentPage() }}">
<input type="hidden" name="sort-by" value="{{ BaseHelper::stringify(request()->input('sort-by')) }}">
<input type="hidden" name="num" value="{{ BaseHelper::stringify(request()->input('num')) }}">
<input type="hidden" name="q" value="{{ BaseHelper::stringify(request()->input('q')) }}">

<div class="row product-grid">
    @forelse ($products as $product)
        <div class="@if($layout === 'product-full-width') col-xxl-3 col-xl-3 @endif col-lg-4 col-md-4 col-6 col-sm-6">
            @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
        </div>
    @empty
        <div class="mt__60 mb__60 text-center">
            <p>{{ __('No products found!') }}</p>
        </div>
    @endforelse
</div>

@if ($products->hasPages())
    <br>
    {!! $products->withQueryString()->links(Theme::getThemeNamespace() . '::partials.custom-pagination') !!}
@endif
