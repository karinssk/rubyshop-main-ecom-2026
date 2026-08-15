
<!-- featture product -->
@php
    $preferWebpVariant = function (string $url): string {
        $path = parse_url($url, PHP_URL_PATH);

        if (! $path) {
            return $url;
        }

        $webpPath = preg_replace('/\.(png|jpe?g)$/i', '.webp', $path);

        if ($webpPath && $webpPath !== $path && file_exists(public_path(ltrim($webpPath, '/')))) {
            return url($webpPath);
        }

        return $url;
    };
@endphp

<section class="bg-white" data-featuredv1-section>
    <div class="container mx-auto px-4 py-8">
        @if ($title)
            <h2 class="hidden lg:block text-2xl font-bold mb-6">{!! BaseHelper::clean($title) !!}</h2>
        @endif
        <div class="flex items-center justify-between flex-wrap gap-4 pt-4">
            <div>
                @if ($title)
                    <h2 class="text-2xl font-bold lg:hidden mb-0">{!! BaseHelper::clean($title) !!}</h2>
                @endif
            </div>
            <div class="flex gap-2 lg:hidden">
                <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-featuredv1-prev aria-label="{{ __('Previous products') }}">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-featuredv1-next aria-label="{{ __('Next products') }}">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="mt-6 flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hidden lg:grid lg:grid-cols-4 lg:gap-6 lg:overflow-visible lg:snap-none" data-featuredv1-track>
            @foreach ($products as $product)
                <a href="{{ $product->url }}" class="group flex-none w-[80vw] sm:w-64 lg:w-auto snap-center">
                    <div class="bg-gray-100 border border-gray-200 rounded-lg p-4 h-full transition-all duration-300 ease-in-out group-hover:shadow-[rgba(0,0,0,0.1)_0px_4px_6px,rgba(0,0,0,0.1)_0px_1px_3px] group-hover:-translate-y-1">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ $preferWebpVariant(RvMedia::getImageUrl($product->image, 'product-thumb')) }}" alt="" width="400" height="400" loading="lazy" decoding="async" class="w-full h-full object-contain imgMixBlendMode"/>
                        </div>
                        <div class="flex-1">
                            <p class="text-base text-gray-800 font-medium line-clamp-2 leading-relaxed">{{ $product->name }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
