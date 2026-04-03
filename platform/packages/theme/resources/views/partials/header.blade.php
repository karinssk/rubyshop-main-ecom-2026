{!! SeoHelper::render() !!}

@if ($favicon = theme_option('favicon'))
    {{ Html::favicon(
        RvMedia::getImageUrl($favicon),
        ['type' => rescue(fn () => File::mimeType(RvMedia::getRealPath($favicon)), 'image/x-icon')]
    ) }}
@endif

@if (Theme::has('headerMeta'))
    {!! Theme::get('headerMeta') !!}
@endif

{!! apply_filters('theme_front_meta', null) !!}

@php
    $currentRoute = request()->route() ? request()->route()->getName() : '';
    $isProductPage = $currentRoute === 'public.product-detail' || 
                     $currentRoute === 'public.product' || 
                     str_contains($currentRoute, 'product') ||
                     request()->is('products/*');
    
    // Also exclude home page since it has its own LocalBusiness schema
    $isHomePage = request()->is('/') || $currentRoute === 'public.index' || request()->url() === url('/');
    
    $shouldShowWebSiteSchema = !$isProductPage && !$isHomePage;
@endphp

@if ($shouldShowWebSiteSchema)
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "{{ rescue(fn() => SeoHelper::openGraph()->getProperty('site_name')) }}",
  "url": "{{ url('') }}"
}
</script>
@endif

{!! Theme::typography()->renderCssVariables() !!}

{!! Theme::asset()->container('before_header')->styles() !!}
{!! Theme::asset()->styles() !!}
{!! Theme::asset()->container('after_header')->styles() !!}
{!! Theme::asset()->container('header')->scripts() !!}

{!! apply_filters(THEME_FRONT_HEADER, null) !!}

<script>
    window.siteUrl = "{{ rescue(fn() => BaseHelper::getHomepageUrl()) }}";
</script>
