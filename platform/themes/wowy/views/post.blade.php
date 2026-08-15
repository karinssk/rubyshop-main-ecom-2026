@php
    $layout = MetaBox::getMetaData($post, 'layout', true);
    $layout = ($layout && in_array($layout, array_keys(get_blog_single_layouts()))) ? $layout : 'blog-right-sidebar';
    Theme::layout($layout);
    $heroImage = RvMedia::getImageUrl($post->image, 'origin', false, RvMedia::getDefaultImage());
@endphp

<style>
/* ── Single Post ─────────────────────────────────────────── */
.rsp { --rsp-red: #D8251D; --rsp-navy: #16233F; --rsp-radius: 12px; }

/* Hero */
.rsp-hero {
    position: relative;
    width: 100%;
    height: 480px;
    border-radius: var(--rsp-radius);
    overflow: hidden;
    margin-bottom: 36px;
}
.rsp-hero img {
    width: 100%; height: 100%;
    object-fit: cover; display: block;
}
.rsp-hero-overlay {
    position: absolute; inset: 0;
    background: linear-gradient(to top, rgba(10,15,30,.75) 0%, rgba(10,15,30,.15) 55%, transparent 100%);
}
.rsp-hero-body {
    position: absolute; bottom: 0; left: 0; right: 0;
    padding: 28px 32px;
    color: #fff;
}
.rsp-cat-badge {
    display: inline-flex; align-items: center;
    background: var(--rsp-red); color: #fff;
    font-size: 11px; font-weight: 700; letter-spacing: .8px; text-transform: uppercase;
    padding: 4px 12px; border-radius: 999px; margin-bottom: 12px;
    text-decoration: none;
}
.rsp-hero-title {
    font-size: clamp(20px, 3.5vw, 34px);
    font-weight: 800; line-height: 1.25;
    color: #fff; margin: 0 0 14px;
}
.rsp-meta {
    display: flex; flex-wrap: wrap; gap: 14px;
    font-size: 13px; color: rgba(255,255,255,.8);
    align-items: center;
}
.rsp-meta span { display: flex; align-items: center; gap: 5px; }
.rsp-meta svg { opacity: .75; }

/* Body */
.rsp-body { padding: 0 4px; }

/* Stand-alone meta (no hero) */
.rsp-header-plain { margin-bottom: 28px; }
.rsp-header-plain h1 { font-size: clamp(22px, 4vw, 36px); font-weight: 800; color: var(--rsp-navy); line-height: 1.3; margin-bottom: 14px; }
.rsp-meta-plain { display: flex; flex-wrap: wrap; gap: 12px; font-size: 13px; color: #6b7280; align-items: center; }
.rsp-meta-plain span { display: flex; align-items: center; gap: 5px; }

/* Divider */
.rsp-divider { border: none; border-top: 1px solid #e9ecef; margin: 32px 0; }

/* Content */
.rsp-content { font-size: 16px; line-height: 1.85; color: #374151; word-break: break-word; }
.rsp-content > * + * { margin-top: 1.1rem; }
.rsp-content h1,.rsp-content h2,.rsp-content h3,.rsp-content h4,.rsp-content h5,.rsp-content h6 {
    font-weight: 700; line-height: 1.3; color: var(--rsp-navy); margin: 2rem 0 .75rem;
}
.rsp-content h2 { font-size: 1.55rem; }
.rsp-content h3 { font-size: 1.3rem; }
.rsp-content h4 { font-size: 1.1rem; }
.rsp-content p { margin-bottom: .75rem; }
.rsp-content ul,.rsp-content ol { padding-left: 1.5rem; margin-bottom: 1rem; }
.rsp-content li { margin-bottom: .45rem; }
.rsp-content img { max-width: 100%; border-radius: 10px; height: auto; display: block; margin: 1.5rem auto; }
.rsp-content blockquote {
    border-left: 4px solid var(--rsp-red);
    background: #fef2f2; padding: 16px 20px;
    border-radius: 0 8px 8px 0; margin: 1.5rem 0;
    font-style: italic; color: #555;
}
.rsp-content a { color: var(--rsp-red); text-decoration: underline; }
.rsp-content strong { color: var(--rsp-navy); }
.rsp-content table { width: 100%; border-collapse: collapse; margin: 1.5rem 0; font-size: 15px; }
.rsp-content table th { background: var(--rsp-navy); color: #fff; padding: 10px 14px; text-align: left; }
.rsp-content table td { padding: 9px 14px; border-bottom: 1px solid #e9ecef; }
.rsp-content table tr:nth-child(even) td { background: #f8f9fa; }

/* Tags */
.rsp-tags { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 28px; }
.rsp-tag {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 5px 14px; border-radius: 999px;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    font-size: 13px; color: #374151; text-decoration: none;
    transition: all .18s;
}
.rsp-tag:hover { background: var(--rsp-red); border-color: var(--rsp-red); color: #fff; }

/* Share */
.rsp-share { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 40px; }
.rsp-share-label { font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: .8px; }
.rsp-share-btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 16px; border-radius: 8px;
    font-size: 13px; font-weight: 600; text-decoration: none;
    transition: opacity .18s;
}
.rsp-share-btn:hover { opacity: .85; }
.rsp-share-btn.fb  { background: #1877f2; color: #fff; }
.rsp-share-btn.tw  { background: #111; color: #fff; }
.rsp-share-btn.li  { background: #0a66c2; color: #fff; }

/* Related */
.rsp-related { margin-top: 12px; }
.rsp-related-title {
    font-size: 18px; font-weight: 800; color: var(--rsp-navy);
    margin-bottom: 20px; padding-bottom: 12px;
    border-bottom: 2px solid var(--rsp-red);
    display: inline-block;
}
.rsp-card { border-radius: var(--rsp-radius); overflow: hidden; background: #fff; border: 1px solid #e9ecef; height: 100%; }
.rsp-card-img { width: 100%; height: 200px; object-fit: cover; display: block; transition: transform .35s; }
.rsp-card:hover .rsp-card-img { transform: scale(1.04); }
.rsp-card-img-wrap { overflow: hidden; position: relative; }
.rsp-card-cat {
    position: absolute; top: 12px; left: 12px;
    background: var(--rsp-red); color: #fff;
    font-size: 11px; font-weight: 700; letter-spacing: .6px; text-transform: uppercase;
    padding: 3px 10px; border-radius: 999px; text-decoration: none;
}
.rsp-card-body { padding: 16px; }
.rsp-card-title { font-size: 15px; font-weight: 700; color: var(--rsp-navy); line-height: 1.4; margin-bottom: 10px; text-decoration: none; display: block; }
.rsp-card-title:hover { color: var(--rsp-red); }
.rsp-card-meta { font-size: 12px; color: #9ca3af; display: flex; align-items: center; justify-content: space-between; }
.rsp-card-read { font-size: 12px; font-weight: 600; color: var(--rsp-red); text-decoration: none; }
.rsp-card-read:hover { text-decoration: underline; }

/* Mobile */
@media (max-width: 767px) {
    .rsp-hero { height: 240px; border-radius: 8px; margin-bottom: 20px; }
    .rsp-hero-body { padding: 16px 18px; }
    .rsp-hero-title { font-size: 18px; }
    .rsp-meta { gap: 8px; font-size: 12px; }
    .rsp-content { font-size: 15px; }
    .rsp-share { gap: 7px; }
    .rsp-card-img { height: 160px; }
}
</style>

<div class="rsp">
    {{-- HERO IMAGE --}}
    @if ($post->image)
    <div class="rsp-hero">
        <img src="{{ $heroImage }}" alt="{{ $post->name }}" loading="eager" fetchpriority="high" decoding="async">
        <div class="rsp-hero-overlay"></div>
        <div class="rsp-hero-body">
            @if ($post->first_category && $post->first_category->name)
                <a href="{{ $post->first_category->url }}" class="rsp-cat-badge">{{ $post->first_category->name }}</a><br>
            @endif
            <h1 class="rsp-hero-title">{{ $post->name }}</h1>
            <div class="rsp-meta">
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    {{ $post->created_at->translatedFormat('d M Y') }}
                </span>
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    {{ __(':count mins read', ['count' => get_time_to_read($post)]) }}
                </span>
                <span>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    {{ number_format($post->views) }} {{ __('Views') }}
                </span>
            </div>
        </div>
    </div>
    @else
    {{-- No image fallback --}}
    <div class="rsp-body">
        <div class="rsp-header-plain">
            @if ($post->first_category && $post->first_category->name)
                <a href="{{ $post->first_category->url }}" class="rsp-cat-badge" style="color:var(--rsp-red);background:#fef2f2;margin-bottom:10px;display:inline-flex;">{{ $post->first_category->name }}</a>
            @endif
            <h1>{{ $post->name }}</h1>
            <div class="rsp-meta-plain">
                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>{{ $post->created_at->translatedFormat('d M Y') }}</span>
                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>{{ __(':count mins read', ['count' => get_time_to_read($post)]) }}</span>
                <span><svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>{{ number_format($post->views) }} {{ __('Views') }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- CONTENT --}}
    <div class="rsp-body">
        <div class="rsp-content">
            {!! BaseHelper::clean($post->content) !!}
        </div>

        {!! apply_filters(BASE_FILTER_PUBLIC_COMMENT_AREA, null, $post) !!}

        <hr class="rsp-divider">

        {{-- TAGS --}}
        @if (!$post->tags->isEmpty())
        <div class="rsp-tags">
            @foreach ($post->tags as $tag)
                <a href="{{ $tag->url }}" class="rsp-tag">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
                    {{ $tag->name }}
                </a>
            @endforeach
        </div>
        @endif

        {{-- SHARE --}}
        <div class="rsp-share">
            <span class="rsp-share-label">{{ __('Share') }}:</span>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}" target="_blank" rel="noopener" class="rsp-share-btn fb">
                <svg width="14" height="14" viewBox="0 0 24 24"><path fill="currentColor" d="M13.5 9H16V6h-2.5C11.6 6 10 7.6 10 9.5V12H8v3h2v6h3v-6h2.3l.7-3H13v-2.5c0-.3.2-.5.5-.5z"/></svg>
                Facebook
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ urlencode(strip_tags($post->name)) }}" target="_blank" rel="noopener" class="rsp-share-btn tw">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.744l7.73-8.835L1.254 2.25H8.08l4.259 5.631 5.905-5.631zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                X
            </a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($post->url) }}" target="_blank" rel="noopener" class="rsp-share-btn li">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                LinkedIn
            </a>
        </div>

        {{-- RELATED POSTS --}}
        @php $relatedPosts = get_related_posts($post->id, 2); @endphp
        @if ($relatedPosts->count())
        <div class="rsp-related">
            <h4 class="rsp-related-title">{{ __('Related Articles') }}</h4>
            <div class="row g-3">
                @foreach ($relatedPosts as $rel)
                <div class="col-md-6">
                    <div class="rsp-card">
                        <div class="rsp-card-img-wrap">
                            <img src="{{ RvMedia::getImageUrl($rel->image, 'medium', false, RvMedia::getDefaultImage()) }}" alt="{{ $rel->name }}" class="rsp-card-img" loading="lazy" decoding="async">
                            @if ($rel->first_category && $rel->first_category->name)
                                <a href="{{ $rel->first_category->url }}" class="rsp-card-cat">{{ $rel->first_category->name }}</a>
                            @endif
                        </div>
                        <div class="rsp-card-body">
                            <a href="{{ $rel->url }}" class="rsp-card-title">{{ $rel->name }}</a>
                            <div class="rsp-card-meta">
                                <span>{{ $rel->created_at->translatedFormat('d M Y') }}</span>
                                <a href="{{ $rel->url }}" class="rsp-card-read">{{ __('Read more') }} →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
