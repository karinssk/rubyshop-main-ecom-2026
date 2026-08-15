@if ($product && $product instanceof \Botble\Ecommerce\Models\Product)
    <div class="product-cart-wrap mb-30 product-item-wrapper">
        <div class="product-img-action-wrap">
            <div class="product-img product-img-zoom">
                <a href="{{ $product->url }}">
                    <img class="default-img" src="{{ RvMedia::getImageUrl($product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" width="400" height="400" loading="lazy" decoding="async">
                    <img class="hover-img" src="{{ RvMedia::getImageUrl($product->images[1] ?? $product->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $product->name }}" width="400" height="400" loading="lazy" decoding="async">
                </a>
            </div>
            
            <div class="product-badges product-badges-position product-badges-mrg">
                @if ($product->isOutOfStock())
                    <span style="background-color: #000; font-size: 11px;">{{ __('Out Of Stock') }}</span>
                @else
                    @if ($product->productLabels->count())
                        @foreach ($product->productLabels as $label)
                            <span @if ($label->color) style="background-color: {{ $label->color }}" @endif>{{ $label->name }}</span>
                        @endforeach
                    @elseif ($product->front_sale_price !== $product->price && $percentSale = get_sale_percentage($product->price, $product->front_sale_price))
                        <span class="hot">{{ $percentSale }}</span>
                    @endif
                @endif
            </div>
        </div>
        <div class="product-content-wrap">
            <div class="product-category">
                @php
                    $category = $product->categories
                        ->filter(fn ($item) => $item && $item->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $item->url)
                        ->sortByDesc('id')
                        ->first()
                        ?: $product->categories->sortByDesc('id')->first();
                    $categoryCanLink = $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url;
                @endphp
                @if ($category)
                    @if ($categoryCanLink)
                        <a href="{{ $category->url }}">{{ $category->name }}</a>
                    @else
                        <span>{{ $category->name }}</span>
                    @endif
                @else
                    &nbsp;
                @endif
            </div>
            <h2 class="text-truncate product-title mb-5">
                <a href="{{ $product->url }}" title="{{ $product->name }}">{{ $product->name }}</a>
            </h2>
            @if (EcommerceHelper::isReviewEnabled())
                <div class="rating_wrap">
                    <div class="rating">
                        <div class="product_rate" style="width: {{ $product->reviews_avg * 20 }}%"></div>
                    </div>
                    <span class="rating_num">({{ $product->reviews_count }})</span>
                </div>
            @endif
            {!! apply_filters('ecommerce_before_product_price_in_listing', null, $product) !!}
            <div class="product-price">
                <span>{{ format_price($product->front_sale_price_with_taxes) }}</span>
                @if ($product->front_sale_price !== $product->price)
                    <span class="old-price">{{ format_price($product->price_with_taxes) }}</span>
                @endif
            </div>
            {!! apply_filters('ecommerce_after_product_price_in_listing', null, $product) !!}
            @if (EcommerceHelper::isCartEnabled())
                <div class="product-action-1 show" @if (!EcommerceHelper::isReviewEnabled()) style="bottom: 10px;" @endif>
                    @if ($product->isOutOfStock())
                        <span aria-label="{{ __('Out of stock') }}" class="action-btn hover-up is-disabled" role="button" aria-disabled="true">
                            <i class="far fa-shopping-bag"></i>
                        </span>
                    @else
                        <a aria-label="{{ __('Add To Cart') }}" class="action-btn hover-up add-to-cart-button" data-id="{{ $product->id }}" data-url="{{ route('public.cart.add-to-cart') }}" href="#">
                            <i class="far fa-shopping-bag"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    @once
        <style>
            .product-item-wrapper {
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .product-item-wrapper .product-img-action-wrap:hover .product-action-1:not(.show) {
                display: none !important;
                opacity: 0 !important;
                visibility: hidden !important;
            }

            .product-item-wrapper .product-img-action-wrap {
                flex: 0 0 auto;
            }

            .product-item-wrapper .product-img {
                aspect-ratio: 1 / 1;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .product-item-wrapper .product-img a {
                display: flex;
                width: 100%;
                height: 100%;
                align-items: center;
                justify-content: center;
            }

            .product-item-wrapper .product-img img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .product-item-wrapper .product-action-1 .action-btn.is-disabled {
                cursor: not-allowed;
                opacity: 0.45;
                pointer-events: none;
            }

            .product-item-wrapper .product-content-wrap {
                display: flex;
                flex: 1 1 auto;
                flex-direction: column;
                min-width: 0;
            }

    .product-item-wrapper .product-category {
        min-height: 20px;
        margin-bottom: 4px;
        display: block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .product-item-wrapper .product-title {
        min-height: 42px;
        margin-bottom: 6px !important;
        overflow: hidden !important;
        white-space: nowrap !important;
        text-overflow: ellipsis;
        display: block !important;
        text-overflow: ellipsis;
    }

            .product-item-wrapper .product-title a {
                display: block;
                overflow: hidden;
                color: inherit;
            }

            .product-item-wrapper .rating_wrap {
                min-height: 22px;
            }

            .product-item-wrapper .product-price {
                min-height: 34px;
                margin-top: auto;
            }

    @media (max-width: 767px) {
                .products-listing .row,
                .shop-product-fillter .row,
                .row.product-grid-4,
                .row.product-grid-3,
                .row.product-grid-5 {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
                    gap: 10px;
                    margin: 0 !important;
                }

                .products-listing .row > [class*="col-"],
                .shop-product-fillter .row > [class*="col-"],
                .row.product-grid-4 > [class*="col-"],
                .row.product-grid-3 > [class*="col-"],
                .row.product-grid-5 > [class*="col-"] {
                    width: 100% !important;
                    max-width: 100% !important;
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                    margin-bottom: 0 !important;
                    min-width: 0 !important;
                }

                .product-item-wrapper.product-cart-wrap {
                    display: flex !important;
                    height: 100% !important;
                    min-height: 0 !important;
                    margin-bottom: 0 !important;
                    padding: 8px !important;
                    border: 1px solid #e5e7eb !important;
                    border-radius: 8px !important;
                    overflow: hidden;
                }

                .product-item-wrapper .product-img {
                    min-height: 0;
                    height: clamp(104px, 31vw, 142px) !important;
                    aspect-ratio: auto;
                    margin-bottom: 6px;
                }

                .product-item-wrapper .product-img .hover-img {
                    display: none !important;
                }

                .product-item-wrapper .product-content-wrap {
                    position: static !important;
                    min-height: 0 !important;
                    margin-top: 0 !important;
                    padding: 6px 0 0 !important;
                }

                .product-item-wrapper .product-category {
                    min-height: 16px !important;
                    max-height: 16px !important;
                    font-size: 0.7rem !important;
                    line-height: 16px !important;
                    overflow: hidden !important;
                    display: block !important;
                    white-space: nowrap !important;
                    text-overflow: ellipsis !important;
                }

                .product-item-wrapper .product-title,
                .product-item-wrapper h2.product-title,
                .product-item-wrapper .text-truncate {
                    position: static !important;
                    height: auto !important;
                    min-height: 20px !important;
                    max-height: 20px !important;
                    margin: 0 0 6px !important;
                    padding: 0 !important;
                    font-size: 0.85rem !important;
                    line-height: 1.35 !important;
                    white-space: nowrap !important;
                    background: transparent !important;
                    z-index: auto !important;
                    overflow: hidden !important;
                    text-overflow: ellipsis !important;
                }

                .product-item-wrapper .product-title a {
                    display: block !important;
                    width: 100% !important;
                    overflow: hidden !important;
                    white-space: nowrap !important;
                    text-overflow: ellipsis !important;
                }

                .product-item-wrapper .rating_wrap {
                    position: static !important;
                    min-height: 18px !important;
                    margin: 0 0 4px !important;
                }

                .product-item-wrapper .rating {
                    transform: scale(0.82);
                    transform-origin: left center;
                }

                .product-item-wrapper .rating_num {
                    font-size: 0.7rem !important;
                }

                .product-item-wrapper .product-price {
                    position: static !important;
                    min-height: 32px;
                    margin-bottom: 4px !important;
                    font-size: 0.85rem !important;
                    z-index: auto !important;
                }

                .product-item-wrapper .product-price span {
                    font-size: 1rem !important;
                    line-height: 1.2 !important;
                }

                .product-item-wrapper .product-price .old-price {
                    font-size: 0.74rem !important;
                }

                .product-item-wrapper .product-action-1 .action-btn,
                .product-item-wrapper .add-to-cart-button {
                    width: 32px !important;
                    height: 32px !important;
                    line-height: 32px !important;
                    font-size: 12px !important;
                }

                .product-item-wrapper .product-badges span {
                    font-size: 9px !important;
                    padding: 3px 6px !important;
                }
            }

            .category-products-page .product-item-wrapper .product-category a {
                    display: block;
                    overflow: hidden;
                    white-space: nowrap;
                    text-overflow: ellipsis;
                }
        </style>
    @endonce
@endif
