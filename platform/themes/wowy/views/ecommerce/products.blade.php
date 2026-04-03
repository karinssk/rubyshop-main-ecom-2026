@php
    $layout = theme_option('product_list_layout');

    $requestLayout = BaseHelper::stringify(request()->input('layout'));
    if ($requestLayout && in_array($requestLayout, array_keys(get_product_single_layouts()))) {
        $layout = $requestLayout;
    }

    $layout = ($layout && in_array($layout, array_keys(get_product_single_layouts()))) ? $layout : 'product-full-width';

    Theme::layout('full-width');

    Theme::asset()->usePath()->add('jquery-ui-css', 'css/plugins/jquery-ui.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-js', 'js/plugins/jquery-ui.js');
    Theme::asset()->container('footer')->usePath()->add('jquery-ui-touch-punch-js', 'js/plugins/jquery.ui.touch-punch.min.js');

    $products->loadMissing(['categories', 'categories.slugable']);
@endphp

<style>
    .product-cart-wrap .product-content-wrap .product-category a {
        color: var(--color-grey-4);
        font-size: 10px;
        letter-spacing: 0px;
        text-transform: uppercase;
        font-weight: bolder
    }
</style>

<div class="container mb-30">
    <div class="row">
        @if ($layout === 'product-full-width')
            <div class="col-lg-12 m-auto mt-4">
                <a class="shop-filter-toggle mb-0" href="#" aria-expanded="false" aria-controls="products-filter">
                    <span class="fal fa-filter mr-5"></span>
                    <span class="title">{{ __('Filters') }}</span>
                    <i class="fal fa-angle-small-up angle-up"></i>
                    <i class="fal fa-angle-small-down angle-down"></i>
                </a>
                <form action="{{ URL::current() }}" method="GET" id="products-filter-ajax" class="collapse">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.filters')
                </form>
            </div>

            <div class="mt-4">
                <div class="products-listing position-relative">
                    @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                </div>
            </div>
        @elseif($layout === 'product-left-sidebar')
            <div class="col-xl-3 primary-sidebar mt-4 d-none d-xl-block">
                <div class="widget-area">
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                </div>
            </div>
            <div class="col-lg-12 col-xl-9">
                <!-- Mobile filter toggle -->
                <div class="d-block d-xl-none mt-4">
                    <a class="shop-filter-toggle mb-3" href="#" aria-expanded="false" aria-controls="sidebar-filter-mobile">
                        <span class="fal fa-filter mr-5"></span>
                        <span class="title">{{ __('Filters') }}</span>
                        <i class="fal fa-angle-small-up angle-up"></i>
                        <i class="fal fa-angle-small-down angle-down"></i>
                    </a>
                    <div id="sidebar-filter-mobile" class="collapse mb-3">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="products-listing position-relative bb-product-items-wrapper">
                        @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                    </div>
                </div>
            </div>
        @elseif($layout === 'product-right-sidebar')
            <div class="col-lg-12 col-xl-9">
                <!-- Mobile filter toggle -->
                <div class="d-block d-xl-none mt-4">
                    <a class="shop-filter-toggle mb-3" href="#" aria-expanded="false" aria-controls="sidebar-filter-mobile">
                        <span class="fal fa-filter mr-5"></span>
                        <span class="title">{{ __('Filters') }}</span>
                        <i class="fal fa-angle-small-up angle-up"></i>
                        <i class="fal fa-angle-small-down angle-down"></i>
                    </a>
                    <div id="sidebar-filter-mobile" class="collapse mb-3">
                        @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="products-listing position-relative bb-product-items-wrapper">
                        @include(Theme::getThemeNamespace() . '::views.ecommerce.includes.product-items', compact('products'))
                    </div>
                </div>
            </div>
            <div class="col-xl-3 primary-sidebar mt-4 d-none d-xl-block">
                <div class="widget-area">
                    @include(Theme::getThemeNamespace('views.ecommerce.includes.filters'))
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Mobile optimizations -->
<style>
    /* Base mobile optimizations */
    @media (max-width: 767px) {
        .container {
            padding-left: 10px;
            padding-right: 10px;
        }
        
        .shop-filter-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            background: #f7f7f7;
            border-radius: 5px;
            margin-bottom: 15px !important;
            font-weight: 500;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        .shop-filter-toggle .title {
            flex-grow: 1;
        }
        
        /* Improve filter panel on mobile */
        #products-filter-ajax,
        #sidebar-filter-mobile {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        
        /* Product grid optimizations */
        .products-listing .row {
            margin-left: -5px;
            margin-right: -5px;
            display: flex;
            flex-wrap: wrap;
        }
        
        /* Make each product take up 50% width (2 columns) */
        .products-listing .row > div[class*="col-"] {
            flex: 0 0 50%;
            max-width: 50%;
            padding-left: 5px;
            padding-right: 5px;
        }
        
        /* Product card optimizations */
        .products-listing .product-cart-wrap {
            padding: 8px;
            margin-bottom: 10px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        
        /* Optimize product image */
        .products-listing .product-img {
            margin-bottom: 8px;
        }
        
        .products-listing .product-img img {
            max-height: 140px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        /* Optimize product content */
        .products-listing .product-content-wrap {
            padding: 8px 0 0 0;
        }
        
        /* Optimize product title */
        .product-title, 
        .product-cart-wrap h2,
        .product-content-wrap h2,
        .text-truncate {
            font-size: 0.85rem !important;
            margin-bottom: 5px !important;
            height: 20px !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: nowrap !important;
            width: 100% !important;
        }
        
        /* Make sure the title links also truncate */
        .product-title a, 
        .product-cart-wrap h2 a,
        .product-content-wrap h2 a {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            width: 100% !important;
            display: inline-block !important;
        }
        
        /* Optimize product price */
        .products-listing .product-price {
            font-size: 0.9rem;
            margin-bottom: 5px;
        }
        
        /* Optimize product buttons */
        .products-listing .add-cart a {
            padding: 5px 10px;
            font-size: 0.8rem;
        }
        
        /* Add pull-to-refresh indicator */
        .pull-to-refresh {
            height: 0;
            overflow: hidden;
            text-align: center;
            transition: height 0.3s;
            position: relative;
            padding: 10px 0;
        }
        
        .pull-to-refresh.active {
            height: 50px;
        }
        
        .pull-to-refresh .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(0,0,0,0.1);
            border-top-color: #3BB77E;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        /* Improve pagination on mobile */
        .pagination {
            flex-wrap: wrap;
            justify-content: center;
        }
        
        .pagination li {
            margin-bottom: 5px;
        }
        
        /* Add scroll to top button */
        #scroll-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 40px;
            height: 40px;
            background: #3BB77E;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        #scroll-top.visible {
            opacity: 1;
            visibility: visible;
        }
        
        /* Improve filter widgets */
        .widget-filter-item {
            margin-bottom: 15px;
        }
        
        .widget-filter-item .widget-title {
            font-size: 1rem;
            padding-bottom: 8px;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        /* Optimize price range slider */
        .price-range-slider {
            margin-top: 15px;
        }
        
        .ui-slider-horizontal {
            height: 4px;
        }
        
        .ui-slider-handle {
            width: 16px !important;
            height: 16px !important;
            top: -6px !important;
        }
    }
    
    /* Tablet optimizations */
    @media (min-width: 768px) and (max-width: 991px) {
        .products-listing .row > div[class*="col-"] {
            flex: 0 0 33.333%;
            max-width: 33.333%;
        }
    }
    
    /* Add loading state for AJAX requests */
    .products-listing.loading::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.7);
        z-index: 2;
    }
    
    .products-listing.loading::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 30px;
        height: 30px;
        margin: -15px 0 0 -15px;
        border: 3px solid rgba(0,0,0,0.1);
        border-top-color: #3BB77E;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        z-index: 3;
    }
