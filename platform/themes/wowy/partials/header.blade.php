<!DOCTYPE html>
<html {!! Theme::htmlAttributes() !!}>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        
        <!-- Resource Hints for Performance -->
        <link rel="preconnect" href="https://cdn.tailwindcss.com">
        <link rel="preconnect" href="https://cdn.jsdelivr.net">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        
        <!-- Critical CSS loaded first -->
        <script src="https://cdn.tailwindcss.com"></script>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Non-critical CSS loaded asynchronously -->
        <link rel="preload" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"></noscript>
        
        <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"></noscript>
        
        <link rel="preload" href="https://unpkg.com/aos@2.3.1/dist/aos.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css"></noscript>
            
     <!-- Event snippet for โอกาสในการขายทางโทรศัพท์ conversion page -->
<script>
  gtag('event', 'conversion', {'send_to': 'AW-1065750118/hV8kCIyViPkCEOacmPwD'});
</script>

        <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-0PWGSWH0P4"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-0PWGSWH0P4');
</script>











<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-VMWVKYGZ6X"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-VMWVKYGZ6X');
</script>








<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1073208261615128');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1073208261615128&ev=PageView&noscript=1"
/></noscript>
<!-- End Meta Pixel Code -->



<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-NHBT4DYH7D"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-NHBT4DYH7D');
</script>









                <!-- Force LocalBusiness Schema on Homepage -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "LocalBusiness",
            "name": "RUBYSHOP",
            "alternateName": "รูบี้ช๊อป",
            "description": "ศูนย์รวมเครื่องมือช่าง อุปกรณ์ก่อสร้าง และเทคโนโลยีงานช่างครบวงจร - พ่นปูน, พ่นสีแรงดันสูง, กรีดผนังเซาะร่อง, ฉีดโพม, กันซึม",
            "image": "https://www.rubyshop.co.th/logo.png",
            "@id": "https://www.rubyshop.co.th/",
            "url": "https://www.rubyshop.co.th/",
            "telephone": "+66-89-666-7802",
            "email": "info@rubyshop.co.th",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "9 ถนนประชาอุทิศ แขวงสีกัน เขตดอนเมือง",
                "addressLocality": "เขตดอนเมือง",
                "addressRegion": "กรุงเทพมหานคร",
                "postalCode": "10210",
                "addressCountry": "TH"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": 14.0273154,
                "longitude": 100.1725207
            },
            "openingHoursSpecification": [{
                "@type": "OpeningHoursSpecification",
                "dayOfWeek": ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
                "opens": "08:30",
                "closes": "17:30"
            }],
            "sameAs": [
                "https://www.facebook.com/photo/?fbid=707251024751513&set=a.432474452229173",
                "https://maps.app.goo.gl/8QtWpT29vT1Rspgq8",
                "https://www.instagram.com/rubyshop_thailand",
                "https://www.youtube.com/@rubyshop-thailand"
            ],
            "priceRange": "฿฿",
            "paymentAccepted": ["Cash", "Credit Card", "Bank Transfer"],
            "currenciesAccepted": "THB"
        }
        </script>




        {!! BaseHelper::googleFonts('https://fonts.googleapis.com/css2?family=' . urlencode(theme_option('font_text', 'Poppins')) . ':ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap') !!}

        <style>
            :root {
                --font-text: {{ theme_option('font_text', 'Poppins') }}, sans-serif;
                --color-brand: {{ theme_option('color_brand', '#5897fb') }};
                --primary-color: {{ theme_option('color_brand', '#5897fb') }};
                --color-brand-2: {{ theme_option('color_brand_2', '#3256e0') }};
                --color-primary: {{ theme_option('color_primary', '#3f81eb') }};
                --color-secondary: {{ theme_option('color_secondary', '#41506b') }};
                --color-warning: {{ theme_option('color_warning', '#ffb300') }};
                --color-danger: {{ theme_option('color_danger', '#ff3551') }};
                --color-success: {{ theme_option('color_success', '#3ed092') }};
                --color-info: {{ theme_option('color_info', '#18a1b7') }};
                --color-text: {{ theme_option('color_text', '#4f5d77') }};
                --color-heading: {{ theme_option('color_heading', '#222222') }};
                --color-grey-1: {{ theme_option('color_grey_1', '#111111') }};
                --color-grey-2: {{ theme_option('color_grey_2', '#242424') }};
                --color-grey-4: {{ theme_option('color_grey_4', '#90908e') }};
                --color-grey-9: {{ theme_option('color_grey_9', '#f4f5f9') }};
                --color-muted: {{ theme_option('color_muted', '#8e8e90') }};
                --color-body: {{ theme_option('color_body', '#4f5d77') }};
            }

            /* Mobile Menu Styles */
            .mobile-header-active {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: white;
                z-index: 9999;
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                overflow-y: auto;
                visibility: hidden;
                opacity: 0;
                display: none;
            }

            .mobile-header-active.sidebar-visible {
                transform: translateX(0);
                visibility: visible;
                opacity: 1;
                display: block !important;
            }

            .body-overlay-1 {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100vh;
                background: rgba(0, 0, 0, 0.5);
                z-index: 9998;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            body.mobile-menu-active .body-overlay-1 {
                opacity: 1;
                visibility: visible;
            }

            /* Hamburger Menu Animation */
            .burger-icon {
                cursor: pointer;
                padding: 8px;
                position: relative;
                z-index: 10000;
                display: flex !important;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                background: rgba(0,0,0,0.1);
                border-radius: 4px;
                transition: background 0.2s ease;
            }

            .burger-icon:hover {
                background: rgba(0,0,0,0.2);
            }

            .burger-icon span,
            .burger-icon .burger-icon-top,
            .burger-icon .burger-icon-mid,
            .burger-icon .burger-icon-bottom {
                display: block;
                width: 24px;
                height: 2px;
                background: white;
                margin: 3px 0;
                transition: all 0.3s ease;
                transform-origin: center;
            }

            .burger-icon.active .burger-icon-top {
                transform: rotate(45deg) translate(5px, 5px);
                background: #333;
            }

            .burger-icon.active .burger-icon-mid {
                opacity: 0;
                transform: scale(0);
            }

            .burger-icon.active .burger-icon-bottom {
                transform: rotate(-45deg) translate(7px, -6px);
                background: #333;
            }

            /* Additional Mobile Menu Styles */
            .mobile-header-wrapper-inner {
                padding: 20px;
                height: 100%;
                overflow-y: auto;
            }

            .mobile-menu-close {
                position: absolute;
                top: 15px;
                right: 15px;
                z-index: 10001;
            }

            /* Reverse menu order in mobile */
            @media (max-width: 991px) {
                .mobile-header-content-area {
                    display: flex;
                    flex-direction: column;
                }
                
                .mobile-menu-wrap {
                    order: 1;
                }
                
                .mobile-search {
                    order: 2;
                }
                
                .mobile-social-icon {
                    order: 3;
                    margin: 20px 0;
                }
                
                .mobile-header-info-wrap {
                    order: 4 !important;
                    margin-bottom: 20px;
                }
                
                /* Make sure info section goes to bottom */
                .mobile-header-wrapper-inner {
                    display: flex;
                    flex-direction: column;
                    min-height: calc(100vh - 40px);
                }
                
                .mobile-header-content-area {
                    flex: 1;
                    display: flex;
                    flex-direction: column;
                }
                
                /* Push user info to bottom with margin-top auto */
                .mobile-header-info-wrap {
                    margin-top: auto !important;
                }
                
                /* Reverse the navigation menu items order */
                .mobile-menu-wrap nav ul.mobile-menu {
                    display: flex !important;
                    flex-direction: column-reverse;
                }
                
                .mobile-menu-wrap .mobile-menu li {
                    order: initial;
                }
            }

             .imgMixBlendMode {
    mix-blend-mode: multiply;
}




            /* Ensure mobile menu is hidden on desktop */
            @media (min-width: 992px) {
                .mobile-header-active {
                    display: none !important;
                }
                .body-overlay-1 {
                    display: none !important;
                }
            }

            /* Force mobile menu to work properly */
            @media (max-width: 991px) {
                .mobile-header-active {
                    display: block;
                }
                
                .burger-icon {
                    display: flex !important;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                }
                
                /* Hide Browse Categories in mobile */
                .mobile-header-active .main-categories-wrap {
                    display: none !important;
                }
            }
             p{
                margin-bottom: -24px !important;
            }         
            .header-bottom .header-wrap {
                display: flex;
                align-items: center;
                gap: 24px;
            }

            .header-bottom .main-menu {
                flex: 1 1 auto;
                min-width: 0;
            }

            .header-bottom .main-categories-wrap,
            .header-bottom .hotline {
                flex-shrink: 0;
            }

            .header-bottom .main-menu > nav > ul {
                display: flex;
                align-items: center;
                gap: 28px;
                justify-content: center;
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .header-bottom .main-menu > nav > ul > li > a {
                white-space: nowrap;
            }

            @media (min-width: 992px) and (max-width: 1250px) {
                .header-bottom .header-wrap {
                    gap: 12px;
                }

                .header-bottom .main-menu > nav > ul {
                    gap: 16px;
                }

                .header-bottom .main-menu > nav > ul > li > a {
                    font-size: 14px;
                    padding: 6px 0;
                }

                .header-bottom .hotline p span {
                    display: none;
                }

                .header-bottom .hotline p {
                    font-size: 0.95rem;
                }
            }

            .header-bottom .hotline {
                display: flex;
                align-items: center;
                height: 100%;
            }

            .header-bottom .hotline p {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                margin: 0;
                line-height: 1.4;
            }
        </style>

        {!! Theme::header() !!}

        @php
            $headerStyle = theme_option('header_style') ?: '';
            $page = Theme::get('page');
            if ($page) {
                $headerStyle = $page->getMetaData('header_style', true) ?: $headerStyle;
            }
            $headerStyle = ($headerStyle && in_array($headerStyle, array_keys(get_layout_header_styles()))) ? $headerStyle : '';
        
        
            
        
        
            @endphp
        <script>
    // Performance monitoring for first page load
    const startTime = performance.now();
    const loadStartTime = Date.now();
    
    console.log("%c RUBYSHOP Performance Monitor Started", "background: #dc2626; color: #ffffff; font-size: 16px; padding: 8px 16px; border-radius: 4px; font-weight: bold;");
    console.log("%c Page Load Start Time:", "background: #3b82f6; color: white; padding: 4px 8px; border-radius: 4px;", new Date(loadStartTime).toLocaleTimeString());

    // Track script loading
    const scriptTracker = {
        scripts: [],
        startTime: performance.now(),
        
        logScript: function(name, timing) {
            const elapsed = performance.now() - this.startTime;
            this.scripts.push({
                name: name,
                timing: timing,
                elapsed: elapsed
            });
            console.log(`%c Script: ${name}`, "background: #10b981; color: white; padding: 2px 6px; border-radius: 3px;", `+${elapsed.toFixed(2)}ms`);
        },
        
        getSummary: function() {
            return this.scripts;
        }
    };

    // Performance observer for tracking resources
    if ('PerformanceObserver' in window) {
        const observer = new PerformanceObserver((list) => {
            list.getEntries().forEach((entry) => {
                if (entry.entryType === 'resource') {
                    const duration = entry.responseEnd - entry.startTime;
                    const filename = entry.name.split('/').pop();
                    
                    // Track slow resources with more detail
                    if (duration > 100) {
                        const isTrackingScript = entry.name.includes('collect') || 
                                               entry.name.includes('analytics') || 
                                               entry.name.includes('gtag') ||
                                               entry.name.includes('google');
                        
                        criticalResourceManager.slowResources.push({
                            name: filename,
                            duration: duration,
                            type: entry.initiatorType,
                            url: entry.name,
                            isTracking: isTrackingScript
                        });
                        
                        // Color-code by severity and type
                        let color = duration > 2000 ? '#dc2626' : duration > 1000 ? '#f59e0b' : '#6b7280';
                        if (isTrackingScript) {
                            color = '#8b5cf6'; // Purple for tracking scripts
                            console.log(`%c Tracking ${entry.initiatorType}: ${filename}`, `background: ${color}; color: white; padding: 2px 6px; border-radius: 3px;`, `${duration.toFixed(2)}ms - This is normal for analytics`);
                        } else {
                            console.log(`%c Slow ${entry.initiatorType}: ${filename}`, `background: ${color}; color: white; padding: 2px 6px; border-radius: 3px;`, `${duration.toFixed(2)}ms`);
                        }
                        
                        // Auto-optimize slow images
                        if (entry.initiatorType === 'img' && duration > 1000) {
                            setTimeout(() => {
                                const img = document.querySelector(`img[src*="${filename}"]`);
                                if (img && !img.loading) {
                                    img.loading = 'lazy';
                                    img.decoding = 'async';
                                }
                            }, 100);
                        }
                    }
                } else if (entry.entryType === 'navigation') {
                    console.log(`%c Navigation: ${entry.type}`, "background: #8b5cf6; color: white; padding: 2px 6px; border-radius: 3px;", `${entry.loadEventEnd.toFixed(2)}ms`);
                }
            });
        });
        
        observer.observe({ entryTypes: ['resource', 'navigation'] });
    }

    // Track initial scripts
    scriptTracker.logScript('Performance Monitor', 'Initialization');

    // Critical Resource Manager for slow images
    const criticalResourceManager = {
        slowResources: [],
        
        optimizeSlowImages: function() {
            // Find and optimize slow-loading images
            const images = document.querySelectorAll('img');
            images.forEach(img => {
                if (!img.loading) {
                    img.loading = 'lazy';
                }
                if (!img.decoding) {
                    img.decoding = 'async';
                }
            });
        },
        
        preloadCriticalImages: function() {
            // Preload only critical above-the-fold images
            const criticalImages = [
                'logo',
                'hero',
                'banner'
            ];
            
            criticalImages.forEach(keyword => {
                const img = document.querySelector(`img[src*="${keyword}"], img[alt*="${keyword}"]`);
                if (img && !img.dataset.preloaded) {
                    const link = document.createElement('link');
                    link.rel = 'preload';
                    link.as = 'image';
                    link.href = img.src;
                    document.head.appendChild(link);
                    img.dataset.preloaded = 'true';
                }
            });
        },
        
        deferNonCriticalResources: function() {
            // Defer non-critical scripts and resources
            const nonCriticalScripts = document.querySelectorAll('script:not([data-critical])');
            nonCriticalScripts.forEach(script => {
                if (!script.defer && !script.async && script.src) {
                    script.defer = true;
                }
            });
        },
        
        optimizeThirdPartyScripts: function() {
            // Defer Google Analytics and other tracking scripts
            const trackingScripts = document.querySelectorAll('script[src*="google"], script[src*="analytics"], script[src*="gtag"]');
            trackingScripts.forEach(script => {
                if (script.src && !script.defer && !script.async) {
                    script.defer = true;
                    console.log('Deferred tracking script:', script.src);
                }
            });
            
            // Add resource hints for known third-party domains
            const thirdPartyDomains = [
                'https://www.google-analytics.com',
                'https://www.googletagmanager.com',
                'https://connect.facebook.net',
                'https://cdn.jsdelivr.net',
                'https://cdnjs.cloudflare.com'
            ];
            
            thirdPartyDomains.forEach(domain => {
                if (!document.querySelector(`link[href*="${domain}"]`)) {
                    const link = document.createElement('link');
                    link.rel = 'dns-prefetch';
                    link.href = domain;
                    document.head.appendChild(link);
                }
            });
        }
    };

    // Apply optimizations immediately
    criticalResourceManager.deferNonCriticalResources();
    criticalResourceManager.optimizeThirdPartyScripts();

    console.log("%c Welcome to RUBYSHOP! Header script loaded.!!", "background: #dc2626; color: #ffffff; font-size: 16px; padding: 8px 16px; border-radius: 4px;");
    
        // Enhanced Mobile Menu Handler with Performance Optimization
    document.addEventListener('DOMContentLoaded', function() {
        const domLoadTime = performance.now();
        scriptTracker.logScript('DOMContentLoaded Event', 'DOM Ready');
        
        // Cache DOM elements immediately for faster access
        const burger = document.querySelector('.burger-icon');
        const mobileWrapper = document.querySelector('.mobile-header-active');
        const closeButton = document.querySelector('.mobile-menu-close button');
        const body = document.body;
        
        // Debug: Log what elements were found
        console.log('Menu Elements Check:', {
            burger: !!burger,
            mobileWrapper: !!mobileWrapper,
            closeButton: !!closeButton,
            burgerClass: burger ? burger.className : 'not found'
        });
        
        // Early return if critical elements are missing
        if (!burger || !mobileWrapper) {
            console.warn('Mobile menu elements not found!');
            scriptTracker.logScript('Mobile Menu Setup', 'Failed - Missing Elements');
            return;
        }        const mobileMenuStartTime = performance.now();
        console.log("%c Mobile Menu Handler Initialized", "background: #10b981; color: white; padding: 4px 8px; border-radius: 4px;");
        
        // Create overlay immediately if needed
        let overlay = document.querySelector('.body-overlay-1');
        if (!overlay) {
            overlay = document.createElement('div');
            overlay.className = 'body-overlay-1';
            document.body.appendChild(overlay);
        }
        
        // Pre-set initial styles synchronously (no setTimeout delay)
        const initializeMenuSync = () => {
            // Batch DOM operations for better performance
            const style = mobileWrapper.style;
            style.transform = 'translateX(-100%)';
            style.visibility = 'hidden';
            style.opacity = '0';
            style.display = 'none';
            style.transition = 'transform 0.3s ease-in-out, opacity 0.3s ease';
            
            const overlayStyle = overlay.style;
            overlayStyle.opacity = '0';
            overlayStyle.visibility = 'hidden';
            
            // Force remove classes and ensure clean state
            mobileWrapper.classList.remove('sidebar-visible');
            body.classList.remove('mobile-menu-active');
            burger.classList.remove('active');
            
            console.log('Menu initialized to closed state');
        };
        
        // Initialize menu immediately
        initializeMenuSync();
        
        // Double-check after a brief delay to ensure it's closed
        setTimeout(() => {
            if (mobileWrapper.classList.contains('sidebar-visible')) {
                console.log('Menu was still open - force closing');
                closeMenu();
            }
        }, 100);
        
        // Optimized menu functions with requestAnimationFrame
        const openMenu = () => {
            console.log('Opening mobile menu...');
            requestAnimationFrame(() => {
                const style = mobileWrapper.style;
                style.transition = 'none';
                style.visibility = 'visible';
                style.opacity = '1';
                style.display = 'block';
                
                requestAnimationFrame(() => {
                    style.transition = 'transform 0.3s ease-in-out, opacity 0.3s ease';
                    style.transform = 'translateX(0)';
                    
                    mobileWrapper.classList.add('sidebar-visible');
                    body.classList.add('mobile-menu-active');
                    burger.classList.add('active');
                    
                    const overlayStyle = overlay.style;
                    overlayStyle.opacity = '1';
                    overlayStyle.visibility = 'visible';
                    
                    console.log('Mobile menu opened');
                });
            });
        };
        
        const closeMenu = () => {
            console.log('Closing mobile menu...');
            requestAnimationFrame(() => {
                const style = mobileWrapper.style;
                style.transition = 'transform 0.3s ease-in-out, opacity 0.3s ease';
                style.transform = 'translateX(-100%)';
                style.opacity = '0';
                
                mobileWrapper.classList.remove('sidebar-visible');
                body.classList.remove('mobile-menu-active');
                burger.classList.remove('active');
                
                const overlayStyle = overlay.style;
                overlayStyle.opacity = '0';
                overlayStyle.visibility = 'hidden';
                
                setTimeout(() => {
                    style.visibility = 'hidden';
                    style.display = 'none';
                    console.log('Mobile menu closed');
                }, 300);
            });
        };
        
        // Enhanced state check with debugging
        const isMenuOpen = () => {
            // Check if we're in mobile view first
            const isMobile = window.innerWidth <= 991;
            if (!isMobile) {
                console.log('Desktop view - menu should be hidden');
                return false;
            }
            
            const hasClass = mobileWrapper.classList.contains('sidebar-visible');
            const transform = window.getComputedStyle(mobileWrapper).transform;
            const isTransformed = transform === 'matrix(1, 0, 0, 1, 0, 0)' || transform === 'none';
            
            console.log('Menu State Check:', {
                isMobile: isMobile,
                hasClass: hasClass,
                isTransformed: isTransformed,
                transform: transform,
                classList: Array.from(mobileWrapper.classList)
            });
            
            return hasClass && isTransformed;
        };
        
        // Event handlers with passive listeners for better performance
        burger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Only handle clicks on mobile
            if (window.innerWidth > 991) {
                console.log('Ignoring burger click on desktop');
                return;
            }
            
            const menuState = isMenuOpen();
            console.log('Burger clicked!', { 
                isOpen: menuState,
                willDo: menuState ? 'close' : 'open',
                viewport: window.innerWidth
            });
            
            if (menuState) {
                closeMenu();
            } else {
                openMenu();
            }
        }, { passive: false });
        
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Close button clicked');
                closeMenu();
            }, { passive: false });
        }
        
        overlay.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Overlay clicked');
            closeMenu();
        }, { passive: false });
        
        // Optimized escape key handler
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isMenuOpen()) {
                closeMenu();
            }
        }, { passive: true });
        
        // Handle window resize to close menu on desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991 && isMenuOpen()) {
                console.log('Switching to desktop - closing menu');
                closeMenu();
            }
        }, { passive: true });
        
        const mobileMenuEndTime = performance.now();
        const setupTime = mobileMenuEndTime - mobileMenuStartTime;
        scriptTracker.logScript('Mobile Menu Setup', `Completed in ${setupTime.toFixed(2)}ms`);
        
        console.log(`%c Mobile Menu Setup Complete! (${setupTime.toFixed(2)}ms)`, "background: #10b981; color: white; padding: 4px 8px; border-radius: 4px;");
        
        // Apply image optimizations after mobile menu setup
        setTimeout(() => {
            criticalResourceManager.optimizeSlowImages();
            criticalResourceManager.preloadCriticalImages();
            scriptTracker.logScript('Image Optimization', 'Applied lazy loading and preload hints');
            
            // Delay Google Analytics to improve initial page load
            if (window.gtag || window.ga) {
                console.log('Google Analytics detected - already loaded');
            } else {
                // If GA hasn't loaded yet, delay it slightly
                setTimeout(() => {
                    criticalResourceManager.optimizeThirdPartyScripts();
                    scriptTracker.logScript('Third-party Optimization', 'Deferred tracking scripts');
                }, 1000);
            }
        }, 0);
    });

    // Page Load Performance Summary
    window.addEventListener('load', function() {
        const loadEndTime = performance.now();
        const totalLoadTime = loadEndTime - startTime;
        
        console.log("%c Page Load Complete!", "background: #059669; color: white; padding: 8px 16px; border-radius: 4px; font-weight: bold;");
        console.log(`%c Total Load Time: ${totalLoadTime.toFixed(2)}ms`, "background: #dc2626; color: white; padding: 4px 8px; border-radius: 4px;");
        
        // Performance metrics
        if (performance.getEntriesByType) {
            const navigation = performance.getEntriesByType('navigation')[0];
            if (navigation) {
                console.group("%c Detailed Performance Metrics", "background: #7c3aed; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;");
                console.log(`DNS Lookup: ${(navigation.domainLookupEnd - navigation.domainLookupStart).toFixed(2)}ms`);
                console.log(`TCP Connection: ${(navigation.connectEnd - navigation.connectStart).toFixed(2)}ms`);
                console.log(`Request: ${(navigation.responseStart - navigation.requestStart).toFixed(2)}ms`);
                console.log(`Response: ${(navigation.responseEnd - navigation.responseStart).toFixed(2)}ms`);
                console.log(`DOM Processing: ${(navigation.domContentLoadedEventEnd - navigation.responseEnd).toFixed(2)}ms`);
                console.log(`Resource Loading: ${(navigation.loadEventStart - navigation.domContentLoadedEventEnd).toFixed(2)}ms`);
                console.groupEnd();
            }
        }
        
        // Script execution summary
        const scriptSummary = scriptTracker.getSummary();
        if (scriptSummary.length > 0) {
            console.group("%c Script Execution Summary", "background: #0891b2; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;");
            scriptSummary.forEach(script => {
                console.log(`${script.name}: +${script.elapsed.toFixed(2)}ms - ${script.timing}`);
            });
            console.groupEnd();
        }
        
        // Performance recommendations with optimization tips
        if (totalLoadTime > 2000) {
            console.warn("%c Page load time is over 2 seconds. Consider optimization.", "background: #dc2626; color: white; padding: 4px 8px; border-radius: 4px;");
            
            // Show specific recommendations
            const slowImages = criticalResourceManager.slowResources.filter(r => r.type === 'img' && r.duration > 1000 && !r.isTracking);
            if (slowImages.length > 0) {
                console.warn("%c Tip: Optimize slow images with WebP format and proper sizing", "background: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;");
            }
            
            const slowScripts = criticalResourceManager.slowResources.filter(r => r.type === 'script' && r.duration > 500 && !r.isTracking);
            if (slowScripts.length > 0) {
                console.warn("%c Tip: Consider async/defer attributes for non-critical scripts", "background: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;");
            }
            
            const slowTracking = criticalResourceManager.slowResources.filter(r => r.isTracking);
            if (slowTracking.length > 0) {
                console.info("%c Analytics requests detected - these are normal but can be optimized", "background: #8b5cf6; color: white; padding: 4px 8px; border-radius: 4px;");
            }
        } else if (totalLoadTime > 1000) {
            console.log("%c Page load time is acceptable but could be improved.", "background: #f59e0b; color: white; padding: 4px 8px; border-radius: 4px;");
        } else {
            console.log("%c Excellent page load performance!", "background: #059669; color: white; padding: 4px 8px; border-radius: 4px;");
        }
        
        // Show top slow resources
        if (criticalResourceManager.slowResources.length > 0) {
            const topSlow = criticalResourceManager.slowResources
                .sort((a, b) => b.duration - a.duration)
                .slice(0, 5);
                
            console.group("%c Top 5 Slowest Resources", "background: #dc2626; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;");
            topSlow.forEach((resource, index) => {
                console.log(`${index + 1}. ${resource.name} (${resource.type}): ${resource.duration.toFixed(2)}ms`);
            });
            console.groupEnd();
        }
        
        scriptTracker.logScript('Performance Summary', 'Analysis Complete');
    });

    // Track critical resources
    const trackCriticalResources = () => {
        const criticalResources = [
            'tailwindcss',
            'swiper',
            'font-awesome',
            'aos',
            'google fonts'
        ];
        
        console.group("%c Critical Resources Status", "background: #be185d; color: white; padding: 4px 8px; border-radius: 4px; font-weight: bold;");
        
        criticalResources.forEach(resource => {
            const entries = performance.getEntriesByType('resource').filter(entry => 
                entry.name.toLowerCase().includes(resource.toLowerCase())
            );
            
            if (entries.length > 0) {
                const totalTime = entries.reduce((sum, entry) => sum + (entry.responseEnd - entry.startTime), 0);
                console.log(`${resource}: ${entries.length} file(s), ${totalTime.toFixed(2)}ms total`);
            } else {
                console.log(`${resource}: Not detected`);
            }
        });
        
        console.groupEnd();
    };
    
    // Run critical resources check after a short delay
    setTimeout(trackCriticalResources, 1000);
