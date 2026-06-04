<style>
    .category-index {
        width: 100% !important;
        max-width: 1320px !important;
        margin-left: auto !important;
        margin-right: auto !important;
        padding: 32px clamp(12px, 3vw, 24px);
        overflow: hidden;
    }

    .category-index,
    .category-index * {
        box-sizing: border-box;
    }

    .category-index .breadcrumb-item + .breadcrumb-item:before {
        content: '/';
        margin: 0 0.5rem;
        color: #9ca3af;
    }

    .category-index .breadcrumb {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0;
        padding: 0;
        margin: 0;
        list-style: none;
        font-size: 0.875rem;
    }

    .category-index > .flex {
        display: flex;
        gap: 24px;
        min-width: 0;
        width: 100%;
    }

    .category-index .bg-white.rounded-2xl {
        border-radius: 14px;
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.05);
        border-color: #e5e7eb !important;
    }

    #category-toggle {
        display: flex;
        width: 100%;
        min-height: 44px;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #e5e7eb;
        cursor: pointer;
    }

    #category-sidebar {
        flex: 0 0 25%;
        min-width: 0;
    }

    .category-index > .flex > .w-full.md\:w-3\/4,
    .category-index > .flex > .w-full {
        min-width: 0;
    }

    #main-category-grid,
    .subcategory-panel .grid {
        display: grid !important;
        width: 100%;
        max-width: 100%;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
        text-align: center;
    }

    #main-category-grid,
    .subcategory-panel .grid {
        gap: 16px !important;
    }

    #main-category-grid article,
    .subcategory-panel article {
        width: 100%;
        min-width: 0;
        max-width: 100%;
        padding: 8px;
        background: #fff;
        min-height: 0;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    #main-category-grid a,
    #main-category-grid button,
    .category-subcategory-trigger,
    .subcategory-panel a {
        display: block;
        width: 100%;
        min-width: 0;
        max-width: 100%;
        color: inherit;
        text-decoration: none;
        border: 0;
        background: transparent;
        cursor: pointer;
    }

    #main-category-grid .category-card-link,
    .subcategory-panel .subcategory-card-link {
        border-radius: 10px;
    }

    #main-category-grid .category-card-link {
        min-height: 154px;
    }

    #main-category-grid .category-card-title,
    .subcategory-panel .category-card-title,
    .subcategory-panel .subcategory-category-title {
        margin: 8px 0 0;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    #main-category-grid .category-subcategory-trigger,
    #main-category-grid .category-subcategory-trigger:hover,
    #main-category-grid .category-subcategory-trigger:focus {
        width: auto;
        min-height: 32px;
        margin: 8px auto 0;
        padding: 6px 10px;
        border: 1px solid #dc2626 !important;
        border-radius: 8px;
        background: #fff !important;
        color: #dc2626;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.2;
        transition: border-color 0.15s ease, background 0.15s ease;
    }

    #main-category-grid .category-subcategory-trigger:hover {
        border-color: #dc2626 !important;
    }

    #main-category-grid img,
    .subcategory-panel img {
        display: block;
        width: 100%;
        height: 112px;
        max-width: 100%;
        margin: 0 auto;
        object-fit: contain;
        border-radius: 8px;
        transition: transform 0.2s ease;
    }

    #main-category-grid a:hover img,
    .subcategory-panel a:hover img {
        transform: scale(1.04);
    }

    #main-category-grid p,
    .subcategory-panel p {
        margin: 8px 0 0 !important;
        color: #1f2937;
        font-size: 12px;
        font-weight: 600;
        line-height: 1.35;
        overflow-wrap: anywhere;
        min-height: 34px;
        max-height: 34px;
        overflow: hidden;
        display: block;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .subcategory-tree-grid {
        display: grid;
        width: 100%;
        max-width: 100%;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
    }

    .subcategory-tree-grid p,
    .subcategory-tree-grid img {
        margin: 8px 0 0 !important;
    }

    .subcategory-back {
        min-height: 40px;
        border: 1px solid #d1d5db;
        background: #fff;
        cursor: pointer;
    }

    .sidebar-expand-toggle {
        flex: 0 0 24px;
        min-width: 24px;
        min-height: 24px;
        border: 0 !important;
        background: transparent !important;
        color: #475569 !important;
        box-shadow: none !important;
        border-radius: 9999px;
    }

    .sidebar-expand-toggle:focus-visible,
    .category-toggle-link:focus-visible,
    .category-subcategory-trigger:focus-visible {
        outline: 2px solid rgba(220, 38, 38, 0.28);
        outline-offset: 2px;
    }

    .category-index .category-toggle-link {
        border: 0 !important;
        background: transparent !important;
        box-shadow: none !important;
        appearance: none;
        -webkit-appearance: none;
        color: #1f2937;
        text-align: left;
    }

    .category-index .category-toggle-link:hover,
    .category-index .category-subcategory-trigger:hover {
        color: #b91c1c;
        text-decoration: none;
    }

    .category-index .category-toggle-link:focus,
    .category-index .sidebar-expand-toggle:focus {
        outline: 2px solid rgba(220, 38, 38, 0.25);
        outline-offset: 2px;
    }

    .category-index .hidden {
        display: none !important;
    }

    .subcategory-tree-grid article {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        background: #fff;
    }

    .sidebar-children {
        border-left: 0 !important;
    }

    .category-subcategory-trigger {
        border-color: #fecaca !important;
        background: #fff5f5 !important;
    }

    .category-subcategory-trigger:hover {
        border-color: #ef4444 !important;
        background: #fee2e2 !important;
    }

    @media (max-width: 1199px) {
        #main-category-grid,
        .subcategory-panel .grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }
    }

    @media (min-width: 768px) and (max-width: 1199px) {
        #main-category-grid,
        .subcategory-panel .grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
        }
    }

    @media (max-width: 767px) {
        .category-index {
            width: 100% !important;
            max-width: 100% !important;
            margin-left: auto !important;
            margin-right: auto !important;
            padding: 24px 12px 48px !important;
        }

        .category-index > .flex {
            display: block;
        }

        #category-sidebar {
            width: 100%;
            margin-bottom: 18px;
            padding-right: 0;
        }

        #category-sidebar:not(.hidden) {
            display: block !important;
        }

        #main-category-grid,
        .subcategory-panel .grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 12px;
        }

        .subcategory-tree-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
            gap: 12px;
        }

        #main-category-grid img,
        .subcategory-panel img {
            height: 92px;
        }

        #main-category-grid article,
        .subcategory-panel article {
            min-height: 152px;
            padding: 8px;
            border-radius: 12px;
            border: 1px solid #eef1f5;
        }

        #main-category-grid .category-card-link {
            min-height: 126px;
        }

        #main-category-grid p,
        .subcategory-panel p {
            min-height: 32px;
            max-height: 32px;
            font-size: 11px;
            line-height: 1.35;
        }
    }

    @media (min-width: 992px) {
        #category-sidebar {
            display: block !important;
        }
    }
