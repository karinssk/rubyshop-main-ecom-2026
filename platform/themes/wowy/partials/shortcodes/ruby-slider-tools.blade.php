@php
    use Botble\Media\Facades\RvMedia;
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $sectionTitle = Arr::get($attributes, 'section_title');

    $slides = [];

    for ($i = 1; $i <= 8; $i++) {
        $image = Arr::get($attributes, "slide{$i}_image");
        $title = Arr::get($attributes, "slide{$i}_title");
        $description = Arr::get($attributes, "slide{$i}_description");
        $link = Arr::get($attributes, "slide{$i}_link");

        if (! $image && ! $title && ! $description && ! $link) {
            continue;
        }

        $slides[] = [
            'image' => $image ? RvMedia::getImageUrl($image) : null,
            'title' => $title,
            'description' => $description,
            'link' => $link,
        ];
    }

    $sliderId = 'ruby-slider-tools-' . uniqid();
@endphp

@if (count($slides))
    <section class="py-12 px-4 max-w-screen-xl mx-auto" id="{{ $sliderId }}">
        @if ($sectionTitle)
            <h3 class="text-2xl font-bold mb-8 text-center">{!! BaseHelper::clean($sectionTitle) !!}</h3>
        @endif

        <div class="relative overflow-hidden max-w-full mx-auto rounded-lg shadow-lg">
            <div class="flex transition-transform duration-300 gap-4" data-slider-track>
                @foreach ($slides as $slide)
                    <div class="w-full sm:w-1/4 flex-shrink-0 rounded-lg overflow-hidden relative group cursor-pointer">
                        @php
                            $cardContent = '<div class="h-64 sm:h-72 md:h-80 lg:h-96 overflow-hidden">
                                ' . ($slide['image'] ? '<img src="' . $slide['image'] . '" alt="' . e($slide['title'] ?? __('Slider image')) . '" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">' : '') . '
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent pt-20 px-4 pb-4 text-white">
                                    ' . ($slide['title'] ? '<h2 class="text-color-class text-lg font-bold transition duration-300 group-hover:text-red-500 group-hover:translate-x-1">' . BaseHelper::clean($slide['title']) . '</h2>' : '') . '
                                    ' . ($slide['description'] ? '<p class="text-color-class text-sm mt-1 opacity-90 transition duration-300 group-hover:text-red-100 group-hover:translate-x-1">' . BaseHelper::clean($slide['description']) . '</p>' : '') . '
                                </div>
                            </div>';
                        @endphp

                        @if ($slide['link'])
                            <a href="{{ $slide['link'] }}">
                                {!! $cardContent !!}
                            </a>
                        @else
                            {!! $cardContent !!}
                        @endif
                    </div>
                @endforeach
            </div>

            <button type="button" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white w-12 h-12 rounded-full flex items-center justify-center z-10 hover:bg-opacity-70 transition-all duration-300" data-slider-prev>
                &#9664;
            </button>
            <button type="button" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black bg-opacity-50 text-white w-12 h-12 rounded-full flex items-center justify-center z-10 hover:bg-opacity-70 transition-all duration-300" data-slider-next>
                &#9654;
            </button>
        </div>
        <div class="text-center mt-4">
           
        </div>
    </section>
@endif
