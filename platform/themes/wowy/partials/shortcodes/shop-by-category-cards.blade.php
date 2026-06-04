@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $title = Arr::get($attributes, 'title', __('Shop By Category'));
    $buttonText = Arr::get($attributes, 'button_text');
    $buttonLink = Arr::get($attributes, 'button_link');
    $rawCards = [];

    $legacyCards = Arr::get($attributes, 'cards', []);

    if (is_string($legacyCards)) {
        $decodedCards = base64_decode($legacyCards, true);

        if ($decodedCards !== false) {
            $legacyCards = json_decode($decodedCards, true) ?: [];
        } else {
            $legacyCards = json_decode($legacyCards, true) ?: [];
        }
    }

    if (is_array($legacyCards) && ! empty($legacyCards)) {
        $firstItem = Arr::first($legacyCards);

        if (is_array($firstItem) && array_key_exists('key', $firstItem) && array_key_exists('value', $firstItem)) {
            $normalized = [];

            foreach ($legacyCards as $card) {
                $item = [];

                foreach ((array) $card as $entry) {
                    $key = Arr::get($entry, 'key');
                    if ($key !== null) {
                        $item[$key] = Arr::get($entry, 'value');
                    }
                }

                if (! empty(array_filter($item, fn ($value) => filled($value)))) {
                    $normalized[] = $item;
                }
            }

            $legacyCards = $normalized;
        }
    }

    if (is_array($legacyCards) && filled($legacyCards)) {
        $rawCards = $legacyCards;
    }

    if (empty($rawCards)) {
        for ($i = 1; $i <= 20; $i++) {
            $card = [
                'image' => Arr::get($attributes, "card{$i}_image"),
                'title' => Arr::get($attributes, "card{$i}_title"),
                'subtitle' => Arr::get($attributes, "card{$i}_subtitle"),
                'link' => Arr::get($attributes, "card{$i}_link"),
            ];

            if (! $card['image'] && ! $card['title'] && ! $card['subtitle'] && ! $card['link']) {
                continue;
            }

            $rawCards[] = $card;
        }
    }

    $accentColors = [
        '#476e8a',
        '#2f120e',
        '#0a7b3b',
        '#20386a',
        '#b91c1c',
        '#c81e1e',
    ];

    $cards = collect($rawCards)
        ->map(function ($item, $index) use ($accentColors) {
            $card = is_array($item) ? $item : [];

            $title = Arr::get($card, 'title');
            $subtitle = Arr::get($card, 'subtitle');
            $image = Arr::get($card, 'image');
            $link = Arr::get($card, 'link');

            if (! $title && ! $subtitle && ! $image && ! $link) {
                return null;
            }

            $resolvedImage = $image
                ? RvMedia::getImageUrl($image, 'medium', false, RvMedia::getDefaultImage())
                : RvMedia::getDefaultImage();

            return [
                'title' => $title,
                'subtitle' => $subtitle,
                'image' => $resolvedImage,
                'link' => $link,
                'accent' => $accentColors[$index % count($accentColors)],
            ];
        })
        ->filter()
        ->values();

    $sectionId = 'shop-by-category-cards-' . uniqid();
@endphp

@if ($cards->isNotEmpty())
    <section class="shop-by-category-cards" id="{{ $sectionId }}" data-shop-by-category-root>
        <div class="shop-by-category-cards__inner">
            <div class="shop-by-category-cards__header">
                <h2 class="shop-by-category-cards__title">{!! BaseHelper::clean($title) !!}</h2>
            </div>

            <div class="shop-by-category-cards__carousel">
                <button type="button" class="shop-by-category-cards__arrow shop-by-category-cards__arrow--prev" data-shop-by-category-prev aria-label="{{ __('Previous cards') }}">
                    <i class="fas fa-arrow-left"></i>
                </button>

                <div class="shop-by-category-cards__track" data-shop-by-category-slider>
                    @foreach ($cards as $card)
                        @php
                            $isLinked = filled($card['link']);
                        @endphp

                        <article class="shop-by-category-cards__card" style="--card-accent: {{ $card['accent'] }};">
                            @if ($isLinked)
                                <a href="{{ $card['link'] }}" class="shop-by-category-cards__card-link" aria-label="{{ Arr::get($card, 'title') }}">
                            @endif

                            <div class="shop-by-category-cards__image-wrap">
                                <img
                                    src="{{ $card['image'] }}"
                                    alt="{{ $card['title'] ?: __('Category image') }}"
                                    class="shop-by-category-cards__image"
                                    loading="lazy"
                                    decoding="async"
                                >
                            </div>

                            <div class="shop-by-category-cards__content">
                                @if ($card['title'])
                                    <h3 class="shop-by-category-cards__card-title">{!! BaseHelper::clean($card['title']) !!}</h3>
                                @endif

                                @if ($card['subtitle'])
                                    <p class="shop-by-category-cards__card-subtitle">{!! BaseHelper::clean($card['subtitle']) !!}</p>
                                @endif
                            </div>

                            @if ($isLinked)
                                </a>
                            @endif
                        </article>
                    @endforeach
                </div>

                <button type="button" class="shop-by-category-cards__arrow shop-by-category-cards__arrow--next" data-shop-by-category-next aria-label="{{ __('Next cards') }}">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            @if ($buttonText && $buttonLink)
                <div class="shop-by-category-cards__cta">
                    <a href="{{ $buttonLink }}" class="shop-by-category-cards__cta-button">
                        {!! BaseHelper::clean($buttonText) !!}
                    </a>
                </div>
            @endif
        </div>
    </section>
@endif

@once
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/shortcodes-shop-by-category-cards.css') }}">
    <script src="{{ Theme::asset()->url('js/shortcodes-shop-by-category-cards.js') }}"></script>
@endonce
