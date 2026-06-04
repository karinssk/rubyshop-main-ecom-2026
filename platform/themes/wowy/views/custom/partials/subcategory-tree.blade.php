@php
    $level = $level ?? 1;
@endphp

@if ($categories->isNotEmpty())
    <div class="{{ $level > 1 ? 'ml-4 border-l border-gray-200 pl-4 mt-3' : '' }}">
        <div class="subcategory-tree-grid text-center">
            @foreach ($categories->filter(fn ($category) => $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url) as $category)
                @php
                    $categoryUrl = $category->url;
                @endphp
                <article class="p-2 bg-white text-xs">
                    <a href="{{ url($categoryUrl) }}" class="block">
                        @if ($category->image)
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->image) }}" alt="{{ $category->name }}" loading="lazy">
                        @elseif ($category->icon_image)
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ RvMedia::url($category->icon_image) }}" alt="{{ $category->name }}" loading="lazy">
                        @else
                            <img class="w-full h-24 object-contain rounded-lg mx-auto" src="{{ RvMedia::getDefaultImage() }}" alt="{{ $category->name }}" loading="lazy">
                        @endif
                        <p class="text-[11px] font-semibold text-gray-800 mt-2 leading-normal">
                            {{ $category->name }}
                        </p>
                    </a>
                </article>
            @endforeach
        </div>

        @foreach ($categories->filter(fn ($category) => $category && $category->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $category->url) as $category)
            @php
                $visibleSubcategories = $category->subcategories
                    ? $category->subcategories->filter(fn ($subcategory) => $subcategory && $subcategory->status == \Botble\Base\Enums\BaseStatusEnum::PUBLISHED && $subcategory->url)
                    : collect();
            @endphp
            @if ($visibleSubcategories->isNotEmpty())
                <div class="mt-4">
                    <h4 class="mb-2 text-sm font-semibold text-gray-700">{{ $category->name }}</h4>
                    @include(Theme::getThemeNamespace() . '::views.custom.partials.subcategory-tree', [
                        'categories' => $visibleSubcategories,
                        'level' => $level + 1,
                    ])
                </div>
            @endif
        @endforeach
    </div>
@endif
