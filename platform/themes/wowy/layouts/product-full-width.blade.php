{!! Theme::partial('header') !!}

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif

    <section class="">
        <div class="container">
            {!! Theme::content() !!}
        </div>
    </section>
</main>

{!! Theme::partial('footer') !!}
