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

        if (window.jQuery) {
            window.jQuery(burger).off('click');
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

(function () {
    const currentScript = document.currentScript;
    const isBlogPage = currentScript && currentScript.dataset.isBlogPage === '1';
    const nonCriticalStyles = [
        'https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css',
        'https://unpkg.com/aos@2.3.1/dist/aos.css',
    ];

    const loadNonCriticalStyles = function () {
        if (window.__rubyshopNonCriticalCssLoaded) {
            return;
        }

        window.__rubyshopNonCriticalCssLoaded = true;
        nonCriticalStyles.forEach(function (href) {
            if (document.querySelector('link[href="' + href + '"]')) {
                return;
            }

            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = href;
            document.head.appendChild(link);
        });
    };

    const scheduleNonCriticalStyles = function () {
        if (!isBlogPage) {
            return;
        }

        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadNonCriticalStyles, { timeout: 2500 });
        } else {
            setTimeout(loadNonCriticalStyles, 1200);
        }
    };

    if (document.readyState === 'complete') {
        scheduleNonCriticalStyles();
    } else {
        window.addEventListener('load', scheduleNonCriticalStyles, { once: true });
    }

    const gtagIds = ['G-NHBT4DYH7D', 'AW-1065750118'];

    const loadAnalytics = function () {
        if (window.__rubyshopAnalyticsLoaded) {
            return;
        }

        window.__rubyshopAnalyticsLoaded = true;
        window.dataLayer = window.dataLayer || [];
        window.gtag = window.gtag || function () { dataLayer.push(arguments); };
        window.gtag('js', new Date());

        gtagIds.forEach(function (id) {
            window.gtag('config', id);
        });

        window.gtag('event', 'conversion', { send_to: 'AW-1065750118/hV8kCIyViPkCEOacmPwD' });

        const ga = document.createElement('script');
        ga.async = true;
        ga.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(gtagIds[0]);
        document.head.appendChild(ga);
    };

    const loadPixel = function () {
        if (window.fbq) {
            return;
        }

        !function(f, b, e, v, n, t, s) {
            if (f.fbq) return; n = f.fbq = function() {
                n.callMethod ? n.callMethod.apply(n, arguments) : n.queue.push(arguments);
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = true;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = true;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s);
        }(window, document, 'script', 'https://connect.facebook.net/en_US/fbevents.js');

        fbq('init', '1559144322039457');
        fbq('track', 'PageView');
    };

    const loadTrackers = function () {
        loadAnalytics();
        loadPixel();
    };

    const scheduleTrackers = function () {
        if ('requestIdleCallback' in window) {
            requestIdleCallback(loadTrackers, { timeout: 8000 });
        } else {
            setTimeout(loadTrackers, 8000);
        }
    };

    let trackerScheduled = false;
    const triggerTrackers = function () {
        if (trackerScheduled) {
            return;
        }

        trackerScheduled = true;
        scheduleTrackers();
    };

    ['scroll', 'click', 'keydown', 'touchstart'].forEach(function (eventName) {
        window.addEventListener(eventName, triggerTrackers, { once: true, passive: true });
    });

    if (document.readyState === 'complete') {
        setTimeout(triggerTrackers, 12000);
    } else {
        window.addEventListener('load', function () {
            setTimeout(triggerTrackers, 12000);
        }, { once: true });
    }
})();

function initializeRubySlider(sliderId) {
    const root = document.getElementById(sliderId);
    if (!root) {
        return;
    }

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

    updateSlider();
    root.dataset.rubySliderInitialized = 'true';
}

function initializeAllRubySliders() {
    const sliders = document.querySelectorAll('[id^="ruby-slider-tools-"]:not([data-ruby-slider-initialized="true"])');

    sliders.forEach((slider) => {
        initializeRubySlider(slider.id);
    });
}

function initializeRubySlidersLazy() {
    const sliders = document.querySelectorAll('[id^="ruby-slider-tools-"]:not([data-ruby-slider-initialized="true"])');

    if (!sliders.length) {
        return;
    }

    if (!('IntersectionObserver' in window)) {
        initializeAllRubySliders();
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) {
                return;
            }

            initializeRubySlider(entry.target.id);
            observer.unobserve(entry.target);
        });
    }, { rootMargin: '200px 0px' });

    sliders.forEach((slider) => {
        observer.observe(slider);
    });

    let forcedInitDone = false;
    const forceInit = () => {
        if (forcedInitDone) {
            return;
        }

        forcedInitDone = true;
        initializeAllRubySliders();
    };

    ['scroll', 'touchstart', 'click'].forEach((eventName) => {
        window.addEventListener(eventName, forceInit, { once: true, passive: true });
    });

    setTimeout(forceInit, 10000);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeRubySlidersLazy);
} else {
    initializeRubySlidersLazy();
}

