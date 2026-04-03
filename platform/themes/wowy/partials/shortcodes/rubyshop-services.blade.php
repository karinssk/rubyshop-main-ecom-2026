@php
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

    $ctaIcon = Arr::get($attributes, 'cta_icon');
    $ctaTitle = Arr::get($attributes, 'cta_title');
    $ctaDescription = Arr::get($attributes, 'cta_description');
    $ctaButtonText = Arr::get($attributes, 'cta_button_text');
    $ctaButtonLink = Arr::get($attributes, 'cta_button_link');
@endphp

@if (collect($cards)->some(fn ($card) => $card['title'] || $card['description']))
    <section>
        <div class="container mx-auto p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($cards as $card)
                    @if ($card['title'] || $card['description'])
                        <div class="bg-gray-200 p-6 flex flex-col justify-between h-[460px]">
                            <div class="text-center">
                                @if ($card['icon'])
                                    <i class="{{ $card['icon'] }} text-4xl mb-4"></i>
                                @endif

                                @if ($card['title'])
                                    <h2 class="text-xl font-bold mb-2">{!! BaseHelper::clean($card['title']) !!}</h2>
                                @endif

                                @if ($card['description'])
                                    <p class="mb-4 text-base text-black">
                                        {!! BaseHelper::clean($card['description']) !!}
                                    </p>
                                @endif
                            </div>

                            @if ($card['buttonText'] && $card['buttonLink'])
                                <div class="text-center mt-4">
                                    <a href="{{ $card['buttonLink'] }}">
                                        <button class="bg-red-500 text-white py-2 px-4 hover:bg-red-600 transition duration-300">
                                            {!! BaseHelper::clean($card['buttonText']) !!}
                                        </button>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
@endif

@if ($ctaTitle || $ctaDescription)
    <section class="">
        <div class="bg-red-500 py-16 px-4">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                @if ($ctaIcon)
                    <i class="{{ $ctaIcon }} text-4xl mb-4 text-white"></i>
                @endif

                @if ($ctaTitle)
                    <h1 class="text-3xl font-bold mb-4 text-white">{!! BaseHelper::clean($ctaTitle) !!}</h1>
                @endif

                @if ($ctaDescription)
                    <p class="mb-6 text-white">{!! BaseHelper::clean($ctaDescription) !!}</p>
                @endif

                @if ($ctaButtonText && $ctaButtonLink)
                    <div>
                        <a href="{{ $ctaButtonLink }}" class="inline-flex items-center justify-center bg-black text-white py-2 px-6 rounded-full hover:bg-red-600 transition duration-300">
                            {!! BaseHelper::clean($ctaButtonText) !!}
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="">
            <p class="text-center text-sm"></p>
        </div>
    </section>
@endif