</script>    
    </head>
    <body {!! Theme::bodyAttributes() !!} class="@if (BaseHelper::isRtlEnabled()) rtl @endif header_full_true wowy-template css_scrollbar lazy_icons btnt4_style_2 zoom_tp_2 css_scrollbar template-index wowy_toolbar_true hover_img2 swatch_style_rounded swatch_list_size_small label_style_rounded wrapper_full_width header_full_true header_sticky_true hide_scrolld_true des_header_3 h_banner_true top_bar_true prs_bordered_grid_1 search_pos_canvas lazyload @if (Theme::get('bodyClass')) {{ Theme::get('bodyClass') }} @endif">
        {!! apply_filters(THEME_FRONT_BODY, null) !!}
        <div id="alert-container"></div>

        {!! Theme::partial('preloader') !!}

        <header class="header-area header-height-2 {{ $headerStyle }}" id="header-main">
            <div class="header-top header-top-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-xl-3 col-lg-4">
                            <div class="header-info">
                                <ul>
                                    @if (theme_option('hotline'))
                                        <li><i class="fa fa-phone-alt mr-5"></i><a href="tel:{{ theme_option('hotline') }}">{{ theme_option('hotline') }}</a></li>
                                    @endif

                                    @if (is_plugin_active('ecommerce') && EcommerceHelper::isOrderTrackingEnabled())
                                        <li><i class="far fa-anchor mr-5"></i><a href="{{ route('public.orders.tracking') }}">{{ __('Track Your Order') }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="col-xl-5 col-lg-4">
                            <div class="text-center">
                                @if (theme_option('header_messages') && $headerMessages = json_decode(theme_option('header_messages'), true))
                                    <div id="news-flash" class="d-inline-block">
                                        <ul>
                                            @foreach($headerMessages as $headerMessage)
                                                @if (count($headerMessage) == 4)
                                                    <li>
                                                        @if ($headerMessage[0]['value'])
                                                            {!! BaseHelper::renderIcon($headerMessage[0]['value'], null, ['class' => 'd-inline-block mr-5']) !!}
                                                        @endif

                                                        @if ($headerMessage[1]['value'])
                                                            <span class="d-inline-block">
                                                                {!! BaseHelper::clean($headerMessage[1]['value']) !!}
                                                            </span>
                                                        @endif
                                                        @if ($headerMessage[2]['value'] && $headerMessage[3]['value'])
                                                            &nbsp;<a class="active d-inline-block" href="{{ url($headerMessage[2]['value']) }}">{!! BaseHelper::clean($headerMessage[3]['value']) !!}</a>
                                                        @endif
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @php $currencies = is_plugin_active('ecommerce') ? get_all_currencies() : []; @endphp

                        @if (is_plugin_active('ecommerce') || is_plugin_active('language'))
                            <div class="col-xl-4 col-lg-4">
                                <div class="header-info header-info-right">
                                        <ul>
                                            @if (is_plugin_active('language'))
                                                {!! Theme::partial('language-switcher') !!}
                                            @endif

                                            @if (is_plugin_active('ecommerce'))
                                                @if (count($currencies) > 1)
                                                    <li>
                                                        <a class="language-dropdown-active" href="#"> <i class="fa fa-coins"></i> {{ get_application_currency()->title }} <i class="fa fa-chevron-down"></i></a>
                                                        <ul class="language-dropdown">
                                                            @foreach ($currencies as $currency)
                                                                @if ($currency->id !== get_application_currency_id())
                                                                    <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endif
                                                @if (auth('customer')->check())
                                                    <li><a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a></li>
                                                @else
                                                    <li><a href="{{ route('customer.login') }}">{{ __('Log In / Sign Up') }}</a></li>
                                                @endif
                                            @endif
                                        </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
                <div class="container">
                    <div class="header-wrap header-space-between">
                        <div class="logo logo-width-1">
                            @if (theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}"></a>
                            @endif
                        </div>
                        @if (is_plugin_active('ecommerce'))
                            <div class="search-style-2">
                                <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                                    <div class="form-group--icon">
                                        <div class="product-cat-label">{{ __('All Categories') }}</div>
                                        <select class="product-category-select" id="product-category-select" name="categories[]">
                                            <option value="">{{ __('All Categories') }}</option>
                                            {!! ProductCategoryHelper::renderProductCategoriesSelect() !!}
                                        </select>
                                    </div>
                                    <input type="text" name="q" class="input-search-product"  placeholder="{{ __('Search for items…') }}" autocomplete="off">
                                    <button type="submit" title="search"> <i class="far fa-search"></i> </button>
                                    <div class="panel--search-result"></div>
                                </form>
                            </div>
                            <div class="header-action-right">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare.svg') }}">
                                                <span class="pro-count blue"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img class="svgInject" alt="{{ __('Wishlist') }}" src="{{ Theme::asset()->url('images/icons/icon-heart.svg') }}">
                                                <span class="pro-count blue">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="{{ __('Cart') }}" src="{{ Theme::asset()->url('images/icons/icon-cart.svg') }}">
                                            <span class="pro-count blue">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="{{ __('Sign In') }}" src="{{ Theme::asset()->url('images/icons/icon-user.svg') }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="header-bottom header-bottom-bg-color sticky-bar gray-bg sticky-blue-bg">
                <div class="container">
                    <div class="header-wrap header-space-between position-relative main-nav">
                        <div class="logo logo-width-1 d-block d-lg-none">
                            @if ($logo = theme_option('logo_light') ?: theme_option('logo'))
                                <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl($logo) }}" alt="{{ theme_option('site_title') }}"></a>
                            @endif
                        </div>

                        @if (is_plugin_active('ecommerce') && theme_option('enabled_browse_categories_on_header', 'yes') == 'yes')
                            @php
                                $openBrowse = $page && $page->template == 'homepage' && $page->getMetaData('expanding_product_categories_on_the_homepage', true) == 'yes';
                                $cantCloseBrowse = $openBrowse && $headerStyle == 'header-style-2';
                            @endphp
                            <div class="main-categories-wrap d-none d-lg-block">
                            <a class="categories-button-active @if ($openBrowse) open @endif @if ($cantCloseBrowse) cant-close @endif" href="#">
                                <span class="fa fa-list"></span> {{ __('Browse Categories') }} <i class="down far fa-chevron-down"></i> <i class="up far fa-chevron-up"></i>
                            </a>
                            @php
                                $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                            @endphp
                            <div class="categories-dropdown-wrap categories-dropdown-active-large @if ($openBrowse) default-open open @endif">
                                <ul>
                                    {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => false]) !!}
                                    @if (count($categories) > 10)
                                        <li>
                                            <ul class="more_slide_open">
                                                {!! Theme::partial('product-categories-dropdown', ['categories' => $categories, 'more' => true]) !!}
                                            </ul>
                                        </li>
                                    @endif
                                </ul>

                                @if (count($categories) > 10)
                                    <div class="more_categories">{{ __('Show more...') }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                        <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block main-menu-light-white hover-boder hover-boder-white">
                            <nav>
                                {!!
                                    Menu::renderMenuLocation('main-menu', [
                                        'view' => 'main-menu',
                                    ])
                                !!}
                            </nav>
                        </div>

                        @if (theme_option('hotline'))
                            <div class="hotline d-none d-lg-block">
                                <p><i class="fa fa-phone-alt"></i><span>{{ __('Hotline') }}</span> {{ theme_option('hotline') }}</p>
                            </div>
                        @endif

                        @if (is_plugin_active('ecommerce'))
                            <div class="header-action-right d-block d-lg-none">
                                <div class="header-action-2">
                                    @if (EcommerceHelper::isCompareEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.compare') }}" class="compare-count">
                                                <img class="svgInject" alt="{{ __('Compare') }}" src="{{ Theme::asset()->url('images/icons/icon-compare-white.svg') }}">
                                                <span class="pro-count white"><span>{{ Cart::instance('compare')->count() }}</span></span>
                                            </a>
                                        </div>
                                    @endif
                                    @if (EcommerceHelper::isWishlistEnabled())
                                        <div class="header-action-icon-2">
                                            <a href="{{ route('public.wishlist') }}" class="wishlist-count">
                                                <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-heart-white.svg') }}">
                                                <span class="pro-count white">@if (auth('customer')->check())<span>{{ auth('customer')->user()->wishlist()->count() }}</span> @else <span>{{ Cart::instance('wishlist')->count() }}</span>@endif</span>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="header-action-icon-2">
                                        <a class="mini-cart-icon" href="{{ route('public.cart') }}">
                                            <img alt="cart" src="{{ Theme::asset()->url('images/icons/icon-cart-white.svg') }}">
                                            <span class="pro-count white">{{ Cart::instance('cart')->count() }}</span>
                                        </a>
                                        <div class="cart-dropdown-wrap cart-dropdown-hm2">
                                            {!! Theme::partial('cart-panel') !!}
                                        </div>
                                    </div>
                                    <div class="header-action-icon-2">
                                        <a href="{{ route('customer.login') }}">
                                            <img alt="wowy" src="{{ Theme::asset()->url('images/icons/icon-user-white.svg') }}">
                                        </a>
                                    </div>
                                    <div class="header-action-icon-2 d-block d-lg-none">
                                        <div class="burger-icon burger-icon-white">
                                            <span class="burger-icon-top"></span>
                                            <span class="burger-icon-mid"></span>
                                            <span class="burger-icon-bottom"></span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="mobile-header-active mobile-header-wrapper-style">
            <div class="mobile-header-wrapper-inner">
                <div class="mobile-header-top">
                    @if (theme_option('logo'))
                        <div class="mobile-header-logo">
                            <a href="{{ BaseHelper::getHomepageUrl() }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}"></a>
                        </div>
                    @endif
                    <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                        <button class="close-style search-close">
                            <i class="icon-top"></i>
                            <i class="icon-bottom"></i>
                        </button>
                    </div>
                </div>
                @if (is_plugin_active('ecommerce'))
                    <div class="mobile-header-content-area">
                    <div class="mobile-search search-style-3 mobile-header-border">
                        <form action="{{ route('public.products') }}" class="form--quick-search" data-ajax-url="{{ route('public.ajax.search-products') }}" method="get">
                            <input type="text" name="q" class="input-search-product" placeholder="{{ __('Search...') }}">
                            <button type="submit" title="search"> <i class="far fa-search"></i> </button>
                            <div class="panel--search-result"></div>
                        </form>
                    </div>
                    <div class="mobile-menu-wrap mobile-header-border">
                        <div class="main-categories-wrap mobile-header-border">
                            <a class="categories-button-active-2" href="#">
                                <span class="far fa-bars"></span> {{ __('Browse Categories') }} <i class="down far fa-chevron-down"></i>
                            </a>
                            <div class="categories-dropdown-wrap categories-dropdown-active-small">
                                <ul>
                                    @php
                                        if (! isset($categories)) {
                                            $categories = ProductCategoryHelper::getProductCategoriesWithUrl();
                                        }

                                        $groupedCategories = $categories->groupBy('parent_id');

                                        $currentCategories = $groupedCategories->get(0);
                                    @endphp

                                    @if($currentCategories)
                                        @foreach ($currentCategories as $category)
                                            @php
                                                $hasChildren = $groupedCategories->has($category->id);
                                            @endphp

                                            <li>
                                                <a href="{{ route('public.single', $category->url) }}">
                                                    @if ($category->icon_image)
                                                        <img src="{{ RvMedia::getImageUrl($category->icon_image) }}" alt="{{ $category->name }}" width="18" height="18">
                                                    @elseif ($icon = $category->icon)
                                                        {!! BaseHelper::renderIcon($icon) !!}
                                                    @endif {{ $category->name }}

                                                    @if ($hasChildren)
                                                        <span class="menu-expand"><i class="down far fa-chevron-down"></i></span>
                                                    @endif
                                                </a>
                                                @if ($hasChildren)
                                                    <ul class="dropdown" style="display: none">
                                                        @php
                                                            $currentCategories = $groupedCategories->get($category->id);
                                                        @endphp
                                                        @if($currentCategories)
                                                            @foreach ($currentCategories as $childCategory)
                                                                <li><a href="{{ route('public.single', $childCategory->url ) }}">{{ $childCategory->name }}</a></li>
                                                            @endforeach
                                                        @endif
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <nav>
                            {!!
                                Menu::renderMenuLocation('main-menu', [
                                    'options' => ['class' => 'mobile-menu'],
                                    'view'    => 'mobile-menu',
                                ])
                            !!}
                        </nav>
                    </div>
                    <div class="mobile-header-info-wrap mobile-header-border">
                        @if (is_plugin_active('language'))
                            <div class="single-mobile-header-info">
                                <a class="mobile-language-active" href="#">{{ __('Language') }} <span><i class="far fa-angle-down"></i></span></a>
                                <div class="lang-curr-dropdown lang-dropdown-active">
                                    <ul>
                                        @php
                                            $showRelated = setting('language_show_default_item_if_current_version_not_existed', true);
                                        @endphp

                                        @foreach (Language::getSupportedLocales() as $localeCode => $properties)
                                            <li><a rel="alternate" hreflang="{{ $localeCode }}" href="{{ $showRelated ? Language::getLocalizedURL($localeCode) : url($localeCode) }}">{!! language_flag($properties['lang_flag'], $properties['lang_name']) !!} {{ $properties['lang_name'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (count($currencies) > 1)
                            <div class="single-mobile-header-info">
                                <a class="mobile-language-active" href="#">{{ __('Currency') }} <span><i class="far fa-angle-down"></i></span></a>
                                <div class="lang-curr-dropdown lang-dropdown-active">
                                    <ul>
                                        @foreach ($currencies as $currency)
                                            <li><a href="{{ route('public.change-currency', $currency->title) }}">{{ $currency->title }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        @if (is_plugin_active('ecommerce'))
                            <div class="single-mobile-header-info">
                                @if (auth('customer')->check())
                                    <a href="{{ route('customer.overview') }}">{{ auth('customer')->user()->name }}</a>
                                @else
                                    <a href="{{ route('customer.login') }}">{{ __('Log In / Sign Up') }}</a>
                                @endif
                            </div>
                        @endif

                        @if ($hotline = theme_option('hotline'))
                            <div class="single-mobile-header-info">
                                <a href="tel:{{ $hotline }}">{{ $hotline }}</a>
                            </div>
                        @endif
                    </div>

                    @if (($socialLinks = theme_option('social_links')) && $socialLinks = json_decode($socialLinks, true))
                        <div class="mobile-social-icon">
                            @foreach($socialLinks as $socialLink)
                                @if (count($socialLink) == 4 && isset($socialLink[0]['value']) && isset($socialLink[1]['value']) && isset($socialLink[2]['value']) && isset($socialLink[3]['value']))
                                    <a href="{{ $socialLink[2]['value'] }}"
                                       title="{{ $socialLink[0]['value'] }}" style="background-color: {{ $socialLink[3]['value'] }}; border: 1px solid {{ $socialLink[3]['value'] }};">
                                        {!! BaseHelper::renderIcon($socialLink[1]['value']) !!}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
