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
@endphp

@if (collect($columns)->filter(fn ($column) => $column['image'] || $column['title'] || $column['description'])->isNotEmpty())
    <section class="relative w-full py-8 sm:py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 w-full gap-0">
            @foreach ($columns as $column)
                @php
                    $imageUrl = $column['image'] ? RvMedia::getImageUrl($column['image']) : null;
                @endphp

                <div class="relative h-[450px] sm:h-[500px] md:h-[600px] overflow-hidden group">
                    @if ($imageUrl)
                        <img src="{{ $imageUrl }}" alt="{{ $column['title'] ?? __('Powerful image') }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105" loading="lazy" />
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent flex flex-col justify-end p-4 sm:p-6 lg:p-8 space-y-4 transition-all duration-300 group-hover:from-black/90 group-hover:via-black/50">
                        <div class="text-center max-w-xl mx-auto {{ $loop->first ? 'md:mr-0 md:ml-auto' : 'md:ml-0 md:mr-auto' }}">
                            @if ($column['title'])
                                <h2 class="text-2xl sm:text-3xl font-bold text-white text-center transform transition-transform duration-300 group-hover:-translate-y-1">
                                    {!! BaseHelper::clean($column['title']) !!}
                                </h2>
                            @endif
                            @if ($column['description'])
                                <p class="text-sm sm:text-base lg:text-lg text-white text-center opacity-90 transition-all duration-300 group-hover:opacity-100 group-hover:-translate-y-0.5">
                                    {!! BaseHelper::clean($column['description']) !!}
                                </p>
                            @endif
                            @if ($column['buttonText'] && $column['buttonLink'])
                                <div class="mt-4 flex justify-center">
                                    <a href="{{ $column['buttonLink'] }}" class="inline-block bg-red-600 text-white font-semibold py-2 px-6 rounded-full transition-all duration-300 group-hover:bg-red-500 group-hover:shadow-lg group-hover:-translate-y-0.5">
                                        {!! BaseHelper::clean($column['buttonText']) !!}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endif