</style>

<div class="category-index container mx-auto px-4 py-8">
    <nav class="breadcrumb-nav mb-4" aria-label="breadcrumb">
        <ol class="breadcrumb flex flex-wrap items-center text-sm">
            <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-gray-500 hover:text-red-500">{{ __('หน้าหลัก') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page"><span class="text-gray-700">{{ __('หมวดหมู่สินค้า') }}</span></li>
        </ol>
    </nav>

    <div class="md:hidden mb-4">
        <button id="category-toggle" class="w-full py-2 px-4 bg-gray-100 text-left flex justify-between items-center rounded-md">
            <span class="font-medium">{{ __('หมวดหมู่สินค้า') }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transform transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    @php
        $visibleCategories = $categories->filter(fn ($category) => $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url);
        $totalProductCount = $visibleCategories->sum('products_count');
        $totalProductCount = $totalProductCount > 0 ? $totalProductCount : 150;
    @endphp

    <div class="flex flex-col md:flex-row">
        <div id="category-sidebar" class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-6 hidden md:block">
            <div class="bg-white rounded-2xl p-5 border">
                <h3 class="text-lg font-medium mb-4">{{ __('สินค้าทั้งหมด') }} [{{ $totalProductCount }}]</h3>
                <ul class="space-y-3 text-sm">
                    @include(Theme::getThemeNamespace() . '::views.custom.partials.sidebar-category-tree', [
                        'categories' => $visibleCategories,
                        'level' => 1,
                    ])
                </ul>
            </div>
        </div>

        <div class="w-full md:w-3/4">
            <header class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-normal mb-2">{{ __('สินค้าทั้งหมด') }}</h1>
                <h2 class="text-lg sm:text-xl font-normal">{{ __('หมวดหมู่') }}</h2>
            </header>

            <div id="subcategory-panels" class="hidden"></div>

                <div id="main-category-grid" class="text-center">
                @foreach ($visibleCategories as $category)
                    @php
                        $visibleSubcategories = $category->subcategories
                            ? $category->subcategories->filter(fn ($subcategory) => $subcategory && $subcategory->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $subcategory->url)
                            : collect();
                        $hasSubcategories = $visibleSubcategories->isNotEmpty();
                        $categoryUrl = $category->url;
                    @endphp
                        <article class="p-2 bg-white text-xs">
                        @if ($hasSubcategories)
                            <a href="{{ url($categoryUrl) }}" class="category-card-link block w-full">
                                @if ($category->image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                @elseif ($category->icon_image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                                @else
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::getDefaultImage() }}" alt="{{ $category->name }}" loading="lazy">
                                @endif
                                <p class="category-card-title text-[11px] font-semibold text-gray-800 mt-2 leading-normal">{{ $category->name }}</p>
                            </a>
                            <button
                                type="button"
                                data-category-url="{{ url($categoryUrl) }}"
                                class="category-subcategory-trigger"
                                data-category-name="{{ e($category->name) }}"
                                data-target="category-panel-{{ $category->id }}"
                                aria-expanded="false"
                                aria-label="{{ __('Open') }} {{ $category->name }}"
                            >
                                {{ __('ดูหมวดหมู่ย่อย') }}
                            </button>
                        @else
                            <a href="{{ $categoryUrl }}" class="block">
                                @if ($category->image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                @elseif ($category->icon_image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                                @else
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::getDefaultImage() }}" alt="{{ $category->name }}" loading="lazy">
                                @endif
                                <p class="category-card-title text-[11px] font-semibold text-gray-800 mt-2 leading-normal">{{ $category->name }}</p>
                            </a>
                        @endif

                            <!-- @if ($category->subcategories && ($subs = $category->subcategories->take(3))->count() > 0)
                                <div class="mt-20 text-[10px] text-gray-500 flex flex.col gap-1">
                                    @foreach ($subs as $subcategory)
                                        @php
                                            $slug = $subcategory->slug ?? strtolower(str_replace(' ', '-', $subcategory->name));
                                        @endphp
                                        <a href="{{ url('product-categories/' . $slug) }}" class="hover:text-red-500 truncate">{{ $subcategory->name }}</a>
                                    @endforeach

                                    @if ($category->subcategories->count() > 3)
                                        <a href="{{ url('product-categories/' . $category->slug) }}" class="text-red-500 font-semibold">{{ __('ดูทั้งหมด') }}</a>
                                    @endif
                                </div>
                            @endif -->
                    </article>
                @endforeach
            </div>

            @foreach ($visibleCategories as $category)
                @php
                    $visibleSubcategories = $category->subcategories
                        ? $category->subcategories->filter(fn ($subcategory) => $subcategory && $subcategory->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $subcategory->url)
                        : collect();
                @endphp
                @if ($visibleSubcategories->isNotEmpty())
                    <div id="category-panel-{{ $category->id }}" class="subcategory-panel hidden">
                        <div class="mb-6 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-500">{{ __('เลือกหมวดหมู่ย่อย') }}</p>
                            </div>
                            <button type="button" class="subcategory-back rounded-md border px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                                {{ __('กลับไปหมวดหมู่หลัก') }}
                            </button>
                        </div>

                        @include(Theme::getThemeNamespace() . '::views.custom.partials.subcategory-tree', [
                            'categories' => $visibleSubcategories,
                            'level' => 1,
                        ])
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('category-toggle');
        const sidebar = document.getElementById('category-sidebar');
        const arrowIcon = toggleButton ? toggleButton.querySelector('svg') : null;
        const categoryToggles = document.querySelectorAll('.category-subcategory-trigger');
        const categoryLinks = document.querySelectorAll('.category-toggle-link');
        const mainCategoryGrid = document.getElementById('main-category-grid');
        const subcategoryPanels = document.querySelectorAll('.subcategory-panel');
        const subcategoryBackButtons = document.querySelectorAll('.subcategory-back');
        const sidebarExpandToggles = document.querySelectorAll('.sidebar-expand-toggle');

        if (toggleButton && sidebar) {
            toggleButton.addEventListener('click', function() {
                sidebar.classList.toggle('hidden');

                if (arrowIcon) {
                    arrowIcon.classList.toggle('rotate-180');
                }
            });
        }

        categoryLinks.forEach(function(link) {
            if (link.tagName.toLowerCase() !== 'a') {
                const targetUrl = link.getAttribute('data-category-url');
                if (targetUrl) {
                    link.addEventListener('click', function () {
                        window.location.href = targetUrl;
                    });
                }
            }
        });

        categoryToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(event) {
                event.preventDefault();

                const targetId = toggle.getAttribute('data-target');
                const target = targetId ? document.getElementById(targetId) : null;
                const targetUrl = toggle.getAttribute('data-category-url');
                const href = toggle.getAttribute('href');

                if (! target) {
                    const redirectUrl = targetUrl || href;
                    if (redirectUrl) {
                        window.location.href = redirectUrl;
                    }

                    return;
                }

                if (toggle.classList.contains('category-subcategory-trigger')) {
                    subcategoryPanels.forEach(function(panel) {
                        panel.classList.add('hidden');
                    });

                    categoryToggles.forEach(function(button) {
                        button.setAttribute('aria-expanded', 'false');
                    });

                    if (mainCategoryGrid) {
                        mainCategoryGrid.classList.add('hidden');
                    }

                    target.classList.remove('hidden');
                    toggle.setAttribute('aria-expanded', 'true');

                    return;
                }

                if (targetUrl) {
                    window.location.href = targetUrl;
                } else if (href) {
                    window.location.href = href;
                }
            });
        });

        subcategoryBackButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                subcategoryPanels.forEach(function(panel) {
                    panel.classList.add('hidden');
                });

                categoryToggles.forEach(function(toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                });

                if (mainCategoryGrid) {
                    mainCategoryGrid.classList.remove('hidden');
                }
            });
        });

        sidebarExpandToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function(event) {
                event.stopPropagation();

                const targetId = toggle.getAttribute('data-target');
                const target = targetId ? document.getElementById(targetId) : null;

                if (! target) {
                    return;
                }

                const isExpanded = toggle.getAttribute('aria-expanded') === 'true';
                toggle.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                target.classList.toggle('hidden');

                const icon = toggle.querySelector('[data-expand-icon]');
                if (icon) {
                    icon.textContent = isExpanded ? '+' : '-';
                }
            });
        });
    });
</script>
