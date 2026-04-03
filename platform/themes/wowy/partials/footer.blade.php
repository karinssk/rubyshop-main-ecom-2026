{!! dynamic_sidebar('top_footer_sidebar') !!}

<!-- Custom RubyShop Footer -->
<style>
    .ruby-footer p {
        margin-bottom: 0.75rem;
        line-height: 1.6;
    }

    .ruby-footer a {
        transition: color 0.2s ease;
    }

    #scrollUp {
        position: fixed;
        bottom: 2rem;
        right: 2rem;
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        background-color: #dc2626;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease, background-color 0.2s ease;
    }

    #scrollUp i {
        font-size: 1.1rem;
    }

    #scrollUp:hover {
        background-color: #b91c1c;
    }

    #scrollUp.active {
        opacity: 1;
        visibility: visible;
    }
</style>

<footer class="ruby-footer bg-gray-900 text-white pt-16 pb-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">
            <div>
                <img src="https://www.rubyshop.co.th/storage/logo/rubyshop-no-bg-white.png" alt="RUBYSHOP Logo" class="h-12 mb-6">
                <p class="text-gray-400">
                    RUBYSHOP ผู้นำเข้าและจัดจำหน่ายอุปกรณ์ก่อสร้างคุณภาพสูง มุ่งมั่นนำเสนอนวัตกรรมและเทคโนโลยีล่าสุดเพื่อตอบสนองความต้องการของลูกค้า
                </p>
                <div class="flex space-x-4 mt-6 text-xl">
                    <a href="https://www.facebook.com/rubyshopcoth" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://page.line.me/rubyshop168?openQrModal=true" class="text-gray-400 hover:text-white"><i class="fab fa-line"></i></a>
                    <a href="https://www.instagram.com/rubyshop_168/" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/channel/UCxiaZiIC8qs2C228jwIjcHg" class="text-gray-400 hover:text-white"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">เมนูหลัก</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="/" class="hover:text-white text-white">หน้าแรก</a></li>
                    <li><a href="https://www.rubyshop.co.th/products" class="hover:text-white">สินค้าทั้งหมด</a></li>
                    <li><a href="https://www.rubyshop.co.th/aboutcompany/about-us" class="hover:text-white">เกี่ยวกับเรา</a></li>
                    <li><a href="https://www.rubyshop.co.th/aboutcompany/about-us" class="hover:text-white">ติดต่อเรา</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">ผลิตภัณฑ์อื่นๆ</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li><a href="https://www.rubyshop.co.th/products/rubyshop-rb-32-3000-rebar-bending-machine" class="hover:text-white">เครื่องตัดเหล็ก</a></li>
                    <li><a href="https://www.rubyshop.co.th/product-categories/airless-sprayer-professional" class="hover:text-white">เครื่องพ่นสี</a></li>
                    <li><a href="https://www.rubyshop.co.th/products?layout=product-full-width&categories%5B%5D=70&page=2" class="hover:text-white">อุปกรณ์เสริม</a></li>
                    <li><a href="https://www.rubyshop.co.th/products?layout=product-full-width&categories%5B%5D=70&page=1" class="hover:text-white">อะไหล่</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-lg font-semibold mb-6 text-white">ติดต่อเรา</h4>
                <ul class="space-y-3 text-gray-400 text-sm">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-red-500"></i>
                        <a class="hover:text-white hover:underline" href="https://www.google.com/maps/place/%E0%B8%AB%E0%B8%88%E0%B8%81.%E0%B8%A3%E0%B8%B9%E0%B8%9A%E0%B8%B5%E0%B9%89%E0%B8%8A%E0%B9%8A%E0%B8%AD%E0%B8%9B/@13.9105948,100.5740356,20z/data=!4m6!3m5!1s0x30e28301fbf17fbd:0x806362f26ffe576f!8m2!3d13.9104803!4d100.5742382!16s%2Fg%2F12m9309nd?entry=ttu">
                            97/60 โกสุมรวมใจ ซ. 39 แขวงดอนเมือง ดอนเมือง กรุงเทพมหานคร 10210
                        </a>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-phone-alt mt-1 mr-3 text-red-500"></i>
                        <a class="hover:text-white hover:underline" href="tel:0896667802">089-666-7802</a>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-envelope mt-1 mr-3 text-red-500"></i>
                        <a class="hover:text-white hover:underline" href="mailto:saleruby.benjavan@gmail.com">info@rubyshop.co.th</a>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-clock mt-1 mr-3 text-red-500"></i>
                        <span>เปิดทำการ: จันทร์-เสาร์ 08:30-17:30 น.</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="pt-8 border-t border-gray-800 text-center text-gray-400 text-sm">
            <p class="mb-4 text-white">&copy; 2025 RUBYSHOP. All rights reserved.</p>
            <div class="flex justify-center space-x-4">
                <a href="https://www.rubyshop.co.th/privacy-policy" class="hover:text-white">นโยบายความเป็นส่วนตัว</a>
                <span>|</span>
                <a href="https://www.rubyshop.co.th/terms-conditions" class="hover:text-white">เงื่อนไขการใช้บริการ</a>
                <span>|</span>
                <a href="https://www.rubyshop.co.th/cookie-policy" class="hover:text-white">นโยบายการคืนสินค้า</a>
            </div>
        </div>
    </div>
