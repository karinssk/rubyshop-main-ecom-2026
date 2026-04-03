@once
    <style>
        .hero-banner101-ruby {
            position: relative;
            width: 100vw;
            margin-left: calc(50% - 50vw);
            overflow: hidden;
            height: clamp(340px, 60vw, 560px);
        }

        .hero-banner101-ruby__main {
            position: absolute;
            left: 0;
            top: 0;
            z-index: 2;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .hero-banner101-ruby__main.loaded {
            opacity: 1;
        }

        .hero-banner101-ruby .hero-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            z-index: 2;
        }

        .hero-banner101-ruby .hero-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            z-index: 3;
            padding-bottom: 60px;
        }

        .hero-banner101-ruby .text-color-class {
            color: #ffffff;
        }

        .hero-banner101-ruby h1 {
            font-weight: 900 !important;
            font-size: clamp(1.5rem, 3vw, 2.8rem) !important;
            white-space: nowrap !important;
            text-align: center !important;
        }

        /* Skeleton Loading Styles */
        .hero-skeleton {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
            z-index: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            padding-bottom: 60px;
        }

        .hero-skeleton.hidden {
            display: none;
        }

        .skeleton-content {
            text-align: center;
            padding: 0 16px;
            max-width: 768px;
            width: 100%;
        }

        .skeleton-title {
            height: 32px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            margin-bottom: 12px;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }

        .skeleton-subtitle {
            height: 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 4px;
            margin-bottom: 20px;
            width: 40%;
            margin-left: auto;
            margin-right: auto;
        }

        .skeleton-button {
            height: 40px;
            width: 120px;
            background: rgba(237, 29, 36, 0.3);
            border-radius: 6px;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes skeleton-shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        @media (max-width: 1024px) {
            .hero-banner101-ruby {
                width: 100%;
                margin-left: 0;
            }
            
            .hero-banner101-ruby h1 {
                white-space: normal !important;
            }

            .skeleton-title {
                height: 28px;
                width: 80%;
            }

            .skeleton-subtitle {
                height: 18px;
                width: 60%;
            }
        }
    </style>
@endonce

@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $heroImageValue = Arr::get($attributes, 'hero_image');
    $defaultHeroImage = 'https://res.cloudinary.com/dhcsqglul/image/upload/v1743562269/cover2_iynrdk.webp';
    $heroImage = $heroImageValue
        ? RvMedia::getImageUrl($heroImageValue, null, false, $defaultHeroImage)
        : $defaultHeroImage;
    $heroTitle = Arr::get($attributes, 'title');
    $heroDescription = Arr::get($attributes, 'subtitle');
    $buttonText = Arr::get($attributes, 'button_text');
    $buttonLink = Arr::get($attributes, 'button_link');
@endphp

<section class="hero-banner101-ruby">
    <!-- Skeleton Loading -->
    <div class="hero-skeleton" id="hero-skeleton-{{ uniqid() }}">
        <div class="skeleton-content">
            <div class="skeleton-title"></div>
            <div class="skeleton-subtitle"></div>
            <div class="skeleton-button"></div>
        </div>
    </div>

    <!-- Main Hero Content -->
    <div class="hero-banner101-ruby__main" id="hero-main-{{ $heroSectionId = uniqid() }}">
        <img src="{{ $heroImage }}" alt="Hero Image" class="hero-image" loading="lazy" id="hero-image-{{ $heroSectionId }}">

        <div class="hero-overlay">
            <div class="text-center px-4 max-w-4xl">
                <h1 class="text-lg sm:text-xl md:text-2xl lg:text-3xl font-bold text-color-class mb-2 sm:mb-3">
                    {{ $heroTitle }}
                </h1>
                <h5 class="text-xs sm:text-sm md:text-base text-color-class mb-3 sm:mb-4 md:mb-5">
                    {{ $heroDescription }}
                </h5>
                <a href="{{ $buttonLink }}">
                    <button class="bg-[#ed1d24] px-4 sm:px-6 md:px-8 py-2 sm:py-2.5 md:py-3 text-xs sm:text-sm md:text-base font-bold hover:bg-red-600 text-white rounded-md shadow-lg">
                        {{ $buttonText }}
                    </button>
                </a>
            </div>
        </div>
    </div>

    <!-- Hero banner will be handled by footer script -->
</section>
