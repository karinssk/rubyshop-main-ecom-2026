@php
    $layout = theme_option('product_list_layout');

    $requestLayout = BaseHelper::stringify(request()->input('layout'));
    if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
        $layout = $requestLayout;
    }

    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';

    Theme::layout('full-width');

    $products->loadMissing(['categories', 'categories.slugable']);

    $categoryBreadcrumbStructuredData = null;
    $categoryDescriptionText = '';
    $currentListingUrl = url()->current();
    $listingPageTitle = __('Products');
    $listingPageDescription = trim(strip_tags((string) SeoHelper::getDescription()));

    if (isset($category) && $category) {
        $listingPageTitle = $category->name;
        $categoryDescriptionText = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags((string) $category->description), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
        $currentSeoDescription = trim(strip_tags((string) SeoHelper::getDescription()));
        $genericSeoDescription = $currentSeoDescription === ''
            || mb_strlen($currentSeoDescription) < 70
            || \Illuminate\Support\Str::contains($currentSeoDescription, [
                'ศูนย์รวมเครื่องมือช่าง',
                'อุปกรณ์ก่อสร้าง และเทคโนโลยีงานช่างครบวงจร',
                'ผู้นำเข้าจัดหาเครื่องมือสำหรับช่างมืออาชีพ',
                'เครื่องพ่นสีกันไฟ',
                'เครื่องตีเส้นถนน',
            ]);

        if ($genericSeoDescription) {
            $categoryFallbackDesc = $categoryDescriptionText
                ? \Illuminate\Support\Str::limit($categoryDescriptionText, 160, '')
                : 'เลือกซื้อ ' . $category->name . ' จาก RUBYSHOP พร้อมสินค้าและอะไหล่สำหรับช่างมืออาชีพ จัดส่งทั่วไทย ให้คำแนะนำก่อนซื้อและบริการหลังการขาย';
            SeoHelper::setDescription($categoryFallbackDesc);
        }

        $categoryBreadcrumbStructuredData = [
            '@type' => 'BreadcrumbList',
            '@id' => $category->url . '#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => __('Home'),
                    'item' => route('public.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => __('Products'),
                    'item' => route('public.products'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $category->name,
                    'item' => $category->url,
                ],
            ],
        ];
    } else {
        $categoryBreadcrumbStructuredData = [
            '@type' => 'BreadcrumbList',
            '@id' => $currentListingUrl . '#breadcrumb',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => __('Home'),
                    'item' => route('public.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => __('Products'),
                    'item' => $currentListingUrl,
                ],
            ],
        ];
    }

    $listingPageDescription = trim(strip_tags((string) SeoHelper::getDescription()));
    $listingProducts = collect(method_exists($products, 'items') ? $products->items() : $products)->filter();
    $listingFirstPosition = method_exists($products, 'firstItem') && $products->firstItem() ? (int) $products->firstItem() : 1;
    $merchantReturnPolicySchema = [
        '@type' => 'MerchantReturnPolicy',
        'applicableCountry' => 'TH',
        'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
        'merchantReturnDays' => (int) theme_option('merchant_return_days', 7),
        'returnMethod' => 'https://schema.org/ReturnByMail',
        'returnFees' => 'https://schema.org/ReturnShippingFees',
    ];

    if ($merchantReturnPolicyUrl = theme_option('merchant_return_policy_url')) {
        $merchantReturnPolicySchema['merchantReturnLink'] = url($merchantReturnPolicyUrl);
    }

    $listingItemElements = $listingProducts
        ->values()
        ->map(function ($productItem, $index) use ($listingFirstPosition, $merchantReturnPolicySchema) {
            $itemData = [
                '@type' => 'Product',
                'name' => $productItem->name,
                'url' => $productItem->url,
            ];

            if ($productItem->image) {
                $itemData['image'] = RvMedia::getImageUrl($productItem->image, 'medium', false, RvMedia::getDefaultImage());
            }

            if ($productItem->sku) {
                $itemData['sku'] = $productItem->sku;
            } else {
                $itemData['sku'] = (string) $productItem->getKey();
            }

            $itemData['offers'] = [
                '@type' => 'Offer',
                'url' => $productItem->url,
                'priceCurrency' => get_application_currency()->title ?: 'THB',
                'price' => (string) $productItem->front_sale_price_with_taxes,
                'availability' => $productItem->isOutOfStock() ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock',
                'itemCondition' => 'https://schema.org/NewCondition',
                'hasMerchantReturnPolicy' => $merchantReturnPolicySchema,
            ];

            return [
                '@type' => 'ListItem',
                'position' => $listingFirstPosition + $index,
                'item' => $itemData,
            ];
        })
        ->values()
        ->all();

    $listingStructuredDataGraph = [
        [
            '@type' => 'CollectionPage',
            '@id' => $currentListingUrl . '#collection',
            'name' => $listingPageTitle,
            'url' => $currentListingUrl,
            'description' => $listingPageDescription,
        ],
        [
            '@type' => 'ItemList',
            '@id' => $currentListingUrl . '#item-list',
            'name' => $listingPageTitle,
            'url' => $currentListingUrl,
            'numberOfItems' => count($listingItemElements),
            'itemListElement' => $listingItemElements,
        ],
    ];

    if ($categoryBreadcrumbStructuredData) {
        array_unshift($listingStructuredDataGraph, $categoryBreadcrumbStructuredData);
    }

    $listingStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => $listingStructuredDataGraph,
    ];