</style>

<!-- Add JavaScript for enhanced mobile experience -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize filter toggles
        const filterToggles = document.querySelectorAll('.shop-filter-toggle');
        filterToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('aria-controls');
                const target = document.getElementById(targetId);
                
                // Toggle the collapse
                if (target) {
                    const isExpanded = this.getAttribute('aria-expanded') === 'true';
                    this.setAttribute('aria-expanded', !isExpanded);
                    
                    if (isExpanded) {
                        target.classList.remove('show');
                    } else {
                        target.classList.add('show');
                    }
                }
            });
        });
        
        // Add scroll to top button
        const scrollTopBtn = document.createElement('button');
        scrollTopBtn.id = 'scroll-top';
        scrollTopBtn.innerHTML = '<i class="fi-rs-arrow-up"></i>';
        document.body.appendChild(scrollTopBtn);
        
        // Show/hide scroll to top button
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.add('visible');
            } else {
                scrollTopBtn.classList.remove('visible');
            }
        });
        
        // Scroll to top when button is clicked
        scrollTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Add pull-to-refresh functionality
        let touchStartY = 0;
        let touchEndY = 0;
        const refreshThreshold = 100;
        let isRefreshing = false;
        
        // Create pull-to-refresh indicator
        const refreshIndicator = document.createElement('div');
        refreshIndicator.className = 'pull-to-refresh';
        refreshIndicator.innerHTML = '<div class="spinner"></div><p>Release to refresh</p>';
        
        const container = document.querySelector('.container');
        if (container) {
            container.insertBefore(refreshIndicator, container.firstChild);
        }
        
        // Touch events for pull-to-refresh
        document.addEventListener('touchstart', function(e) {
            touchStartY = e.touches[0].clientY;
        }, { passive: true });
        
                document.addEventListener('touchmove', function(e) {
            if (isRefreshing) return;
            
            touchEndY = e.touches[0].clientY;
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            
            // Only enable pull-to-refresh when at the top of the page
            if (scrollTop <= 0 && touchEndY - touchStartY > 30) {
                refreshIndicator.classList.add('active');
                refreshIndicator.querySelector('p').textContent = 
                    touchEndY - touchStartY > refreshThreshold ? 'Release to refresh' : 'Pull down to refresh';
            }
        }, { passive: true });
        
        document.addEventListener('touchend', function() {
            const scrollTop = window.scrollY || document.documentElement.scrollTop;
            
            if (scrollTop <= 0 && touchEndY - touchStartY > refreshThreshold && !isRefreshing) {
                // Perform refresh
                isRefreshing = true;
                refreshIndicator.querySelector('p').textContent = 'Refreshing...';
                
                // Reload the page after a short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                // Hide refresh indicator
                refreshIndicator.classList.remove('active');
            }
            
            touchStartY = 0;
            touchEndY = 0;
        }, { passive: true });
        
        // Optimize images for mobile
    // Optimize images for mobile - UPDATED
