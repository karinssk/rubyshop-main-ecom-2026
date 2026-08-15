@once
    @unless (request()->path() === '/' || request()->routeIs('public.index') || request()->routeIs('home'))
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/ruby-performance.css') }}?v=20260604-1">
    @endunless
@endonce

@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $columns = [];

    for ($i = 1; $i <= 2; $i++) {
        $columns[] = [
            'image' => Arr::get($attributes, "column{$i}_image"),
            'title' => Arr::get($attributes, "column{$i}_title"),
            'description' => Arr::get($attributes, "column{$i}_description"),
            'buttonText' => Arr::get($attributes, "column{$i}_button_text"),
            'buttonLink' => Arr::get($attributes, "column{$i}_button_link"),
        ];
    }

    $visibleColumns = collect($columns)->filter(fn (array $column) => $column['image'] || $column['title'] || $column['description']);
@endphp

@if ($visibleColumns->isNotEmpty())
    <section class="ruby-performance">
        <div class="ruby-performance__grid">
            @foreach ($visibleColumns as $column)
                @php
                    $imageUrl = $column['image'] ? RvMedia::getImageUrl($column['image'], 'medium', false, RvMedia::getDefaultImage()) : RvMedia::getDefaultImage();
                    $imageUrlSmall = $column['image'] ? RvMedia::getImageUrl($column['image'], 'product-thumb', false, RvMedia::getDefaultImage()) : $imageUrl;
                @endphp

                <article class="ruby-performance__panel">
                    <img
                        class="ruby-performance__image"
                        src="{{ $imageUrl }}"
                        srcset="{{ $imageUrlSmall }} 400w, {{ $imageUrl }} 800w"
                        sizes="(max-width: 991px) 100vw, 50vw"
                        alt="{{ e($column['title'] ?: __('Powerful image')) }}"
                        width="900"
                        height="600"
                        loading="lazy"
                        decoding="async"
                    >

                    <div class="ruby-performance__overlay">
                        <div class="ruby-performance__content">
                            @if ($column['title'])
                                <h2 class="ruby-performance__title">{!! BaseHelper::clean($column['title']) !!}</h2>
                            @endif

                            @if ($column['description'])
                                <p class="ruby-performance__description">{!! BaseHelper::clean($column['description']) !!}</p>
                            @endif

                            @if ($column['buttonText'] && $column['buttonLink'])
                                <div class="ruby-performance__action">
                                    <a class="ruby-performance__button" href="{{ e($column['buttonLink']) }}" aria-label="{{ e(trim(strip_tags((string) $column['buttonText'])) . ($column['title'] ? ': ' . trim(strip_tags((string) $column['title'])) : '')) }}">
                                        {!! BaseHelper::clean($column['buttonText']) !!}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </section>
@endif