@endphp

<script type="application/ld+json">
    {!! json_encode($listingStructuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<style>
    .products-listing .product-cart-wrap .product-content-wrap .product-category a {
        color: var(--color-grey-4);
        font-size: 10px;
        letter-spacing: 0px;
        text-transform: uppercase;
        font-weight: bolder
    }
</style>

<div class="container mb-30 category-products-page">
    <h1 class="visually-hidden">
        {{ isset($category) && $category ? $category->name : __('Products') }}
    </h1>
    <div class="row">
        @if ($layout === 'product-full-width')
            <div class="col-lg-12 m-auto mt-4">
                <a class="shop-filter-toggle mb-0" href="#" aria-expanded="false" aria-controls="products-filter-ajax">
                    <span class="fal fa-filter mr-5"></span>
                    <span class="title">{{ __('Filters') }}</span>
                    <i class="fal fa-angle-small-up angle-up"></i>
                    <i class="fal fa-angle-small-down angle-down"></i>
                </a>
                <form action="{{ URL::current() }}" method="GET" id="products-filter-ajax">
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                </form>
            </div>

            <div class="mt-4">
                <div class="products-listing position-relative">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                </div>
            </div>
        @elseif($layout === 'product-left-sidebar')
            <div class="col-xl-3 primary-sidebar mt-4 d-none d-xl-block">
                <div class="widget-area">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.filters')
                </div>
            </div>
            <div class="col-lg-12 col-xl-9">
                <!-- Mobile filter toggle -->
                <div class="d-block d-xl-none mt-4">
                    <a class="shop-filter-toggle mb-3" href="#" aria-expanded="false" aria-controls="sidebar-filter-mobile">
                        <span class="fal fa-filter mr-5"></span>
                        <span class="title">{{ __('Filters') }}</span>
                        <i class="fal fa-angle-small-up angle-up"></i>
                        <i class="fal fa-angle-small-down angle-down"></i>
                    </a>
                    <div id="sidebar-filter-mobile" class="collapse mb-3">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="products-listing position-relative bb-product-items-wrapper">
                        @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                    </div>
                </div>
            </div>
        @elseif($layout === 'product-right-sidebar')
            <div class="col-lg-12 col-xl-9">
                <!-- Mobile filter toggle -->
                <div class="d-block d-xl-none mt-4">
                    <a class="shop-filter-toggle mb-3" href="#" aria-expanded="false" aria-controls="sidebar-filter-mobile">
                        <span class="fal fa-filter mr-5"></span>
                        <span class="title">{{ __('Filters') }}</span>
                        <i class="fal fa-angle-small-up angle-up"></i>
                        <i class="fal fa-angle-small-down angle-down"></i>
                    </a>
                    <div id="sidebar-filter-mobile" class="collapse mb-3">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="products-listing position-relative bb-product-items-wrapper">
                        @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                    </div>
                </div>
            </div>
            <div class="col-xl-3 primary-sidebar mt-4 d-none d-xl-block">
                <div class="widget-area">
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                </div>
            </div>
        @endif
    </div>

    @if (isset($category) && $category && trim((string) $category->description))
        <section class="category-seo-after-pagination" aria-label="{{ __('Category details') }}">
            <div class="category-seo-inner">
                <div class="category-seo-copy" itemscope itemtype="https://schema.org/WebContent">
                    {!! BaseHelper::clean($category->description) !!}
                </div>
            </div>
        </section>
    @endif
</div>

<!-- Mobile optimizations -->
<style>
    .shop-filter-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        min-height: 44px;
        padding: 10px 15px;
        background: #f7f7f7;
        border-radius: 6px;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .shop-filter-toggle {
        width: fit-content;
        border: 1px solid #e5e7eb;
        background: #fff;
        color: #111827;
    }

    .shop-filter-toggle:hover,
    .shop-filter-toggle[aria-expanded="true"] {
        border-color: #dc2626;
        color: #dc2626;
    }

    .shop-filter-toggle .title {
        flex-grow: 1;
    }

    .shop-filter-toggle .angle-up,
    .shop-filter-toggle[aria-expanded="true"] .angle-down {
        display: none;
    }

    .shop-filter-toggle[aria-expanded="true"] .angle-up {
        display: inline-block;
    }

    .products-listing {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    .category-products-page {
        display: block !important;
        width: 100% !important;
        max-width: 1320px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding-left: clamp(12px, 3vw, 24px) !important;
        padding-right: clamp(12px, 3vw, 24px) !important;
        overflow: hidden;
    }

    .category-products-page > .row,
    .category-products-page .products-listing .product-grid {
        width: 100%;
        max-width: 100%;
    }

    .products-listing .product-grid {
        display: grid !important;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
        margin: 0 !important;
    }

    .products-listing .product-grid > div[class*="col-"] {
        grid-column: auto !important;
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        padding: 0 !important;
        margin: 0 !important;
    }

    .products-listing .product-item-wrapper.product-cart-wrap {
        height: 100% !important;
        min-height: 0 !important;
        margin: 0 !important;
        padding: 12px !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        box-shadow: none !important;
        overflow: hidden;
    }

    .products-listing .product-item-wrapper .product-img {
        height: 190px !important;
        min-height: 0 !important;
        aspect-ratio: auto !important;
        margin-bottom: 10px !important;
    }

    .products-listing .product-item-wrapper .product-img img {
        width: 100% !important;
        height: 100% !important;
        object-fit: contain !important;
    }

    .products-listing .product-item-wrapper .hover-img {
        display: none !important;
    }

    .category-seo-after-pagination {
        box-sizing: border-box;
        width: 100%;
        max-width: 100%;
        margin: 34px 0 0;
        padding: 32px 0 22px;
        border-top: 4px solid #d6001c;
        background: #fff;
        color: #374151;
        line-height: 1.75;
    }

    .category-seo-inner {
        width: 100%;
        max-width: none;
        margin: 0 auto;
    }

    .category-seo-copy {
        display: block !important;
        width: 100% !important;
        max-width: none !important;
        columns: auto !important;
        column-count: auto !important;
    }

    .category-seo-copy h2,
    .category-seo-copy h3 {
        margin: 0;
        color: #111827;
        font-weight: 700;
        line-height: 1.3;
    }

    .category-seo-copy h2 {
        margin-bottom: 12px;
        font-size: 22px;
    }

    .category-seo-copy h3 {
        margin-top: 18px;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .category-seo-copy p,
    .category-seo-copy li {
        color: #555;
        font-size: 15px;
        line-height: 1.7;
    }

    .category-seo-copy p {
        max-width: 1180px;
        margin: 0 0 12px;
    }

    .category-seo-copy ul {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 34px;
        margin: 0 0 14px;
        padding-left: 0;
        list-style: none;
    }

    .category-seo-copy li {
        position: relative;
        padding-left: 18px;
    }

    .category-seo-copy li::before {
        content: '';
        position: absolute;
        top: 0.68em;
        left: 0;
        width: 7px;
        height: 7px;
        border-radius: 999px;
        background: #d6001c;
        transform: translateY(-50%);
    }

    @media (max-width: 767px) {
        .category-seo-after-pagination {
            width: 100%;
            max-width: 100%;
            margin: 26px 0 0;
            padding: 24px 0 12px;
        }

        .category-seo-copy h2 {
            font-size: 18px;
        }

        .category-seo-copy ul {
            display: block;
        }
    }

    .products-listing .product-item-wrapper .product-content-wrap {
        position: static !important;
        display: flex !important;
        min-height: 0 !important;
        padding: 0 !important;
        flex-direction: column;
    }

    .products-listing .product-item-wrapper .product-category {
        min-height: 18px !important;
        max-height: 18px !important;
        margin-bottom: 6px !important;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
    }

    .products-listing .product-item-wrapper .product-category a {
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .products-listing .product-item-wrapper .product-title,
    .products-listing .product-item-wrapper h2.product-title,
    .products-listing .product-item-wrapper .text-truncate {
        display: block !important;
        height: 22px !important;
        min-height: 22px !important;
        max-height: 22px !important;
        margin: 0 0 8px !important;
        padding: 0 !important;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
        font-size: 14px !important;
        line-height: 22px !important;
    }

    .products-listing .product-item-wrapper .product-title a {
        display: block !important;
        width: 100% !important;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis !important;
    }

    .products-listing .product-item-wrapper .rating_wrap {
        min-height: 20px !important;
        margin: 0 0 8px !important;
    }

    .products-listing .product-item-wrapper .product-price {
        min-height: 30px !important;
        margin-top: auto !important;
        margin-bottom: 0 !important;
    }

    .products-listing .shop-product-filter {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: nowrap;
        margin-bottom: 18px;
    }

    .products-listing .shop-product-filter .total-product {
        flex: 1 1 auto;
        min-width: 0;
    }

    .products-listing .shop-product-filter .total-product p {
        margin: 0 !important;
        line-height: 1.45;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    #products-filter-ajax,
    #sidebar-filter-mobile {
        box-sizing: border-box;
        display: block !important;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10060;
        width: min(390px, calc(100vw - 28px));
        max-width: 100dvw;
        height: 100vh;
        height: 100dvh;
        max-height: 100dvh;
        margin: 0 !important;
        padding: 0 !important;
        background: #fff;
        box-shadow: 20px 0 50px rgba(15, 23, 42, 0.22);
        transform: translateX(calc(-100% - 24px));
        transition: transform 0.24s ease;
        overflow: hidden;
    }

    #products-filter-ajax.show,
    #sidebar-filter-mobile.show {
        transform: translateX(0);
    }

    .ruby-filter-backdrop {
        position: fixed;
        inset: 0;
        z-index: 10050;
        background: rgba(15, 23, 42, 0.48);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }

    .ruby-filter-backdrop.is-visible {
        opacity: 1;
        visibility: visible;
    }

    body.ruby-filter-open {
        overflow: hidden;
    }

    .ruby-filter-panel {
        position: relative;
        display: flex !important;
        width: 100%;
        height: 100%;
        min-height: 0;
        flex-direction: column;
        margin: 0 !important;
        background: #fff;
    }

    .ruby-filter-panel,
    .ruby-filter-panel * {
        box-sizing: border-box;
    }

    .ruby-filter-panel__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
    }

    .ruby-filter-panel__head > div {
        min-width: 0;
    }

    .ruby-filter-panel__eyebrow {
        display: block;
        margin-bottom: 2px;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .ruby-filter-panel__head h2 {
        margin: 0;
        color: #111827;
        font-size: 20px;
        font-weight: 800;
        line-height: 1.25;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .ruby-filter-close {
        display: inline-flex;
        flex: 0 0 40px;
        width: 40px;
        height: 40px;
        align-items: center;
        justify-content: center;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        color: #111827;
    }

    .ruby-filter-panel__body {
        display: block !important;
        flex: 1 1 auto;
        min-height: 0;
        margin: 0 !important;
        padding: 16px 20px;
        overflow-y: auto;
        overscroll-behavior: contain;
        -webkit-overflow-scrolling: touch;
    }

    .ruby-filter-panel__body > [class*="col-"] {
        width: 100% !important;
        max-width: 100% !important;
        padding: 0 !important;
        margin: 0 0 14px !important;
    }

    .ruby-filter-section {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
        overflow: hidden;
    }

    .ruby-filter-section .widget__title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        min-height: 48px;
        margin: 0 !important;
        padding: 14px 16px !important;
        border: 0 !important;
        background: #f8fafc;
        color: #111827;
        font-size: 14px;
        font-weight: 800;
        line-height: 1.2;
    }

    .ruby-filter-options,
    .ruby-filter-section .price-filter {
        width: 100%;
        min-width: 0;
        max-width: 100%;
        max-height: 280px;
        padding: 12px 16px 16px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .ruby-filter-options .mCustomScrollBox,
    .ruby-filter-options .mCSB_container {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow: visible !important;
    }

    .ruby-filter-section .price-filter,
    .ruby-filter-section .price-filter-inner,
    .ruby-filter-section .price_slider_amount,
    .ruby-filter-section .label-input {
        min-width: 0;
        max-width: 100%;
    }

    .ruby-filter-options ul {
        padding: 0;
        margin: 0;
        list-style: none;
        width: 100%;
        min-width: 0;
    }

    .ruby-filter-options .form-check,
    .ruby-filter-options > .form-check {
        position: relative;
        display: flex !important;
        flex-wrap: wrap;
        align-items: flex-start;
        gap: 0 10px;
        min-height: 42px;
        width: 100%;
        min-width: 0;
        margin: 0 !important;
        padding: 9px 0 !important;
        border-bottom: 1px solid #f1f5f9;
    }

    .ruby-filter-options .form-check:last-child {
        border-bottom: 0;
    }

    .ruby-filter-options .ruby-filter-subcategories {
        flex: 0 0 100%;
        width: 100%;
        max-width: 100%;
        min-width: 0;
        margin: 8px 0 0 0;
        padding: 0 0 0 18px;
        border-left: 2px solid #eef2f7;
        list-style: none;
    }

    .ruby-filter-options .form-check-input {
        flex: 0 0 18px;
        float: none !important;
        width: 18px;
        height: 18px;
        margin: 2px 0 0 !important;
        border-color: #cbd5e1;
    }

    .ruby-filter-options .form-check-label {
        display: block;
        flex: 1 1 calc(100% - 28px);
        min-width: 0;
        max-width: calc(100% - 28px);
        margin: 0 !important;
        color: #334155;
        font-size: 14px;
        line-height: 1.35;
        overflow: visible;
        overflow-wrap: break-word;
        word-break: normal;
        white-space: normal;
    }

    .ruby-filter-options > input.form-check-input {
        float: none;
        display: inline-block;
        margin: 2px 8px 10px 0 !important;
        vertical-align: top;
    }

    .ruby-filter-options > input.form-check-input + label.form-check-label {
        display: inline;
        vertical-align: top;
    }

    .ruby-filter-options .form-check .form-check {
        width: 100%;
        min-width: 0;
        margin-left: 0 !important;
        padding-left: 0 !important;
    }

    .ruby-filter-actions {
        box-sizing: border-box;
        position: sticky;
        bottom: 0;
        z-index: 2;
        flex: 0 0 auto;
        display: grid;
        width: 100%;
        max-width: 100%;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
        padding: 14px 20px max(18px, env(safe-area-inset-bottom));
        border-top: 1px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 -10px 26px rgba(15, 23, 42, 0.08);
    }

    .ruby-filter-actions .btn {
        display: inline-flex;
        width: 100%;
        min-height: 44px;
        min-width: 0;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin: 0 !important;
        padding-right: 10px !important;
        padding-left: 10px !important;
        border-radius: 8px;
        font-weight: 700;
        line-height: 1.2;
        white-space: normal;
        text-align: center;
        overflow-wrap: anywhere;
    }

    .ruby-filter-actions .btn i {
        flex: 0 0 auto;
        margin-right: 0 !important;
        margin-left: 0 !important;
    }

    .ruby-filter-apply {
        border-color: #dc2626 !important;
        background: #dc2626 !important;
        color: #fff !important;
    }

    .ruby-filter-clear {
        border-color: #e5e7eb !important;
        background: #fff !important;
        color: #475569 !important;
    }

    .show-advanced-filters,
    .advanced-search-widgets {
        margin: 0;
    }

    .ruby-filter-advanced-block {
        width: 100%;
        min-width: 0;
        margin-top: 4px;
        padding-bottom: 10px;
    }

    .show-advanced-filters {
        display: inline-flex;
        min-height: 40px;
        align-items: center;
        gap: 8px;
        max-width: calc(100% - 40px);
        overflow: hidden;
    }

    .show-advanced-filters .title {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    @media (max-width: 991px) {
        .category-products-page {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            padding-left: 12px !important;
            padding-right: 12px !important;
            overflow: hidden;
        }

        .category-products-page > .row {
            display: block !important;
            width: 100% !important;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .category-products-page > .row > .mt-4 {
            width: 100%;
            max-width: 100%;
            padding-left: 0;
            padding-right: 0;
        }

        .products-listing .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 10px;
            margin-left: 0 !important;
            margin-right: 0 !important;
        }

        .products-listing .product-grid > div[class*="col-"] {
            grid-column: auto !important;
            width: 100% !important;
            max-width: 100% !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
            margin-bottom: 0 !important;
            min-width: 0 !important;
        }

        .products-listing .shop-product-filter {
            display: flex;
            flex-wrap: nowrap;
            justify-content: space-between;
            gap: 8px;
            align-items: center;
        }

        .products-listing .shop-product-filter .total-product {
            font-size: 14px;
            flex: 1 1 auto;
            min-width: 0;
        }

        .products-listing .shop-product-filter .total-product p {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .products-listing .shop-product-filter .sort-by-product-area {
            flex: 0 1 auto;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, auto));
            gap: 8px;
            min-width: 0;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by-cover {
            min-width: 0;
            margin-right: 0 !important;
            position: relative;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by-product-wrap {
            display: flex;
            min-height: 40px;
            min-width: 0;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
            padding: 8px 10px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            cursor: pointer;
            user-select: none;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by,
        .products-listing .shop-product-filter .sort-by-product-area .sort-by-dropdown-wrap {
            min-width: 0;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by span,
        .products-listing .shop-product-filter .sort-by-product-area .sort-by-dropdown-wrap > span {
            display: inline-flex;
            max-width: 100%;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
            font-size: 12px;
            line-height: 1.2;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by i {
            margin-right: 4px;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by-current-value {
            display: inline-block;
            max-width: 76px;
            overflow: hidden;
            text-overflow: ellipsis;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by-dropdown {
            right: 0;
            left: auto;
            min-width: 190px;
            max-width: calc(100vw - 24px);
            z-index: 60;
        }

        .products-listing .shop-product-filter .sort-by-product-area .sort-by-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
            pointer-events: auto;
        }

        @media (max-width: 575px) {
            .products-listing .shop-product-filter {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                align-items: stretch;
            }

            .products-listing .shop-product-filter .total-product {
                width: 100%;
            }

            .products-listing .shop-product-filter .sort-by-product-area {
                width: 100%;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .products-listing .shop-product-filter .sort-by-product-area .sort-by-current-value {
                max-width: 58px;
            }
        }

        @media (max-width: 374px) {
            .products-listing .shop-product-filter .sort-by-product-area {
                grid-template-columns: minmax(0, 1fr);
            }

            .products-listing .shop-product-filter .sort-by-product-area .sort-by-current-value {
                max-width: 120px;
            }
        }

        .products-listing .product-item-wrapper.product-cart-wrap {
            padding: 8px !important;
        }

        .products-listing .product-item-wrapper .product-img {
            height: clamp(104px, 31vw, 142px) !important;
            margin-bottom: 8px !important;
        }

        .products-listing .product-item-wrapper .product-category {
            min-height: 16px !important;
            max-height: 16px !important;
            margin-bottom: 4px !important;
        }

        .products-listing .product-item-wrapper .product-title,
        .products-listing .product-item-wrapper h2.product-title,
        .products-listing .product-item-wrapper .text-truncate {
            height: 20px !important;
            min-height: 20px !important;
            max-height: 20px !important;
            font-size: 12px !important;
            line-height: 20px !important;
            margin-bottom: 6px !important;
        }

        .products-listing .product-item-wrapper .rating_wrap {
            min-height: 18px !important;
            margin-bottom: 4px !important;
        }

        .products-listing .product-item-wrapper .product-price span {
            font-size: 16px !important;
            line-height: 1.2 !important;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination li {
            margin-bottom: 5px;
        }
        
        .price-range-slider {
            margin-top: 15px;
        }
        
        .ui-slider-horizontal {
            height: 4px;
        }
        
        .ui-slider-handle {
            width: 16px !important;
            height: 16px !important;
            top: -6px !important;
        }
    }

    @media (max-width: 575px) {
        #products-filter-ajax,
        #sidebar-filter-mobile {
            width: 100dvw;
            max-width: 100dvw;
            transform: translateX(calc(-100% - 1px));
            box-shadow: none;
        }

        .ruby-filter-panel__head {
            padding: 14px 14px;
        }

        .ruby-filter-panel__body {
            padding: 12px 14px;
        }

        .ruby-filter-options,
        .ruby-filter-section .price-filter {
            max-height: none;
            padding: 10px 12px 12px;
            overflow: visible;
        }

        .ruby-filter-options .ruby-filter-subcategories {
            padding-left: 8px;
        }

        .ruby-filter-section .widget__title {
            min-height: 44px;
            padding: 12px !important;
        }

        .ruby-filter-actions {
            gap: 8px;
            padding: 12px 14px max(14px, env(safe-area-inset-bottom));
        }

        .ruby-filter-actions .btn {
            min-height: 42px;
            padding: 8px 10px !important;
            font-size: 12px;
        }

        .show-advanced-filters,
        .advanced-search-widgets {
            margin-right: 0;
            margin-left: 0;
        }
    }

    @media (max-width: 359px) {
        #products-filter-ajax,
        #sidebar-filter-mobile {
            width: 100dvw;
            max-width: 100dvw;
        }

        .ruby-filter-actions {
            grid-template-columns: minmax(0, 1fr);
        }

        .ruby-filter-panel__body {
            padding-bottom: 12px;
        }
    }

    @media (min-width: 768px) and (max-width: 991px) {
        .products-listing .product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .products-listing .product-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }
    }
    
    .products-listing.loading::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.7);
        z-index: 2;
        pointer-events: none;
    }
    
    .products-listing.loading::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid rgba(0,0,0,0.1);
        border-top-color: #3BB77E;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 3;
        pointer-events: none;
    }
</style>

<!-- Add JavaScript for enhanced mobile experience -->
<script>
    function initCategoryProductControls() {
        if (window.__rubyCategoryProductControlsReady) {
            return;
        }

        window.__rubyCategoryProductControlsReady = true;

        const productsContainer = document.querySelector('.products-listing');
        const body = document.body;
        const filterBackdrop = document.createElement('button');
        filterBackdrop.type = 'button';
        filterBackdrop.className = 'ruby-filter-backdrop';
        filterBackdrop.setAttribute('aria-label', '{{ __('Close filters') }}');
        document.body.appendChild(filterBackdrop);

        function closeFilters() {
            document.querySelectorAll('.shop-filter-toggle').forEach(toggle => {
                toggle.setAttribute('aria-expanded', 'false');
            });

            document.querySelectorAll('#products-filter-ajax, #sidebar-filter-mobile').forEach(panel => {
                panel.classList.remove('show');
            });

            filterBackdrop.classList.remove('is-visible');
            body.classList.remove('ruby-filter-open');
        }

        document.querySelectorAll('.shop-filter-toggle').forEach(toggle => {
            toggle.addEventListener('click', function (event) {
                event.preventDefault();

                const target = document.getElementById(this.getAttribute('aria-controls'));
                if (!target) {
                    return;
                }

                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', (!isExpanded).toString());
                target.classList.toggle('show', !isExpanded);
                filterBackdrop.classList.toggle('is-visible', !isExpanded);
                body.classList.toggle('ruby-filter-open', !isExpanded);
            });
        });

        filterBackdrop.addEventListener('click', closeFilters);

        document.querySelectorAll('.ruby-filter-close').forEach(button => {
            button.addEventListener('click', closeFilters);
        });

        document.querySelectorAll('.products-listing .sort-by-product-area .sort-by-product-wrap').forEach(trigger => {
            trigger.setAttribute('role', 'button');
            trigger.setAttribute('tabindex', '0');
            trigger.setAttribute('aria-haspopup', 'listbox');
            trigger.setAttribute('aria-expanded', trigger.parentElement && trigger.parentElement.classList.contains('show') ? 'true' : 'false');

            const toggleSortDropdown = event => {
                event.preventDefault();
                event.stopPropagation();

                const cover = trigger.closest('.sort-by-cover');
                const area = trigger.closest('.sort-by-product-area');
                const dropdown = cover ? cover.querySelector('.sort-by-dropdown') : null;
                const willOpen = cover ? !cover.classList.contains('show') : false;

                document.querySelectorAll('.products-listing .sort-by-cover.show').forEach(openCover => {
                    openCover.classList.remove('show');
                    const openDropdown = openCover.querySelector('.sort-by-dropdown');
                    const openTrigger = openCover.querySelector('.sort-by-product-wrap');

                    if (openDropdown) {
                        openDropdown.classList.remove('show');
                    }

                    if (openTrigger) {
                        openTrigger.setAttribute('aria-expanded', 'false');
                    }
                });

                if (!cover || !dropdown) {
                    return;
                }

                cover.classList.toggle('show', willOpen);
                dropdown.classList.toggle('show', willOpen);
                trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');

                if (area) {
                    area.classList.toggle('show', willOpen);
                }

                if (window.console) {
                    console.debug('[RUBY Sort Debug] toggle', {
                        opened: willOpen,
                        name: dropdown.dataset.name || null,
                        options: dropdown.querySelectorAll('a').length,
                    });
                }
            };

            trigger.addEventListener('click', toggleSortDropdown, true);
            trigger.addEventListener('keydown', event => {
                if (event.key === 'Enter' || event.key === ' ') {
                    toggleSortDropdown(event);
                }
            });
        });

        document.querySelectorAll('.products-listing .sort-by-dropdown a').forEach(link => {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                event.stopImmediatePropagation();

                if (window.console) {
                    console.debug('[RUBY Sort Debug] option click', {
                        label: this.textContent.trim(),
                        href: this.href,
                    });
                }

                window.location.href = this.href;
            }, true);
        });

        document.addEventListener('click', event => {
            if (event.target.closest('.products-listing .sort-by-product-area')) {
                return;
            }

            document.querySelectorAll('.products-listing .sort-by-cover.show').forEach(openCover => {
                openCover.classList.remove('show');

                const openDropdown = openCover.querySelector('.sort-by-dropdown');
                const openTrigger = openCover.querySelector('.sort-by-product-wrap');

                if (openDropdown) {
                    openDropdown.classList.remove('show');
                }

                if (openTrigger) {
                    openTrigger.setAttribute('aria-expanded', 'false');
                }
            });
        }, true);

        if (window.innerWidth <= 768) {
            document.querySelectorAll('.product-img img').forEach(img => {
                if (!img.hasAttribute('loading')) {
                    img.setAttribute('loading', 'lazy');
                }

                img.addEventListener('error', function () {
                    this.src = '/themes/wowy/images/placeholder.jpg';
                });
            });
        }

        document.querySelectorAll('.widget-filter-item').forEach((item, index) => {
            const title = item.querySelector('.widget__title, .widget-title');
            const content = item.querySelector('.widget-content, .custome-checkbox, .price-range-slider, .ps-custom-scrollbar');

            if (title && content && window.innerWidth <= 768) {
                title.style.cursor = 'pointer';

                const indicator = document.createElement('span');
                indicator.innerHTML = '<i class="fi-rs-angle-small-down"></i>';
                indicator.style.float = 'right';
                title.appendChild(indicator);

                title.addEventListener('click', function () {
                    const isVisible = content.style.display !== 'none';

                    if (isVisible) {
                        content.style.display = 'none';
                        indicator.innerHTML = '<i class="fi-rs-angle-small-down"></i>';
                    } else {
                        content.style.display = 'block';
                        indicator.innerHTML = '<i class="fi-rs-angle-small-up"></i>';
                    }
                });

                if (index !== 0) {
                    content.style.display = 'none';
                }
            }
        });

        const filterForm = document.getElementById('products-filter-ajax');
        if (filterForm) {
            const rubyFilterDebug = true;
            const debugFilterEvent = (eventName, payload = {}) => {
                if (!rubyFilterDebug || !window.console) {
                    return;
                }

                console.groupCollapsed(`[RUBY Filter Debug] ${eventName}`);
                Object.entries(payload).forEach(([key, value]) => console.log(key, value));
                console.groupEnd();
            };

            function encodeQueryKey(key) {
                return encodeURIComponent(key).replace(/%5B/g, '[').replace(/%5D/g, ']');
            }

            function appendFormQuery(segments, key, value) {
                if (value === null || value === '') {
                    return;
                }

                if (key === 'page') {
                    return;
                }

                segments.push(encodeQueryKey(key.replace(/\[\d+\]/g, '[]')) + '=' + encodeURIComponent(value));
            }

            function buildFormQuery(form, skipDefaultPrices) {
                const formData = new FormData(form);
                const segments = [];

                formData.forEach((value, key) => {
                    const field = form.querySelector(`[name="${CSS.escape(key)}"]`);

                    if (skipDefaultPrices && key === 'min_price' && field && String(value) === String(field.dataset.min || '')) {
                        return;
                    }

                    if (skipDefaultPrices && key === 'max_price' && field && String(value) === String(field.dataset.max || '')) {
                        return;
                    }

                    appendFormQuery(segments, key, value);
                });

                return segments.join('&');
            }

            function buildFilterUrl(form) {
                const targetUrl = new URL(form.action, window.location.origin);
                const queryString = buildFormQuery(form, true);

                targetUrl.search = queryString ? '?' + queryString : '';

                return targetUrl.toString();
            }

            filterForm.addEventListener('submit', function (event) {
                event.preventDefault();
                event.stopPropagation();
                const targetUrl = buildFilterUrl(filterForm);

                debugFilterEvent('submit filter', {
                    currentUrl: window.location.href,
                    formAction: filterForm.action,
                    targetUrl,
                    formQuery: buildFormQuery(filterForm, true),
                    checkedCategories: Array.from(filterForm.querySelectorAll('input[name="categories[]"]:checked')).map(input => input.value),
                });

                window.location.href = targetUrl;
            }, true);

            filterForm.querySelectorAll('.clear_all_filter').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    const targetUrl = this.href || filterForm.action;

                    debugFilterEvent('clear filter', {
                        currentUrl: window.location.href,
                        targetUrl,
                    });

                    window.location.href = targetUrl;
                }, true);
            });

            document.querySelectorAll('.products-listing .pagination-page a.page-link').forEach(link => {
                link.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();
                    event.stopImmediatePropagation();

                    const targetUrl = new URL(this.href, window.location.origin);

                    debugFilterEvent('pagination click', {
                        clickedText: this.textContent.trim(),
                        currentUrl: window.location.href,
                        href: this.href,
                        targetPage: targetUrl.searchParams.get('page') || '1',
                        targetSearch: targetUrl.search,
                        hasIndexedCategories: /categories%5B\d+%5D|categories\[\d+\]/i.test(this.href),
                        checkedCategories: Array.from(filterForm.querySelectorAll('input[name="categories[]"]:checked')).map(input => input.value),
                    });

                    window.location.href = targetUrl.toString();
                }, true);
            });

            function debounce(func, wait) {
                let timeout;
                return function () {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }

            filterForm.querySelectorAll('input, select').forEach(input => {
                const eventType = input.type === 'checkbox' || input.type === 'radio' || input.tagName === 'SELECT'
                    ? 'change' : 'input';

                input.addEventListener(eventType, debounce(function () {
                    if (input.closest('.ruby-filter-panel')) {
                        return;
                    }

                    if (productsContainer) {
                        productsContainer.classList.add('loading');
                    }

                    const requestUrl = new URL(filterForm.action, window.location.origin);
                    const queryString = buildFormQuery(filterForm, true);

                    requestUrl.search = queryString ? '?' + queryString : '';

                    fetch(requestUrl.toString(), {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        if (!productsContainer) {
                            return;
                        }

                        const doc = new DOMParser().parseFromString(html, 'text/html');
                        const nextProducts = doc.querySelector('.products-listing');
                        productsContainer.innerHTML = nextProducts ? nextProducts.innerHTML : html;

                        const rect = productsContainer.getBoundingClientRect();
                        if (rect.top < 0) {
                            window.scrollTo({
                                top: window.scrollY + rect.top - 20,
                                behavior: 'smooth'
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error updating products:', error);
                    })
                    .finally(() => {
                        if (productsContainer) {
                            productsContainer.classList.remove('loading');
                        }
                    });
                }, 500));
            });
        }

        const productSliders = document.querySelectorAll('.product-img-slider');
        if (productSliders.length > 0) {
            productSliders.forEach(slider => {
                let touchStartX = 0;
                let touchEndX = 0;

                slider.addEventListener('touchstart', function (e) {
                    touchStartX = e.touches[0].clientX;
                }, { passive: true });

                slider.addEventListener('touchend', function (e) {
                    touchEndX = e.changedTouches[0].clientX;
                    const distance = touchStartX - touchEndX;

                    if (Math.abs(distance) > 50) {
                        const nextBtn = slider.querySelector('.slick-next') || slider.querySelector('.next');
                        const prevBtn = slider.querySelector('.slick-prev') || slider.querySelector('.prev');

                        if (distance > 0 && nextBtn) {
                            nextBtn.click();
                        } else if (distance < 0 && prevBtn) {
                            prevBtn.click();
                        }
                    }
                }, { passive: true });
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCategoryProductControls);
    } else {
        initCategoryProductControls();
    }
</script>
