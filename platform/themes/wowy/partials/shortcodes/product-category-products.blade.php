@once
    <style>
        .category-products {
            background: #f7f8f9;
            padding: 52px 0;
        }

        .category-products,
        .category-products * {
            box-sizing: border-box;
        }

        .category-products__inner {
            width: min(1180px, calc(100% - 32px));
            margin: 0 auto;
        }

        .category-products__header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 28px;
        }

        .category-products__title {
            margin: 0;
            color: #111827;
            font-size: clamp(28px, 3.2vw, 44px);
            font-weight: 900;
            line-height: 1.12;
        }

        .category-products__tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 8px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .category-products__tab {
            appearance: none;
            min-height: 38px;
            padding: 8px 14px;
            border: 1px solid #d1d5db;
            border-radius: 999px;
            background: #fff;
            color: #374151;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.2;
            cursor: pointer;
            transition: background 0.18s ease, border-color 0.18s ease, color 0.18s ease;
        }

        .category-products__tab.active,
        .category-products__tab:hover {
            border-color: #dc2626;
            background: #dc2626;
            color: #fff;
        }

        .category-products__view-all {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #dc2626;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .category-products__view-all:hover {
            color: #b91c1c;
            text-decoration: none;
        }

        .category-products__content {
            position: relative;
        }

        .category-products__grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
        }

        .category-products__item {
            min-width: 0;
        }

        .category-products .product-cart-wrap {
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
            margin-bottom: 0;
            overflow: hidden;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .category-products .product-img-action-wrap,
        .category-products .product-img {
            position: relative;
            min-height: 220px;
            background: #fff;
        }

        .category-products .product-img {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 14px;
        }

        .category-products .product-img a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        .category-products .product-img img {
            display: block;
            width: auto;
            max-width: 100%;
            height: auto;
            max-height: 210px;
            object-fit: contain;
            margin: 0 auto;
        }

        .category-products .product-img .hover-img {
            display: none;
        }

        .category-products .product-content-wrap {
            position: relative;
            display: flex;
            flex: 1 1 auto;
            flex-direction: column;
            min-height: 176px;
            padding: 14px;
            background: #fff;
        }

        .category-products .product-category {
            min-height: 18px;
            margin-bottom: 6px;
            font-size: 12px;
            line-height: 1.3;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .category-products .product-category a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
        }

        .category-products .product-title {
            min-height: 42px;
            margin: 0 0 8px;
            font-size: 15px;
            font-weight: 800;
            line-height: 1.35;
            white-space: normal;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .category-products .product-title a {
            color: #111827;
            text-decoration: none;
        }

        .category-products .product-title a:hover,
        .category-products .product-category a:hover {
            color: #dc2626;
            text-decoration: none;
        }

        .category-products .rating_wrap {
            min-height: 22px;
            margin: 0 0 8px;
        }

        .category-products .product-price {
            min-height: 34px;
            margin-top: auto;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.3;
        }

        .category-products .product-price .old-price {
            margin-left: 6px;
            color: #6b7280;
            font-size: 12px;
            font-weight: 600;
            text-decoration: line-through;
        }

        .category-products .product-action-1 {
            right: 12px;
            bottom: 12px !important;
        }

        .category-products__empty {
            margin: 0;
            padding: 32px 16px;
            border: 1px dashed #d1d5db;
            background: #fff;
            color: #6b7280;
            text-align: center;
            font-weight: 700;
        }

        .category-products .loading-spinner {
            position: absolute;
            inset: 0;
            z-index: 5;
            display: none;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            background: rgba(247, 248, 249, 0.72);
        }

        .category-products .loading-spinner:not(.d-none) {
            display: flex;
        }

        @media (max-width: 1199px) {
            .category-products__grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (max-width: 991px) {
            .category-products__header {
                align-items: flex-start;
                flex-direction: column;
                gap: 16px;
            }

            .category-products__tabs {
                justify-content: flex-start;
            }

            .category-products__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }
        }

        @media (max-width: 575px) {
            .category-products {
                padding: 36px 0;
            }

            .category-products__inner {
                width: min(100% - 24px, 520px);
            }

            .category-products__grid {
                gap: 12px;
            }

            .category-products .product-img-action-wrap,
            .category-products .product-img {
                min-height: 160px;
            }

            .category-products .product-img img {
                max-height: 150px;
            }

            .category-products .product-content-wrap {
                min-height: 150px;
                padding: 10px;
            }

            .category-products .product-content-wrap,
            .category-products .product-img-action-wrap,
            .category-products .product-item-wrapper,
            .category-products .product-cart-wrap {
                max-width: 100%;
            }

            .category-products .product-title {
                min-height: 38px;
                font-size: 13px;
            }

            .category-products .product-title,
            .category-products .product-title a,
            .category-products .product-category {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .category-products .product-price {
                font-size: 14px;
            }

            .category-products .product-img {
                border-radius: 12px;
            }
        }

        @media (max-width: 575px) {
            .category-products__grid {
                grid-template-columns: 1fr !important;
                gap: 12px;
            }
        }
    </style>
@endonce

<section class="category-products product-tabs">
    <div class="category-products__inner">
        <div class="category-products__header">
            <h2 class="category-products__title">{{ $category->name }}</h2>

            @if ($category->activeChildren->isNotEmpty())
                <ul class="category-products__tabs nav nav-tabs right no-border" role="tablist">
                    <li role="presentation">
                        <button class="category-products__tab nav-link active" type="button" data-url="{{ route('public.ajax.products-by-category', $category->id, ['limit' => $limit]) }}" role="tab" aria-controls="product-categories-product" aria-selected="true">{{ __('All') }}</button>
                    </li>
                    @foreach ($category->activeChildren as $item)
                        <li role="presentation">
                            <button class="category-products__tab nav-link" type="button" data-url="{{ route('public.ajax.products-by-category', $item->id, ['limit' => $limit]) }}" role="tab" aria-controls="product-categories-product" aria-selected="false">{{ $item->name }}</button>
                        </li>
                    @endforeach
                </ul>
            @else
                <a href="{{ $category->url }}" class="category-products__view-all">
                    {{ __('View all') }}
                    <i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            @endif
        </div>

        <div class="category-products__content tab-content">
            <div class="loading-spinner d-none">
                <div class="ruby-global-loader loader" role="status"></div>
            </div>

            <div class="tab-pane fade show active" id="product-categories-product" role="tabpanel" aria-labelledby="product-categories-product-tab">
                @if ($products->isNotEmpty())
                    <div class="category-products__grid product-grid-4">
                        @foreach ($products as $product)
                            <div class="category-products__item">
                                @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', compact('product'))
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="category-products__empty">{{ __('No products found.') }}</p>
                @endif
            </div>
        </div>
    </div>
</section>