</footer>

<!-- <div class="mx-auto max-w-5xl px-6 text-center text-xs text-gray-500 mt-4">
    <p>เครื่องหมายการค้าต่อไปนี้เป็นของ เครื่องพ่นสีแรงดันสูง เครื่องผสมสี เครื่องพ่นสีกันไฟ เครื่องพ่นปูนฉาบ เครื่องตีเส้นถนน เครื่องกรีดผนัง เครื่องปั่นหน้าปูนและอื่นๆ ของ RUBYSHOP: โทนสีแดง-เทา และลวดลายบนพื้นผิวของเครื่องมือ หจก. รูบี้ช๊อป</p>
</div> -->

<!-- Quick view -->
<div class="modal fade custom-modal" id="quick-view-modal" tabindex="-1" aria-labelledby="quick-view-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-body">
                <div class="half-circle-spinner loading-spinner">
                    <div class="circle circle-1"></div>
                    <div class="circle circle-2"></div>
                </div>
                <div class="quick-view-content"></div>
            </div>
        </div>
    </div>
</div>

@if (is_plugin_active('ecommerce'))
    <script>
        window.currencies = {!! json_encode(get_currencies_json()) !!};
    </script>
@endif

{!! Theme::footer() !!}

<script>
    (function () {
        const successAlert = document.getElementById('successAlert');
        const emailSignupForm = document.getElementById('emailSignupForm');

        if (emailSignupForm && successAlert) {
            emailSignupForm.addEventListener('submit', function (event) {
                event.preventDefault();
                successAlert.classList.remove('hidden');
                this.reset();
                setTimeout(() => successAlert.classList.add('hidden'), 5000);
            });
        }
    })();

    window.trans = {
        "Views": "{{ __('Views') }}",
        "Read more": "{{ __('Read more') }}",
        "days": "{{ __('days') }}",
        "hours": "{{ __('hours') }}",
        "mins": "{{ __('mins') }}",
        "sec": "{{ __('sec') }}",
        "No reviews!": "{{ __('No reviews!') }}"
    };
</script>

