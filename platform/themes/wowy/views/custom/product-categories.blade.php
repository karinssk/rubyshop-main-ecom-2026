<div class="container mx-auto px-4 py-8">
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
        $totalProductCount = $categories->sum('products_count');
        $totalProductCount = $totalProductCount > 0 ? $totalProductCount : 150;
    @endphp

    <div class="flex flex-col md:flex-row">
        <div id="category-sidebar" class="w-full md:w-1/4 mb-6 md:mb-0 md:pr-6 hidden md:block">
            <div class="bg-white rounded-2xl p-5 border">
                <h3 class="text-lg font-medium mb-4">{{ __('สินค้าทั้งหมด') }} [{{ $totalProductCount }}]</h3>
                <ul class="space-y-3 text-sm">
                    @include(Theme::getThemeNamespace() . '::views.custom.partials.sidebar-category-tree', [
                        'categories' => $categories,
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

            <div id="main-category-grid" class="grid gap-4 grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 text-center">
                @foreach ($categories as $category)
                    @php
                        $hasSubcategories = $category->subcategories && $category->subcategories->count() > 0;
                    @endphp
                    <article class="p-2 bg-white text-xs">
                        @if ($hasSubcategories)
                            <button
                                type="button"
                                class="category-toggle-link block w-full"
                                data-category-name="{{ e($category->name) }}"
                                data-target="category-panel-{{ $category->id }}"
                                aria-expanded="false"
                            >
                                @if ($category->image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                @elseif ($category->icon_image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                                @else
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ Theme::asset()->url('images/category-placeholder.jpg') }}" alt="{{ $category->name }}" loading="lazy">
                                @endif
                                <p class="text-[11px] font-semibold text-gray-800 mt-2 leading-normal">{{ $category->name }}</p>
                            </button>
                        @else
                            <a href="{{ url('product-categories/' . $category->slug) }}" class="block">
                                @if ($category->image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                                @elseif ($category->icon_image)
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                                @else
                                    <img class="w-full h-28 object-contain rounded-lg mx-auto" src="{{ Theme::asset()->url('images/category-placeholder.jpg') }}" alt="{{ $category->name }}" loading="lazy">
                                @endif
                                <p class="text-[11px] font-semibold text-gray-800 mt-2 leading-normal">{{ $category->name }}</p>
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

            @foreach ($categories as $category)
                @if ($category->subcategories && $category->subcategories->count() > 0)
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
                            'categories' => $category->subcategories,
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
        const categoryToggles = document.querySelectorAll('.category-toggle-link');
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

        categoryToggles.forEach(function(toggle) {
            toggle.addEventListener('click', function() {
                const targetId = toggle.getAttribute('data-target');
                const target = targetId ? document.getElementById(targetId) : null;

                if (! target) {
                    return;
                }

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

@push('styles')
    <style>
        .breadcrumb-item + .breadcrumb-item:before {
            content: '/';
            margin: 0 0.5rem;
            color: #9ca3af;
        }
    </style>
@endpush
