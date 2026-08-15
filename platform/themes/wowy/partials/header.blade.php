<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        @php
            $path = trim(request()->path(), '/');
            $normalizedPath = $path;

            foreach (['th', 'en'] as $locale) {
                if ($normalizedPath === $locale) {
                    $normalizedPath = '';
                    break;
                }

                if (str_starts_with($normalizedPath, $locale . '/')) {
                    $normalizedPath = substr($normalizedPath, strlen($locale) + 1);
                    break;
                }
            }

            $isUtilityNoindexPage = request()->is('cart')
                || request()->is('compare')
                || request()->is('wishlist')
                || request()->is('login')
                || request()->is('register')
                || request()->is('checkout*')
                || request()->is('customer*')
                || request()->is('orders/tracking*')
                || request()->is('currency/switch/*');
            $hasQueryString = request()->getQueryString() !== null && request()->getQueryString() !== '';
            $isListingQueryNoindexPage = $hasQueryString
                && (
                    $normalizedPath === 'products'
                    || $normalizedPath === 'product-categories'
                    || $normalizedPath === 'allproducts'
                    || str_starts_with($normalizedPath, 'allproducts/category/')
                    || str_starts_with($normalizedPath, 'product-categories/')
                    || str_starts_with($normalizedPath, 'sub/')
                    || $normalizedPath === 'search'
                    || $normalizedPath === 'blog'
                );
            $isListingBaseIndexPage = ! $hasQueryString
                && ($normalizedPath === 'products' || $normalizedPath === 'product-categories');
            $isContactPage = request()->is('contact*');
            $robotsContent = null;

            if ($isUtilityNoindexPage || $isListingQueryNoindexPage) {
                $robotsContent = 'noindex,follow';
            } elseif ($isListingBaseIndexPage) {
                $robotsContent = 'index,follow';
            }

            $isCategoryPage = $normalizedPath === 'product-categories'
                || str_starts_with($normalizedPath, 'product-categories/')
                || str_contains($normalizedPath, '/product-categories/');
            $canonicalContent = ($isListingQueryNoindexPage || $isListingBaseIndexPage) ? url()->current() : null;
        @endphp
        @if ($robotsContent)
            <meta name="robots" content="{{ $robotsContent }}">
        @endif
        
        <!-- Resource Hints for Performance -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        @php
            $isHomePage = request()->path() === '/' || request()->routeIs('public.index');
            $useTailwindCss = true;
            $cssVersion = '20260604-1';
            $useTailwindCdn = false;
        @endphp
        @if ($isHomePage)
            <link rel="preload" as="image" href="{{ asset('storage/logo/coverpage.webp') }}" fetchpriority="high" media="(max-width: 767px)" type="image/webp">
            <link rel="preload" as="image" href="{{ asset('storage/home/hero-medium-first-frame.webp') }}" fetchpriority="high" media="(min-width: 768px)" type="image/webp">
        @endif
        @if ($useTailwindCss)
            <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}?v={{ $cssVersion }}">
        @endif
        @if ($useTailwindCdn)
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Meta Pixel Base Code -->
        <script src="{{ Theme::asset()->url('js/rubyshop-meta-pixel-tracking.js') }}?v=20260604-1" defer></script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=1559144322039457&ev=PageView&noscript=1" alt="Meta Pixel tracking"></noscript>
        <!-- End Meta Pixel Base Code -->
        <!-- Non-critical CSS loaded in footer to keep initial render path lean -->

        <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap"></noscript>

        <style>
            :root {
                --font-text: Prompt;
                --color-brand: {{ theme_option('color_brand', '#5897fb') }};
                --primary-color: {{ theme_option('color_brand', '#5897fb') }};
                --color-brand-2: {{ theme_option('color_brand_2', '#3256e0') }};
                --color-primary: {{ theme_option('color_primary', '#3f81eb') }};
                --color-secondary: {{ theme_option('color_secondary', '#41506b') }};
                --color-warning: {{ theme_option('color_warning', '#ffb300') }};
                --color-danger: {{ theme_option('color_danger', '#ff3551') }};
                --color-success: {{ theme_option('color_success', '#3ed092') }};
                --color-info: {{ theme_option('color_info', '#18a1b7') }};
                --color-text: {{ theme_option('color_text', '#4f5d77') }};
                --color-heading: {{ theme_option('color_heading', '#222222') }};
                --color-grey-1: {{ theme_option('color_grey_1', '#111111') }};
                --color-grey-2: {{ theme_option('color_grey_2', '#242424') }};
                --color-grey-4: {{ theme_option('color_grey_4', '#90908e') }};
                --color-grey-9: {{ theme_option('color_grey_9', '#f4f5f9') }};
                --color-muted: {{ theme_option('color_muted', '#8e8e90') }};
                --color-body: {{ theme_option('color_body', '#4f5d77') }};
            }
        .mobile-categories-wrap { display: none !important; }

        /* ── RS Drawer (mobile sidebar) ── */
        /* Override theme's red brand background on the inner wrapper */
        .mobile-header-wrapper-inner.rs-drw {
            background-color: #fff !important;
            padding: 0 !important;
        }
        .rs-drw { display:flex; flex-direction:column; height:100%; font-family:inherit; }

        /* Head */
        .rs-drw-head {
            display:flex; align-items:center; justify-content:space-between;
            padding:14px 18px 12px;
            background:var(--color-brand);
            flex-shrink:0;
        }
        .rs-drw-logo img { height:32px; width:auto; display:block; }
        .mobile-menu-close { display:flex; align-items:center; }
        .rs-drw-close {
            display:grid; place-items:center;
            width:36px; height:36px;
            background:rgba(255,255,255,.1);
            border:none; border-radius:8px;
            color:#fff; cursor:pointer;
            transition:background .2s;
        }
        .rs-drw-close:hover { background:rgba(255,255,255,.22); }

        /* Body */
        .rs-drw-body { flex:1; overflow-y:auto; padding:14px 14px 0; }
        .rs-drw-body::-webkit-scrollbar { width:3px; }
        .rs-drw-body::-webkit-scrollbar-thumb { background:#d1d5db; border-radius:2px; }


        /* Nav — override theme's white-on-red menu styles */
        .rs-drw-menu li {
            border-bottom: 1px solid #f0f2f5 !important;
            padding: 0 !important;
        }
        .rs-drw-menu li:last-child { border-bottom: none !important; }
        .rs-drw-menu li a,
        .rs-drw-menu li > a {
            color: #16233F !important;
            display: flex !important;
            align-items: center !important;
            padding: 13px 4px !important;
            font-size: 14.5px !important;
            font-weight: 600 !important;
            line-height: 1.3 !important;
            text-transform: none !important;
        }
        .rs-drw-menu li a:hover,
        .rs-drw-menu li > a:hover { color: #D8251D !important; }
        /* sub-items */
        .rs-drw-menu li ul {
            border-top: 1px solid #f0f2f5 !important;
            margin-top: 0 !important;
            padding: 4px 0 8px 14px !important;
        }
        .rs-drw-menu li ul li {
            border-bottom: none !important;
            padding: 0 !important;
        }
        .rs-drw-menu li ul li a {
            color: #4b5563 !important;
            font-size: 13.5px !important;
            font-weight: 400 !important;
            padding: 8px 4px !important;
        }
        .rs-drw-menu li ul li a:hover { color: #D8251D !important; }
        .rs-drw-menu li:hover > a { color: #D8251D !important; }
        /* expand button */
        .rs-drw-menu .menu-expand {
            color: #9ca3af !important;
            background: transparent !important;
            border-radius: 6px !important;
            width: 32px !important; height: 32px !important;
            line-height: 32px !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            font-size: 12px !important;
        }
        .rs-drw-menu .menu-item-has-children.active > .menu-expand {
            background: #f3f4f6 !important;
            color: #16233F !important;
        }

        /* Nav */
        .rs-drw-nav { margin-bottom:4px; }
        .rs-drw-menu { list-style:none; margin:0; padding:0; }
        .rs-drw-menu > li {
            border-bottom:1px solid #f3f4f6;
        }
        .rs-drw-menu > li:last-child { border-bottom:none; }
        .rs-drw-menu > li > a {
            display:flex; align-items:center; gap:10px;
            padding:12px 4px;
            font-size:15px; font-weight:600; color:#16233F;
            text-decoration:none; line-height:1.3;
        }
        .rs-drw-menu > li > a:hover { color:#D8251D; }
        /* Nested menus */
        .rs-drw-menu .dropdown { list-style:none; padding:0 0 4px 16px; margin:0; }
        .rs-drw-menu .dropdown li a {
            display:block; padding:7px 4px;
            font-size:13.5px; color:#4b5563; text-decoration:none;
        }
        .rs-drw-menu .dropdown li a:hover { color:#D8251D; }
        .rs-drw-menu .menu-expand {
            margin-left:auto; background:none; border:none; padding:4px;
            color:#6b7280; cursor:pointer; line-height:1;
            transition:transform .25s;
        }
        .rs-drw-menu .menu-item-has-children.active .menu-expand { transform:rotate(180deg); }

        /* All-categories CTA */
        .rs-drw-allcats {
            display:flex; align-items:center; gap:10px;
            padding:11px 14px;
            background:#f8f9fa; border:1px solid #e9ecef;
            border-radius:10px; margin-bottom:14px;
            font-size:14px; font-weight:600; color:#16233F;
            text-decoration:none;
            transition:background .2s;
        }
        .rs-drw-allcats:hover { background:#e9ecef; color:#D8251D; }

        /* Footer */
        .rs-drw-foot { padding:14px; border-top:1px solid #f0f0f0; flex-shrink:0; }

        /* Login CTA */
        .rs-drw-login {
            display:flex; align-items:center; justify-content:center; gap:8px;
            width:100%; padding:12px 14px;
            background:#D8251D; color:#fff;
            border-radius:10px; text-decoration:none;
            font-size:14.5px; font-weight:700;
            margin-bottom:12px;
            transition:background .2s;
        }
        .rs-drw-login:hover { background:#b81e17; color:#fff; }

        /* Bottom row */
        .rs-drw-bottom { display:flex; align-items:center; gap:12px; justify-content:space-between; }

        /* Social */
        .rs-drw-social { display:flex; gap:8px; }
        .rs-drw-soc-btn {
            display:grid; place-items:center;
            width:34px; height:34px;
            border-radius:50%; background:#f3f4f6;
            color:#374151; text-decoration:none;
            transition:background .2s, color .2s;
        }
        .rs-drw-soc-btn:hover { background:#16233F; color:#fff; }

        /* Language toggle */
        .rs-drw-meta { position:relative; }
        .rs-drw-meta-toggle {
            display:flex; align-items:center; gap:6px;
            font-size:13px; color:#6b7280; text-decoration:none;
            padding:6px 10px; border-radius:8px; background:#f3f4f6;
            white-space:nowrap;
        }
        .rs-drw-meta-toggle:hover { background:#e9ecef; color:#16233F; }
        .rs-drw-meta-drop {
            position:absolute; bottom:calc(100% + 6px); right:0;
            background:#fff; border:1px solid #e5e7eb; border-radius:10px;
            box-shadow:0 8px 24px rgba(0,0,0,.12); z-index:99;
            min-width:140px; display:none;
        }
        .rs-drw-meta-drop.show,
        .rs-drw-meta-drop.active { display:block; }
        .rs-drw-meta-drop ul { list-style:none; margin:0; padding:6px 0; }
        .rs-drw-meta-drop ul li a {
            display:flex; align-items:center; gap:8px;
            padding:9px 14px; font-size:13.5px; color:#374151;
            text-decoration:none;
        }
        .rs-drw-meta-drop ul li a:hover { background:#f9fafb; color:#D8251D; }

        </style>

        @php
            if ($isHomePage) {
                Theme::asset()->remove([
                    'ckeditor-content-styles',
                    'animate-css',
                ]);
            }

            $isLeanAssetPage = $isHomePage
                || $normalizedPath === 'blog'
                || str_starts_with($normalizedPath, 'blog/')
                || $normalizedPath === 'products'
                || str_starts_with($normalizedPath, 'products/')
                || $normalizedPath === 'product-categories'
                || str_starts_with($normalizedPath, 'product-categories/');

            if ($isLeanAssetPage) {
                Theme::asset()->remove([
                    'custom-scrollbar-css',
                    'animate-css',
                ]);
            }

            $themeHeader = Theme::header();

            $themeHeader = preg_replace(
                '/<link\b(?=[^>]*fonts\.googleapis\.com\/css2\?family=Inter)[^>]*>\s*/i',
                '',
                $themeHeader
            ) ?? $themeHeader;

            if ($isHomePage) {
                $deferredHomeCss = [
                    'vendor/core/plugins/language/css/language-public.css',
                    'vendor/core/plugins/cookie-consent/css/cookie-consent.css',
                    'themes/wowy/css/vendors/normalize.css',
                    'themes/wowy/css/vendors/fontawesome-all.min.css',
                    'themes/wowy/css/vendors/wowy-font.css',
                    'vendor/core/plugins/ecommerce/css/front-ecommerce.css',
                    'themes/wowy/css/style.integration.css',
                ];

                foreach ($deferredHomeCss as $cssPath) {
                    $themeHeader = preg_replace_callback(
                        '/<link\b(?=[^>]*\brel=(["\'])stylesheet\1)(?=[^>]*' . preg_quote($cssPath, '/') . ')[^>]*>/i',
                        function (array $matches): string {
                            $link = $matches[0];

                            if (str_contains($link, 'onload=')) {
                                return $link;
                            }

                            $link = preg_replace('/\smedia=(["\'])(?:all|screen)\1/i', '', $link) ?: $link;

                            return rtrim($link, '>') . ' media="print" onload="this.media=\'all\'">';
                        },
                        $themeHeader
                    ) ?? $themeHeader;
                }
            }

            if ($robotsContent) {
                $themeHeader = preg_replace(
                    '/<meta\b(?=[^>]*\bname=(["\'])robots\1)[^>]*>\s*/i',
                    '',
                    $themeHeader
                ) ?? $themeHeader;
            }

            if (isset($seoDescription)) {
                $themeHeader = preg_replace(
                    '/<meta\b(?=[^>]*\bname=(["\'])description\1)[^>]*>\s*/i',
                    '',
                    $themeHeader
                ) ?? $themeHeader;
            }

            if ($isHomePage) {
                $themeHeader = preg_replace(
                    '/<link\b(?=[^>]*fonts\.googleapis\.com\/css2\?family=Inter\b)[^>]*>\s*/i',
                    '',
                    $themeHeader
                ) ?? $themeHeader;
            }

            if ($canonicalContent) {
                $themeHeader = preg_replace(
                    '/<link\b(?=[^>]*\brel=(["\'])canonical\1)[^>]*>\s*/i',
                    '',
                    $themeHeader
                ) ?? $themeHeader;

                $themeHeader .= PHP_EOL . '<link rel="canonical" href="' . e($canonicalContent) . '">';
            }

            $normalizeSeoText = function (?string $text): string {
                $text = strip_tags((string) $text);
                $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $text = str_replace("\xC2\xA0", ' ', $text);
                $text = preg_replace('/\\s+/u', ' ', $text) ?: '';

                return trim($text);
            };

            $seoTitle = $normalizeSeoText(SeoHelper::getTitle() ?: theme_option('seo_title', theme_option('site_title', 'RUBYSHOP')));
            $seoDescription = $normalizeSeoText(SeoHelper::getDescription() ?: theme_option('seo_description', ''));
            $defaultContactDescription = 'ติดต่อ Rubyshop เพื่อรับข้อมูลสินค้า เครื่องมือช่าง และการสนับสนุนสำหรับลูกค้าทุกระดับ ทั้งลูกค้ารายย่อยและโครงการ';
            $isProductsIndexPage = ! $hasQueryString && $normalizedPath === 'products';

            if (! $seoTitle) {
                $seoTitle = $isContactPage ? 'Contact | RUBYSHOP' : theme_option('site_title', 'RUBYSHOP');
            }

            if (! $seoDescription) {
                $seoDescription = $isContactPage ? $defaultContactDescription : theme_option('seo_description', '');
            }

            if ($isProductsIndexPage) {
                $seoTitle = 'สินค้าทั้งหมด เครื่องมือช่าง RUBYSHOP';
                $seoDescription = 'เลือกซื้อเครื่องมือช่าง RUBYSHOP สำหรับงานพ่นสี พ่นปูน กรีดผนัง ขัดผนัง อุปกรณ์เสริม และอะไหล่ พร้อมบริการสำหรับช่างมืออาชีพ';
            }

            if (mb_strlen($seoDescription) > 155) {
                $seoDescription = rtrim(mb_substr($seoDescription, 0, 152)) . '...';
            }
            $seoImage = trim(SeoHelper::openGraph()->getProperty('image') ?: theme_option('seo_og_image', asset('storage/ads/rubyshop-catalog2.jpg')));
            $seoUrl = url()->current();
            $isSocialCategoryPage = $isCategoryPage
                || request()->is('categories')
                || request()->is('allproducts/category/*')
                || request()->is('sub/*');

            if (str_starts_with($normalizedPath, 'product-categories/')) {
                $categoryKey = trim(substr($normalizedPath, strlen('product-categories/')), '/');

                if ($categoryKey && ! str_contains($categoryKey, '/')) {
                    $categorySlug = \Botble\Slug\Facades\SlugHelper::getSlug(
                        $categoryKey,
                        \Botble\Slug\Facades\SlugHelper::getPrefix(\Botble\Ecommerce\Models\ProductCategory::class),
                        \Botble\Ecommerce\Models\ProductCategory::class
                    );
                    $categoryImage = $categorySlug?->reference?->image;

                    if ($categoryImage) {
                        $seoImage = \Botble\Media\Facades\RvMedia::getImageUrl($categoryImage, 'origin', false, $seoImage);
                    }
                }
            }

            if ($seoImage && ! preg_match('/^https?:\/\//i', $seoImage)) {
                $seoImage = url($seoImage);
            }

            $ogType = SeoHelper::openGraph()->getProperty('type') ?: 'website';

            if ($isHomePage) {
                $ogType = 'website';
            } elseif ($isSocialCategoryPage) {
                $ogType = 'product.group';
            } elseif (str_contains($themeHeader, 'name="twitter:card" content="product"')) {
                $ogType = 'product';
            }

            $socialMeta = [
                ['name', 'description', $seoDescription],
                ['property', 'og:type', $ogType],
                ['property', 'og:title', mb_strlen($seoTitle) > 60 ? rtrim(mb_substr($seoTitle, 0, 57)) . '...' : $seoTitle],
                ['property', 'og:description', $seoDescription],
                ['property', 'og:image', $seoImage],
                ['property', 'og:url', $seoUrl],
                ['property', 'og:locale', 'th_TH'],
                ['name', 'twitter:card', 'summary_large_image'],
                ['name', 'twitter:title', mb_strlen($seoTitle) > 70 ? rtrim(mb_substr($seoTitle, 0, 67)) . '...' : $seoTitle],
                ['name', 'twitter:description', $seoDescription],
                ['name', 'twitter:image', $seoImage],
                ['name', 'twitter:url', $seoUrl],
                ['name', 'twitter:site', '@RUBYSHOP168'],
            ];

            foreach ($socialMeta as [$attribute, $key]) {
                $themeHeader = preg_replace(
                    '/<meta\b(?=[^>]*\b' . $attribute . '=(["\'])' . preg_quote($key, '/') . '\1)[^>]*>\s*/i',
                    '',
                    $themeHeader
                ) ?? $themeHeader;
            }

            $themeHeader .= PHP_EOL . implode(PHP_EOL, array_map(
                fn (array $meta): string => '<meta ' . $meta[0] . '="' . e($meta[1]) . '" content="' . e($meta[2]) . '">',
                $socialMeta
            ));

            if ($isProductsIndexPage) {
                $themeHeader = preg_replace(
                    '/<title\b[^>]*>[\s\S]*?<\/title>\s*/i',
                    '<title>' . e($seoTitle) . '</title>' . PHP_EOL,
                    $themeHeader,
                    1
                ) ?? $themeHeader;
            }

            if ($isCategoryPage) {
                $themeHeader = preg_replace_callback(
                    '/<script\b[^>]*type=(["\'])application\/ld\+json\1[^>]*>[\s\S]*?<\/script>\s*/i',
                    function (array $matches): string {
                        $script = $matches[0];

                        if (
                            str_contains($script, 'BreadcrumbList')
                            && ! str_contains($script, 'CollectionPage')
                            && ! str_contains($script, 'ItemList')
                        ) {
                            return '';
                        }

                        return $script;
                    },
                    $themeHeader
                ) ?? $themeHeader;
            }
        @endphp
        {!! $themeHeader !!}

        {{-- This stylesheet MUST come after Theme::header() so it loads after Bootstrap CSS.
             Bootstrap's d-lg-block uses display:block !important; this bundle also includes global loader/footer/mobile CSS. --}}
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/ruby-header.css') }}?v=20260604-10">
        @if ($isHomePage)
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/ruby-home-shortcodes.css') }}?v=20260606-cls2">
        @endif

        @php
            $headerStyle = theme_option('header_style') ?: '';
            $page = Theme::get('page');
            if ($page) {
                $headerStyle = $page->getMetaData('header_style', true) ?: $headerStyle;
            }
            $headerStyle = ($headerStyle && in_array($headerStyle, array_keys(get_layout_header_styles()))) ? $headerStyle : '';
        
        
            
        
        
            @endphp
    </head>
    <body {!! Theme::bodyAttributes() !!} class="@if (BaseHelper::isRtlEnabled()) rtl @endif header_full_true wowy-template css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-index wowy_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true header_sticky_true hide_scrolld_true des_header_3 h_banner_true top_bar_true prs_bordered_grid_1 search_pos_canvas lazyload @if ($isHomePage) ruby-homepage @endif @if (Theme::get('bodyClass')) {{ Theme::get('bodyClass') }} @endif">
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <div id="alert-container"></div>

        {!! Theme::partial('preloader') !!}

        <header class="header-area header-height-2 {{ $headerStyle }}" id="header-main">
            <div class="header-top header-top-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-4">
                            <div class="header-info">
                                <ul>
                                    @if (theme_option('hotline'))
                                        <li><i class="fa fa-phone-alt mr-5"></i><a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></li>
                                    @endif

                                    @if (is_plugin_active('ecommerce') && EcommerceHelper::isOrderTrackingEnabled())
                                        <li><i class="far fa-anchor mr-5"></i><a href="{{ route('public.orders.tracking') }}">{{ __('Track Your Order') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-4">
                            <div class="text-center">
                                @if (theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                                    <div id="news-flash" class="d-inline-block">
                                        <ul>
                                            @foreach($headerMessages as $headerMessage)
                                                @if (count($headerMessage) == 4)
                                                    <li>
                                                        @if ($headerMessage[0]['value'])
                                                            {!! BaseHelper::renderIcon($headerMessage[0]['value'], null, ['class' => 'd-inline-block mr-5']) !!}
                                                        @endif

                                                        @if ($headerMessage[1]['value'])
                                                            <span class="d-inline-block">
                                                                {!! BaseHelper::clean($headerMessage[1]['value']) !!}
                                                            </span>
                                                        @endif
                                                        @if ($headerMessage[2]['value'] && $headerMessage[3]['value'])
                                                            &nbsp;<a class="active d-inline-block" href="{{ url($headerMessage[2]['value']) }}">{!! BaseHelper::clean($headerMessage[3]['value']) !!}</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @php $currencies = is_plugin_active('ecommerce') ? get_all_currencies() : []; @endphp

                        @if (is_plugin_active('ecommerce') || is_plugin_active('language'))
                            <div class="col-xl-4 col-lg-4">
                                <div class="header-info header-info-right">
                                        <ul>
                                            @if (is_plugin_active('language'))
                                                {!! Theme::partial('language-switcher') !!}
                                            @endif

                                            @if (is_plugin_active('ecommerce'))
                                                @if (count($currencies) > 1)
                                                    <li>
                                                        <a class="language-dropdown-active" href="#"> <i class="fa fa-coins"></i> {{ get_application_currency()->title }} <i class="fa fa-chevron-down"></i></a>
                                                        <ul class="language-dropdown">
                                                            @foreach ($currencies as $currency)
                                                                @if ($currency->id !== get_application_currency_id())
                                                                    <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                                @if (auth('customer')->check())
                                                    <li><a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a></li>
                                                @else
                                                    <li><a href="{{ route('customer.login') }}">{{ __('Log In / Sign Up') }}</a></li>
                                                @endif
                                            @endif
                                        </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="header-wrap header-space-between">
                        <div class="logo logo-width-1">
                            @if (theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" width="150" height="45" decoding="async"></a>
                            @endif
                        </div>
                        @if (is_plugin_active('ecommerce'))
                            <div class="search-style-2">
                                <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                    <div class="form-group--icon">
                                        <label class="visually-hidden" for="product-category-select">{{ __('Product category') }}</label>
                                        <div class="product-cat-label" aria-hidden="true">{{ __('All Categories') }}</div>
                                        <select class="product-category-select" id="product-category-select" name="categories[]" aria-label="{{ __('Product category') }}">
                                            <option value="">{{ __('All Categories') }}</option>
                                            {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                                        </select>
                                    </div>
                                    <input type="text" name="q" class="input-search-product"  placeholder="{{ __('Search for items…') }}" autocomplete="off">
                                    <button type="submit" title="search"> <i class="far fa-search"></i> </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            </div>
                            <div class="header-action-right">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                                <span class="visually-hidden">{{ __('Compare products') }}</span>
                                                <span class="pro-count blue"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img class="svgInject" alt="{{ __('Wishlist') }}" src="{{ Theme::asset()->url('images/icons/icon-heart.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                                <span class="visually-hidden">{{ __('Wishlist') }}</span>
                                                <span class="pro-count blue">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="{{ __('Cart') }}" src="{{ Theme::asset()->url('images/icons/icon-cart.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                            <span class="visually-hidden">{{ __('Shopping cart') }}</span>
                                            <span class="pro-count blue">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="{{ __('Sign In') }}" src="{{ Theme::asset()->url('images/icons/icon-user.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                            <span class="visually-hidden">{{ __('Sign in') }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-bottom header-bottom-bg-color sticky-bar gray-bg sticky-blue-bg">
                <div class="container">
                    <div class="header-wrap header-space-between position-relative main-nav">
                        <div class="logo logo-width-1 d-block d-lg-none">
                            @if ($logo = theme_option('logo_light') ?: theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}" width="150" height="45" decoding="async"></a>
                            @endif
                        </div>

                        @if (is_plugin_active('ecommerce') && theme_option('enabled_browse_categories_on_header', 'yes') == 'yes')
                            @php
                                $openBrowse = $page && $page->template == 'homepage' && $page->getMetaData('expanding_product_categories_on_the_homepage', true) == 'yes';
                                $cantCloseBrowse = $openBrowse && $headerStyle == 'header-style-2';
                            @endphp
                            <div class="main-categories-wrap header-nav-categories d-none d-lg-block">
                            <a class="categories-button-active @if ($openBrowse) open @endif @if ($cantCloseBrowse) cant-close @endif" href="#">
                                <span class="fa fa-list"></span> {{ __('Browse Categories') }} <i class="down far fa-chevron-down"></i> <i class="up far fa-chevron-up"></i>
                            </a>
                            @php
                                $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                            @endphp
                            <div class="categories-dropdown-wrap categories-dropdown-active-large @if ($openBrowse) default-open open @endif">
                                <ul>
                                    {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => false]) !!}
                                    @if (count($categories) > 10)
                                        <li>
                                            <ul class="more_slide_open">
                                                {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => true]) !!}
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                                @if (count($categories) > 10)
                                    <div class="more_categories">{{ __('Show more...') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block main-menu-light-white hover-boder hover-boder-white">
                            <nav>
                                {!!
                                    Menu::renderMenuLocation('main-menu', [
                                        'view' => 'main-menu',
                                    ])
                                !!}
                            </nav>
                        </div>

                        @if (theme_option('hotline'))
                            @php
                                $hotlineDigits = preg_replace('/\D+/', '', theme_option('hotline'));
                            @endphp
                            <div class="hotline header-nav-hotline d-none d-lg-flex">
                                <a href="tel:{{ $hotlineDigits ?: theme_option('hotline') }}">
                                    <i class="fa fa-phone-alt"></i>
                                    <span class="hotline-label">{{ __('Hotline') }}</span>
                                    <strong>{{ theme_option('hotline') }}</strong>
                                </a>
                            </div>
                        @endif

                        @if (is_plugin_active('ecommerce'))
                            <div class="header-action-right d-block d-lg-none">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare-white.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                                <span class="visually-hidden">{{ __('Compare products') }}</span>
                                                <span class="pro-count white"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-heart-white.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                                <span class="visually-hidden">{{ __('Wishlist') }}</span>
                                                <span class="pro-count white">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="cart" src="{{ Theme::asset()->url('images/icons/icon-cart-white.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                            <span class="visually-hidden">{{ __('Shopping cart') }}</span>
                                            <span class="pro-count white">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-user-white.svg') }}" width="24" height="24" loading="lazy" decoding="async">
                                            <span class="visually-hidden">{{ __('Sign in') }}</span>
                                        </a>
                                    </div>
                                    <div class="header-action-icon-2 d-block d-lg-none">
                                        <div class="burger-icon burger-icon-white">
                                            <span class="burger-icon-top"></span>
                                            <span class="burger-icon-mid"></span>
                                            <span class="burger-icon-bottom"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="mobile-header-active mobile-header-wrapper-style">
            <div class="mobile-header-wrapper-inner rs-drw">

                {{-- TOP BAR --}}
                <div class="rs-drw-head">
                    @if ($drwLogo = theme_option('logo_light') ?: theme_option('logo'))
                        <a href="{{ BaseHelper::getHomepageUrl() }}" class="rs-drw-logo">
                            <img src="{{ RvMedia::getImageUrl($drwLogo) }}" alt="{{ theme_option('site_title') }}" height="34" decoding="async">
                        </a>
                    @endif
                    <div class="mobile-menu-close">
                        <button type="button" class="rs-drw-close" aria-label="{{ __('Close menu') }}">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                        </button>
                    </div>
                </div>

                {{-- BODY (scrollable) --}}
                <div class="rs-drw-body">

                    {{-- CATEGORIES LINK --}}
                    <a href="{{ url('/product-categories') }}" class="rs-drw-allcats">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
                        หมวดหมู่สินค้าทั้งหมด
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" style="margin-left:auto"><path d="m9 6 6 6-6 6"/></svg>
                    </a>

                    {{-- NAV --}}
                    <nav class="rs-drw-nav">
                        {!!
                            Menu::renderMenuLocation('main-menu', [
                                'options' => ['class' => 'mobile-menu rs-drw-menu'],
                                'view'    => 'mobile-menu',
                            ])
                        !!}
                    </nav>

                </div>{{-- /rs-drw-body --}}

                {{-- FOOTER --}}
                <div class="rs-drw-foot">

                    {{-- LOGIN --}}
                    @if (is_plugin_active('ecommerce'))
                        <a href="{{ auth('customer')->check() ? route('customer.overview') : route('customer.login') }}" class="rs-drw-login">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                            {{ auth('customer')->check() ? auth('customer')->user()->name : __('Log In / Sign Up') }}
                        </a>
                    @endif

                    {{-- SOCIAL + LANG/CURR in a row --}}
                    <div class="rs-drw-bottom">
                        @if (($socialLinks = theme_option('social_links')) && $socialLinks = json_decode($socialLinks, true))
                            <div class="rs-drw-social">
                                @foreach($socialLinks as $socialLink)
                                    @if (count($socialLink) == 4 && isset($socialLink[2]['value']))
                                        @php
                                            $socialUrl = (string) $socialLink[2]['value'];
                                            $socialUrlLower = Str::lower($socialUrl);
                                            if (Str::contains($socialUrl, 'x.com/i/flow/login')) { $socialUrl = 'https://x.com/RUBYSHOP168'; }
                                            if (Str::contains($socialUrl, 'x.com/')) { continue; }
                                        @endphp
                                        <a href="{{ $socialUrl }}" title="{{ $socialLink[0]['value'] }}" class="rs-drw-soc-btn">
                                            @if (Str::contains($socialUrlLower, 'facebook'))
                                                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M13.5 9H16V6h-2.5C11.6 6 10 7.6 10 9.5V12H8v3h2v6h3v-6h2.3l.7-3H13v-2.5c0-.3.2-.5.5-.5z"/></svg>
                                            @elseif (Str::contains($socialUrlLower, 'instagram'))
                                                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm0 2a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3H7zm11.5 1.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3zM12 7a5 5 0 1 1 0 10 5 5 0 0 1 0-10zm0 2a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/></svg>
                                            @elseif (Str::contains($socialUrlLower, 'line.me'))
                                                <svg width="16" height="16" viewBox="0 0 24 24"><path fill="currentColor" d="M12 2C6.5 2 2 5.9 2 10.8c0 4.4 3.6 8 8.3 8.6l-.6 2.8c-.1.4.4.8.8.5l3.2-2.4h.3c5.5 0 10-3.9 10-8.8S17.5 2 12 2zm-4 6.2h1.6v5H8V8.2zm4.9 5.1H10.7V8.2h1.6v3.7h1.3v1.4zm3.8-3.7h-1.8v.7h1.8v1.4h-1.8v.7h1.8v1.4h-3.4V8.2h3.4v1.4zm3.3 3.7h-1.4l-1.7-2.3v2.3h-1.6V8.2h1.4l1.7 2.3V8.2H20v5.1z"/></svg>
                                            @else
                                                {!! BaseHelper::renderIcon($socialLink[1]['value']) !!}
                                            @endif
                                            <span class="visually-hidden">{{ $socialLink[0]['value'] }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif

                        <div class="rs-drw-meta">
                            @if (is_plugin_active('language'))
                                <div class="rs-drw-meta-item">
                                    <a class="mobile-language-active rs-drw-meta-toggle" href="#">
                                        🌐 {{ __('Language') }}
                                        <i class="far fa-angle-down"></i>
                                    </a>
                                    <div class="lang-curr-dropdown lang-dropdown-active rs-drw-meta-drop">
                                        <ul>
                                            @php
                                                $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
                                                $normalizeLanguageUrl = fn (?string $url): ?string => $url
                                                    ? preg_replace('/((?:categories|brands|tags|attributes)%5B)\d+(%5D=)/i', '$1$2', $url)
                                                    : $url;
                                            @endphp
                                            @foreach (Language::getSupportedLocales() as $localeCode => $properties)
                                                <li><a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $normalizeLanguageUrl($showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode)) }}">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!} {{ $properties['lang_name'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>{{-- /rs-drw-foot --}}

            </div>
        </div>
