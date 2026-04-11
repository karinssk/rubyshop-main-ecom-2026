@php
    $level = $level ?? 1;
@endphp

@if ($categories->isNotEmpty())
    <div class="{{ $level > 1 ? 'ml-4 border-l border-gray-200 pl-4 mt-3' : '' }}">
        <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 text-center">
            @foreach ($categories as $category)
                @php
                    $slug = $category->slug ?? strtolower(str_replace(' ', '-', $category->name));
                @endphp
                <article class="p-2 bg-white text-xs">
                    <a href="{{ url('product-categories/' . $slug) }}" class="block">
                        @if ($category->image)
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                        @elseif ($category->icon_image)
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                        @else
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ Theme::asset()->url('images/category-placeholder.jpg') }}" alt="{{ $category->name }}" loading="lazy">
                        @endif
                        <p class="text-[11px] font-semibold text-gray-800 mt-2 leading-normal">
                            {{ $category->name }}
                        </p>
                    </a>
                </article>
            @endforeach
        </div>

        @foreach ($categories as $category)
            @if ($category->subcategories && $category->subcategories->count() > 0)
                <div class="mt-4">
                    <h4 class="mb-2 text-sm font-semibold text-gray-700">{{ $category->name }}</h4>
                    @include(Theme::getThemeNamespace() . '::views.custom.partials.subcategory-tree', [
                        'categories' => $category->subcategories,
                        'level' => $level + 1,
                    ])
                </div>
            @endif
        @endforeach
    </div>
@endif