<script>
    window.addEventListener('load', function () {
        if (typeof window.jQuery === 'undefined' || typeof window.jQuery.fn.slick === 'undefined') {
            return;
        }

        const $ = window.jQuery;
        const $slider = $('.product-image-slider');
        const $thumbnails = $('.slider-nav-thumbnails');

        if (!$slider.length || $slider.hasClass('slick-initialized')) {
            return;
        }

        const isRTL = $('body').prop('dir') === 'rtl';

        $slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            rtl: isRTL,
            arrows: false,
            fade: false,
            asNavFor: '.slider-nav-thumbnails',
        });

        if ($thumbnails.length && !$thumbnails.hasClass('slick-initialized')) {
            $thumbnails.slick({
                slidesToShow: 5,
                slidesToScroll: 1,
                rtl: isRTL,
                asNavFor: '.product-image-slider',
                dots: false,
                focusOnSelect: true,
                prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
            });
        }

        const syncActiveThumbnail = function (index) {
            if (!$thumbnails.length) {
                return;
            }

            const $slides = $thumbnails.find('.slick-slide');
            $slides.removeClass('slick-active');
            $slides.eq(index).addClass('slick-active');
        };

        syncActiveThumbnail(0);

        $slider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            syncActiveThumbnail(nextSlide);
        });

        if (typeof $slider.lightGallery === 'function') {
            $slider.lightGallery({
                selector: '.slick-slide:not(.slick-cloned) a',
                thumbnail: true,
                share: false,
                fullScreen: false,
                autoplay: false,
                autoplayControls: false,
                actualSize: false,
            });
        }
    });
</script>

<script>
    (function () {
        const ensureOverlay = () => {
            let overlay = document.querySelector('.body-overlay-1');

            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'body-overlay-1';
                document.body.prepend(overlay);
            }

            return overlay;
        };

        const attachFallback = () => {
            const burger = document.querySelector('.burger-icon');
            const mobileWrapper = document.querySelector('.mobile-header-active');
            const closeButton = document.querySelector('.mobile-menu-close button');
            const body = document.body;

            if (!burger || !mobileWrapper || burger.dataset.menuFallback === 'attached') {
                return;
            }

            const overlay = ensureOverlay();

            const openMenu = () => {
                mobileWrapper.classList.add('sidebar-visible');
                body.classList.add('mobile-menu-active');
            };

            const closeMenu = () => {
                mobileWrapper.classList.remove('sidebar-visible');
                body.classList.remove('mobile-menu-active');
            };

            burger.addEventListener('click', function (event) {
                event.preventDefault();

                if (mobileWrapper.classList.contains('sidebar-visible')) {
                    closeMenu();
                } else {
                    openMenu();
                }
            });

            closeButton?.addEventListener('click', function (event) {
                event.preventDefault();
                closeMenu();
            });

            overlay.addEventListener('click', function (event) {
                event.preventDefault();
                closeMenu();
            });

            burger.dataset.menuFallback = 'attached';
        };

        document.addEventListener('DOMContentLoaded', attachFallback);
    })();
</script>

{!! Theme::place('footer') !!}

