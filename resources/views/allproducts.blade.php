@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4 text-center text-3xl font-bold">สินค้าทั้งหมด</h1>

    @php
        // Pagination for categories
        $categoriesPerPage = 5;
        $currentPage = request()->query('page', 1);
        $paginatedCategories = $categories->forPage($currentPage, $categoriesPerPage);
        $totalPages = ceil($categories->count() / $categoriesPerPage);
    @endphp

    @foreach ($paginatedCategories as $key => $category)
        <div class="category-section mb-5" 
             data-category-id="{{ $category->id }}" 
             id="category-{{ $category->id }}">
            
            <!-- Category Header -->
            <div class="row align-items-center mb-4">
                <div class="col-md-12">
                    <h2 class="category-title">{{ $category->name }}</h2>
                    @if ($category->description)
                        <p>{{ $category->description }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Category Products Slider Container -->
            <div class="product-slider-container" data-loaded="{{ $key < 2 ? 'true' : 'false' }}">
                @if ($key < 2)
                    <!-- Eagerly load first two categories -->
                    @php
                        $allProducts = $category->products ?? $category->featuredProducts ?? collect();
                        $sortedProducts = $allProducts->sortBy(function($product) {
                            return $product->sale_price ?: $product->price;
                        });
                        $totalProducts = count($sortedProducts);
                        $itemsPerSlide = 4; // Number of items per slide
                        $totalSlides = max(1, ceil($totalProducts / $itemsPerSlide));
                    @endphp
                    
                    <div class="alert alert-info mb-3">
                        ทั้งหมด {{ $totalProducts }} รายการ
                    </div>
                    
                    <!-- Product Slider -->
                    <div class="position-relative">
                        <button class="slider-arrow slider-prev" data-slider="slider-{{ $category->id }}">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <div class="product-slider" id="slider-{{ $category->id }}" data-total-products="{{ $totalProducts }}">
                            <div class="slider-track">
                                @forelse ($sortedProducts as $product)
                                    <div class="slider-item">
                                    <a href="{{ route('product.detail', $product->id) }}">
                                        <div class="card h-100">
                                            @if ($product->images)
                                                @php
                                                    $images = json_decode($product->images, true);
                                                    $firstImage = $images[0] ?? null;
                                                @endphp
                                                @if ($firstImage)
                                                    <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy" style="height: 200px; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
                                                @endif
                                            @else
                                                <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $product->name }}</h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="price-box">
                                                        @if ($product->sale_price)
                                                            <span class="text-muted text-decoration-line-through">฿{{ number_format($product->price, 2) }}</span>
                                                            <span class="text-danger">฿{{ number_format($product->sale_price, 2) }}</span>
                                                        @else
                                                            <span>฿{{ number_format($product->price, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                            <div class="card-footer">
                                                <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-primary w-100 hover:bg-red-500 color-red-500">ดูรายละเอียด</a>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="slider-item">
                                        <div class="alert alert-info">
                                            No products found in this category.
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                        
                        <button class="slider-arrow slider-next" data-slider="slider-{{ $category->id }}">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <!-- Slider Navigation Dots -->
                    <div class="slider-dots text-center mt-3" id="dots-{{ $category->id }}">
                        @for ($i = 0; $i < $totalSlides; $i++)
                            <span class="dot @if($i === 0) active @endif" data-slider="slider-{{ $category->id }}" data-index="{{ $i }}"></span>
                        @endfor
                    </div>
                @else
                    <!-- Lazy load placeholder for other categories -->
                    <div class="lazy-slider-placeholder" data-category-id="{{ $category->id }}">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading products...</p>
                        </div>
                    </div>
                    
                    <!-- Hidden template with product data for lazy loading -->
                    <template id="slider-template-{{ $category->id }}">
                        @php
                            $allProducts = $category->products ?? $category->featuredProducts ?? collect();
                            $sortedProducts = $allProducts->sortBy(function($product) {
                                return $product->sale_price ?: $product->price;
                            });
                            $totalProducts = count($sortedProducts);
                            $itemsPerSlide = 4; // Number of items per slide
                            $totalSlides = max(1, ceil($totalProducts / $itemsPerSlide));
                        @endphp
                        
                        <div class="alert alert-info mb-3">
                            ทั้งหมด {{ $totalProducts }} รายการ
                        </div>
                        
                        <!-- Position relative for slider arrows -->
                        <div class="position-relative">
                            <button class="slider-arrow slider-prev" data-slider="slider-{{ $category->id }}">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <div class="product-slider" id="slider-{{ $category->id }}" data-total-products="{{ $totalProducts }}">
                                <div class="slider-track">
                                    @forelse ($sortedProducts as $product)
                                        <div class="slider-item">
                                        <a href="{{ route('product.detail', $product->id) }}" >
                                            <div class="card h-100">
                                                @if ($product->images)
                                                    @php
                                                        $images = json_decode($product->images, true);
                                                        $firstImage = $images[0] ?? null;
                                                    @endphp
                                                    @if ($firstImage)
                                                        <img src="{{ asset('storage/' . $firstImage) }}" class="card-img-top" alt="{{ $product->name }}" loading="lazy" style="height: 200px; object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
                                                    @endif
                                                @else
                                                    <img src="{{ asset('images/no-image.jpg') }}" class="card-img-top" alt="No Image" loading="lazy" style="height: 200px; object-fit: cover;">
                                                @endif
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $product->name }}</h5>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div class="price-box">
                                                            @if ($product->sale_price)
                                                                <span class="text-muted text-decoration-line-through">฿{{ number_format($product->price, 2) }}</span>
                                                                <span class="text-danger">฿{{ number_format($product->sale_price, 2) }}</span>
                                                            @else
                                                                <span>฿{{ number_format($product->price, 2) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                </a>
                                                <div class="card-footer">
                                                    <a href="{{ route('product.detail', $product->id) }}" class="btn btn-outline-primary w-100 hover:bg-red-500">ดูรายละเอียด</a>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="slider-item">
                                            <div class="alert alert-info">
                                                No products found in this category.
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                            <button class="slider-arrow slider-next" data-slider="slider-{{ $category->id }}">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <!-- Slider Navigation Dots -->
                        <div class="slider-dots text-center mt-3" id="dots-{{ $category->id }}">
                            @for ($i = 0; $i < $totalSlides; $i++)
                                <span class="dot @if($i === 0) active @endif" data-slider="slider-{{ $category->id }}" data-index="{{ $i }}"></span>
                            @endfor
                        </div>
                    </template>
                @endif
            </div>
        </div>
        
        @if (!$loop->last)
            <hr class="my-5">
        @endif
    @endforeach

    <!-- Category Pagination -->
    @if($totalPages > 1)
    <div class="category-pagination my-5">
        <nav aria-label="Category navigation">
            <ul class="pagination justify-content-center">
                <!-- Previous Page -->
                <li class="page-item {{ $currentPage <= 1 ? 'disabled' : '' }}">
                    <a class="page-link" href="?page={{ $currentPage - 1 }}" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                <!-- Page Numbers -->
                @for($i = 1; $i <= $totalPages; $i++)
                    <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                    </li>
                @endfor
                
                <!-- Next Page -->
                <li class="page-item {{ $currentPage >= $totalPages ? 'disabled' : '' }}">
                    <a class="page-link" href="?page={{ $currentPage + 1 }}" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Category Styles */
    .category-section {
        background-color: #f9f9f9;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 25px;
    }
    
    .category-title {
        color: #333;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
        font-size: 1.5rem;
    }
    
    /* Slider Container */
    .product-slider-container {
        position: relative;
        overflow: hidden;
        padding: 0;
    }
    
    .product-slider {
        width: 100%;
        overflow: visible;
        position: relative;
    }
    
    .slider-track {
        display: flex;
        transition: transform 0.5s ease;
    }
    
    /* Desktop view - 4 items per slide */
    .slider-item {
        flex: 0 0 25%;
        max-width: 25%;
        padding: 0 10px;
        box-sizing: border-box;
        transition: all 0.3s ease;
    }
    
    /* Card styles */
    .card {
        height: 100%;
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.125);
        overflow: hidden;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    
    .card-img-top {
        height: auto; /* Auto height based on width */
        max-height: 200px; /* Maximum height constraint */
        width: 100%;
        object-fit: contain; /* Show the entire image */
        transition: transform 0.5s ease;
    }
    
    .card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .card-body {
        padding: 1rem;
        height: 120px; /* Fixed height for card body */
        overflow: hidden;
    }
    
    .card-title {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
        height: 2.5rem;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    .price-box {
        margin-bottom: 0.5rem;
    }
    
    .card-footer {
        padding: 0.75rem 1rem;
        background-color: rgba(0,0,0,0.02);
        border-top: 1px solid rgba(0,0,0,0.08);
    }
    
    /* Slider Navigation */
    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 40px;
        height: 40px;
        background-color: rgba(255, 255, 255, 0.9);
        border: none;
        border-radius: 50%;
        z-index: 10;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        transition: all 0.2s ease;
    }
    
    .slider-arrow:hover {
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .slider-prev {
        left: 5px;
    }
    
    .slider-next {
        right: 5px;
    }
    
    /* Slider Dots */
    .slider-dots {
        margin-top: 15px;
        text-align: center;
    }
    
    .dot {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin: 0 5px;
        background-color: #bbb;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s ease;
        border: none;
    }
    
    .dot.active {
        background-color:rgb(255, 0, 0);
        width: 12px;
        height: 12px;
    }
    
    .dot:hover {
        background-color: #999;
    }
    
    /* Lazy loading placeholder */
    .lazy-slider-placeholder {
        background-color: #f8f9fa;
        border-radius: 8px;
        min-height: 300px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.3s ease;
    }
    
    /* Pagination styles */
    .category-pagination .page-link {
        color:rgb(254, 8, 8);
        background-color: #fff;
        border: 1px solid #dee2e6;
    }
    
    .category-pagination .page-item.active .page-link {
        z-index: 3;
        color: #fff;
        background-color:rgb(255, 0, 0);
        border-color:rgb(255, 0, 0);
    }
    
    .category-pagination .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #fff;
        border-color: #dee2e6;
    }
    
    /* Mobile Optimizations */
    @media (max-width: 768px) {
        .container {
            padding: 0 10px;
        }
        
        h1 {
            font-size: 1.75rem !important;
            margin-bottom: 1rem !important;
        }
        
        .category-section {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .category-title {
            font-size: 1.25rem;
            margin-bottom: 15px;
            padding-bottom: 8px;
        }
        
        /* Mobile Carousel */
        .product-slider-container {
            margin: 0 -15px;
            padding: 0 15px;
        }
        
        .slider-item {
            flex: 0 0 85%;
            max-width: 85%;
            padding: 0 8px;
            transition: transform 0.3s ease, opacity 0.3s ease;
        }
        
        /* Active item styling */
        .slider-item.active {
            transform: scale(1);
            opacity: 1;
            z-index: 2;
        }
        
        /* Non-active items styling */
        .slider-item:not(.active) {
            transform: scale(0.9);
            /* opacity: 0.7; */
        }
        
        /* Card adjustments for mobile */
        .card {
            margin-bottom: 0;
        }
        
        .card-img-top {
            height: 150px;
        }
        
        .card-body {
            padding: 0.75rem;
        }
        
        .card-title {
            font-size: 0.95rem;
            height: auto;
            max-height: 2.5rem;
            margin-bottom: 0.5rem;
        }
        
        .price-box {
            font-size: 0.9rem;
        }
        
        .card-footer {
            padding: 0.5rem;
        }
        
        .card-footer .btn {
            font-size: 0.85rem;
            padding: 0.375rem 0.5rem;
        }
        
        /* Slider navigation for mobile */
        .slider-arrow {
            width: 35px;
            height: 35px;
            /* opacity: 0.8; */
        }
        
        .slider-prev {
            left: 0;
        }
        
        .slider-next {
            right: 0;
        }
        
        /* Dots for mobile */
        .slider-dots {
            margin-top: 10px;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            margin: 0 4px;
        }
        
        .dot.active {
            width: 10px;
            height: 10px;
        }
        
        /* Pagination for mobile */
        .category-pagination {
            margin: 15px 0;
        }
        
        .pagination .page-link {
            padding: 0.375rem 0.75rem;
            font-size: 0.9rem;
        }
    }
    
    /* Snap scrolling for mobile */
    @media (max-width: 768px) {
        .slider-track {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        
        .slider-item {
            scroll-snap-align: center;
        }
    }
    
    /* Improved touch experience */
    @media (max-width: 768px) {
        .product-slider {
            -webkit-tap-highlight-color: transparent;
        }
        
        /* Price display improvements */
        .price-box {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        
        .text-decoration-line-through {
            font-size: 0.8rem;
        }
        
        .text-danger {
            font-size: 1rem;
            font-weight: 600;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Load Font Awesome if needed
        if (!document.querySelector('link[href*="font-awesome"]')) {
            const fontAwesome = document.createElement('link');
            fontAwesome.rel = 'stylesheet';
            fontAwesome.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
            document.head.appendChild(fontAwesome);
        }
        
        // Initialize visible sliders
        initializeVisibleSliders();
        
        // Set up lazy loading
        setupLazyLoading();
    });
    
    // Initialize all visible sliders
    function initializeVisibleSliders() {
        // Initialize sliders
        document.querySelectorAll('.product-slider').forEach(slider => {
            initSlider(slider.id);
        });
        
        // Set up arrow navigation
        document.querySelectorAll('.slider-arrow').forEach(arrow => {
            arrow.addEventListener('click', function() {
                const sliderId = this.getAttribute('data-slider');
                const direction = this.classList.contains('slider-next') ? 'next' : 'prev';
                navigateSlider(sliderId, direction);
            });
        });
        
        // Set up dot navigation
        document.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', function() {
                const sliderId = this.getAttribute('data-slider');
                const index = parseInt(this.getAttribute('data-index'));
                goToSlide(sliderId, index);
            });
        });
        
        // Set up keyboard navigation
        setupKeyboardNavigation();
        
        // Set up touch navigation
        setupTouchNavigation();
    }
    
    // Set up keyboard navigation
    function setupKeyboardNavigation() {
        document.addEventListener('keydown', function(e) {
            if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
                const visibleSliders = Array.from(document.querySelectorAll('.product-slider'))
                    .filter(slider => {
                        const rect = slider.getBoundingClientRect();
                        return rect.top < window.innerHeight && rect.bottom > 0;
                    });
                
                if (visibleSliders.length > 0) {
                    const direction = e.key === 'ArrowRight' ? 'next' : 'prev';
                    navigateSlider(visibleSliders[0].id, direction);
                    e.preventDefault();
                }
            }
        });
    }
    
    // Set up touch navigation
    function setupTouchNavigation() {
        document.querySelectorAll('.product-slider').forEach(slider => {
            let touchStartX = 0;
            let touchEndX = 0;
            let touchStartTime = 0;
            let isSwiping = false;
            const minSwipeDistance = 30;
            const maxSwipeTime = 300;
            
            slider.addEventListener('touchstart', function(e) {
                touchStartX = e.touches[0].clientX;
                touchStartTime = Date.now();
                isSwiping = true;
            }, { passive: true });
            
            slider.addEventListener('touchmove', function(e) {
                if (!isSwiping) return;
                
                const currentX = e.touches[0].clientX;
                const diffX = touchStartX - currentX;
                
                if (Math.abs(diffX) > 10) {
                    e.preventDefault();
                }
            }, { passive: false });
            
            slider.addEventListener('touchend', function(e) {
                if (!isSwiping) return;
                
                touchEndX = e.changedTouches[0].clientX;
                const touchEndTime = Date.now();
                const timeDiff = touchEndTime - touchStartTime;
                const distance = touchStartX - touchEndX;
                
                if (timeDiff < maxSwipeTime && Math.abs(distance) >= minSwipeDistance) {
                    const direction = distance > 0 ? 'next' : 'prev';
                    navigateSlider(slider.id, direction);
                    e.preventDefault();
                }
                
                isSwiping = false;
            }, { passive: false });
            
            slider.addEventListener('touchcancel', function() {
                isSwiping = false;
            }, { passive: true });
        });
    }
    
    // Set up lazy loading
    function setupLazyLoading() {
        const lazyLoadObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const container = entry.target;
                    const isLoaded = container.getAttribute('data-loaded') === 'true';
                    
                    if (!isLoaded) {
                        loadCategoryContent(container, observer);
                    } else {
                        observer.unobserve(entry.target);
                    }
                }
            });
        }, {
            root: null,
            rootMargin: '200px',
            threshold: 0.1
        });
        
        // Observe all slider containers
        document.querySelectorAll('.product-slider-container').forEach(container => {
            lazyLoadObserver.observe(container);
        });
    }
    
    // Load category content
    function loadCategoryContent(container, observer) {
        const placeholder = container.querySelector('.lazy-slider-placeholder');
        if (!placeholder) return;
        
        const categoryId = placeholder.getAttribute('data-category-id');
        const template = document.getElementById(`slider-template-${categoryId}`);
        
        if (template) {
            // Clone the template content
            const content = template.content.cloneNode(true);
            
            // Replace placeholder with actual content
            placeholder.style.opacity = '0';
            setTimeout(() => {
                placeholder.replaceWith(content);
                container.setAttribute('data-loaded', 'true');
                
                // Initialize the newly added slider
                initSlider(`slider-${categoryId}`);
                
                // Set up navigation for the new slider
                setupNewSliderNavigation(container);
                
                // Stop observing this element
                observer.unobserve(container);
            }, 300);
        }
    }
    
    // Set up navigation for newly loaded slider
    function setupNewSliderNavigation(container) {
        // Set up arrow navigation
        container.querySelectorAll('.slider-arrow').forEach(arrow => {
            arrow.addEventListener('click', function() {
                const sliderId = this.getAttribute('data-slider');
                const direction = this.classList.contains('slider-next') ? 'next' : 'prev';
                navigateSlider(sliderId, direction);
            });
        });
        
        // Set up dot navigation
        container.querySelectorAll('.dot').forEach(dot => {
            dot.addEventListener('click', function() {
                const sliderId = this.getAttribute('data-slider');
                const index = parseInt(this.getAttribute('data-index'));
                goToSlide(sliderId, index);
            });
        });
        
        // Set up touch navigation
        setupTouchNavigation();
    }
    
    // Initialize slider
    function initSlider(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const track = slider.querySelector('.slider-track');
        const items = slider.querySelectorAll('.slider-item');
        const totalProducts = parseInt(slider.getAttribute('data-total-products') || items.length);
        
        // Store slider state
        slider.currentIndex = 0;
        slider.totalItems = items.length;
        
        // Set items per page based on screen size
        const isMobile = window.innerWidth <= 768;
        const itemsPerPage = isMobile ? 1 : 4;
        
        // Calculate max index correctly based on total items and items per page
        slider.itemsPerPage = itemsPerPage;
        slider.maxIndex = Math.max(0, slider.totalItems - itemsPerPage);
        
        // Set initial active state for mobile view
        if (isMobile && items.length > 0) {
            updateCarouselClasses(slider);
        }
        
        // Initial positioning
        updateSliderPosition(sliderId);
        
        // Update on window resize
        window.addEventListener('resize', function() {
            const wasMobile = slider.itemsPerPage === 1;
            const isMobileNow = window.innerWidth <= 768;
            
            // Only update if mobile state changed
            if (wasMobile !== isMobileNow) {
                slider.itemsPerPage = isMobileNow ? 1 : 4;
                slider.maxIndex = Math.max(0, slider.totalItems - (isMobileNow ? 1 : 4));
                
                // Reset active classes
                items.forEach(item => {
                    item.classList.remove('active', 'prev', 'next');
                });
                
                // Set active class for current item in mobile
                if (isMobileNow && items.length > 0) {
                    updateCarouselClasses(slider);
                }
                
                updateSliderPosition(sliderId);
            }
        });
    }
    
    // Update carousel classes for mobile view
    function updateCarouselClasses(slider) {
        const items = slider.querySelectorAll('.slider-item');
        const currentIndex = slider.currentIndex;
        const totalItems = items.length;
        
        // Remove all special classes first
        items.forEach(item => {
            item.classList.remove('active', 'prev', 'next');
        });
        
        // Add appropriate classes based on position
        // Current item (center)
        if (currentIndex >= 0 && currentIndex < totalItems) {
            items[currentIndex].classList.add('active');
        }
        
        // Previous item (left)
        const prevIndex = currentIndex - 1;
        if (prevIndex >= 0) {
            items[prevIndex].classList.add('prev');
        }
        
        // Next item (right)
        const nextIndex = currentIndex + 1;
        if (nextIndex < totalItems) {
            items[nextIndex].classList.add('next');
        }
    }
    
    // Navigate slider
    function navigateSlider(sliderId, direction) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const isMobile = window.innerWidth <= 768;
        
        if (direction === 'next' && slider.currentIndex < slider.maxIndex) {
            slider.currentIndex++;
        } else if (direction === 'prev' && slider.currentIndex > 0) {
            slider.currentIndex--;
        }
        
        // Update carousel classes if in mobile view
        if (isMobile) {
            updateCarouselClasses(slider);
        }
        
        updateSliderPosition(sliderId);
        
        // Add haptic feedback for mobile devices if supported
        if (isMobile && window.navigator && window.navigator.vibrate) {
            window.navigator.vibrate(50); // Subtle vibration feedback
        }
    }
    
    // Go to specific slide
    function goToSlide(sliderId, index) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const isMobile = window.innerWidth <= 768;
        const itemsPerPage = slider.itemsPerPage;
        
        // Calculate the actual item index based on items per page and slide index
        let targetIndex;
        
        if (isMobile) {
            // For mobile, each dot represents one item
            targetIndex = index;
        } else {
            // For desktop, calculate the starting index for this slide
            targetIndex = index * itemsPerPage;
            
            // Make sure we don't exceed the maximum index
            targetIndex = Math.min(targetIndex, slider.maxIndex);
        }
        
        if (targetIndex >= 0 && targetIndex <= slider.maxIndex) {
            slider.currentIndex = targetIndex;
            
            // Update carousel classes if in mobile view
            if (isMobile) {
                updateCarouselClasses(slider);
            }
            
            updateSliderPosition(sliderId);
        }
    }
    
    // Update slider position
    function updateSliderPosition(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const track = slider.querySelector('.slider-track');
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Mobile view: Center the current item
            const itemWidth = 85; // Each item is 85% wide in mobile
            
            // Calculate position to center the current item
            // We need to account for the item width and center it
            const position = (slider.currentIndex * itemWidth);
            
            // Apply the transform with smooth animation
            track.style.transform = `translateX(-${position}%)`;
        } else {
            // Desktop view: Position based on current index
            // Each item is 25% wide (4 items per row), so we move in 25% increments
            const itemWidth = 25; // Each item is 25% wide
            const position = slider.currentIndex * itemWidth;
            
            track.style.transform = `translateX(-${position}%)`;
        }
        
        // Update dots
        updateDots(sliderId);
        
        // Update arrow visibility
        updateArrows(sliderId);
    }
    
    // Update navigation dots
    function updateDots(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const categoryId = sliderId.replace('slider-', '');
        const dotsContainer = document.getElementById(`dots-${categoryId}`);
        
        if (dotsContainer) {
            const dots = dotsContainer.querySelectorAll('.dot');
            const isMobile = window.innerWidth <= 768;
            
            // Calculate which dot should be active
            let activeDotIndex;
            
            if (isMobile) {
                // In mobile, each dot represents one item
                activeDotIndex = slider.currentIndex;
            } else {
                // In desktop, calculate which slide we're on based on current index and items per page
                activeDotIndex = Math.floor(slider.currentIndex / slider.itemsPerPage);
            }
            
            // Update dot active states
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === activeDotIndex);
            });
        }
    }
    
    // Update navigation arrows
    function updateArrows(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return;
        
        const prevArrow = document.querySelector(`.slider-prev[data-slider="${sliderId}"]`);
        const nextArrow = document.querySelector(`.slider-next[data-slider="${sliderId}"]`);
        
        if (prevArrow) {
            prevArrow.style.opacity = slider.currentIndex === 0 ? '0.3' : '1';
            prevArrow.style.visibility = 'visible'; // Always keep arrows visible on mobile for better UX
        }
        
        if (nextArrow) {
            nextArrow.style.opacity = slider.currentIndex >= slider.maxIndex ? '0.3' : '1';
            nextArrow.style.visibility = 'visible'; // Always keep arrows visible on mobile for better UX
        }
    }
    
    // Add smooth scrolling to category sections
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling to category links if they exist
        const categoryLinks = document.querySelectorAll('.category-link');
        categoryLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Smooth scroll to the target
                    window.scrollTo({
                        top: targetElement.offsetTop - 20,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Add pull-to-refresh functionality for mobile
        let touchStartY = 0;
        let touchEndY = 0;
        const refreshThreshold = 150;
        let isRefreshing = false;
        
        document.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
        document.addEventListener('touchmove', function(e) {
            if (isRefreshing) return;
            
            touchEndY = e.touches[0].clientY;
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            
            // Only enable pull-to-refresh when at the top of the page
            if (scrollTop <= 0 && touchEndY - touchStartY > 50) {
                // Show visual indicator for pull-to-refresh
                showRefreshIndicator(Math.min((touchEndY - touchStartY) / refreshThreshold, 1));
            }
        }, { passive: true });
        
        document.addEventListener('touchend', function() {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            
            if (scrollTop <= 0 && touchEndY - touchStartY > refreshThreshold && !isRefreshing) {
                // Perform refresh
                isRefreshing = true;
                showRefreshIndicator(1);
                
                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 500);
            } else {
                // Hide refresh indicator
                hideRefreshIndicator();
            }
            
            touchStartY = 0;
            touchEndY = 0;
        }, { passive: true });
        
        // Create refresh indicator if it doesn't exist
        if (!document.getElementById('refresh-indicator')) {
            const indicator = document.createElement('div');
            indicator.id = 'refresh-indicator';
            indicator.innerHTML = '<div class="spinner"></div><span>Release to refresh</span>';
            indicator.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                background-color: #f8f9fa;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 0;
                overflow: hidden;
                transition: height 0.3s ease;
                z-index: 1000;
                box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            `;
            document.body.prepend(indicator);
            
            // Add spinner style
            const style = document.createElement('style');
            style.textContent = `
                #refresh-indicator .spinner {
                    width: 24px;
                    height: 24px;
                    border: 3px solid rgba(0,123,255,0.3);
                    border-radius: 50%;
                    border-top-color:rgb(255, 0, 0);
                    animation: spin 1s linear infinite;
                    margin-right: 10px;
                }
                @keyframes spin {
                    to { transform: rotate(360deg); }
                }
            `;
            document.head.appendChild(style);
        }
    });
    
    // Show refresh indicator
    function showRefreshIndicator(progress) {
        const indicator = document.getElementById('refresh-indicator');
        if (indicator) {
            const height = Math.min(progress * 60, 60); // Max height 60px
            indicator.style.height = `${height}px`;
            
            // Update text based on progress
            const text = indicator.querySelector('span');
            if (text) {
                text.textContent = progress >= 1 ? 'Refreshing...' : 'Pull down to refresh';
            }
        }
    }
    
    // Hide refresh indicator
    function hideRefreshIndicator() {
        const indicator = document.getElementById('refresh-indicator');
        if (indicator) {
            indicator.style.height = '0';
        }
    }
    
    // Add scroll to top button for mobile
    document.addEventListener('DOMContentLoaded', function() {
        // Create scroll to top button
        const scrollTopBtn = document.createElement('button');
        scrollTopBtn.id = 'scroll-top-btn';
        scrollTopBtn.innerHTML = '<i class="fas fa-arrow-up"></i>';
        scrollTopBtn.style.cssText = `
            position: fixed;
            bottom: 20px;
            left: 20px;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color:rgb(255, 0, 0);
            color: white;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: none;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
        
            transition: opacity 0.3s, transform 0.3s;
        `;
        document.body.appendChild(scrollTopBtn);
        
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.style.display = 'flex';
                // Add a small delay to make it feel more responsive
                setTimeout(() => {
                    scrollTopBtn.style.opacity = '0.8';
                    scrollTopBtn.style.transform = 'scale(1)';
                }, 10);
            } else {
                scrollTopBtn.style.opacity = '0';
                scrollTopBtn.style.transform = 'scale(0.8)';
                setTimeout(() => {
                    if (window.pageYOffset <= 300) {
                        scrollTopBtn.style.display = 'none';
                    }
                }, 300);
            }
        });
        
        // Scroll to top when button is clicked
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
            
            // Add haptic feedback if supported
            if (window.navigator && window.navigator.vibrate) {
                window.navigator.vibrate(50);
            }
        });
    });
    
    // Optimize images for mobile
    document.addEventListener('DOMContentLoaded', function() {
        if (window.innerWidth <= 768) {
            // Add lazy loading to all images
            document.querySelectorAll('img').forEach(img => {
                if (!img.hasAttribute('loading')) {
                    img.setAttribute('loading', 'lazy');
                }
                
                // Add fade-in effect for images
                img.style.opacity = '1';
                img.style.transition = 'opacity 0.3s ease';
                
                img.addEventListener('load', function() {
                    this.style.opacity = '1';
                });
            });
        }
    });
</script>
@endpush
