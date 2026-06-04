@php
    $level = $level ?? 1;
@endphp

@foreach ($categories->filter(fn ($category) => $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url) as $category)
    @php
        $visibleSubcategories = $category->subcategories
            ? $category->subcategories->filter(fn ($subcategory) => $subcategory && $subcategory->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $subcategory->url)
            : collect();
        $hasSubcategories = $visibleSubcategories->isNotEmpty();
        $categoryUrl = $category->url;
        $treeId = 'sidebar-subtree-' . $category->id;
    @endphp
    <li class="{{ $level > 1 ? 'ml-4 mt-2' : '' }}">
        <div class="flex items-start gap-2">
            @if ($level === 1 && $hasSubcategories)
                <a
                    href="{{ url($categoryUrl) }}"
                    class="category-toggle-link block grow text-left font-semibold text-gray-800 hover:text-red-500 py-0.5 px-0"
                    data-target="category-panel-{{ $category->id }}"
                    aria-expanded="false"
                >
                    {{ $category->name }} [{{ $category->products_count ?? 0 }}]
                </a>
            @else
                <a
                    href="{{ url($categoryUrl) }}"
                    class="block grow {{ $level === 1 ? 'font-semibold text-gray-800 hover:text-red-500' : 'font-medium text-gray-700 hover:text-red-500' }}"
                >
                    {{ $category->name }} [{{ $category->products_count ?? 0 }}]
                </a>
            @endif

            @if ($hasSubcategories)
                <button
                    type="button"
                    class="sidebar-expand-toggle mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded border-0 bg-transparent text-xs text-gray-600 hover:text-red-500 focus-visible:outline-none focus-visible:ring-0"
                    data-target="{{ $treeId }}"
                    aria-expanded="false"
                    aria-label="{{ __('Expand subcategories') }}"
                >
                    <span data-expand-icon>+</span>
                </button>
            @endif
        </div>

        @if ($hasSubcategories)
            <ul id="{{ $treeId }}" class="sidebar-children hidden border-l border-gray-200 pl-3">
                @include(Theme::getThemeNamespace() . '::views.custom.partials.sidebar-category-tree', [
                    'categories' => $visibleSubcategories,
                    'level' => $level + 1,
                ])
            </ul>
        @endif
    </li>
@endforeach