@if (session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
    <script>
        window.onload = function () {
            @if (session()->has('success_msg')) window.showAlert('alert-success', '{{ session('success_msg') }}'); @endif
            @if (session()->has('error_msg')) window.showAlert('alert-danger', '{{ session('error_msg') }}'); @endif
            @if (isset($error_msg)) window.showAlert('alert-danger', '{{ $error_msg }}'); @endif
            @if (isset($errors)) @foreach ($errors->all() as $error) window.showAlert('alert-danger', '{!! BaseHelper::clean($error) !!}'); @endforeach @endif
        };
    </script>
@endif

<div id="scrollUp"><i class="fal fa-long-arrow-up"></i></div>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-WSR5H4YBF2"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'G-WSR5H4YBF2');
</script>


<script>
    console.log("%c Welcome to RUBYSHOP! Footer script loaded.!!", "background: #dc2626; color: #ffffff; font-size: 16px; padding: 8px 16px; border-radius: 4px;");
</script>

<!-- Ruby Slider Tools Script -->
<script>
    console.log("%c Ruby Slider Tools Script Loaded!", "background: #059669; color: #ffffff; font-size: 14px; padding: 6px 12px; border-radius: 4px;");
    
    function initializeRubySlider(sliderId) {
        const root = document.getElementById(sliderId);
        if (!root) {
            return;
        }

        // Check if already initialized to prevent multiple initializations
        if (root.dataset.rubySliderInitialized === 'true') {
            return;
        }

        const sliderTrack = root.querySelector('[data-slider-track]');
        const prevBtn = root.querySelector('[data-slider-prev]');
        const nextBtn = root.querySelector('[data-slider-next]');

        if (!sliderTrack || !prevBtn || !nextBtn) {
            return;
        }

        const totalSlides = sliderTrack.children.length;
        let currentSlide = 0;
        let position = 0;

        const getImagesPerSlide = () => (window.innerWidth < 640 ? 1 : 4);

        const updateSlider = () => {
            const slideWidth = sliderTrack.children[0].offsetWidth;
            position = -currentSlide * slideWidth;
            sliderTrack.style.transform = `translateX(${position}px)`;
            updateButtonStates();
        };

        const updateButtonStates = () => {
            const maxSlideIndex = Math.max(totalSlides - getImagesPerSlide(), 0);
            
            // Disable/enable buttons based on current position
            if (currentSlide <= 0) {
                prevBtn.style.opacity = '0.3';
                prevBtn.style.pointerEvents = 'none';
            } else {
                prevBtn.style.opacity = '1';
                prevBtn.style.pointerEvents = 'auto';
            }
            
            if (currentSlide >= maxSlideIndex) {
                nextBtn.style.opacity = '0.3';
                nextBtn.style.pointerEvents = 'none';
            } else {
                nextBtn.style.opacity = '1';
                nextBtn.style.pointerEvents = 'auto';
            }
        };

        nextBtn.addEventListener('click', () => {
            const maxSlideIndex = Math.max(totalSlides - getImagesPerSlide(), 0);
            if (currentSlide < maxSlideIndex) {
                currentSlide += 1;
                updateSlider();
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentSlide > 0) {
                currentSlide -= 1;
                updateSlider();
            }
        });

        const handleResize = (() => {
            let resizeTimer;
            return () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    // Just update the slider position without changing currentSlide
                    const maxSlideIndex = Math.max(totalSlides - getImagesPerSlide(), 0);
                    if (currentSlide > maxSlideIndex) {
                        currentSlide = maxSlideIndex;
                    }
                    updateSlider();
                }, 200);
            };
        })();

        window.addEventListener('resize', handleResize);

        let touchStartX = 0;
        let touchEndX = 0;

        sliderTrack.addEventListener(
            'touchstart',
            (event) => {
                touchStartX = event.changedTouches[0].screenX;
            },
            { passive: true }
        );

        sliderTrack.addEventListener(
            'touchend',
            (event) => {
                touchEndX = event.changedTouches[0].screenX;
                const maxSlideIndex = Math.max(totalSlides - getImagesPerSlide(), 0);
                
                if (touchEndX < touchStartX - 50) {
                    if (currentSlide < maxSlideIndex) {
                        currentSlide += 1;
                        updateSlider();
                    }
                } else if (touchEndX > touchStartX + 50) {
                    if (currentSlide > 0) {
                        currentSlide -= 1;
                        updateSlider();
                    }
                }
            },
            { passive: true }
        );

        // Mark as initialized and run initial setup
        updateSlider();
        root.dataset.rubySliderInitialized = 'true';
    }

    // Auto-initialize all Ruby Sliders when DOM is ready
    function initializeAllRubySliders() {
        const sliders = document.querySelectorAll('[id^="ruby-slider-tools-"]:not([data-ruby-slider-initialized="true"])');
        
        sliders.forEach(slider => {
            initializeRubySlider(slider.id);
        });
    }

    // Initialize only once when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeAllRubySliders);
    } else {
        initializeAllRubySliders();
    }

    // Check for new sliders less frequently and only for uninitialized ones
    setInterval(() => {
        const uninitializedSliders = document.querySelectorAll('[id^="ruby-slider-tools-"]:not([data-ruby-slider-initialized="true"])');
        if (uninitializedSliders.length > 0) {
            initializeAllRubySliders();
        }
    }, 5000);
