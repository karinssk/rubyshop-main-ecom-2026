@php
    use Botble\Media\Facades\RvMedia;

    $hotline = theme_option('hotline') ?: '021234567';
    $hotlineDigits = preg_replace('/\D+/', '', $hotline);
    $lineUrl = 'https://line.me/R/ti/p/@rubyshop';
@endphp

<div class="w-full bg-gray-50 text-gray-900">
    @foreach ($landingSections as $section)
        @php
            $sectionType = $section['type'] ?? '';
            $sectionTitle = $section['title'] ?? '';
            $sectionContent = $section['content'] ?? '';
            $sectionKickerText = $section['kicker_text'] ?? '';
            $sectionImage = $section['image'] ?? '';
            $sectionTextColor = $section['text_color'] ?? '';
            $sectionKickerColor = $section['kicker_color'] ?? '';
            $sectionHeadlineColor = $section['headline_color'] ?? '';
            $sectionSubheadlineColor = $section['subheadline_color'] ?? '';
            $sectionBackdropColor = $section['backdrop_color'] ?? '';
            $sectionBackdropOpacity = $section['backdrop_opacity'] ?? null;
            $sectionButtonText = $section['button_text'] ?? '';
            $sectionButtonUrl = $section['button_url'] ?? '';
        @endphp

        @switch($sectionType)
            @case('hero_section_v2')
                @php
                    $heroBackground = $sectionImage ?: ($gallery->first() ?: $product->image);
                    $heroTextColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', $sectionTextColor) ? $sectionTextColor : '#ffffff';
                    $heroKickerColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', $sectionKickerColor) ? $sectionKickerColor : $heroTextColor;
                    $heroHeadlineColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', $sectionHeadlineColor) ? $sectionHeadlineColor : $heroTextColor;
                    $heroSubheadlineColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', $sectionSubheadlineColor) ? $sectionSubheadlineColor : $heroTextColor;
                    $heroBackdropColor = preg_match('/^#[0-9a-fA-F]{3,8}$/', $sectionBackdropColor) ? $sectionBackdropColor : '#000000';
                    $heroBackdropOpacity = is_numeric($sectionBackdropOpacity) ? max(0, min(100, (int) $sectionBackdropOpacity)) : 65;
                @endphp
                <section class="relative isolate min-h-[100svh] overflow-hidden md:min-h-[85vh]">
                    <img
                        src="{{ RvMedia::getImageUrl($heroBackground, 'origin', false, RvMedia::getDefaultImage()) }}"
                        alt="{{ $product->name }}"
                        class="absolute inset-0 -z-20 h-full w-full object-cover"
                    >
                    <div
                        class="absolute inset-0 -z-10"
                        style="background-color: {{ $heroBackdropColor }}; opacity: {{ number_format($heroBackdropOpacity / 100, 2, '.', '') }};"
                    ></div>

                    <div class="container mx-auto flex min-h-[100svh] items-center justify-start px-4 pt-[max(170px,calc(env(safe-area-inset-top)+130px))] sm:pt-32 md:min-h-[85vh] md:px-6 md:py-12 lg:py-16">
                        <div class="hero-v2-copy w-full max-w-4xl">
                            <div class="hero-v2-stack flex min-h-[68svh] flex-col md:min-h-0 md:block">
                                <div class="my-auto md:my-0">
                                    <p class="mb-2 text-[11px] font-semibold leading-snug tracking-wide sm:text-xs md:mb-3 md:text-sm" style="color: {{ $heroKickerColor }};">
                                        {{ $sectionKickerText ?: ($product->name . ' | ' . ($product->brand?->name ?: 'RUBYSHOP')) }}
                                    </p>

                                    <h1 class="text-[clamp(1.9rem,8vw,3.75rem)] font-extrabold leading-[1.08] sm:leading-[1.1] md:leading-tight" style="color: {{ $heroHeadlineColor }};">
                                        {!! BaseHelper::clean($sectionTitle ?: __('4 คน ฉาบได้เท่า 8 คน — เร็วขึ้น 5 เท่า')) !!}
                                    </h1>

                                    <p class="mt-3 max-w-3xl text-[clamp(0.95rem,3.8vw,1.5rem)] leading-relaxed md:mt-4" style="color: {{ $heroSubheadlineColor }};">
                                        {!! BaseHelper::clean($sectionContent ?: __('คืนทุนภายใน 3 เดือน พร้อมระบบผสมอัตโนมัติ ทำงานต่อเนื่อง ไม่สะดุด')) !!}
                                    </p>
                                </div>

                                <div class="hero-v2-actions flex flex-col gap-3 pb-[max(96px,calc(env(safe-area-inset-bottom)+96px))] sm:flex-row sm:flex-wrap md:mt-8 md:pb-0 md:justify-start">
                                    @if ($sectionButtonText && $sectionButtonUrl)
                                        <a href="{{ $sectionButtonUrl }}" data-ads-cta="hero-v2-primary" class="inline-flex w-full items-center justify-center rounded-full bg-red-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:bg-red-700 sm:w-auto sm:px-8 sm:py-3.5 sm:text-base">
                                            {{ $sectionButtonText }}
                                        </a>
                                    @else
                                        <a href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer" data-ads-cta="hero-v2-primary" class="inline-flex w-full items-center justify-center rounded-full bg-red-600 px-6 py-3 text-sm font-bold text-white shadow-lg hover:bg-red-700 sm:w-auto sm:px-8 sm:py-3.5 sm:text-base">
                                            {{ __('นัดสาธิตฟรีหน้างาน') }}
                                        </a>
                                    @endif

                                    <a href="{{ $productUrlWithQuery }}" data-ads-cta="hero-v2-secondary" class="inline-flex w-full items-center justify-center rounded-full bg-white/20 px-6 py-3 text-sm font-bold text-white backdrop-blur hover:bg-white/30 sm:w-auto sm:px-8 sm:py-3.5 sm:text-base">
                                        {{ __('ดูราคา & ROI') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="absolute bottom-6 right-6 hidden rounded-2xl px-5 py-3 text-sm font-extrabold tracking-wide md:block" style="background-color: {{ $heroBackdropColor }}; color: {{ $heroTextColor }};">
                        RUBYSHOP
                    </div>
                </section>
                <style>
                    .hero-v2-copy {
                        text-align: center;
                    }

                    @media (min-width: 768px) {
                        .hero-v2-copy {
                            text-align: left;
                        }

                        .hero-v2-stack {
                            min-height: auto;
                        }

                        .hero-v2-actions {
                            justify-content: flex-start;
                        }
                    }
                </style>
                @break

            @case('hero_section')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-10 md:px-6 md:py-14">
                        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                            <div>
                                <div class="mb-4 flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wide text-red-600">
                                    <span class="rounded-full bg-red-100 px-3 py-1">Rubyshop Official</span>
                                    @if ($product->brand?->name)
                                        <span class="rounded-full bg-white px-3 py-1 text-gray-700 ring-1 ring-gray-200">{{ $product->brand->name }}</span>
                                    @endif
                                </div>

                                <h1 class="mb-4 text-3xl font-extrabold leading-tight md:text-5xl">
                                    {{ $sectionTitle ?: __('Finish Wall-Chasing Jobs Faster With Less Dust') }}
                                </h1>

                                <p class="mb-6 max-w-2xl text-base text-gray-700 md:text-lg">
                                    {!! BaseHelper::clean($sectionContent ?: ($product->name . ' - ' . __('Powerful cutting performance, cleaner work area, and smoother workflow for daily site use.'))) !!}
                                </p>

                                <div class="mb-6 flex flex-wrap items-end gap-3">
                                    <div class="text-3xl font-extrabold text-red-600">{{ format_price($product->front_sale_price_with_taxes) }}</div>
                                    @if ($product->price > $product->front_sale_price)
                                        <div class="text-lg text-gray-400 line-through">{{ format_price($product->price_with_taxes) }}</div>
                                    @endif
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    @if ($sectionButtonText && $sectionButtonUrl)
                                        <a href="{{ $sectionButtonUrl }}" data-ads-cta="hero-primary" class="rounded-xl bg-red-600 px-7 py-3.5 text-sm font-bold text-white shadow hover:bg-red-700">
                                            {{ $sectionButtonText }}
                                        </a>
                                    @else
                                        <a href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer" data-ads-cta="hero-primary" class="rounded-xl bg-red-600 px-7 py-3.5 text-sm font-bold text-white shadow hover:bg-red-700">
                                            {{ __('LINE for Fast Quote') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <div class="overflow-hidden rounded-2xl border border-gray-200 bg-white p-3 shadow-sm">
                                    <img
                                        src="{{ RvMedia::getImageUrl($gallery->first() ?: $product->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                        alt="{{ $product->name }}"
                                        class="mx-auto h-auto max-h-[520px] w-full object-cover"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('trust_badges')
            @case('trust_indicators')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-6 md:px-6">
                        @if ($sectionTitle)
                            <h2 class="mb-4 text-2xl font-bold text-gray-900">{{ $sectionTitle }}</h2>
                        @endif
                        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                            <div class="rounded-xl border border-gray-200 bg-white p-4">
                                <div class="text-sm font-semibold text-gray-900">{{ __('Fast Shipping') }}</div>
                                <div class="mt-1 text-xs text-gray-600">{{ __('Nationwide delivery with tracking support.') }}</div>
                            </div>
                            <div class="rounded-xl border border-gray-200 bg-white p-4">
                                <div class="text-sm font-semibold text-gray-900">{{ __('After-sales Support') }}</div>
                                <div class="mt-1 text-xs text-gray-600">{{ __('Technical team available before and after purchase.') }}</div>
                            </div>
                            <div class="rounded-xl border border-gray-200 bg-white p-4">
                                <div class="text-sm font-semibold text-gray-900">{{ __('Secure Payment') }}</div>
                                <div class="mt-1 text-xs text-gray-600">{{ __('Trusted checkout and official Rubyshop channels.') }}</div>
                            </div>
                            <div class="rounded-xl border border-gray-200 bg-white p-4">
                                <div class="text-sm font-semibold text-gray-900">{{ __('Policy Ready') }}</div>
                                <div class="mt-1 text-xs text-gray-600">{{ __('Clear return and privacy policy for ad compliance.') }}</div>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('product_specs')
            @case('product_features_specifications')
                @if ($specifications->isNotEmpty())
                    <section class="w-full bg-white">
                        <div class="container mx-auto px-4 py-10 md:px-6">
                            <div class="mb-6 flex items-center justify-between">
                                <h2 class="text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Specifications') }}</h2>
                                @if ($product->specificationTable?->name)
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">{{ $product->specificationTable->name }}</span>
                                @endif
                            </div>
                            <div class="overflow-x-auto rounded-xl border border-gray-200">
                                <table class="min-w-[560px] w-full border-collapse bg-white text-sm">
                                    <tbody>
                                        @foreach ($specifications as $specification)
                                            <tr class="border-b border-gray-100">
                                                <td class="w-1/3 bg-gray-50 px-4 py-3 font-semibold text-gray-800">{{ $specification->title }}</td>
                                                <td class="px-4 py-3 text-gray-700">{!! BaseHelper::clean($specification->pivot->value) !!}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                @endif
                @break

            @case('problem_section')
            @case('solution_overview')
            @case('key_benefits')
            @case('how_it_works')
            @case('before_after_results')
            @case('testimonials_reviews')
            @case('comparison')
            @case('use_cases')
            @case('risk_reversal')
            @case('urgency_scarcity')
                <section class="w-full bg-gray-50">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Section') }}</h2>
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 text-gray-700">
                            @if ($sectionContent)
                                <div class="whitespace-pre-line">{!! BaseHelper::clean($sectionContent) !!}</div>
                            @else
                                <p class="mb-0 text-sm text-gray-500">{{ __('Add content for this section from Landing Page Builder.') }}</p>
                            @endif
                        </div>
                        @if ($sectionButtonText && $sectionButtonUrl)
                            <div class="mt-4">
                                <a href="{{ $sectionButtonUrl }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:border-red-500 hover:text-red-600">{{ $sectionButtonText }}</a>
                            </div>
                        @endif
                    </div>
                </section>
                @break

            @case('video_demo')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Video Demonstration / Demo') }}</h2>
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            @if ($sectionContent)
                                {!! BaseHelper::clean($sectionContent) !!}
                            @else
                                <div class="rounded-xl bg-gray-100 p-8 text-center text-sm text-gray-500">{{ __('Paste embed code (YouTube/video iframe) in this section content.') }}</div>
                            @endif
                        </div>
                    </div>
                </section>
                @break

            @case('product_content')
                @if ($product->content)
                    <section class="w-full bg-gray-50">
                        <div class="container mx-auto px-4 py-10 md:px-6">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Product Details') }}</h2>
                            <div class="prose prose-sm max-w-none rounded-2xl border border-gray-200 bg-white p-6 md:prose-base">
                                {!! BaseHelper::clean($product->content) !!}
                            </div>
                        </div>
                    </section>
                @endif
                @break

            @case('policy_links')
                <section class="w-full bg-gray-50">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        @if ($sectionTitle)
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle }}</h2>
                        @endif
                        <div class="grid gap-3 rounded-2xl border border-gray-200 bg-white p-5 text-sm text-gray-700 md:grid-cols-3">
                            <a href="{{ url('/return-policy') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center font-semibold hover:border-red-500 hover:text-red-600">{{ __('Return Policy') }}</a>
                            <a href="{{ url('/privacy-policy') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center font-semibold hover:border-red-500 hover:text-red-600">{{ __('Privacy Policy') }}</a>
                            <a href="{{ url('/terms-of-service') }}" class="rounded-lg border border-gray-200 px-4 py-3 text-center font-semibold hover:border-red-500 hover:text-red-600">{{ __('Terms of Service') }}</a>
                        </div>
                    </div>
                </section>
                @break

            @case('pricing_offer')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <h2 class="mb-4 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Pricing / Offer / Promotion') }}</h2>
                        <div class="rounded-2xl border border-red-100 bg-red-50 p-6">
                            <div class="text-3xl font-extrabold text-red-600">{{ format_price($product->front_sale_price_with_taxes) }}</div>
                            @if ($product->price > $product->front_sale_price)
                                <div class="mt-1 text-lg text-gray-500 line-through">{{ format_price($product->price_with_taxes) }}</div>
                            @endif
                            @if ($sectionContent)
                                <div class="mt-3 text-sm text-gray-700">{!! BaseHelper::clean($sectionContent) !!}</div>
                            @endif
                            <div class="mt-4 flex flex-wrap gap-2">
                                <a href="{{ $productUrlWithQuery }}" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">{{ __('Buy Now') }}</a>
                                <a href="tel:{{ $hotlineDigits }}" class="rounded-lg border border-red-200 bg-white px-5 py-2.5 text-sm font-semibold text-red-700 hover:border-red-500">{{ __('Call Sales') }}</a>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('faq_section')
                <section class="w-full bg-gray-50">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('FAQ Section') }}</h2>
                        <div class="rounded-2xl border border-gray-200 bg-white p-6 text-gray-700">
                            @if ($sectionContent)
                                {!! BaseHelper::clean($sectionContent) !!}
                            @else
                                <p class="mb-0 text-sm text-gray-500">{{ __('Add your FAQs in section content (HTML or plain text).') }}</p>
                            @endif
                        </div>
                    </div>
                </section>
                @break

            @case('related_products')
                @if ($relatedProducts->isNotEmpty())
                    <section class="w-full bg-white">
                        <div class="container mx-auto px-4 py-10 md:px-6">
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Recommended Products') }}</h2>
                            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach ($relatedProducts as $relatedProduct)
                                    <article class="overflow-hidden rounded-xl border border-gray-200 bg-white transition-shadow hover:shadow-md">
                                        <a href="{{ route('landing.product', ['slug' => $relatedProduct->slug]) }}" class="block p-4">
                                            <img src="{{ RvMedia::getImageUrl($relatedProduct->image, 'thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $relatedProduct->name }}" class="mb-3 h-40 w-full object-contain">
                                            <h3 class="mb-2 line-clamp-2 text-sm font-semibold text-gray-900">{{ $relatedProduct->name }}</h3>
                                            <p class="text-sm font-bold text-red-600">{{ format_price($relatedProduct->front_sale_price_with_taxes) }}</p>
                                        </a>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    </section>
                @endif
                @break

            @case('cta_banner')
            @case('primary_cta')
            @case('secondary_cta')
            @case('final_cta')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-8 md:px-6">
                        <div class="overflow-hidden rounded-3xl border border-red-100 bg-gradient-to-br from-red-50 via-white to-red-100 shadow-sm">
                            <div class="grid gap-4 p-6 md:grid-cols-3 md:items-center md:p-8">
                                <div class="md:col-span-2">
                                    <span class="inline-flex rounded-full bg-red-600 px-3 py-1 text-[11px] font-bold uppercase tracking-wide text-white">
                                        {{ __('Action') }}
                                    </span>
                                    <h2 class="mt-3 text-2xl font-extrabold leading-tight text-gray-900 md:text-3xl">{{ $sectionTitle ?: __('Need a quotation for this model?') }}</h2>
                                    @if ($sectionContent)
                                        <p class="mt-3 max-w-2xl text-sm text-gray-700 md:text-base">{!! BaseHelper::clean($sectionContent) !!}</p>
                                    @else
                                        <p class="mt-3 max-w-2xl text-sm text-gray-700 md:text-base">{{ __('Talk with our team for pricing, usage advice, and the best setup for your job.') }}</p>
                                    @endif

                                    <div class="mt-5 flex flex-wrap gap-2">
                                        @if ($sectionButtonText && $sectionButtonUrl)
                                            <a href="{{ $sectionButtonUrl }}" class="rounded-xl bg-red-600 px-6 py-3 text-sm font-bold text-white shadow hover:bg-red-700">{{ $sectionButtonText }}</a>
                                        @else
                                            <a href="tel:{{ $hotlineDigits }}" data-ads-cta="banner-call" class="rounded-xl bg-red-600 px-6 py-3 text-sm font-bold text-white shadow hover:bg-red-700">{{ __('Call Sales') }}</a>
                                        @endif
                                        <a href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-green-300 bg-white px-6 py-3 text-sm font-bold text-green-700 hover:border-green-500">{{ __('LINE Chat') }}</a>
                                    </div>
                                </div>

                                <div class="rounded-2xl border border-white/60 bg-white/70 p-4 text-center backdrop-blur">
                                    <img
                                        src="{{ RvMedia::getImageUrl($product->image, 'thumb', false, RvMedia::getDefaultImage()) }}"
                                        alt="{{ $product->name }}"
                                        class="mx-auto h-24 w-24 object-contain"
                                    >
                                    <div class="mt-2 text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('Current Price') }}</div>
                                    <div class="mt-1 text-2xl font-extrabold text-red-600">{{ format_price($product->front_sale_price_with_taxes) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('contact_section')
                <section class="w-full bg-white">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle ?: __('Contact Section') }}</h2>
                        <div class="rounded-2xl border border-gray-200 bg-white p-6">
                            @if ($sectionContent)
                                <p class="mb-4 text-sm text-gray-700">{!! BaseHelper::clean($sectionContent) !!}</p>
                            @endif
                            <div class="flex flex-wrap gap-2">
                                <a href="tel:{{ $hotlineDigits }}" class="rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-700">{{ __('Call') }} {{ $hotline }}</a>
                                <a href="{{ $lineUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-lg border border-green-300 bg-green-50 px-5 py-2.5 text-sm font-semibold text-green-700 hover:border-green-500">{{ __('LINE Chat') }}</a>
                                <a href="{{ $productsUrlWithQuery }}" class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-700 hover:border-red-500 hover:text-red-600">{{ __('Browse Products') }}</a>
                            </div>
                        </div>
                    </div>
                </section>
                @break

            @case('footer_basic_legal')
                <section class="w-full bg-gray-900 text-white">
                    <div class="container mx-auto px-4 py-8 md:px-6">
                        <h2 class="mb-4 text-xl font-bold">{{ $sectionTitle ?: __('Footer') }}</h2>
                        @if ($sectionContent)
                            <p class="mb-4 text-sm text-gray-200">{!! BaseHelper::clean($sectionContent) !!}</p>
                        @endif
                        <div class="flex flex-wrap gap-4 text-sm">
                            <a class="text-gray-200 hover:text-white" href="{{ url('/privacy-policy') }}">{{ __('Privacy Policy') }}</a>
                            <a class="text-gray-200 hover:text-white" href="{{ url('/terms-of-service') }}">{{ __('Terms of Service') }}</a>
                            <a class="text-gray-200 hover:text-white" href="{{ url('/return-policy') }}">{{ __('Return Policy') }}</a>
                        </div>
                    </div>
                </section>
                @break

            @case('custom_html')
                <section class="w-full bg-gray-50">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        @if ($sectionTitle)
                            <h2 class="mb-6 text-2xl font-bold text-gray-900">{{ $sectionTitle }}</h2>
                        @endif
                        <div class="rounded-2xl border border-gray-200 bg-white p-6">{!! BaseHelper::clean($sectionContent) !!}</div>
                    </div>
                </section>
                @break

            @case('custom_text')
                <section class="w-full bg-gray-50">
                    <div class="container mx-auto px-4 py-10 md:px-6">
                        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm md:p-8">
                            <div class="mb-5 h-1 w-20 rounded-full bg-red-600"></div>
                            @if ($sectionTitle)
                                <h2 class="mb-4 text-2xl font-extrabold text-gray-900">{{ $sectionTitle }}</h2>
                            @endif
                            <div class="text-base leading-relaxed text-gray-700 whitespace-pre-line">{{ $sectionContent }}</div>
                        </div>
                        @if ($sectionButtonText && $sectionButtonUrl)
                            <div class="mt-4">
                                <a href="{{ $sectionButtonUrl }}" class="rounded-xl bg-red-600 px-6 py-3 text-sm font-bold text-white hover:bg-red-700">{{ $sectionButtonText }}</a>
                            </div>
                        @endif
                    </div>
                </section>
                @break
        @endswitch
    @endforeach

    <section class="sticky bottom-0 z-20 border-t border-gray-200 bg-white/95 backdrop-blur">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-3 px-4 py-3 md:px-6">
            <div class="min-w-0">
                <div class="truncate text-sm font-semibold text-gray-900">{{ $product->name }}</div>
                <div class="text-lg font-bold text-red-600">{{ format_price($product->front_sale_price_with_taxes) }}</div>
            </div>
            <div class="flex w-full flex-wrap items-center gap-2 sm:w-auto sm:flex-nowrap">
                <a href="{{ $productUrlWithQuery }}" data-ads-cta="sticky-buy" class="flex-1 rounded-lg bg-red-600 px-4 py-2.5 text-center text-sm font-semibold text-white hover:bg-red-700 sm:flex-none sm:px-5">
                    {{ __('Buy Now') }}
                </a>
                <a href="tel:{{ $hotlineDigits }}" data-ads-cta="sticky-call" class="flex-1 rounded-lg border border-gray-300 px-4 py-2.5 text-center text-sm font-semibold text-gray-700 hover:border-red-500 hover:text-red-600 sm:flex-none sm:px-5">
                    {{ __('Call') }}
                </a>
                <a href="{{ $productsUrlWithQuery }}" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-center text-sm font-semibold text-gray-700 hover:border-red-500 hover:text-red-600 sm:w-auto sm:px-5">
                    {{ __('Browse') }}
                </a>
            </div>
        </div>
    </section>
</div>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": @json($product->name),
  "image": @json($gallery->map(fn ($image) => RvMedia::getImageUrl($image, 'origin'))->values()->all()),
  "description": @json(strip_tags((string) $product->description)),
  "sku": @json($product->sku),
  "brand": {
    "@type": "Brand",
    "name": @json($product->brand?->name ?: 'Rubyshop')
  },
  "offers": {
    "@type": "Offer",
    "priceCurrency": @json(get_application_currency()->title ?: 'THB'),
    "price": @json((string) $product->front_sale_price_with_taxes),
    "availability": @json($product->isOutOfStock() ? 'https://schema.org/OutOfStock' : 'https://schema.org/InStock'),
    "url": @json($productUrlWithQuery)
  }
}
</script>

<script>
    document.addEventListener('click', function (event) {
        const target = event.target.closest('[data-ads-cta]');

        if (! target || typeof window.gtag !== 'function') {
            return;
        }

        window.gtag('event', 'landing_cta_click', {
            event_category: 'Landing Page',
            event_label: target.getAttribute('data-ads-cta'),
            value: 1
        });
    });
</script>
