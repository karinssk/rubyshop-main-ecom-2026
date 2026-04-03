@php
    $page->loadMissing('metadata');

    Theme::set('page', $page);
@endphp

<style>
    .legal-page-content,
    .legal-page-content * {
        font-family: inherit;
    }

    .legal-page-content {
        max-width: 960px;
        margin: 0 auto;
        color: #1f2937;
        line-height: 1.8;
        font-size: 16px;
        word-break: break-word;
    }

    .legal-page-content h1,
    .legal-page-content h2,
    .legal-page-content h3,
    .legal-page-content h4,
    .legal-page-content h5,
    .legal-page-content h6 {
        line-height: 1.35;
        font-weight: 700;
        margin-top: 1.25em;
        margin-bottom: 0.6em;
    }

    .legal-page-content p,
    .legal-page-content li,
    .legal-page-content div,
    .legal-page-content span {
        font-size: inherit !important;
        line-height: inherit !important;
    }

    .legal-page-content p,
    .legal-page-content ul,
    .legal-page-content ol {
        margin-bottom: 1rem;
    }

    .legal-page-content ul,
    .legal-page-content ol {
        padding-left: 1.25rem;
    }
</style>

@if ($page->template == 'default')
    <section class="mt-60 mb-60">
       {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 
'ck-content legal-page-content'])->toHtml(), $page) !!}
    </section>
@else
{!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', BaseHelper::clean($page->content), ['class' => 'ck-content legal-page-content'])->toHtml(), 
$page) !!}
@endif
