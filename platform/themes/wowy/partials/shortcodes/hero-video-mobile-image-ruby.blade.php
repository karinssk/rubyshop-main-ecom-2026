@once
    @unless (request()->path() === '/' || request()->routeIs('public.index') || request()->routeIs('home'))
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/hero-video-mobile-image-ruby.css') }}">
    @endunless
@endonce

@php
    use Botble\Base\Facades\BaseHelper;
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];

    $desktopVideo   = Arr::get($attributes, 'desktop_video');
    $desktopPoster  = Arr::get($attributes, 'desktop_poster');
    $mobileImage    = Arr::get($attributes, 'mobile_image');
    $defaultImage   = RvMedia::getDefaultImage();

    $desktopVideoUrl = $desktopVideo ? RvMedia::url($desktopVideo) : null;
    $desktopPosterUrl = $desktopPoster
        ? RvMedia::getImageUrl($desktopPoster, null, false, $defaultImage)
        : ($mobileImage ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage) : $defaultImage);
    $mobileImageUrl = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, 'medium', false, $defaultImage)
        : $desktopPosterUrl;
    $mobileImageUrlFull = $mobileImage
        ? RvMedia::getImageUrl($mobileImage, null, false, $defaultImage)
        : $desktopPosterUrl;
    $desktopVideoPlaceholderUrl = null;

    if ($desktopVideo) {
        $desktopVideoPath = parse_url($desktopVideo, PHP_URL_PATH) ?: $desktopVideo;
        $desktopVideoPath = preg_replace('#^/?storage/#', '', ltrim($desktopVideoPath, '/'));
        $desktopVideoPlaceholderPath = preg_replace('/\.(mp4|webm|mov|m4v)$/i', '-first-frame.webp', $desktopVideoPath);

        if ($desktopVideoPlaceholderPath && $desktopVideoPlaceholderPath !== $desktopVideoPath && file_exists(public_path('storage/' . $desktopVideoPlaceholderPath))) {
            $desktopVideoPlaceholderUrl = RvMedia::url($desktopVideoPlaceholderPath);
        }
    }

    $eyebrow    = Arr::get($attributes, 'eyebrow')      ?: 'RUBYSHOP · เครื่องมือช่างมืออาชีพ';
    $title      = Arr::get($attributes, 'title')        ?: 'เครื่องพ่นสีและ<br>เครื่องมือช่างมืออาชีพ';
    $subtitle   = Arr::get($attributes, 'subtitle')     ?: 'พ่นสี · พ่นปูน · กรีดผนัง · เครื่องมือครบครัน';
    $buttonText = Arr::get($attributes, 'button_text')  ?: 'เลือกซื้อเลย';
    $buttonLink = Arr::get($attributes, 'button_link')  ?: '/products';
    $btn2Text   = Arr::get($attributes, 'button2_text') ?: 'ดูหมวดหมู่';
    $btn2Link   = Arr::get($attributes, 'button2_link') ?: '/product-categories';
    $hasAction  = filled($buttonText) && filled($buttonLink);
    $heroId = 'ruby-hero-' . md5(($desktopVideoUrl ?: $mobileImageUrl ?: '') . $title . $buttonLink);
@endphp

<section class="ruby-hero" id="{{ $heroId }}" aria-label="Hero">
    {{-- Desktop: video --}}
    @if ($desktopVideoUrl)
        <div class="ruby-hero__media ruby-hero__media--desktop" @if ($desktopVideoPlaceholderUrl) style="background-image: url('{{ $desktopVideoPlaceholderUrl }}')" @endif>
            <video autoplay muted loop playsinline preload="metadata"
                disablepictureinpicture disableremoteplayback
                controlslist="nodownload,nofullscreen,noremoteplayback">
                <source src="{{ $desktopVideoUrl }}" type="video/mp4">
            </video>
            <div class="ruby-hero__media__fallback" aria-hidden="true">
                <span class="ruby-hero__loader"></span>
            </div>
        </div>
    @endif

    {{-- Mobile: image only --}}
    <div class="ruby-hero__media ruby-hero__media--mobile">
        <img src="{{ $mobileImageUrl }}"
             srcset="{{ $mobileImageUrl }} 768w, {{ $mobileImageUrlFull }} 1600w"
             sizes="100vw"
             alt="{{ BaseHelper::clean($title) }}"
             width="768" height="1024"
             loading="eager" fetchpriority="high" decoding="async">
    </div>

    <div class="ruby-hero__overlay" aria-hidden="true"></div>

    <div class="ruby-hero__content">
        <div class="ruby-hero__inner">
            <div class="ruby-hero__copy">

                {{-- Eyebrow badge --}}
                <div class="ruby-hero__eyebrow">
                    <span class="ruby-hero__eyebrow-dot" aria-hidden="true"></span>
                    {{ $eyebrow }}
                </div>

                {{-- Headline --}}
                @if ($title)
                    <h1 class="ruby-hero__title">{!! BaseHelper::clean($title) !!}</h1>
                @endif

                {{-- Subtitle --}}
                @if ($subtitle)
                    <p class="ruby-hero__subtitle">{!! BaseHelper::clean($subtitle) !!}</p>
                @endif

                {{-- CTAs --}}
                @if ($hasAction)
                    <div class="ruby-hero__actions">
                        <a href="{{ $buttonLink }}" class="ruby-hero__btn-primary">
                            {{ $buttonText }}
                            <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M3 8h10M9 4l4 4-4 4"/>
                            </svg>
                        </a>
                        @if (filled($btn2Text) && filled($btn2Link))
                            <a href="{{ $btn2Link }}" class="ruby-hero__btn-secondary">{{ $btn2Text }}</a>
                        @endif
                    </div>
                @endif

                {{-- Trust signals --}}
                <div class="ruby-hero__trust">
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        ส่งทั่วไทย
                    </span>
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        รับประกันคุณภาพ
                    </span>
                    <span class="ruby-hero__trust-item">
                        <svg class="ruby-hero__trust-icon" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M2 8l4 4 8-8"/></svg>
                        ช่างมืออาชีพใช้จริง
                    </span>
                </div>

            </div>
        </div>
    </div>
</section>

@if ($desktopVideoUrl)
    @once
        <script src="{{ Theme::asset()->url('js/hero-video-mobile-image-ruby.js') }}" defer></script>
    @endonce
@endif
