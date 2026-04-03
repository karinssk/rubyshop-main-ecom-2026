@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $cards = [];

    for ($i = 1; $i <= 3; $i++) {
        $title = Arr::get($attributes, "card{$i}_title");
        $description = Arr::get($attributes, "card{$i}_description");
        $image = Arr::get($attributes, "card{$i}_image");
        $buttonText = Arr::get($attributes, "card{$i}_button_text");
        $buttonLink = Arr::get($attributes, "card{$i}_button_link");

        if (! $title && ! $description && ! $image && ! $buttonText && ! $buttonLink) {
            continue;
        }

        $cards[] = [
            'title' => $title,
            'description' => $description,
            'image' => $image ? RvMedia::getImageUrl($image) : null,
            'buttonText' => $buttonText,
            'buttonLink' => $buttonLink,
        ];
    }

    $sectionId = 'ruby-feature-cards-' . uniqid();
@endphp

@once
    <style>
        /* Feature Cards Skeleton Loading Styles */
        .ruby-feature-cards {
            position: relative;
        }

        .ruby-feature-cards__main {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }

        .ruby-feature-cards__main.loaded {
            opacity: 1;
        }

        .feature-cards-skeleton {
            position: absolute;
            inset: 0;
            z-index: 1;
            padding: 64px 24px;
            max-width: 1152px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr;
            gap: 24px;
        }

        .feature-cards-skeleton.hidden {
            display: none;
        }

        .skeleton-feature-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .skeleton-card-image {
            height: 192px;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: skeleton-shimmer 2s infinite;
        }

        .skeleton-card-content {
            padding: 24px;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .skeleton-card-title {
            height: 28px;
            background: #f0f0f0;
            border-radius: 4px;
            margin-bottom: 12px;
            animation: skeleton-shimmer 2s infinite;
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
        }

        .skeleton-card-description {
            height: 48px;
            background: #f5f5f5;
            border-radius: 4px;
            margin-bottom: 16px;
            animation: skeleton-shimmer 2s infinite;
            background: linear-gradient(90deg, #f5f5f5 25%, #e8e8e8 50%, #f5f5f5 75%);
            background-size: 200% 100%;
        }

        .skeleton-card-button {
            height: 40px;
            width: 120px;
            background: rgba(239, 68, 68, 0.2);
            border-radius: 4px;
            margin: auto auto 0 auto;
            animation: skeleton-shimmer 2s infinite;
            background: linear-gradient(90deg, rgba(239, 68, 68, 0.2) 25%, rgba(239, 68, 68, 0.3) 50%, rgba(239, 68, 68, 0.2) 75%);
            background-size: 200% 100%;
        }

        @keyframes skeleton-shimmer {
            0% {
                background-position: -200% 0;
            }
            100% {
                background-position: 200% 0;
            }
        }

        @media (min-width: 768px) {
            .feature-cards-skeleton {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>
@endonce

@if (count($cards))
    <section class="ruby-feature-cards" id="{{ $sectionId }}">
        <!-- Skeleton Loading -->
        <div class="feature-cards-skeleton">
            @for ($i = 0; $i < count($cards); $i++)
                <div class="skeleton-feature-card">
                    <div class="skeleton-card-image"></div>
                    <div class="skeleton-card-content">
                        <div class="skeleton-card-title"></div>
                        <div class="skeleton-card-description"></div>
                        <div class="skeleton-card-button"></div>
                    </div>
                </div>
            @endfor
        </div>

        <!-- Main Content -->
        <div class="ruby-feature-cards__main py-16 px-6 max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($cards as $card)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden flex flex-col h-full">
                    @if ($card['image'])
                        <img src="{{ $card['image'] }}" alt="{{ $card['title'] ?? __('Feature image') }}" class="w-full h-48 object-cover feature-card-image" loading="lazy">
                    @endif
                    <div class="p-6 text-center flex flex-col flex-grow">
                        @if ($card['title'])
                            <h3 class="text-xl font-bold">{!! BaseHelper::clean($card['title']) !!}</h3>
                        @endif
                        @if ($card['description'])
                            <p class="text-gray-600 mt-2">{!! BaseHelper::clean($card['description']) !!}</p>
                        @endif
                        @if ($card['buttonText'] && $card['buttonLink'])
                            <div class="mt-auto">
                                <a href="{{ $card['buttonLink'] }}" class="mt-4 inline-block bg-red-500 px-4 py-2 rounded font-semibold hover:bg-red-600 transition text-white">
                                    {!! BaseHelper::clean($card['buttonText']) !!}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
