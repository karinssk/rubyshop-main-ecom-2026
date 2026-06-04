@once
    @unless (request()->path() === '/' || request()->routeIs('public.index') || request()->routeIs('home'))
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/ruby-guarantee.css') }}?v=20260604-1">
    @endunless
@endonce

@php
    use Illuminate\Support\Arr;

    $attributes = $attributes ?? [];
    $backgroundColor = Arr::get($attributes, 'background_color', '#ed1d24');
    $textColor = Arr::get($attributes, 'text_color', '#000000');
    $title = Arr::get($attributes, 'title');
    $subtitle = Arr::get($attributes, 'subtitle');

    if (trim((string) $title) === 'Guaranteed Tough®') {
        $title = 'Built for Pros®';
    }

    if (trim((string) $subtitle) === 'เพื่อช่างมืออาชีพ งานจบไว มั่นใจคุณภาพ') {
        $subtitle = 'เพื่อช่างมืออาชีพ ทำงานไว จบงานเนี๊ยบ มั่นใจทุกไซต์งาน';
    }
@endphp

@if ($title || $subtitle)
    <section class="ruby-guarantee" style="background-color: {{ e($backgroundColor) }}; color: {{ e($textColor) }};">
        @if ($title)
            <h2 class="ruby-guarantee__title" style="color: {{ e($textColor) }};">{!! BaseHelper::clean($title) !!}</h2>
        @endif

        @if ($subtitle)
            <p class="ruby-guarantee__subtitle" style="color: {{ e($textColor) }};">{!! BaseHelper::clean($subtitle) !!}</p>
        @endif
    </section>
@endif
