@php
    $page->loadMissing('metadata');

    Theme::set('page', $page);

    $hasRenderedH1 = \Illuminate\Support\Str::contains(mb_strtolower((string) $page->content), '<h1');
    $isContactPage = request()->is('contact*')
        || \Illuminate\Support\Str::contains($page->content, ['id="contact"', "id='contact'"])
        || \Illuminate\Support\Str::contains(strtolower((string) $page->name), 'contact');
@endphp

@if ($isContactPage)
    <style>
    #main-section > .container {
        max-width: 100% !important;
        width: 100% !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    #main-section > .container > .mt-60.mb-60 {
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
    </style>
@endif

@if ($page->template === 'homepage')
    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
@elseif ($page->template === 'default')
    @if ($isContactPage)
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, BaseHelper::clean($page->content), $page) !!}
    @else
        @php
            $pageContent = BaseHelper::clean($page->content);
            if ($isContactPage && ! $hasRenderedH1) {
                $pageTitle = trim((string) $page->name);
                $pageContent = '<h1 class="text-3xl font-bold text-gray-900 mb-8">' . e($pageTitle ?: __('Contact')) . '</h1>' . $pageContent;
            }
        @endphp
        <section class="mt-60 mb-60">
            {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', $pageContent, ['class' => 'ck-content legal-page-content'])->toHtml(), $page) !!}
        </section>
    @endif
@else
    @if ($isContactPage)
        @php
            $pageContent = BaseHelper::clean($page->content);
            if (! $hasRenderedH1) {
                $pageTitle = trim((string) $page->name);
                $pageContent = '<h1 class="text-3xl font-bold text-gray-900 mb-8">' . e($pageTitle ?: __('Contact')) . '</h1>' . $pageContent;
            }
        @endphp
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, $pageContent, $page) !!}
    @else
        {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content legal-page-content'])->toHtml(), $page) !!}
    @endif
@endif