function initializeRubyFadeAnimation() {
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fade');
                } else {
                    entry.target.classList.remove('animate-fade');
                }
            });
        }, {
            threshold: 0.2,
            rootMargin: '50px'
        });

        const fadeCards = document.querySelectorAll('.ruby-fade-card');
        fadeCards.forEach(function(card) {
            if (!card.dataset.fadeObserverInitialized) {
                observer.observe(card);
                card.dataset.fadeObserverInitialized = 'true';
            }
        });
    } else {
        const fadeCards = document.querySelectorAll('.ruby-fade-card');
        fadeCards.forEach(function(card) {
            card.classList.add('animate-fade');
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeRubyFadeAnimation);
} else {
    initializeRubyFadeAnimation();
}

(function () {
    'use strict';

    var DD = {
        log: function() { console.log.apply(console, ['[FLY]'].concat(Array.from(arguments))); },
        warn: function() { console.warn.apply(console, ['[FLY]'].concat(Array.from(arguments))); }
    };

    document.addEventListener('DOMContentLoaded', function () {
        var wrap = document.querySelector('.categories-dropdown-wrap');
        if (!wrap) { return; }

        var hideTimer = null;
        var activeLi = null;

        function positionMenu(li, menu) {
            menu.style.visibility = 'hidden';
            menu.style.display = 'block';
            var menuH = menu.offsetHeight;
            var menuW = menu.offsetWidth;
            menu.style.display = '';
            menu.style.visibility = '';

            var rect = li.getBoundingClientRect();
            var vw = window.innerWidth;
            var vh = window.innerHeight;

            var left = rect.right;
            var top = rect.top;
            var flippedH = false, flippedV = false;

            if (left + menuW > vw) { left = Math.max(0, rect.left - menuW); flippedH = true; }
            if (top + menuH > vh) { top = Math.max(0, vh - menuH - 8); flippedV = true; }

            menu.style.left = left + 'px';
            menu.style.top = top + 'px';

            DD.log('positionMenu "' + li.innerText.trim().slice(0,20) + '"',
                'li.rect={top:' + Math.round(rect.top) + ',right:' + Math.round(rect.right) + ',bottom:' + Math.round(rect.bottom) + '}',
                'menu={w:' + menuW + ',h:' + menuH + '}',
                '\u2192 left=' + Math.round(left) + ' top=' + Math.round(top),
                flippedH ? '\u2b05 flipped-left' : '',
                flippedV ? '\u2b06 flipped-up' : ''
            );
        }

        function show(li) {
            clearTimeout(hideTimer);
            var label = '"' + li.innerText.trim().slice(0,20) + '"';

            if (li === activeLi) {
                DD.log('show', label, '\u2014 already active, skip');
                return;
            }

            if (activeLi && activeLi !== li) {
                DD.log('switching away from', '"' + activeLi.innerText.trim().slice(0,20) + '"');
                activeLi.classList.remove('is-active');
            }
            var menu = li.querySelector(':scope > .dropdown-menu');
            DD.log('show', label, '| menu found:', !!menu);
            if (menu) {
                positionMenu(li, menu);
                var cs = getComputedStyle(menu);
                DD.log('  menu after position: display=' + cs.display + ' left=' + menu.style.left + ' top=' + menu.style.top + ' w=' + cs.width + ' h=' + cs.height);
            }
            li.classList.add('is-active');
            activeLi = li;
        }

        function hide(li) {
            clearTimeout(hideTimer);
            var label = '"' + li.innerText.trim().slice(0,20) + '"';
            DD.log('hide scheduled for', label, '(120ms)');
            hideTimer = setTimeout(function () {
                DD.log('hide EXECUTED for', label);
                li.classList.remove('is-active');
                if (activeLi === li) { activeLi = null; }
            }, 120);
        }

        wrap.addEventListener('mouseenter', function (e) {
            var li = e.target.closest && e.target.closest('li.has-children');
            if (li && wrap.contains(li) && !li.closest('.dropdown-menu')) {
                DD.log('mouseenter li', '"' + li.innerText.trim().slice(0,20) + '"');
                show(li);
            }
        }, true);

        wrap.addEventListener('mouseleave', function (e) {
            var li = e.target.closest && e.target.closest('li.has-children');
            if (li && wrap.contains(li) && !li.closest('.dropdown-menu')) {
                DD.log('mouseleave li', '"' + li.innerText.trim().slice(0,20) + '"');
                hide(li);
            }
        }, true);

        document.addEventListener('mouseover', function (e) {
            if (!activeLi) { return; }
            var menu = activeLi.querySelector(':scope > .dropdown-menu');
            if (menu && menu.contains(e.target)) {
                DD.log('mouse ENTERED flyout \u2192 cancel hide');
                clearTimeout(hideTimer);
            }
        });
        document.addEventListener('mouseout', function (e) {
            if (!activeLi) { return; }
            var menu = activeLi.querySelector(':scope > .dropdown-menu');
            if (menu && menu.contains(e.target) && !menu.contains(e.relatedTarget)) {
                DD.log('mouse LEFT flyout \u2192 schedule hide');
                hide(activeLi);
            }
        });
    });
}());

(function () {
    'use strict';

    window.addEventListener('load', function () {
        var $ = window.jQuery;
        if (!$ || !$.fn) { return; }

        setTimeout(function () {
            var $win = $(window);
            var $header = $('header.header-area');

            try {
                var eventsData = $._data(window, 'events');
                if (!eventsData || !eventsData.scroll) { return; }

                var originalHandlers = eventsData.scroll.slice();
                $win.off('scroll');

                originalHandlers.forEach(function (h) {
                    $win.on('scroll', function (e) {
                        var $dropdown = $header.find('.categories-dropdown-active-large');
                        var $button = $header.find('.categories-button-active');
                        var wasOpen = $dropdown.hasClass('open');

                        h.handler.call(this, e);

                        if (wasOpen && !$dropdown.hasClass('open')) {
                            $dropdown.addClass('open');
                            $button.addClass('open');
                        }
                    });
                });
            } catch (e) { /* silent fail */ }
        }, 500);
    });
}());
