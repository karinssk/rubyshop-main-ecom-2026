@php
    $normalizeLanguageUrl = fn (?string $url): ?string => $url
        ? preg_replace('/((?:categories|brands|tags|attributes)%5B)\\d+(%5D=)/i', '$1$2', $url)
        : $url;
@endphp

<link
    href="{{ $normalizeLanguageUrl(Language::getLocalizedURL(Language::getDefaultLocale(), url()->current(), [], false)) }}"
    hreflang="x-default"
    rel="alternate"
/>

@if (!empty($urls))
    @foreach ($urls as $item)
        <link
            href="{{ $normalizeLanguageUrl($item['url']) }}"
            hreflang="{{ $item['lang_code'] }}"
            rel="alternate"
        />
    @endforeach
@else
    @foreach (Language::getSupportedLocales() as $localeCode => $properties)
        <link
            href="{{ $normalizeLanguageUrl(Language::getLocalizedURL($localeCode, url()->current(), [], false)) }}"
            hreflang="{{ $localeCode }}"
            rel="alternate"
        />
    @endforeach
@endif
