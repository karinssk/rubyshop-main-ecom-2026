<section class="bg-white">
  <div class="container mx-auto px-4 py-8">
    <div class="flex items-center justify-between flex-wrap gap-4">
      <h2 class="text-3xl font-bold">{{ $title }}</h2>
      <div class="flex gap-2 md:hidden">
        <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-category-slider-prev>
          <i class="fas fa-chevron-left"></i>
        </button>
        <button type="button" class="p-2 rounded-full border border-gray-200 text-gray-600 focus:outline-none focus:ring hover:bg-gray-100" data-category-slider-next>
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>
    <div class="mt-8 flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hidden md:grid md:grid-cols-3 lg:grid-cols-4 md:overflow-visible md:snap-none" data-category-slider>
      @foreach($categories as $category)
        <div class="flex-none w-[85vw] sm:w-72 md:w-auto bg-gray-100 p-6 rounded-lg shadow-md text-center transition-shadow duration-300 ease-in-out group hover:shadow-[rgba(0,0,0,0.07)_0px_1px_1px,rgba(0,0,0,0.07)_0px_2px_2px,rgba(0,0,0,0.07)_0px_4px_4px,rgba(0,0,0,0.07)_0px_8px_8px,rgba(0,0,0,0.07)_0px_16px_16px] snap-center" data-category-card>
          <div class="relative">
            <a href="{{ $category->url }}">
              <img class="imgMixBlendMode w-full h-72 object-cover rounded-lg" src="{{ RvMedia::getImageUrl($category->image, 'product-thumb', false, RvMedia::getDefaultImage()) }}" alt="{{ $category->name }}" />
            </a>
            <span class="absolute top-2 left-2 bg-gray-800 text-white text-xs px-2 py-1 rounded">{{ $category->name }}</span>
          </div>
          <h3 class="text-xl font-bold mt-8">{{ strtoupper($category->name) }}</h3>
          <a class="text-md text-black font-bold mt-4 inline-block" href="{{ $category->url }}">
            EXPLORE ALL <i class="fas fa-chevron-right"></i>
          </a>
        </div>
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
  </style>
  <script>
    (function () {
      const slider = document.querySelector('[data-category-slider]');
      const prevBtn = document.querySelector('[data-category-slider-prev]');
      const nextBtn = document.querySelector('[data-category-slider-next]');

      if (!slider || !prevBtn || !nextBtn) {
        return;
      }

      const isDesktop = () => window.innerWidth >= 768;

      const scrollAmount = () => {
        const card = slider.querySelector('[data-category-card]');
        return (card ? card.offsetWidth : slider.clientWidth) + 24;
      };

      const scrollSlider = (direction) => {
        if (isDesktop()) {
          return;
        }

        slider.scrollBy({
          left: direction * scrollAmount(),
          behavior: 'smooth',
        });
      };

      prevBtn.addEventListener('click', () => scrollSlider(-1));
      nextBtn.addEventListener('click', () => scrollSlider(1));
    })();
  </script>
@endonce