if (window.innerWidth <= 768) {
    // Add lazy loading to all images
    document.querySelectorAll('.product-img img').forEach(img => {
        if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
        }
        
        // Removed opacity transition code
        
        // Optional: Add error handling for images
        img.addEventListener('error', function() {
            // Replace broken images with a placeholder
            this.src = '/themes/wowy/images/placeholder.jpg';
        });
    });
    
    // Rest of the code remains the same...
}

            
            // Optimize product grid for touch
            const productCards = document.querySelectorAll('.product-cart-wrap');
            productCards.forEach(card => {
                card.addEventListener('touchstart', function() {
                    this.style.transform = 'scale(0.98)';
                }, { passive: true });
                
                card.addEventListener('touchend', function() {
                    this.style.transform = 'scale(1)';
                }, { passive: true });
            });
        }
        
        // Enhance filter interactions
        const filterItems = document.querySelectorAll('.widget-filter-item');
        filterItems.forEach(item => {
            const title = item.querySelector('.widget-title');
            const content = item.querySelector('.widget-content');
            
            if (title && content && window.innerWidth <= 768) {
                // Add toggle functionality for filter sections on mobile
                title.style.cursor = 'pointer';
                
                // Add indicator
                const indicator = document.createElement('span');
                indicator.innerHTML = '<i class="fi-rs-angle-small-down"></i>';
                indicator.style.float = 'right';
                title.appendChild(indicator);
                
                title.addEventListener('click', function() {
                    const isVisible = content.style.display !== 'none';
                    
                    if (isVisible) {
                        content.style.display = 'none';
                        indicator.innerHTML = '<i class="fi-rs-angle-small-down"></i>';
                    } else {
                        content.style.display = 'block';
                        indicator.innerHTML = '<i class="fi-rs-angle-small-up"></i>';
                    }
                });
                
                // Initially hide all but the first filter section
                if (item !== filterItems[0]) {
                    content.style.display = 'none';
                }
            }
        });
        
        // Enhance AJAX filtering
        const filterForm = document.getElementById('products-filter-ajax');
        if (filterForm) {
            const productsContainer = document.querySelector('.products-listing');
            
            // Add debounce function for filter inputs
            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }
            
            // Handle filter changes
            const filterInputs = filterForm.querySelectorAll('input, select');
            filterInputs.forEach(input => {
                const eventType = input.type === 'checkbox' || input.type === 'radio' || input.tagName === 'SELECT' 
                    ? 'change' : 'input';
                
                input.addEventListener(eventType, debounce(function() {
                    // Show loading state
                    if (productsContainer) {
                        productsContainer.classList.add('loading');
                    }
                    
                    // Submit form via AJAX
                    const formData = new FormData(filterForm);
                    
                    fetch(filterForm.action, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.text())
                    .then(html => {
                        // Update products container
                        if (productsContainer) {
                            productsContainer.innerHTML = html;
                            productsContainer.classList.remove('loading');
                            
                            // Reinitialize any scripts needed for the new content
                            // ...
                            
                            // Scroll to top of products if not already visible
                            const rect = productsContainer.getBoundingClientRect();
                            if (rect.top < 0) {
                                window.scrollTo({
                                    top: window.scrollY + rect.top - 20,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error updating products:', error);
                        productsContainer.classList.remove('loading');
                    });
                }, 500));
            });
        }
        
        // Add swipe navigation for product images (if any sliders exist)
        const productSliders = document.querySelectorAll('.product-img-slider');
        if (productSliders.length > 0) {
            productSliders.forEach(slider => {
                let touchStartX = 0;
                let touchEndX = 0;
                
                slider.addEventListener('touchstart', function(e) {
                    touchStartX = e.touches[0].clientX;
                }, { passive: true });
                
                slider.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].clientX;
                    const distance = touchStartX - touchEndX;
                    
                    // If significant horizontal swipe detected
                    if (Math.abs(distance) > 50) {
                        // Find next/prev buttons
                        const nextBtn = slider.querySelector('.slick-next') || slider.querySelector('.next');
                        const prevBtn = slider.querySelector('.slick-prev') || slider.querySelector('.prev');
                        
                        if (distance > 0 && nextBtn) {
                            // Swipe left, go to next slide
                            nextBtn.click();
                        } else if (distance < 0 && prevBtn) {
                            // Swipe right, go to previous slide
                            prevBtn.click();
                        }
                    }
                }, { passive: true });
            });
        }
        
        // Add infinite scroll for product listings (if pagination exists)
        const pagination = document.querySelector('.pagination');
        const nextPageLink = pagination ? pagination.querySelector('a[rel="next"]') : null;
        
        if (nextPageLink && productsContainer) {
            // Create loading indicator for infinite scroll
            const loadingIndicator = document.createElement('div');
            loadingIndicator.className = 'text-center py-4 loading-more';
            loadingIndicator.innerHTML = '<div class="spinner d-inline-block"></div><p class="mt-2">Loading more products...</p>';
            loadingIndicator.style.display = 'none';
            
            // Add loading indicator after products container
            productsContainer.parentNode.insertBefore(loadingIndicator, pagination);
            
            // Set up intersection observer for infinite scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && nextPageLink && !isRefreshing) {
                        // Show loading indicator
                        loadingIndicator.style.display = 'block';
                        
                        // Load next page
                        fetch(nextPageLink.href, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.text())
                        .then(html => {
                            // Parse the HTML
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            // Get new products
                            const newProducts = doc.querySelector('.products-listing .row');
                            
                            if (newProducts) {
                                // Append new products
                                const currentProducts = productsContainer.querySelector('.row');
                                if (currentProducts) {
                                    currentProducts.innerHTML += newProducts.innerHTML;
                                }
                                
                                // Update next page link
                                const newNextPageLink = doc.querySelector('.pagination a[rel="next"]');
                                if (newNextPageLink) {
                                    nextPageLink.href = newNextPageLink.href;
                                } else {
                                    // No more pages, remove observer
                                    observer.disconnect();
                                    loadingIndicator.style.display = 'none';
                                    pagination.style.display = 'none';
                                }
                            }
                            
                            // Hide loading indicator
                            loadingIndicator.style.display = 'none';
                        })
                        .catch(error => {
                            console.error('Error loading more products:', error);
                            loadingIndicator.style.display = 'none';
                        });
                    }
                });
            }, {
                rootMargin: '200px',
                threshold: 0.1
            });
            
            // Observe the pagination element
            observer.observe(pagination);
        }
    });
</script>

