@php
    $level = $level ?? 1;
@endphp

@foreach ($categories as $category)
    @php
        $hasSubcategories = $category->subcategories && $category->subcategories->count() > 0;
        $slug = $category->slug ?? strtolower(str_replace(' ', '-', $category->name));
        $treeId = 'sidebar-subtree-' . $category->id;
    @endphp
    <li class="{{ $level > 1 ? 'ml-4 mt-2' : '' }}">
        <div class="flex items-start gap-2">
            @if ($level === 1 && $hasSubcategories)
                <button
                    type="button"
                    class="category-toggle-link block grow text-left font-semibold text-gray-800 hover:text-red-500"
                    data-target="category-panel-{{ $category->id }}"
                    aria-expanded="false"
                >
                    {{ $category->name }} [{{ $category->products_count ?? 0 }}]
                </button>
            @else
                <a
                    href="{{ url('product-categories/' . $slug) }}"
                    class="block grow {{ $level === 1 ? 'font-semibold text-gray-800 hover:text-red-500' : 'font-medium text-gray-700 hover:text-red-500' }}"
                >
                    {{ $category->name }} [{{ $category->products_count ?? 0 }}]
                </a>
            @endif

            @if ($hasSubcategories)
                <button
                    type="button"
                    class="sidebar-expand-toggle mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded border border-gray-300 text-xs text-gray-600 hover:border-red-500 hover:text-red-500"
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
                    'categories' => $category->subcategories,
                    'level' => $level + 1,
                ])
            </ul>
        @endif
    </li>
@endforeach
