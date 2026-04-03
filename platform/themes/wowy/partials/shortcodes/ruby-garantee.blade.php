@php
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $backgroundColor = Arr::get($attributes, 'background_color', '#ed1d24');
    $textColor = Arr::get($attributes, 'text_color', '#000000');
    $title = Arr::get($attributes, 'title');
    $subtitle = Arr::get($attributes, 'subtitle');
@endphp

@if ($title || $subtitle)
    <section class="py-6 text-center h-[150px] flex flex-col justify-center" style="background-color: {{ $backgroundColor }}; color: {{ $textColor }};">
        @if ($title)
            <h4 class="text-3xl font-bold uppercase mb-2" style="color: {{ $textColor }};">{!! BaseHelper::clean($title) !!}</h4>
        @endif
        @if ($subtitle)
            <p class="text-base uppercase" style="color: {{ $textColor }};">{!! BaseHelper::clean($subtitle) !!}</p>
        @endif
    </section>
@endif
