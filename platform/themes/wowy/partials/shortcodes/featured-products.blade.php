
<!-- featture product -->

<section class="bg-white">
    <div class="container mx-auto px-4 py-8">
        @if ($title)
            <h1 class="text-2xl font-bold mb-6">{!! BaseHelper::clean($title) !!}</h1>
        @endif
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div></div>
            <div class="flex gap-2 lg:hidden">
                <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-featuredv1-prev>
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-featuredv1-next>
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>

        <div class="mt-6 flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hidden lg:grid lg:grid-cols-4 lg:gap-6 lg:overflow-visible lg:snap-none" data-featuredv1-track>
            @foreach ($products as $product)
                <a href="{{ $product->url }}" class="group flex-none w-[80vw] sm:w-64 lg:w-auto snap-center">
                    <div class="bg-gray-100 border border-gray-200 rounded-lg p-4 h-full transition-all duration-300 ease-in-out group-hover:shadow-[rgba(0,0,0,0.1)_0px_4px_6px,rgba(0,0,0,0.1)_0px_1px_3px] group-hover:-translate-y-1">
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4 flex items-center justify-center">
                            <img src="{{ RvMedia::getImageUrl($product->image, 'medium') }}" alt="{{ $product->name }}" class="w-full h-full object-contain imgMixBlendMode"/>
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

@once
    <style>
        .scrollbar-hidden::-webkit-scrollbar {
            display: none;
        }
        .scrollbar-hidden {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Line clamp for product names */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        /* Ensure consistent card heights */
        .featured-product-card {
            min-height: 280px;
            display: flex;
            flex-direction: column;
        }
        
        /* Image container for consistent aspect ratio */
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
    </style>
    <script>
        (function () {
            const track = document.querySelector('[data-featuredv1-track]');
            const prevBtn = document.querySelector('[data-featuredv1-prev]');
            const nextBtn = document.querySelector('[data-featuredv1-next]');

            if (!track || !prevBtn || !nextBtn) {
                return;
            }

            const isDesktop = () => window.innerWidth >= 1024;
            const scrollAmount = () => {
                const card = track.querySelector('a');
                return (card ? card.offsetWidth : track.clientWidth) + 24;
            };

            const scrollSlider = (direction) => {
                if (isDesktop()) {
                    return;
                }

                track.scrollBy({
                    left: direction * scrollAmount(),
                    behavior: 'smooth',
                });
            };

            prevBtn.addEventListener('click', () => scrollSlider(-1));
            nextBtn.addEventListener('click', () => scrollSlider(1));
        })();
    </script>
@endonce
