@php
    $categoriesRequest ??= [];
    $activeCategoryId ??= 0;

    if (!isset($groupedCategories)) {
        $groupedCategories = $categories->groupBy('parent_id');
    }

    $currentCategories = $groupedCategories->get($parentId ?? 0);
@endphp

@if($currentCategories)
    @foreach ($currentCategories as $category)
        <li class="form-check ruby-filter-category-item">
            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" @checked(in_array($category->id, $categoriesRequest)) id="category-filter-{{ $category->id }}">
            <label class="form-check-label" for="category-filter-{{ $category->id }}">
                {{ $category->name }}
            </label>

            @if ($groupedCategories->has($category->id))
                <ul class="ruby-filter-subcategories">
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.categories'), [
                        'categories' => $categories,
                        'groupedCategories' => $groupedCategories,
                        'parentId' => $category->id,
                        'activeCategoryId' => $activeCategoryId,
                        'categoriesRequest' => $categoriesRequest,
                        'urlCurrent' => $urlCurrent ?? null,
                    ])
                </ul>
            @endif
        </li>
    @endforeach
@endif
