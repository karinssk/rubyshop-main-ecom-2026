@once
    <style>
        @keyframes ruby-fade-in {
            0% {
                opacity: 0;
                transform: translateX(200px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .ruby-fade-card {
            /* Start invisible and positioned to the right */
            opacity: 0;
            transform: translateX(200px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .ruby-fade-card.animate-fade {
            /* Animate to visible position when class is added */
            animation: ruby-fade-in 2s ease-out forwards;
        }

        /* Optional: Add a subtle hover effect */
        .ruby-fade-card:hover {
            transform: translateX(-5px);
            transition: transform 0.3s ease;
        }

        /* Reduced motion preference support */
        @media (prefers-reduced-motion: reduce) {
            .ruby-fade-card {
                animation: none !important;
                opacity: 1 !important;
                transform: translateX(0) !important;
            }
        }

        /* Skeleton Loading for Fade Animation Section */
        .ruby-fade-section {
            position: relative;
        }

        .ruby-fade-section__main {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .ruby-fade-section__main.loaded {
            opacity: 1;
        }

        .fade-section-skeleton {
            position: absolute;
            inset: 0;
            background: #000;
            z-index: 1;
            display: flex;
            justify-content: center;
        }

        .fade-section-skeleton.hidden {
            display: none;
        }

        .fade-skeleton-container {
            width: 100%;
            position: relative;
            height: 450px;
            overflow: hidden;
        }

        @media (min-width: 768px) {
            .fade-skeleton-container {
                height: 645px;
            }
        }

        .fade-skeleton-bg {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, #333 25%, #444 50%, #333 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
        }

        .fade-skeleton-overlay {
            position: absolute;
            top: 0;
            right: 0;
            width: 25%;
            height: 100%;
            background: #000;
        }

        @media (min-width: 768px) {
            .fade-skeleton-overlay {
                width: 20%;
            }
        }

        .fade-skeleton-card {
            position: absolute;
            top: 50%;
            right: 16px;
            transform: translateY(-50%);
            margin-top: -60px;
            border: 1px solid #000;
            background: white;
            padding: 16px;
            width: 85%;
            max-width: 600px;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        @media (min-width: 640px) {
            .fade-skeleton-card {
                width: 65%;
            }
        }

        @media (min-width: 768px) {
            .fade-skeleton-card {
                right: 48px;
                padding: 32px;
                width: 55%;
                min-height: 250px;
            }
        }

        @media (min-width: 1024px) {
            .fade-skeleton-card {
                padding: 48px;
                padding-bottom: 64px;
                width: 50%;
            }
        }

        .fade-skeleton-title {
            height: 32px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
            border-radius: 4px;
            margin-bottom: 16px;
            width: 90%;
        }

        .fade-skeleton-description {
            height: 60px;
            background: linear-gradient(90deg, #f5f5f5 25%, #e8e8e8 50%, #f5f5f5 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
            border-radius: 4px;
            margin-bottom: 24px;
            flex-grow: 1;
        }

        .fade-skeleton-button {
            height: 36px;
            width: 120px;
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.2) 25%, rgba(239, 68, 68, 0.3) 50%, rgba(239, 68, 68, 0.2) 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
            border-radius: 4px;
            margin-top: auto;
        }

        @media (min-width: 768px) {
            .fade-skeleton-title {
                height: 40px;
                margin-bottom: 24px;
            }

            .fade-skeleton-description {
                height: 80px;
                margin-bottom: 32px;
            }

            .fade-skeleton-button {
                height: 40px;
                width: 140px;
            }
        }
    </style>
@endonce

@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $backgroundImage = Arr::get($attributes, 'background_image');
    $backgroundImageUrl = $backgroundImage ? RvMedia::getImageUrl($backgroundImage) : null;
    $cardTitle = Arr::get($attributes, 'card_title');
    $cardDescription = Arr::get($attributes, 'card_description');
    $buttonText = Arr::get($attributes, 'button_text');
    $buttonLink = Arr::get($attributes, 'button_link');
    $sectionId = 'ruby-fade-section-' . uniqid();
@endphp

<section class="ruby-fade-section" id="{{ $sectionId }}">
    <!-- Skeleton Loading -->
    <div class="fade-section-skeleton">
        <div class="fade-skeleton-container">
            <div class="fade-skeleton-bg"></div>
            <div class="fade-skeleton-overlay"></div>
            <div class="fade-skeleton-card">
                <div class="fade-skeleton-title"></div>
                <div class="fade-skeleton-description"></div>
                <div class="fade-skeleton-button"></div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ruby-fade-section__main bg-black">
        <div class="relative flex justify-center">
            <div class="w-full relative h-[450px] md:h-[645px] overflow-hidden">
                @if ($backgroundImageUrl)
                    <img alt="{{ $cardTitle ?? __('Background image') }}" class="w-full h-full object-cover fade-bg-image" src="{{ $backgroundImageUrl }}" loading="lazy" />
                @endif

                <div class="absolute top-0 right-0 w-1/4 md:w-1/5 h-full bg-black opacity-100"></div>

                <div class="ruby-fade-card absolute top-1/2 right-4 md:right-12 transform -translate-y-1/2 mt-[-60px] border border-black bg-white p-4 md:p-8 lg:p-12 pb-6 md:pb-10 lg:pb-16 w-[85%] sm:w-[65%] md:w-[55%] lg:w-1/2 flex flex-col justify-start max-w-[600px] min-h-[200px] md:min-h-[250px]">
                    @if ($cardTitle)
                        <h2 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl font-bold mb-3 md:mb-4 lg:mb-6 leading-tight">{!! BaseHelper::clean($cardTitle) !!}</h2>
                    @endif
                    @if ($cardDescription)
                        <p class="text-sm md:text-base mb-4 md:mb-6 lg:mb-8 text-black leading-relaxed flex-grow">{!! BaseHelper::clean($cardDescription) !!}</p>
                    @endif
                    @if ($buttonText && $buttonLink)
                        <div class="mt-auto">
                            <a href="{{ $buttonLink }}">
                                <button class="bg-red-500 text-white font-bold py-2 md:py-3 px-4 md:px-6 rounded hover:bg-red-600 transition duration-300 text-sm md:text-base">
                                    {!! BaseHelper::clean($buttonText) !!}
                                </button>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>