</script>

<!-- Ruby Fade Animation Script -->
<script>
    console.log("%c Ruby Fade Animation Script Loaded!", "background: #059669; color: #ffffff; font-size: 14px; padding: 6px 12px; border-radius: 4px;");
    
    function initializeRubyFadeAnimation() {
        // Only run if Intersection Observer is supported
        if ('IntersectionObserver' in window) {
            
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        // Add animation class when card comes into view
                        entry.target.classList.add('animate-fade');
                    } else {
                        // Remove animation class when card goes out of view (optional)
                        entry.target.classList.remove('animate-fade');
                    }
                });
            }, {
                threshold: 0.2, // Trigger when 20% of the element is visible
                rootMargin: '50px' // Start animation 50px before element enters viewport
            });
            
            // Observe all ruby-fade-card elements
            const fadeCards = document.querySelectorAll('.ruby-fade-card');
            fadeCards.forEach(function(card) {
                // Mark as initialized to prevent re-observation
                if (!card.dataset.fadeObserverInitialized) {
                    observer.observe(card);
                    card.dataset.fadeObserverInitialized = 'true';
                }
            });
            
        } else {
            // Fallback: Just add animate class to all cards
            const fadeCards = document.querySelectorAll('.ruby-fade-card');
            fadeCards.forEach(function(card) {
                card.classList.add('animate-fade');
            });
        }
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeRubyFadeAnimation);
    } else {
        initializeRubyFadeAnimation();
    }
    
    // Re-check for new fade cards every 3 seconds
    setInterval(() => {
        const uninitializedCards = document.querySelectorAll('.ruby-fade-card:not([data-fade-observer-initialized="true"])');
        if (uninitializedCards.length > 0) {
            initializeRubyFadeAnimation();
        }
    }, 3000);
</script>

<!-- Hero Banner Skeleton Handler Script -->
<script>
    console.log("%c Hero Skeleton Handler Loaded!", "background: #059669; color: #ffffff; font-size: 14px; padding: 6px 12px; border-radius: 4px;");
    
    function forceShowHeroContent() {
        // Find all hero sections and force show content
        const heroSections = document.querySelectorAll('.hero-banner101-ruby');
        
        heroSections.forEach(function(heroSection) {
            const heroMain = heroSection.querySelector('.hero-banner101-ruby__main');
            const heroSkeleton = heroSection.querySelector('.hero-skeleton');
            
            if (heroMain && heroSkeleton) {
                // Force show content
                heroSkeleton.style.display = 'none';
                heroMain.style.opacity = '1';
                heroMain.classList.add('loaded');
            }
        });
    }
    
    function initHeroSkeletonHandler() {
        // Wait for DOM to be ready
        setTimeout(function() {
            const heroSections = document.querySelectorAll('.hero-banner101-ruby');
            
            heroSections.forEach(function(heroSection, index) {
                const heroMain = heroSection.querySelector('.hero-banner101-ruby__main');
                const heroSkeleton = heroSection.querySelector('.hero-skeleton');
                const heroImage = heroSection.querySelector('.hero-image');
                
                if (!heroMain || !heroSkeleton) return;
                
                // Mark as processing
                if (heroSection.dataset.skeletonProcessed === 'true') return;
                heroSection.dataset.skeletonProcessed = 'true';
                
                let contentShown = false;
                
                function showContent() {
                    if (contentShown) return;
                    contentShown = true;
                    
                    heroSkeleton.style.transition = 'opacity 0.3s ease';
                    heroSkeleton.style.opacity = '0';
                    heroMain.style.opacity = '1';
                    heroMain.classList.add('loaded');
                    
                    setTimeout(function() {
                        heroSkeleton.style.display = 'none';
                    }, 300);
                }
                
                // Force show after 1 second regardless of image status
                setTimeout(showContent, 1000);
                
                // Try to detect image load if image exists
                if (heroImage) {
                    if (heroImage.complete || heroImage.naturalWidth > 0) {
                        setTimeout(showContent, 100);
                    } else {
                        heroImage.addEventListener('load', showContent);
                        heroImage.addEventListener('error', showContent);
                    }
                } else {
                    // No image, show immediately
                    setTimeout(showContent, 100);
                }
            });
        }, 100);
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHeroSkeletonHandler);
    } else {
        initHeroSkeletonHandler();
    }
    
    // Re-run periodically to catch dynamically added hero sections
    setInterval(initHeroSkeletonHandler, 2000);
    
    // Emergency fallback - force show all content after 3 seconds
    setTimeout(forceShowHeroContent, 3000);
