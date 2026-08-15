@php
    SeoHelper::setTitle('หมวดหมู่สินค้าเครื่องมือช่าง RUBYSHOP');
    SeoHelper::setDescription('เลือกซื้อเครื่องมือช่าง RUBYSHOP ตามหมวดหมู่ เช่น เครื่องพ่นสีแรงดันสูง เครื่องพ่นปูน เครื่องกรีดผนัง อะไหล่ และอุปกรณ์งานก่อสร้างสำหรับช่างมืออาชีพ');

    $visibleCategories = isset($categories)
        ? $categories->filter(fn ($c) => $c && $c->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $c->url)
        : collect();

    $flattenCategories = function ($items) use (&$flattenCategories) {
        return collect($items)->flatMap(function ($category) use (&$flattenCategories) {
            if (! $category || $category->status != \Botble\Base\Enums\BaseStatusEnum::PUBLISHED || ! $category->url) {
                return collect();
            }

            $children = $category->subcategories
                ? $flattenCategories($category->subcategories)
                : collect();

            return collect([$category])->merge($children);
        })->values();
    };

    $allVisibleCategories = $flattenCategories($visibleCategories)
        ->unique('id')
        ->values();

    $categoryIndexUrl = url('/product-categories');
    $categoryIndexItems = $allVisibleCategories->values()->map(function ($c, $i) {
        $item = ['@type' => 'Thing', 'name' => $c->name, 'url' => $c->url];
        if ($c->image || $c->icon_image) {
            $item['image'] = RvMedia::getImageUrl($c->image ?: $c->icon_image, 'medium', false, RvMedia::getDefaultImage());
        }
        return ['@type' => 'ListItem', 'position' => $i + 1, 'item' => $item];
    })->all();

    $categoryIndexStructuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            ['@type' => 'BreadcrumbList', '@id' => $categoryIndexUrl . '#breadcrumb',
             'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('public.index')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'หมวดหมู่สินค้า', 'item' => $categoryIndexUrl],
            ]],
            ['@type' => 'CollectionPage', '@id' => $categoryIndexUrl . '#collection',
             'name' => 'หมวดหมู่สินค้าเครื่องมือช่าง RUBYSHOP', 'url' => $categoryIndexUrl,
             'description' => 'เลือกซื้อเครื่องมือช่าง RUBYSHOP ตามหมวดหมู่'],
            ['@type' => 'ItemList', '@id' => $categoryIndexUrl . '#item-list',
             'name' => 'หมวดหมู่สินค้า RUBYSHOP', 'url' => $categoryIndexUrl,
             'numberOfItems' => count($categoryIndexItems), 'itemListElement' => $categoryIndexItems],
        ],
    ];

    // Icon mapping by category name keywords
    $catIcon = function (string $name): string {
        $n = mb_strtolower($name);
        if (str_contains($n, 'mortar') || str_contains($n, 'cement') || str_contains($n, 'rotor') || str_contains($n, 'stator') || str_contains($n, 'waterproof') || str_contains($n, 'water proof') || str_contains($n, 'กันซึม') || str_contains($n, 'พ่นปูน')) return 'mortar';
        if (str_contains($n, 'airless') || str_contains($n, 'spray') || str_contains($n, 'road line') || str_contains($n, 'texture') || str_contains($n, 'พ่นสี') || str_contains($n, 'injection') || str_contains($n, 'ยิงโฟม') || str_contains($n, 'phosset')) return 'spray';
        if (str_contains($n, 'chaser') || str_contains($n, 'กรีด') || str_contains($n, 'rebar') || str_contains($n, 'ดัดเหล็ก') || str_contains($n, 'diamond blade')) return 'chaser';
        if (str_contains($n, 'sander') || str_contains($n, 'smooth') || str_contains($n, 'remover') || str_contains($n, 'polishing') || str_contains($n, 'ขัด') || str_contains($n, 'ปั่น') || str_contains($n, 'sandpaper')) return 'sander';
        if (str_contains($n, 'trowel') || str_contains($n, 'เกรียง') || str_contains($n, 'skim coat') || str_contains($n, 'plastering') || str_contains($n, 'ปูนฉาบ')) return 'trowel';
        if (str_contains($n, 'tape') || str_contains($n, 'blade') || str_contains($n, 'กระดาษ')) return 'sheet';
        return 'gear';
    };

    $tints = [
        'spray'  => ['#FDECEC', '#D8251D'],
        'mortar' => ['#E9F2EC', '#1E8A4C'],
        'chaser' => ['#FFF3E6', '#E07A1A'],
        'sander' => ['#ECEFF6', '#3A5A9B'],
        'trowel' => ['#F2ECF7', '#7A4FB0'],
        'gear'   => ['#EDEFF2', '#586273'],
        'sheet'  => ['#FBF4E6', '#B58A2A'],
    ];

    $iconPaths = [
        'spray'  => '<path d="M7 8h6v9a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3z"/><path d="M13 10h3l2-2"/><path d="M18 5l2 1M18 8l2 .5M18 11l2-.5"/><path d="M9 4h2v4H9z"/>',
        'mortar' => '<path d="M4 20h16"/><path d="M6 20v-6l6-3 6 3v6"/><path d="M12 11V6"/><path d="M9 6h6l-1-2h-4z"/>',
        'chaser' => '<circle cx="10" cy="13" r="6"/><path d="M10 9v4l3 2"/><path d="M16 7l4-4M17 9l3-1"/>',
        'sander' => '<rect x="4" y="9" width="14" height="7" rx="2"/><path d="M18 11h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-2"/><path d="M7 16v2M14 16v2"/>',
        'trowel' => '<path d="M3 14l8-8 4 4-8 8z"/><path d="M14 7l5-4 2 2-4 5z"/>',
        'gear'   => '<circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M4.2 4.2l2.1 2.1M17.7 17.7l2.1 2.1M2 12h3M19 12h3M4.2 19.8l2.1-2.1M17.7 6.3l2.1-2.1"/>',
        'sheet'  => '<rect x="5" y="3" width="14" height="18" rx="2"/><path d="M8 8h8M8 12h8M8 16h5"/>',
    ];

    $svgIcon = fn (string $icon, int $size = 24, float $stroke = 1.6, string $color = 'currentColor'): string =>
        '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="'.e($color).'" stroke-width="'.$stroke.'" stroke-linecap="round" stroke-linejoin="round">'.($iconPaths[$icon] ?? $iconPaths['gear']).'</svg>';

    // Extract English portion from "English Name | ชื่อไทย" pattern
    $enName = function (string $name): string {
        if (preg_match('/^([A-Za-z0-9][^|]{1,50}?)\s*\|/u', $name, $m)) {
            return trim($m[1]);
        }
        // If no Thai characters, return full name
        if (!preg_match('/[\x{0E00}-\x{0E7F}]/u', $name)) {
            return $name;
        }
        return '';
    };

    $totalCats   = $allVisibleCategories->count();
    $totalProducts = $allVisibleCategories->sum('products_count');
