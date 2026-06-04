@php
    $layout = theme_option('product_list_layout');

    $requestLayout = BaseHelper::stringify(request()->input('layout'));
    if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
        $layout = $requestLayout;
    }

    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';

    Theme::layout('full-width');

    Theme::asset()->usePath()->add('jquery-ui-css', 'css/plugins/jquery-ui.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/plugins/jquery-ui.js');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-touch-punch-js', 'js/plugins/jquery.ui.touch-punch.min.js');

    $products->loadMissing(['categories', 'categories.slugable']);

    $categoryBreadcrumbStructuredData = null;

    if (isset($category) && $category) {
        $categoryBreadcrumbStructuredData = [
            '@context' => 'https://schema.org',
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
    }
@endphp

@if ($categoryBreadcrumbStructuredData)
    <script type="application/ld+json">
        {!! json_encode($categoryBreadcrumbStructuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif

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
                <form action="{{ URL::current() }}" method="GET" id="products-filter-ajax" class="collapse">
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
        display: block !important;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 10060;
        width: min(390px, calc(100vw - 28px));
        height: 100dvh;
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
        display: flex !important;
        height: 100%;
        flex-direction: column;
        margin: 0 !important;
        background: #fff;
    }

    .ruby-filter-panel__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 20px;
        border-bottom: 1px solid #e5e7eb;
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
    }

    .ruby-filter-close {
        display: inline-flex;
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
        margin: 0 !important;
        padding: 16px 20px 112px;
        overflow-y: auto;
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
        max-height: 280px;
        padding: 12px 16px 16px;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .ruby-filter-options ul {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .ruby-filter-options .form-check,
    .ruby-filter-options > .form-check {
        position: relative;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        min-height: 42px;
        margin: 0 !important;
        padding: 9px 0 !important;
        border-bottom: 1px solid #f1f5f9;
    }

    .ruby-filter-options .form-check:last-child {
        border-bottom: 0;
    }

    .ruby-filter-options .form-check-input {
        flex: 0 0 18px;
        width: 18px;
        height: 18px;
        margin: 2px 0 0 !important;
        border-color: #cbd5e1;
    }

    .ruby-filter-options .form-check-label {
        flex: 1 1 auto;
        margin: 0 !important;
        color: #334155;
        font-size: 14px;
        line-height: 1.35;
        overflow-wrap: anywhere;
    }

    .ruby-filter-options .form-check .form-check {
        margin-left: 12px !important;
        padding-left: 12px !important;
        border-left: 2px solid #f1f5f9;
    }

    .ruby-filter-actions {
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto;
        gap: 10px;
        padding: 14px 20px 18px;
        border-top: 1px solid #e5e7eb;
        background: #fff;
        box-shadow: 0 -10px 26px rgba(15, 23, 42, 0.08);
    }

    .ruby-filter-actions .btn {
        display: inline-flex;
        min-height: 44px;
        align-items: center;
        justify-content: center;
        margin: 0 !important;
        border-radius: 8px;
        font-weight: 700;
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
        margin: 0 20px;
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
            min-width: 0;
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
        
        #scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #3BB77E;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        #scroll-top.visible {
            opacity: 1;
            visibility: visible;
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

        const scrollTopBtn = document.createElement('button');
        scrollTopBtn.id = 'scroll-top';
        scrollTopBtn.type = 'button';
        scrollTopBtn.innerHTML = '<i class="fi-rs-arrow-up"></i>';
        document.body.appendChild(scrollTopBtn);

        window.addEventListener('scroll', function () {
            scrollTopBtn.classList.toggle('visible', window.pageYOffset > 300);
        }, { passive: true });

        scrollTopBtn.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

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
                    if (productsContainer) {
                        productsContainer.classList.add('loading');
                    }

                    const formData = new FormData(filterForm);
                    const requestUrl = new URL(filterForm.action, window.location.origin);
                    formData.forEach((value, key) => {
                        requestUrl.searchParams.append(key, value);
                    });

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
