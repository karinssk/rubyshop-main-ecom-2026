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
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ url('product-categories/' . $category->slug) }}" class="block font-semibold text-gray-800 hover:text-red-500">
                                {{ $category->name }} [{{ $category->products_count ?? rand(2, 50) }}]
                            </a>

                            @if ($category->subcategories && $category->subcategories->count() > 0)
                                <ul class="mt-1 ml-3 space-y-1 text-gray-600 text-xs">
                                    @foreach ($category->subcategories as $subcategory)
                                        @php
                                            $slug = $subcategory->slug ?? strtolower(str_replace(' ', '-', $subcategory->name));
                                        @endphp
                                        <li>
                                            <a href="{{ url('product-categories/' . $slug) }}" class="hover:text-red-500">
                                                {{ $subcategory->name }} [{{ $subcategory->products_count ?? rand(1, 15) }}]
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="w-full md:w-3/4">
            <header class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-normal mb-2">{{ __('สินค้าทั้งหมด') }}</h1>
                <h2 class="text-lg sm:text-xl font-normal">{{ __('หมวดหมู่') }}</h2>
            </header>

            <div class="grid gap-4 grid-cols-2 sm:grid-cols-3 xl:grid-cols-5 text-center">
                @foreach ($categories as $category)
                    <article class="p-2 bg-white text-xs">
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
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('category-toggle');
            const sidebar = document.getElementById('category-sidebar');
            const arrowIcon = toggleButton?.querySelector('svg');

            if (toggleButton && sidebar) {
                toggleButton.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    arrowIcon?.classList.toggle('rotate-180');
                });
            }
        });
    </script>
@endpush

@push('styles')
    <style>
        .breadcrumb-item + .breadcrumb-item:before {
            content: '/';
            margin: 0 0.5rem;
            color: #9ca3af;
        }
    </style>
@endpush
