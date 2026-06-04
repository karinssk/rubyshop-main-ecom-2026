@once
    <style>
        .ruby-guarantee {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 112px;
            padding: 24px 16px;
            text-align: center;
        }

        .ruby-guarantee__title {
            margin: 0 0 8px;
            font-size: clamp(24px, 3vw, 36px);
            font-weight: 900;
            line-height: 1.15;
            text-transform: uppercase;
        }

        .ruby-guarantee__subtitle {
            margin: 0;
            font-size: clamp(14px, 1.4vw, 17px);
            font-weight: 800;
            line-height: 1.45;
            text-transform: uppercase;
            overflow-wrap: anywhere;
        }

        @media (max-width: 767px) {
            .ruby-guarantee {
                min-height: 96px;
                padding: 18px 14px;
            }
        }
    </style>
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