</script>

<!-- Feature Cards Skeleton Handler Script -->
<script>
    console.log("%c Feature Cards Skeleton Handler Loaded!", "background: #059669; color: #ffffff; font-size: 14px; padding: 6px 12px; border-radius: 4px;");
    
    function forceShowFeatureCards() {
        // Find all feature card sections and force show content
        const featureSections = document.querySelectorAll('.ruby-feature-cards');
        
        featureSections.forEach(function(featureSection) {
            const featureMain = featureSection.querySelector('.ruby-feature-cards__main');
            const featureSkeleton = featureSection.querySelector('.feature-cards-skeleton');
            
            if (featureMain && featureSkeleton) {
                // Force show content
                featureSkeleton.style.display = 'none';
                featureMain.style.opacity = '1';
                featureMain.classList.add('loaded');
            }
        });
    }
    
    function initFeatureCardsSkeletonHandler() {
        // Wait for DOM to be ready
        setTimeout(function() {
            const featureSections = document.querySelectorAll('.ruby-feature-cards');
            
            featureSections.forEach(function(featureSection, index) {
                const featureMain = featureSection.querySelector('.ruby-feature-cards__main');
                const featureSkeleton = featureSection.querySelector('.feature-cards-skeleton');
                const featureImages = featureSection.querySelectorAll('.feature-card-image');
                
                if (!featureMain || !featureSkeleton) return;
                
                // Mark as processing
                if (featureSection.dataset.skeletonProcessed === 'true') return;
                featureSection.dataset.skeletonProcessed = 'true';
                
                let contentShown = false;
                
                function showContent() {
                    if (contentShown) return;
                    contentShown = true;
                    
                    featureSkeleton.style.transition = 'opacity 0.3s ease';
                    featureSkeleton.style.opacity = '0';
                    featureMain.style.opacity = '1';
                    featureMain.classList.add('loaded');
                    
                    setTimeout(function() {
                        featureSkeleton.style.display = 'none';
                    }, 300);
                }
                
                // Force show after 1.5 seconds regardless of image status
                setTimeout(showContent, 1500);
                
                // Try to detect image loads if images exist
                if (featureImages.length > 0) {
                    let imagesLoaded = 0;
                    let totalImages = featureImages.length;
                    
                    function checkAllImagesLoaded() {
                        imagesLoaded++;
                        if (imagesLoaded >= totalImages) {
                            setTimeout(showContent, 100);
                        }
                    }
                    
                    featureImages.forEach(function(img) {
                        if (img.complete || img.naturalWidth > 0) {
                            checkAllImagesLoaded();
                        } else {
                            img.addEventListener('load', checkAllImagesLoaded);
                            img.addEventListener('error', checkAllImagesLoaded);
                        }
                    });
                } else {
                    // No images, show after short delay
                    setTimeout(showContent, 200);
                }
            });
        }, 100);
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFeatureCardsSkeletonHandler);
    } else {
        initFeatureCardsSkeletonHandler();
    }
    
    // Re-run periodically to catch dynamically added feature card sections
    setInterval(initFeatureCardsSkeletonHandler, 2000);
    
    // Emergency fallback - force show all feature cards after 4 seconds
    setTimeout(forceShowFeatureCards, 4000);
</script>

<!-- Fade Section Skeleton Handler Script -->
<script>
    console.log("%c Fade Section Skeleton Handler Loaded!", "background: #059669; color: #ffffff; font-size: 14px; padding: 6px 12px; border-radius: 4px;");
    
    function forceShowFadeSections() {
        // Find all fade sections and force show content
        const fadeSections = document.querySelectorAll('.ruby-fade-section');
        
        fadeSections.forEach(function(fadeSection) {
            const fadeMain = fadeSection.querySelector('.ruby-fade-section__main');
            const fadeSkeleton = fadeSection.querySelector('.fade-section-skeleton');
            
            if (fadeMain && fadeSkeleton) {
                // Force show content
                fadeSkeleton.style.display = 'none';
                fadeMain.style.opacity = '1';
                fadeMain.classList.add('loaded');
            }
        });
    }
    
    function initFadeSectionSkeletonHandler() {
        // Wait for DOM to be ready
        setTimeout(function() {
            const fadeSections = document.querySelectorAll('.ruby-fade-section');
            
            fadeSections.forEach(function(fadeSection, index) {
                const fadeMain = fadeSection.querySelector('.ruby-fade-section__main');
                const fadeSkeleton = fadeSection.querySelector('.fade-section-skeleton');
                const fadeImage = fadeSection.querySelector('.fade-bg-image');
                
                if (!fadeMain || !fadeSkeleton) return;
                
                // Mark as processing
                if (fadeSection.dataset.skeletonProcessed === 'true') return;
                fadeSection.dataset.skeletonProcessed = 'true';
                
                let contentShown = false;
                
                function showContent() {
                    if (contentShown) return;
                    contentShown = true;
                    
                    fadeSkeleton.style.transition = 'opacity 0.3s ease';
                    fadeSkeleton.style.opacity = '0';
                    fadeMain.style.opacity = '1';
                    fadeMain.classList.add('loaded');
                    
                    setTimeout(function() {
                        fadeSkeleton.style.display = 'none';
                    }, 300);
                }
                
                // Force show after 1.2 seconds regardless of image status
                setTimeout(showContent, 1200);
                
                // Try to detect image load if image exists
                if (fadeImage) {
                    if (fadeImage.complete || fadeImage.naturalWidth > 0) {
                        setTimeout(showContent, 100);
                    } else {
                        fadeImage.addEventListener('load', showContent);
                        fadeImage.addEventListener('error', showContent);
                    }
                } else {
                    // No image, show after short delay
                    setTimeout(showContent, 200);
                }
            });
        }, 100);
    }
    
    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFadeSectionSkeletonHandler);
    } else {
        initFadeSectionSkeletonHandler();
    }
    
    // Re-run periodically to catch dynamically added fade sections
    setInterval(initFadeSectionSkeletonHandler, 2000);
    
    // Emergency fallback - force show all fade sections after 3.5 seconds
    setTimeout(forceShowFadeSections, 3500);
</script>


<!-- Messenger Float Button -->
<a href="https://m.me/816184855086392" target="_blank" rel="noopener noreferrer" id="messenger-float-btn" title="Chat with us on Messenger" style="position:fixed;bottom:24px;right:24px;width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#0695FF,#A334FA,#FF6968);display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,0.25);z-index:9998;text-decoration:none;transition:transform 0.3s,box-shadow 0.3s;">
    <svg width="32" height="32" viewBox="0 0 36 36" fill="white" xmlns="http://www.w3.org/2000/svg"><path d="M18 3C9.716 3 3 9.146 3 16.5c0 4.243 2.117 8.025 5.42 10.504V33l5.783-3.175c1.217.338 2.508.525 3.797.525 8.284 0 15-6.146 15-13.5S26.284 3 18 3zm1.488 18.182l-3.822-4.08-7.46 4.08 8.2-8.707 3.915 4.08 7.367-4.08-8.2 8.707z"/></svg>
</a>

</body>
</html>
