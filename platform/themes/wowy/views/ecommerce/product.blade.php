@php
    $layout = MetaBox::getMetaData($product, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-right-sidebar';
    Theme::layout($layout);

    Theme::asset()->usePath()->add('lightGallery-css', 'plugins/lightGallery/css/lightgallery.min.css');
    Theme::asset()->container('footer')->usePath()
        ->add('lightGallery-js', 'plugins/lightGallery/js/lightgallery.min.js', ['jquery']);

    $productCanonicalUrl = $productCanonicalUrl ?? url()->current();
    $productSeoDescription = trim(strip_tags((string) ($seoDescription ?? $product->description ?? $product->content ?? '')));
    $productSchemaImages = collect($productImages ?? [$product->image])
        ->filter()
        ->map(fn ($image) => RvMedia::getImageUrl($image, 'origin', false, RvMedia::getDefaultImage()))
        ->filter()
        ->unique()
        ->values()
        ->all();

    if (empty($productSchemaImages)) {
        $productSchemaImages = [RvMedia::getImageUrl($product->image, 'origin', false, RvMedia::getDefaultImage())];
    }

    $productOfferSchema = [
        '@type' => 'Offer',
        'url' => $productCanonicalUrl,
        'priceCurrency' => get_application_currency()->title ?: 'THB',
        'price' => (string) $product->front_sale_price_with_taxes,
        'availability' => $product->isOutOfStock() ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock',
        'itemCondition' => 'https://schema.org/NewCondition',
    ];

    $productStructuredData = [
        '@type' => 'Product',
        '@id' => $productCanonicalUrl . '#product',
        'name' => $product->name,
        'description' => $productSeoDescription,
        'image' => $productSchemaImages,
        'sku' => $product->sku ?: (string) $product->getKey(),
        'brand' => [
            '@type' => 'Brand',
            'name' => $product->brand?->name ?: 'RUBYSHOP',
        ],
        'offers' => $productOfferSchema,
    ];

    $breadcrumbStructuredData = [
        '@type' => 'BreadcrumbList',
        '@id' => $productCanonicalUrl . '#breadcrumb',
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
                'name' => $product->name,
                'item' => $productCanonicalUrl,
            ],
        ],
    ];

    $productPageStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            $productStructuredData,
            $breadcrumbStructuredData,
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode($productPageStructuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<style>
    .product-detail .detail-gallery img {
        background-color: transparent !important;
    }

    .product-detail .product-image-slider figure {
        margin: 0;
        aspect-ratio: 1 / 1;
        background: #fff;
    }

    .product-detail .product-image-slider figure a {
        display: flex;
        width: 100%;
        height: 100%;
        align-items: center;
        justify-content: center;
    }

    .product-detail .product-image-slider figure img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .product-detail .slider-nav-thumbnails img {
        aspect-ratio: 1 / 1;
        width: 100%;
        height: auto;
        object-fit: contain;
        background: #fff;
    }

    .product-detail .single-social-share .mobile-social-icon a {
        background: transparent !important;
        border: 0 !important;
        box-shadow: none !important;
        color: #1f2937 !important;
        opacity: 1 !important;
    }

    .product-detail .single-social-share .mobile-social-icon a i {
        color: #1f2937 !important;
    }

    .product-detail .product-more-actions {
        position: relative;
        display: inline-block;
    }

    .product-detail .product-more-actions .more-btn {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        border: 1px solid #d1d5db;
        background: #fff;
        color: #111827;
        font-size: 18px;
        line-height: 1;
    }

    .product-detail .product-more-actions-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 220px;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        padding: 8px;
        z-index: 30;
        display: none;
    }

    .product-detail .product-more-actions-menu.is-open {
        display: block;
    }

    .product-detail .product-more-actions-menu a {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        width: 100% !important;
        padding: 10px 12px !important;
        border-radius: 8px;
        color: #111827 !important;
        text-decoration: none !important;
        line-height: 1.35 !important;
        white-space: nowrap !important;
    }

    .product-detail .product-more-actions-menu a i {
        flex: 0 0 16px !important;
        width: 16px !important;
        text-align: center !important;
        font-size: 14px !important;
        margin: 0 !important;
    }

    .product-detail .product-more-actions-menu a span {
        display: block !important;
        flex: 1 1 auto !important;
        font-size: 14px !important;
        font-weight: 500 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }

    .product-detail .product-more-actions-menu a:hover {
        background: #f3f4f6;
    }

    .product-detail .detail-extralink {
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        flex-wrap: nowrap !important;
    }

    .product-detail .detail-extralink .detail-qty {
        margin: 0 !important;
        flex: 0 0 auto !important;
    }

    .product-detail .detail-extralink .product-extra-link2 {
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: nowrap !important;
        margin: 0 !important;
    }

    .product-detail .detail-extralink .product-extra-link2 .button {
        margin: 0 !important;
        white-space: nowrap !important;
    }

    @media (max-width: 767px) {
        .product-detail .product-more-actions-menu {
            right: 0 !important;
            min-width: 190px !important;
            max-width: 220px !important;
        }

        .product-detail .detail-extralink {
            align-items: stretch !important;
            flex-wrap: wrap !important;
            overflow: visible !important;
            gap: 8px !important;
            padding-bottom: 0;
        }

        .product-detail .detail-extralink .detail-qty {
            height: 44px;
        }

        .product-detail .detail-extralink .product-extra-link2 {
            display: grid !important;
            flex: 1 1 100% !important;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr) auto;
            gap: 8px !important;
            width: 100%;
        }

        .product-detail .detail-extralink .product-extra-link2 .button {
            display: flex !important;
            min-width: 0 !important;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            padding: 10px 12px !important;
            white-space: normal !important;
            line-height: 1.2 !important;
            text-align: center;
        }

        .product-detail .product-extra-link2 .product-more-actions {
            margin-left: 0 !important;
        }

        .product-detail .product-more-actions .more-btn {
            width: 44px;
            height: 44px;
        }

        .product-detail .tab-style3 .nav-tabs {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            gap: 14px;
            padding-bottom: 4px;
        }

        .product-detail .tab-style3 .nav-tabs .nav-item {
            flex: 0 0 auto;
        }

        .product-detail .tab-style3 .nav-tabs .nav-link {
            margin: 0 !important;
            white-space: nowrap;
        }

        .product-detail .tp-product-details-additional-info {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .product-detail .tp-product-details-additional-info table {
            width: 100%;
            min-width: 0;
        }

        .product-detail .tp-product-details-additional-info th,
        .product-detail .tp-product-details-additional-info td {
            width: auto !important;
            padding: 10px 12px !important;
            word-break: break-word;
        }
    }

    @media (max-width: 767px) {
        .product-detail .detail-gallery,
        .product-detail .product-image-slider,
        .product-detail .slider-nav-thumbnails {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }

        .product-detail .row.mb-50 {
            margin-bottom: 0 !important;
        }

        .product-detail .row.mb-50 > .col-md-6 {
            padding-top: 0 !important;
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        .product-detail .detail-info {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .product-detail .row.mb-50 > .col-md-6:last-child {
            margin-top: 0 !important;
        }

        .product-detail .detail-info .title-detail {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.3;
            margin-top: 0 !important;
            margin-bottom: 0.25rem !important;
            font-size: 1.5rem;
        }

        .product-detail .detail-info .product-detail-rating {
            margin-top: 0 !important;
            margin-bottom: 0.35rem !important;
        }

        .product-detail .detail-info .clearfix.product-price-cover {
            margin-top: 0 !important;
            margin-bottom: 0.35rem !important;
        }

        .product-detail .detail-info .bt-1.border-color-1.mt-15.mb-15 {
            margin-top: 0.35rem !important;
            margin-bottom: 0.5rem !important;
        }

        .product-detail .detail-info .short-desc.mb-30 {
            margin-bottom: 0.75rem !important;
        }
    }

    @media (max-width: 420px) {
        .product-detail .detail-extralink .product-extra-link2 {
            grid-template-columns: 1fr;
        }

        .product-detail .product-more-actions,
        .product-detail .product-more-actions .more-btn {
            width: 100%;
            border-radius: 8px;
        }
    }
</style>
<div class="product-detail accordion-detail mx-4">
    <div class="row mb-50">
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-gallery">
                <div class="product-image-slider">
                    @foreach ($productImages as $img)
                        <figure class="border-radius-10">
                            <a href="{{ RvMedia::getImageUrl($img) }}">
                                <img src="{{ RvMedia::getImageUrl($img, 'medium') }}" alt="{{ $product->name }}" width="800" height="800" @if ($loop->first) loading="eager" fetchpriority="high" @else loading="lazy" @endif decoding="async">
                            </a>
                        </figure>
                    @endforeach
                </div>
                <div class="slider-nav-thumbnails pl-15 pr-15">
                    @foreach ($productImages as $img)
                        <div><img src="{{ RvMedia::getImageUrl($img, 'thumb') }}" alt="{{ $product->name }}" width="150" height="150" loading="lazy" decoding="async"></div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 col-xs-12">
            <div class="detail-info">
                <h1 class="title-detail pt-4">{{ $product->name }}</h1>
                <div class="clearfix product-price-cover">
                    <div class="product-price primary-color float-left">
                        <ins><span class="text-brand">{{ format_price($product->front_sale_price_with_taxes) }}</span></ins>
                        @if ($product->front_sale_price !== $product->price)
                            <ins><span class="old-price font-md ml-15">{{ format_price($product->price_with_taxes) }}</span></ins>
                            <span class="save-price font-md color3 ml-15"><span class="percentage-off d-inline-block">{{ get_sale_percentage($product->price, $product->front_sale_price) }}</span> <span class="d-inline-block">{{ __('Off') }}</span></span>
                        @endif
                    </div>
                </div>
                <div class="bt-1 border-color-1 mt-15 mb-15"></div>
                <div class="short-desc mb-30">
                    {!! apply_filters('ecommerce_before_product_description', null, $product) !!}
                    {!! BaseHelper::clean($product->description) !!}
                    {!! apply_filters('ecommerce_after_product_description', null, $product) !!}
                </div>

                <div class="bt-1 border-color-1 mt-30 mb-30"></div>
                <form class="add-to-cart-form" method="POST" action="{{ route('public.cart.add-to-cart') }}">
                    @csrf

                    @if ($product->variations()->count() > 0)
                        <div class="pr_switch_wrap">
                            {!! render_product_swatches($product, [
                                'selected' => $selectedAttrs,
                                'view'     => Theme::getThemeNamespace() . '::views.ecommerce.attributes.swatches-renderer'
                            ]) !!}
                        </div>
                        <div class="number-items-available" style="@if (!$product->isOutOfStock()) display: none; @endif margin-bottom: 10px;">
                            @if ($product->isOutOfStock())
                                <span class="text-danger">({{ __('Out of stock') }})</span>
                            @endif
                        </div>
                    @endif

                    {!! render_product_options($product) !!}

                    {!! apply_filters(ECOMMERCE_PRODUCT_DETAIL_EXTRA_HTML, null, $product) !!}
                    <input type="hidden" name="id" class="hidden-product-id" value="{{ ($product->is_variation || !$product->defaultVariation->product_id) ? $product->id : $product->defaultVariation->product_id }}"/>
                    <div class="detail-extralink">
                        @if (EcommerceHelper::isCartEnabled())
                            <div class="detail-qty border radius">
                                <a href="#" class="qty-down"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
                                <input type="number" min="1" value="1" name="qty" class="qty-val qty-input" />
                                <a href="#" class="qty-up"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
                            </div>
                        @endif

                        <div class="product-extra-link2 @if (EcommerceHelper::isQuickBuyButtonEnabled()) has-buy-now-button @endif">
                            @if (EcommerceHelper::isCartEnabled())
                                <button type="submit" class="button button-add-to-cart @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" @if ($product->isOutOfStock()) disabled @endif>{{ __('Add to cart') }}</button>
                                @if (EcommerceHelper::isQuickBuyButtonEnabled())
                                    <button class="button button-buy-now ms-2 @if ($product->isOutOfStock()) btn-disabled @endif" type="submit" name="checkout" @if ($product->isOutOfStock()) disabled @endif>{{ __('Buy Now') }}</button>
                                @endif
                            @endif

                            @if (EcommerceHelper::isWishlistEnabled())
                                
                            @endif
                            @if (EcommerceHelper::isCompareEnabled())
                                
                            @endif
                            <div class="product-more-actions ms-2">
                                <button class="more-btn product-more-toggle" type="button" aria-label="{{ __('More actions') }}">...</button>
                                <div class="product-more-actions-menu product-more-menu" role="menu" aria-hidden="true">
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <a aria-label="{{ __('Add To Wishlist') }}" class="js-add-to-wishlist-button" data-url="{{ route('public.wishlist.add', $product->id) }}" href="#" role="menuitem">
                                            <i class="far fa-heart"></i>
                                            <span>{{ __('Add To Wishlist') }}</span>
                                        </a>
                                    @endif
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <a aria-label="{{ __('Add To Compare') }}" href="#" class="js-add-to-compare-button" data-url="{{ route('public.compare.add', $product->id) }}" role="menuitem">
                                            <i class="far fa-exchange-alt"></i>
                                            <span>{{ __('Add To Compare') }}</span>
                                        </a>
                                    @endif
                                    <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on Facebook') }}" role="menuitem">
                                        <i class="fab fa-facebook-f"></i>
                                        <span>{{ __('Share on Facebook') }}</span>
                                    </a>
                                    <a class="twitter" href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ strip_tags(strip_tags(SeoHelper::getDescription())) }}" target="_blank" rel="noopener noreferrer" aria-label="{{ __('Share on X') }}" role="menuitem">
                                        <i class="fab fa-twitter"></i>
                                        <span>{{ __('Share on X') }}</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <ul class="product-meta font-xs color-grey mt-50">

                    <li class="mb-5 @if (! $product->sku) d-none @endif"><span class="d-inline-block me-1" id="product-sku">{{ __('SKU') }}</span>: <span>{{ $product->sku }}</span></li>

                    @if ($product->categories->isNotEmpty())
                        <li class="mb-5"><span class="d-inline-block me-1">{{ __('Categories') }}:</span>
                        @foreach($product->categories as $category)
                            @php
                                $categoryCanLink = $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url;
                            @endphp
                            @if ($categoryCanLink)
                                <a href="{{ $category->url }}" title="{{ $category->name }}">{{ $category->name }}</a>
                            @else
                                <span title="{{ $category->name }}">{{ $category->name }}</span>
                            @endif
                            @if (!$loop->last),@endif
                        @endforeach
                    </li>
                    @endif
                    @if ($product->tags->isNotEmpty())
                        <li class="mb-5"><span class="d-inline-block me-1">{{ __('Tags') }}:</span>
                        @foreach($product->tags as $tag)
                            <a href="{{ $tag->url }}" rel="tag" title="{{ $tag->name }}">{{ $tag->name }}</a>@if (!$loop->last),@endif
                        @endforeach
                        </li>
                    @endif

                    <li><span class="d-inline-block me-1">{{ __('Availability') }}:</span> <span class="in-stock text-success ml-5">{!! BaseHelper::clean($product->stock_status_html) !!}</span></li>
                </ul>
            </div>
            <!-- Detail Info -->

        </div>
    </div>
    <div class="tab-style3">
        <ul class="nav nav-tabs text-uppercase">
            <li class="nav-item">
                <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">{{ __('Description') }}</a>
            </li>
            @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-specification">{{ __('Specification') }}</a></li>
            @endif
            @if (EcommerceHelper::isReviewEnabled())
                <li class="nav-item">
                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">{{ __('Reviews') }} ({{ $product->reviews_count }})</a>
                </li>
            @endif
            @if (is_plugin_active('faq'))
                @if (count($product->faq_items) > 0)
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#tab-faq">{{ __('Questions and Answers') }}</a>
                    </li>
                @endif
            @endif
        </ul>
        <div class="tab-content shop_info_tab entry-main-content">
            <div class="tab-pane fade show active" id="Description">
                <div class="ck-content">
                    {!! BaseHelper::clean($product->content) !!}
                </div>
                {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $product) !!}
            </div>

            @if (EcommerceHelper::isProductSpecificationEnabled() && $product->specificationAttributes->where('pivot.hidden', false)->isNotEmpty())
                <div class="tab-pane fade" id="tab-specification">
                    <div class="tp-product-details-additional-info">
                        @include(EcommerceHelper::viewPath('includes.product-specification'))
                    </div>
                </div>
            @endif

            @if (is_plugin_active('faq') && count($product->faq_items) > 0)
                <div class="tab-pane fade faqs-list" id="tab-faq">
                    <div class="accordion" id="faq-accordion">
                        @foreach($product->faq_items as $faq)
                            <div class="card">
                                <div class="card-header" id="heading-faq-{{ $loop->index }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left @if (!$loop->first) collapsed @endif" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-faq-{{ $loop->index }}" aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse-faq-{{ $loop->index }}">
                                            {!! BaseHelper::clean($faq[0]['value']) !!}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapse-faq-{{ $loop->index }}" class="collapse @if ($loop->first) show @endif" aria-labelledby="heading-faq-{{ $loop->index }}" data-bs-parent="#faq-accordion">
                                    <div class="card-body">
                                        {!! BaseHelper::clean($faq[1]['value']) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if (EcommerceHelper::isReviewEnabled())
                <div class="tab-pane fade" id="Reviews">
                    @include('plugins/ecommerce::themes.includes.reviews', ['reviewButtonClass' => 'button'])
                </div>
            @endif
        </div>
    </div>

    @php
        $crossSellProducts = get_cross_sale_products($product, $layout == 'product-full-width' ? 4 : 3);
    @endphp
    @if (count($crossSellProducts) > 0)
        <div class="row mt-60">
            <div class="col-12">
                <h2 class="section-title style-1 mb-30">{{ __('You may also like') }}</h2>
            </div>
            @foreach($crossSellProducts as $crossProduct)
                <div class="col-lg-{{ 12 / ($layout == 'product-full-width' ? 4 : 3) }} col-md-4 col-12 col-sm-6">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', ['product' => $crossProduct])
                </div>
            @endforeach
        </div>
    @endif

    @php
        $relatedProducts = get_related_products($product, 6);
    @endphp

    @if (count($relatedProducts) > 0)
        <div class="row mt-60" id="related-products">
            <div class="col-12">
                <h2 class="section-title style-1 mb-30">{{ __('Related products') }}</h2>
            </div>
            @foreach($relatedProducts as $relatedProduct)
                <div class="col-lg-{{ 12 / ($layout == 'product-full-width' ? 4 : 3) }} col-md-4 col-sm-6 col-6">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-item', ['product' => $relatedProduct])
                </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    // Meta Pixel — ViewContent
    if (typeof fbq === 'function') {
        fbq('track', 'ViewContent', {
            content_ids: ['{{ $product->id }}'],
            content_name: '{{ addslashes($product->name) }}',
            content_type: 'product',
            value: {{ $product->front_sale_price ?? $product->price ?? 0 }},
            currency: 'THB'
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        var toggle = document.querySelector('.product-more-toggle');
        var menu = document.querySelector('.product-more-menu');
        if (!toggle || !menu) {
            return;
        }

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            menu.classList.toggle('is-open');
        });

        document.addEventListener('click', function (event) {
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                menu.classList.remove('is-open');
            }
        });
    });
</script>
