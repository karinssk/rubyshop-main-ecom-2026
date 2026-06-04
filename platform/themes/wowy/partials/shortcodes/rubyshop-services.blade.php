@once
    @unless (request()->path() === '/' || request()->routeIs('public.index') || request()->routeIs('home'))
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/rubyshop-services.css') }}?v=20260604-1">
    @endunless
@endonce

@php
    use Botble\Base\Facades\BaseHelper;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];

    $cards = [];
    for ($i = 1; $i <= 4; $i++) {
        $cards[] = [
            'icon' => Arr::get($attributes, "card{$i}_icon"),
            'title' => Arr::get($attributes, "card{$i}_title"),
            'description' => Arr::get($attributes, "card{$i}_description"),
            'buttonText' => Arr::get($attributes, "card{$i}_button_text"),
            'buttonLink' => Arr::get($attributes, "card{$i}_button_link"),
        ];
    }

    $visibleCards = collect($cards)->filter(fn (array $card) => $card['title'] || $card['description']);
    $ctaIcon = Arr::get($attributes, 'cta_icon');
    $ctaTitle = Arr::get($attributes, 'cta_title');
    $ctaDescription = Arr::get($attributes, 'cta_description');
    $ctaButtonText = Arr::get($attributes, 'cta_button_text');
    $ctaButtonLink = Arr::get($attributes, 'cta_button_link');
@endphp

@if ($visibleCards->isNotEmpty() || $ctaTitle || $ctaDescription)
    <section class="ruby-services">
        @if ($visibleCards->isNotEmpty())
            <div class="ruby-services__inner">
                <div class="ruby-services__grid">
                    @foreach ($visibleCards as $card)
                        <article class="ruby-services__card">
                            <div>
                                @if ($card['icon'])
                                    <span class="ruby-services__icon" aria-hidden="true">
                                        <i class="{{ e($card['icon']) }}"></i>
                                    </span>
                                @endif

                                @if ($card['title'])
                                    <h2 class="ruby-services__title">{!! BaseHelper::clean($card['title']) !!}</h2>
                                @endif

                                @if ($card['description'])
                                    <p class="ruby-services__description">{!! BaseHelper::clean($card['description']) !!}</p>
                                @endif
                            </div>

                            @if ($card['buttonText'] && $card['buttonLink'])
                                <div class="ruby-services__action">
                                    <a class="ruby-services__button" href="{{ e($card['buttonLink']) }}">
                                        {!! BaseHelper::clean($card['buttonText']) !!}
                                    </a>
                                </div>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($ctaTitle || $ctaDescription)
            <div class="ruby-services__cta">
                <div class="ruby-services__cta-inner">
                    @if ($ctaIcon)
                        <span class="ruby-services__cta-icon" aria-hidden="true">
                            <i class="{{ e($ctaIcon) }}"></i>
                        </span>
                    @endif

                    @if ($ctaTitle)
                        <h2 class="ruby-services__cta-title">{!! BaseHelper::clean($ctaTitle) !!}</h2>
                    @endif

                    @if ($ctaDescription)
                        <p class="ruby-services__cta-description">{!! BaseHelper::clean($ctaDescription) !!}</p>
                    @endif

                    @if ($ctaButtonText && $ctaButtonLink)
                        <div class="ruby-services__cta-action">
                            <a class="ruby-services__cta-button" href="{{ e($ctaButtonLink) }}">
                                {!! BaseHelper::clean($ctaButtonText) !!}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif
