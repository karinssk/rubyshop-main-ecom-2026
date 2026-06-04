@once
    @unless (request()->path() === '/' || request()->routeIs('public.index') || request()->routeIs('home'))
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/featured-product-categories.css') }}">
    @endunless
@endonce

@php
    use Botble\Media\Facades\RvMedia;

    $sectionId = 'featured-categories-' . uniqid();
@endphp

@if ($categories->isNotEmpty())
    <section class="featured-categories" id="{{ $sectionId }}" data-featured-categories-root>
        <div class="featured-categories__inner">
            <div class="featured-categories__header">
                @if ($title)
                    <h2 class="featured-categories__title">{!! BaseHelper::clean($title) !!}</h2>
                @endif

                <div class="featured-categories__controls" aria-label="{{ __('Category slider controls') }}">
                    <button type="button" class="featured-categories__arrow" data-featured-categories-prev aria-label="{{ __('Previous categories') }}">
                        <i class="fas fa-chevron-left" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="featured-categories__arrow" data-featured-categories-next aria-label="{{ __('Next categories') }}">
                        <i class="fas fa-chevron-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="featured-categories__track" data-featured-categories-slider>
                @foreach ($categories as $category)
                    <article class="featured-categories__card" data-featured-category-card>
                        <a class="featured-categories__link" href="{{ $category->url }}">
                            <div class="featured-categories__image-wrap">
                                <img
                                    class="featured-categories__image imgMixBlendMode"
                                    src="{{ RvMedia::getImageUrl($category->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}"
                                    alt="{{ e($category->name) }}"
                                    width="400"
                                    height="400"
                                    loading="lazy"
                                    decoding="async"
                                >
                                <span class="featured-categories__badge">{{ $category->name }}</span>
                            </div>

                            <div class="featured-categories__content">
                                <h3 class="featured-categories__name">{{ strtoupper($category->name) }}</h3>
                                <span class="featured-categories__cta">
                                    {{ __('Explore all') }}
                                    <i class="fas fa-chevron-right" aria-hidden="true"></i>
                                </span>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif

@once
    <script src="{{ Theme::asset()->url('js/featured-product-categories.js') }}" defer></script>
@endonce
