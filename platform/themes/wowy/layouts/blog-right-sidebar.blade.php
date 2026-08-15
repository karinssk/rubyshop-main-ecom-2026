@php
    Theme::asset()->container('footer')->usePath()->add('jquery.theia.sticky-js', 'js/plugins/jquery.theia.sticky.js');
@endphp

{!! Theme::partial('header') !!}

<style>
/* ── Blog responsive ── */
.rs-blog-header {
    margin-bottom: 32px;
    padding: 0 4px;
}
.rs-blog-header h1 { font-size: clamp(20px, 5vw, 32px); line-height: 1.3; }
.rs-blog-grid { padding-right: 0; }

/* Scope min-height override to blog articles only, not sidebar widgets */
article .post-thumb { min-height: 0 !important; }

/* First (hero) post image */
.first-post .post-thumb img {
    width: 100%;
    height: 520px;
    object-fit: cover;
    border-radius: 10px;
    display: block;
}
/* Card post images */
article:not(.first-post) .post-thumb img {
    width: 100%;
    height: 340px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
}

/* Recent Posts widget — restore natural sizing */
.sidebar-widget .post-thumb { min-height: 0 !important; }
.sidebar-widget .post-thumb img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 6px;
    display: block;
}

/* Read more link — flex instead of float */
.rs-read-more { display: flex; justify-content: flex-end; }

/* Sidebar toggle — mobile */
.rs-sidebar-toggle {
    display: none;
    width: 100%;
    padding: 11px 16px;
    background: #f8f9fa;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    color: #16233F;
    cursor: pointer;
    text-align: left;
    margin-bottom: 16px;
}
.rs-sidebar-toggle svg { float: right; transition: transform .25s; }
.rs-sidebar-toggle.open svg { transform: rotate(180deg); }
.rs-sidebar-body { transition: none; }

@media (max-width: 991px) {
    .rs-blog-header { margin-bottom: 20px; }
    .rs-blog-grid .col-md-6.col-sm-6 { margin-bottom: 20px; }
    section.mt-60 { margin-top: 24px !important; }
    section.mb-60 { margin-bottom: 24px !important; }

    /* Sidebar: hidden by default on mobile, toggled open */
    .rs-sidebar-toggle { display: flex; align-items: center; justify-content: space-between; }
    .rs-sidebar-body { display: none; }
    .rs-sidebar-body.open { display: block; }

    /* Hero post */
    .first-post .entry-content { padding: 12px 0 0; }
    .first-post .post-title { font-size: 18px !important; }
    .first-post .post-exerpt { display: none; }
    .first-post .mb-30 { margin-bottom: 12px !important; }
    .first-post .mb-20 { margin-bottom: 8px !important; }
}

@media (max-width: 575px) {
    .rs-blog-grid .col-md-6.col-sm-6 { width: 100% !important; flex: 0 0 100% !important; max-width: 100%; }
    article:not(.first-post) .post-thumb img { aspect-ratio: 21/9; }
}
</style>

<main class="main" id="main-section">
    @if (Theme::get('hasBreadcrumb', true))
        {!! Theme::partial('breadcrumb') !!}
    @endif

    <section class="mt-60 mb-60">
        <div class="container custom">
            <div class="row">
                <div class="col-lg-9">
                    {!! Theme::content() !!}
                </div>
                <div class="col-lg-3 primary-sidebar sticky-sidebar">
                    <div class="widget-area">
                        <button class="rs-sidebar-toggle" type="button" onclick="this.classList.toggle('open'); this.nextElementSibling.classList.toggle('open')">
                            ตัวกรองและข้อมูลเพิ่มเติม
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="rs-sidebar-body">
                            {!! dynamic_sidebar('primary_sidebar') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
{!! Theme::partial('footer') !!}