@endphp

<script type="application/ld+json">
    {!! json_encode($categoryIndexStructuredData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

<style>
/* ── Design system tokens ── */
.rsc-root {
    --rs-red: #D8251D;
    --rs-red-dark: #b91c1c;
    --rs-red-soft: #fdecec;
    --rs-navy: #16233F;
    --rs-ink: #1A2230;
    --rs-muted: #6B7280;
    --rs-faint: #9AA1AD;
    --rs-line: #E8EAEF;
    --rs-line-2: #F0F1F4;
    --rs-bg: #F4F5F7;
    --rs-card: #FFFFFF;
    --rs-radius: 14px;
    --rs-radius-sm: 9px;
    --rs-shadow: 0 1px 2px rgba(16,24,40,.04), 0 8px 24px rgba(16,24,40,.06);
    --rs-shadow-hover: 0 6px 14px rgba(16,24,40,.08), 0 20px 40px rgba(216,37,29,.10);
    --rs-gap: 18px;
    font-family: 'Prompt', system-ui, sans-serif;
    color: var(--rs-ink);
    background: var(--rs-bg);
    -webkit-font-smoothing: antialiased;
}
.rsc-root *, .rsc-root *::before, .rsc-root *::after { box-sizing: border-box; }
.rsc-root a { text-decoration: none; color: inherit; }
.rsc-root button { font-family: inherit; cursor: pointer; border: none; background: none; }

/* ── Wrapper ── */
.rsc-wrap { max-width: 1280px; margin: 0 auto; padding: 0 24px 60px; }

/* ── Breadcrumb ── */
.rsc-crumb { display: flex; align-items: center; gap: 8px; font-size: 13px; color: var(--rs-muted); padding: 18px 0 4px; flex-wrap: wrap; }
.rsc-crumb a:hover { color: var(--rs-red); }
.rsc-crumb .cur { color: var(--rs-ink); font-weight: 600; }
.rsc-crumb svg { color: var(--rs-faint); flex-shrink: 0; }

/* ── Hero ── */
.rsc-hero { padding: 8px 0 22px; display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
.rsc-hero h1 { font-size: 28px; font-weight: 800; letter-spacing: -.5px; margin: 0 0 6px; color: var(--rs-ink); }
.rsc-hero p { margin: 0; color: var(--rs-muted); font-size: 14px; }
.rsc-hero p b { color: var(--rs-red); font-weight: 700; }
.rsc-stats { display: flex; gap: 20px; flex-shrink: 0; }
.rsc-stat { text-align: center; background: var(--rs-card); border: 1px solid var(--rs-line); border-radius: 12px; padding: 10px 20px; }
.rsc-stat strong { display: block; font-size: 22px; font-weight: 800; color: var(--rs-red); line-height: 1; }
.rsc-stat span { font-size: 11px; color: var(--rs-muted); font-weight: 600; margin-top: 3px; display: block; }

/* ── Layout: sidebar + main ── */
.rsc-layout { display: grid; grid-template-columns: 256px 1fr; gap: 24px; align-items: start; }

/* ── Sidebar ── */
.rsc-side { background: var(--rs-card); border: 1px solid var(--rs-line); border-radius: var(--rs-radius); position: sticky; top: 16px; overflow: hidden; box-shadow: var(--rs-shadow); }
.rsc-side-head { padding: 14px 16px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid var(--rs-line); }
.rsc-side-head b { font-size: 14px; font-weight: 800; color: var(--rs-ink); display: inline-flex; align-items: center; gap: 7px; }
.rsc-side-head b svg { color: var(--rs-red); }
.rsc-tree { padding: 6px 8px 10px; }
.rsc-tree-all { width: 100%; display: flex; align-items: center; gap: 9px; padding: 10px 12px; border-radius: 10px; font-size: 13.5px; font-weight: 700; color: var(--rs-ink); transition: background .15s; }
.rsc-tree-all:hover, .rsc-tree-all.on { background: var(--rs-red-soft); color: var(--rs-red); }
.rsc-tree-all .ct { margin-left: auto; font-size: 12px; color: var(--rs-faint); font-weight: 700; }
.rsc-tree-all.on .ct { color: var(--rs-red); }
.rsc-tree-grp { border-top: 1px solid var(--rs-line-2); }
.rsc-tree-row { display: flex; align-items: center; border-radius: 10px; cursor: pointer; }
.rsc-tree-row .lbl { flex: 1; display: flex; align-items: center; gap: 9px; padding: 10px 4px 10px 10px; font-size: 13px; font-weight: 600; color: var(--rs-ink); min-width: 0; }
.rsc-tree-row .lbl .ic { color: var(--rs-faint); flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px; }
.rsc-tree-row .lbl .ic img { width: 28px; height: 28px; border-radius: 6px; object-fit: contain; display: block; }
.rsc-chip .ic img { width: 18px; height: 18px; border-radius: 4px; object-fit: contain; display: block; }
.rsc-tree-row .lbl .nm { overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rsc-tree-row .ct { font-size: 11.5px; color: var(--rs-faint); font-weight: 700; padding: 0 4px; flex-shrink: 0; }
.rsc-tree-row .exp { width: 32px; height: 32px; display: grid; place-items: center; color: var(--rs-faint); border-radius: 8px; flex-shrink: 0; transition: transform .2s; }
.rsc-tree-row:hover { background: var(--rs-bg); }
.rsc-tree-row:hover .lbl { color: var(--rs-red); }
.rsc-tree-row:hover .lbl .ic { color: var(--rs-red); }
.rsc-tree-row.on .lbl { color: var(--rs-red); font-weight: 700; }
.rsc-tree-row.on .lbl .ic { color: var(--rs-red); }
.rsc-tree-subs { padding: 2px 0 6px 28px; display: flex; flex-direction: column; }
.rsc-tree-subs.hidden { display: none; }
.rsc-tree-sub { display: flex; align-items: center; gap: 7px; padding: 7px 10px; border-radius: 8px; font-size: 12.5px; color: var(--rs-muted); border-left: 2px solid var(--rs-line); margin-left: 6px; transition: color .15s; }
.rsc-tree-sub .nm { flex: 1; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rsc-tree-sub .ct { font-size: 11px; color: var(--rs-faint); font-weight: 700; flex-shrink: 0; }
.rsc-tree-sub:hover { color: var(--rs-red); border-left-color: var(--rs-red); }

/* ── Main column ── */
.rsc-main { min-width: 0; }

/* Search box */
.rsc-search { display: flex; align-items: center; gap: 10px; background: var(--rs-card); border: 1.5px solid var(--rs-line); border-radius: var(--rs-radius); padding: 11px 16px; margin-bottom: 22px; box-shadow: var(--rs-shadow); transition: border-color .2s; }
.rsc-search:focus-within { border-color: var(--rs-red); }
.rsc-search svg { color: var(--rs-faint); flex-shrink: 0; }
.rsc-search input { flex: 1; border: none; outline: none; font-family: inherit; font-size: 14px; color: var(--rs-ink); background: transparent; }
.rsc-search input::placeholder { color: var(--rs-faint); }
.rsc-search .clr { width: 26px; height: 26px; border-radius: 50%; background: var(--rs-bg); display: grid; place-items: center; color: var(--rs-muted); border: none; cursor: pointer; }
.rsc-search .clr:hover { background: var(--rs-red); color: #fff; }

/* Empty state */
.rsc-empty { padding: 54px; text-align: center; color: var(--rs-muted); background: var(--rs-card); border: 1px dashed var(--rs-line); border-radius: var(--rs-radius); }
.rsc-empty svg { opacity: .4; margin-bottom: 10px; }
.rsc-empty p { font-size: 15px; font-weight: 600; margin: 0; }

/* Section heading */
.rsc-sec-head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; margin-top: 6px; }
.rsc-sec-head h2 { font-size: 16px; font-weight: 800; margin: 0; color: var(--rs-ink); }
.rsc-sec-head .badge { background: var(--rs-red); color: #fff; font-size: 11px; font-weight: 800; padding: 2px 9px; border-radius: 999px; }

/* ── Group card (categories WITH subcategories) ── */
.rs-grp { display: flex; align-items: center; gap: 14px; padding: 16px; background: var(--rs-card); border: 1px solid var(--rs-line); border-radius: var(--rs-radius); cursor: pointer; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
.rs-grp:hover { transform: translateY(-2px); box-shadow: var(--rs-shadow-hover); border-color: #fff; }
.rs-grp .ic { width: 64px; height: 64px; border-radius: 12px; display: grid; place-items: center; flex-shrink: 0; overflow: hidden; }
.rs-grp .ic img { width: 100%; height: 100%; object-fit: cover; border-radius: 12px; transition: transform .2s ease; }
.rs-grp:hover .ic img { transform: scale(1.06); }
.rs-grp .body { flex: 1; min-width: 0; }
.rs-grp .body h3 { font-size: 14.5px; font-weight: 700; margin: 0 0 2px; color: var(--rs-ink); overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rs-grp .body .en { font-size: 11px; color: var(--rs-faint); font-weight: 600; display: block; margin-bottom: 5px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rs-grp .body .meta { font-size: 12px; color: var(--rs-muted); }
.rs-grp .body .meta b { color: var(--rs-red); }
.rs-grp .arrow { color: var(--rs-faint); flex-shrink: 0; transition: transform .18s; }
.rs-grp:hover .arrow { transform: translateX(3px); color: var(--rs-red); }
.rs-grp-wrap.open .rs-grp { border-radius: var(--rs-radius) var(--rs-radius) 0 0; border-bottom-color: transparent; transform: none; box-shadow: none; }
.rs-grp-wrap.open .rs-grp .arrow svg { transform: rotate(90deg); color: var(--rs-red); }
.rs-grp-subs { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; padding: 10px 12px 12px; background: var(--rs-bg); border: 1px solid var(--rs-line); border-top: none; border-radius: 0 0 var(--rs-radius) var(--rs-radius); }
.rs-grp-subs[hidden] { display: none !important; }
.rs-sub-chip { display: flex; align-items: center; gap: 6px; padding: 8px 10px; background: var(--rs-card); border: 1.5px solid var(--rs-line); border-radius: 8px; font-size: 12px; font-weight: 600; color: var(--rs-ink); transition: border-color .15s, color .15s; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rs-sub-chip:hover { border-color: var(--rs-red); color: var(--rs-red); }
.rs-sub-all {
    grid-column: 1 / -1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 38px;
    padding: 10px 14px;
    background: var(--rs-red);
    border: 1px solid var(--rs-red);
    border-radius: 9px;
    box-shadow: 0 8px 18px rgba(216, 37, 29, .22);
    font-size: 13px;
    font-weight: 800;
    color: #fff;
    transition: background .15s, border-color .15s, box-shadow .15s, transform .15s;
}
.rs-sub-all,
.rs-sub-all:visited,
.rs-sub-all:focus,
.rs-sub-all:active {
    color: #fff !important;
}
.rs-sub-all:hover {
    background: var(--rs-red-dark);
    border-color: var(--rs-red-dark);
    color: #fff;
    box-shadow: 0 10px 22px rgba(185, 28, 28, .28);
    transform: translateY(-1px);
}
.rs-sub-all svg {
    flex-shrink: 0;
    color: #fff;
    stroke: currentColor;
    transition: transform .15s;
}
.rs-sub-all:hover svg {
    transform: translateX(2px);
}
.rsc-grp-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--rs-gap); margin-bottom: 28px; }

/* ── Category tile (leaf or sub) ── */
.rs-cat { display: flex; flex-direction: column; background: var(--rs-card); border: 1px solid var(--rs-line); border-radius: var(--rs-radius); overflow: hidden; transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease; }
.rs-cat:hover { transform: translateY(-3px); box-shadow: var(--rs-shadow-hover); border-color: #fff; }
.rs-cat-media { padding: 14px 14px 0; display: flex; align-items: center; justify-content: center; }
.rs-tile { width: 100%; aspect-ratio: 1/1; border-radius: var(--rs-radius-sm); display: grid; place-items: center; position: relative; overflow: hidden; }
.rs-tile.has-image {
    background: #fff !important;
}
.rs-tile img { width: 100%; height: 100%; object-fit: contain; border-radius: var(--rs-radius-sm); transition: transform .22s ease; }
.rs-cat:hover .rs-tile img { transform: scale(1.06); }
.rs-tile-glow { position: absolute; width: 70%; height: 70%; border-radius: 50%; filter: blur(28px); left: 15%; top: 12%; }
.rs-cat-body { padding: 0 14px 14px; display: flex; flex-direction: column; flex: 1; }
.rs-cat-name { font-size: 13.5px; font-weight: 700; line-height: 1.35; margin: 0 0 3px; color: var(--rs-ink); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2.7em; }
.rs-cat-en { font-size: 11px; color: var(--rs-faint); font-weight: 600; display: block; margin-bottom: 10px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.rs-cat-foot { margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.rs-cat-count { font-size: 12px; color: var(--rs-muted); font-weight: 600; }
.rs-cat-go { display: inline-flex; align-items: center; gap: 3px; font-size: 12px; font-weight: 700; color: var(--rs-red); }
.rs-cat-sub { display: inline-flex; align-items: center; gap: 4px; font-size: 11px; font-weight: 700; color: var(--rs-faint); background: var(--rs-bg); padding: 3px 8px; border-radius: 999px; }
.rsc-cat-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--rs-gap); }

/* ── Mobile chip rail ── */
.rsc-chiprail-wrap { display: none; overflow-x: auto; padding: 14px 16px 10px; gap: 8px; scrollbar-width: none; -webkit-overflow-scrolling: touch; }
.rsc-chiprail-wrap::-webkit-scrollbar { display: none; }
.rsc-chip { display: inline-flex; align-items: center; gap: 7px; padding: 8px 15px; border-radius: 999px; border: 1.5px solid var(--rs-line); background: var(--rs-card); font-size: 13px; font-weight: 600; color: var(--rs-ink); white-space: nowrap; cursor: pointer; transition: all .15s; flex-shrink: 0; }
.rsc-chip .ic { color: var(--rs-faint); display: grid; place-items: center; }
.rsc-chip:hover { border-color: var(--rs-red); color: var(--rs-red); }
.rsc-chip.on { background: var(--rs-red-soft); border-color: var(--rs-red); color: var(--rs-red); }
.rsc-chip.on .ic { color: var(--rs-red); }

/* ── Category sections (mobile grouped view) ── */
.rsc-cat-section { padding-bottom: 24px; }
.rsc-cat-section[data-key].rsc-hidden { display: none; }
.rsc-msec-head { display: flex; align-items: center; gap: 10px; padding: 12px 16px; }
.rsc-msec-head .ic { width: 34px; height: 34px; border-radius: 9px; display: grid; place-items: center; flex-shrink: 0; }
.rsc-msec-head .tx h2 { font-size: 15px; font-weight: 800; margin: 0; }
.rsc-msec-head .tx span { font-size: 12px; color: var(--rs-muted); }
.rsc-msec-head .all { margin-left: auto; font-size: 12.5px; font-weight: 700; color: var(--rs-red); display: inline-flex; align-items: center; gap: 3px; }

/* ── Responsive ── */
@media (max-width: 1023px) {
    .rsc-layout { grid-template-columns: 1fr; }
    .rsc-side { display: none; }
    .rsc-chiprail-wrap { display: flex; }
    .rsc-cat-grid { grid-template-columns: repeat(3, 1fr); }
    .rsc-stats { display: none; }
    #rsc-grp-head { display: none; }
    #rsc-grp-grid { display: none; }
}
@media (max-width: 767px) {
    .rsc-wrap { padding: 0 12px 48px; }
    .rsc-hero h1 { font-size: 22px; }
    .rsc-cat-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
    .rs-cat-media { padding: 12px; }
    .rs-cat-name { font-size: 12.5px; }
    .rs-grp { padding: 12px; }
    .rs-grp .ic { width: 42px; height: 42px; }
}
@media (max-width: 400px) {
    .rsc-cat-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
}
</style>

<div class="rsc-root">

{{-- Mobile chip rail (hidden on desktop via CSS) --}}
<div class="rsc-chiprail-wrap" id="rsc-chiprail">
    <button class="rsc-chip on" data-filter="all">
        <span class="ic">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/>
                <rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/>
            </svg>
        </span>ทั้งหมด
    </button>
    @foreach ($visibleCategories as $category)
        @php $chipIcon = $catIcon($category->name); [$chipBg, $chipFg] = $tints[$chipIcon] ?? $tints['gear']; @endphp
        <button class="rsc-chip" data-filter="cat-{{ $category->id }}">
            <span class="ic"@if($category->image) style="background:{{ $chipBg }}; padding:2px; border-radius:4px"@endif>
                @if ($category->image)
                    <img src="{{ RvMedia::url($category->image) }}" alt="" loading="lazy" width="18" height="18">
                @else
                    {!! $svgIcon($chipIcon, 15, 2, $chipFg) !!}
                @endif
            </span>
            {{ Str::limit($category->name, 22) }}
        </button>
    @endforeach
</div>

<div class="rsc-wrap">

    {{-- Breadcrumb --}}
    <nav class="rsc-crumb" aria-label="breadcrumb">
        <a href="{{ url('/') }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 11l8-7 8 7"/><path d="M6 10v9h12v-9"/></svg>
        </a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
        <a href="{{ route('public.products') }}">สินค้า</a>
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
        <span class="cur">หมวดหมู่สินค้า</span>
    </nav>

    {{-- Hero --}}
    <div class="rsc-hero">
        <div>
            <h1>หมวดหมู่สินค้า</h1>
            <p>เลือกซื้อตามประเภท · <b>{{ $totalCats }}</b> หมวดหมู่ · <b>{{ number_format($totalProducts) }}</b> สินค้า</p>
        </div>
        <div class="rsc-stats">
            <div class="rsc-stat"><strong>{{ $totalCats }}</strong><span>หมวดหมู่</span></div>
            <div class="rsc-stat"><strong>{{ number_format($totalProducts) }}</strong><span>สินค้าทั้งหมด</span></div>
        </div>
    </div>

    {{-- 2-col layout --}}
    <div class="rsc-layout">

        {{-- Sidebar --}}
        <aside class="rsc-side">
            <div class="rsc-side-head">
                <b>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
                    หมวดหมู่ทั้งหมด
                </b>
            </div>
            <div class="rsc-tree">
                <button class="rsc-tree-all on" data-filter="all">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
                    สินค้าทั้งหมด
                    <span class="ct">{{ $totalCats }}</span>
                </button>

                @foreach ($visibleCategories as $category)
                    @php
                        $icon = $catIcon($category->name);
                        [$bg, $fg] = $tints[$icon] ?? $tints['gear'];
                        $hasSubs = $category->subcategories && $category->subcategories->isNotEmpty();
                    @endphp
                    <div class="rsc-tree-grp">
                        <div class="rsc-tree-row" data-filter="cat-{{ $category->id }}">
                            <span class="lbl">
                                <span class="ic"@if($category->image) style="background:{{ $bg }}; padding:3px"@endif>
                                    @if ($category->image)
                                        <img src="{{ RvMedia::url($category->image) }}" alt="" loading="lazy" width="28" height="28">
                                    @else
                                        {!! $svgIcon($icon, 16, 1.8, $fg) !!}
                                    @endif
                                </span>
                                <span class="nm">{{ $category->name }}</span>
                            </span>
                            <span class="ct">{{ $category->products_count }}</span>
                            @if ($hasSubs)
                                <button class="exp" data-toggle="subs-{{ $category->id }}" aria-label="expand" aria-expanded="false">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                </button>
                            @endif
                        </div>
                        @if ($hasSubs)
                            <div class="rsc-tree-subs hidden" id="subs-{{ $category->id }}">
                                @foreach ($category->subcategories as $sub)
                                    @if ($sub && $sub->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $sub->url)
                                        <a class="rsc-tree-sub" href="{{ $sub->url }}">
                                            <span class="nm">{{ $sub->name }}</span>
                                            <span class="ct">{{ $sub->products_count }}</span>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </aside>

        {{-- Main content --}}
        <main class="rsc-main">

            {{-- Search --}}
            <div class="rsc-search">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <input type="text" id="rsc-q" placeholder="ค้นหาหมวดหมู่…" autocomplete="off" />
                <button class="clr" id="rsc-q-clr" style="display:none" aria-label="clear">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 6l12 12M18 6 6 18"/></svg>
                </button>
            </div>

            {{-- Groups (categories with subcategories) --}}
            @php $groups = $visibleCategories->filter(fn($c) => $c->subcategories && $c->subcategories->isNotEmpty()); @endphp
            @if ($groups->isNotEmpty())
                <div class="rsc-sec-head" id="rsc-grp-head">
                    <h2>หมวดหมู่หลัก</h2>
                    <span class="badge">{{ $groups->count() }}</span>
                </div>
                <div class="rsc-grp-grid" id="rsc-grp-grid">
                    @foreach ($groups as $category)
                        @php
                            $icon = $catIcon($category->name);
                            [$bg, $fg] = $tints[$icon] ?? $tints['gear'];
                            $subCount = $category->subcategories->count();
                        @endphp
                        <div class="rs-grp-wrap rsc-item" data-cat="cat-{{ $category->id }}" data-name="{{ strtolower($category->name) }}">
                            <div class="rs-grp" role="button" tabindex="0" aria-expanded="false">
                                <span class="ic" style="background:{{ $bg }}">
                                    @if ($category->image)
                                        <img src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy" width="64" height="64">
                                    @else
                                        {!! $svgIcon($icon, 28, 1.6, $fg) !!}
                                    @endif
                                </span>
                                <div class="body">
                                    <h3>{{ $category->name }}</h3>
                                    <span class="en">{{ $enName($category->name) }}</span>
                                    <div class="meta">
                                        <b>{{ $subCount }}</b> หมวดย่อย · {{ $category->products_count }} สินค้า
                                    </div>
                                </div>
                                <span class="arrow">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                </span>
                            </div>
                            <div class="rs-grp-subs" hidden>
                                @foreach ($category->subcategories as $sub)
                                    <a href="{{ $sub->url }}" class="rs-sub-chip">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                        {{ $sub->name }}
                                    </a>
                                @endforeach
                                <a href="{{ $category->url }}" class="rs-sub-all">
                                    ดูทั้งหมด {{ $category->products_count }} สินค้า
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- All categories tile grid --}}
            @php $allCats = $allVisibleCategories; @endphp
            <div class="rsc-sec-head" style="margin-top: {{ $groups->isNotEmpty() ? '8px' : '0' }}">
                <h2>สินค้าทุกหมวดหมู่</h2>
                <span class="badge">{{ $allCats->count() }}</span>
            </div>
            <div class="rsc-cat-grid" id="rsc-cat-grid">
                @foreach ($allCats as $category)
                    @php
                        $icon = $catIcon($category->name);
                        [$bg, $fg] = $tints[$icon] ?? $tints['gear'];
                        $hasSubs = $category->subcategories && $category->subcategories->isNotEmpty();
                    @endphp
                    <a class="rs-cat rsc-item" href="{{ $category->url }}" data-cat="cat-{{ $category->id }}" data-name="{{ strtolower($category->name) }}">
                        <div class="rs-cat-media">
                            <div class="rs-tile {{ ($category->image || $category->icon_image) ? 'has-image' : 'has-icon' }}" style="background: {{ ($category->image || $category->icon_image) ? '#fff' : 'radial-gradient(120% 120% at 30% 20%, #fff 0%, ' . $bg . ' 70%)' }}">
                                @if ($category->image)
                                    <img src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy" width="200" height="200">
                                @elseif ($category->icon_image)
                                    <img src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy" width="200" height="200">
                                @else
                                    <div class="rs-tile-glow" style="background:{{ $fg }}; opacity:.07"></div>
                                    {!! $svgIcon($icon, 52, 1.4, $fg) !!}
                                @endif
                            </div>
                        </div>
                        <div class="rs-cat-body">
                            <h3 class="rs-cat-name">{{ $category->name }}</h3>
                            <span class="rs-cat-en">{{ $enName($category->name) }}</span>
                            <div class="rs-cat-foot">
                                <span class="rs-cat-count">{{ $category->products_count }} สินค้า</span>
                                @if ($hasSubs)
                                    <span class="rs-cat-sub">
                                        <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7" rx="1.2"/><rect x="14" y="3" width="7" height="7" rx="1.2"/><rect x="3" y="14" width="7" height="7" rx="1.2"/><rect x="14" y="14" width="7" height="7" rx="1.2"/></svg>
                                        หมวดย่อย
                                    </span>
                                @else
                                    <span class="rs-cat-go">
                                        ดูสินค้า
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            {{-- Empty state (shown by JS when search has no results) --}}
            <div class="rsc-empty" id="rsc-empty" style="display:none">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
                <p>ไม่พบหมวดหมู่ที่ตรงกับการค้นหา</p>
            </div>

        </main>
    </div>
</div>{{-- /.rsc-wrap --}}
</div>{{-- /.rsc-root --}}

<script>
(function () {
    const q = document.getElementById('rsc-q');
    const clrBtn = document.getElementById('rsc-q-clr');
    const grpGrid = document.getElementById('rsc-grp-grid');
    const catGrid = document.getElementById('rsc-cat-grid');
    const emptyEl = document.getElementById('rsc-empty');
    const items = document.querySelectorAll('.rsc-item');

    // ── Search filter ──
    function applySearch(val) {
        const s = val.trim().toLowerCase();
        clrBtn.style.display = s ? '' : 'none';
        let visible = 0;
        items.forEach(el => {
            const name = el.getAttribute('data-name') || '';
            const show = !s || name.includes(s);
            el.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        emptyEl.style.display = visible === 0 ? '' : 'none';
    }

    if (q) {
        q.addEventListener('input', () => applySearch(q.value));
        clrBtn && clrBtn.addEventListener('click', () => { q.value = ''; applySearch(''); q.focus(); });
    }

    // ── Sidebar tree filter ──
    const sidebarRows  = document.querySelectorAll('.rsc-tree-row, .rsc-tree-all');
    const chipBtns     = document.querySelectorAll('.rsc-chip');

    function setFilter(filterKey) {
        // update sidebar active state
        sidebarRows.forEach(r => {
            const k = r.getAttribute('data-filter');
            r.classList.toggle('on', k === filterKey);
        });
        // update chip active state
        chipBtns.forEach(b => b.classList.toggle('on', b.getAttribute('data-filter') === filterKey));

        // show/hide items
        items.forEach(el => {
            const cat = el.getAttribute('data-cat');
            el.style.display = (filterKey === 'all' || cat === filterKey) ? '' : 'none';
        });

        // show/hide grp grid header if no groups visible
        if (grpGrid) {
            const anyGrp = [...grpGrid.querySelectorAll('.rsc-item')].some(e => e.style.display !== 'none');
            grpGrid.closest('.rsc-grp-grid') && (grpGrid.style.display = anyGrp ? '' : 'none');
        }

        emptyEl.style.display = 'none';
    }

    sidebarRows.forEach(r => {
        r.addEventListener('click', function(e) {
            if (e.target.closest('.exp')) return; // let expand btn handle itself
            setFilter(this.getAttribute('data-filter'));
        });
    });

    chipBtns.forEach(b => {
        b.addEventListener('click', function() {
            setFilter(this.getAttribute('data-filter'));
            // scroll into view for mobile
            this.scrollIntoView({ inline: 'center', behavior: 'smooth', block: 'nearest' });
        });
    });

    // ── Group card expand/collapse ──
    document.querySelectorAll('.rs-grp').forEach(function(card) {
        card.addEventListener('click', function() {
            var wrap = this.closest('.rs-grp-wrap');
            var subs = wrap && wrap.querySelector('.rs-grp-subs');
            if (!subs) return;
            var expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            subs.hidden = expanded;
            wrap.classList.toggle('open', !expanded);
        });
        card.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); this.click(); }
        });
    });

    // ── Sidebar expand toggles ──
    document.querySelectorAll('.exp').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const targetId = this.getAttribute('data-toggle');
            const target = document.getElementById(targetId);
            if (!target) return;
            const expanded = this.getAttribute('aria-expanded') === 'true';
            this.setAttribute('aria-expanded', String(!expanded));
            target.classList.toggle('hidden', expanded);
            // rotate arrow
            const svg = this.querySelector('svg');
            if (svg) svg.style.transform = expanded ? '' : 'rotate(90deg)';
        });
    });
})();
</script>
