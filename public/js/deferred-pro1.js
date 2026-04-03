

  // Wait for DOM to be fully loaded
  document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu functionality
    const menuBtn = document.getElementById('menu-btn');
    const closeBtn = document.getElementById('close-btn');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');
    
    if (menuBtn && closeBtn && sidebar && overlay) {
      menuBtn.addEventListener('click', function() {
        sidebar.classList.remove('translate-x-full');
        overlay.classList.remove('opacity-0', 'pointer-events-none');
        overlay.style.opacity = '0.5';
        document.body.style.overflow = 'hidden';
        menuBtn.setAttribute('aria-expanded', 'true');
        sidebar.setAttribute('aria-hidden', 'false');
      });
      
      function closeSidebar() {
        sidebar.classList.add('translate-x-full');
        overlay.classList.add('opacity-0', 'pointer-events-none');
        overlay.style.opacity = '0';
        document.body.style.overflow = '';
        menuBtn.setAttribute('aria-expanded', 'false');
        sidebar.setAttribute('aria-hidden', 'true');
      }
      
      closeBtn.addEventListener('click', closeSidebar);
      overlay.addEventListener('click', closeSidebar);
      
      // Close sidebar when clicking on a link
      const sidebarLinks = sidebar.querySelectorAll('a');
      sidebarLinks.forEach(link => {
        link.addEventListener('click', closeSidebar);
      });
      
      // Close sidebar on escape key
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !sidebar.classList.contains('translate-x-full')) {
          closeSidebar();
        }
      });
    }
    
    // Contact dropdown functionality
    const contactButton = document.getElementById('contactButton');
    const socialDropdown = document.getElementById('social-dropdown');
    
    if (contactButton && socialDropdown) {
      contactButton.addEventListener('click', function() {
        const expanded = contactButton.getAttribute('aria-expanded') === 'true';
        contactButton.setAttribute('aria-expanded', !expanded);
        if (expanded) {
          socialDropdown.classList.add('hidden');
        } else {
          socialDropdown.classList.remove('hidden');
        }
      });
      
      // Close dropdown when clicking outside
      document.addEventListener('click', function(e) {
        if (!contactButton.contains(e.target) && !socialDropdown.contains(e.target)) {
          contactButton.setAttribute('aria-expanded', 'false');
          socialDropdown.classList.add('hidden');
        }
      });
    }
    
    // YouTube video lazy loading
    const placeholder = document.getElementById('youtube-placeholder');
    if (placeholder) {
      placeholder.addEventListener('click', loadYouTubeVideo);
      placeholder.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          loadYouTubeVideo();
        }
      });
    }
    
    function loadYouTubeVideo() {
      const container = document.getElementById('youtube-iframe-container');
      const placeholder = document.getElementById('youtube-placeholder');
      
      if (!container || !placeholder) return;
      
      // Create and insert the iframe
      container.innerHTML = `<iframe
        class="absolute top-0 left-0 w-full h-full rounded-lg"
        src="https://www.youtube.com/embed/Y6x1ZHgIhkI?autoplay=1"
        title="คุณจรินทร์ ที่มั่นใจ เลือกใช้เครื่องพ่นปูนฉาบ รุ่น RB-M30L"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        loading="lazy"
        allowfullscreen>
      </iframe>`;
      
      // Show the iframe and hide the placeholder
      container.classList.remove('hidden');
      placeholder.classList.add('hidden');
    }
    
    // Load Swiper if needed
    if (typeof Swiper === 'undefined') {
      // Load Swiper CSS
      const swiperCss = document.createElement('link');
      swiperCss.rel = 'stylesheet';
      swiperCss.href = 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css';
      document.head.appendChild(swiperCss);
      
      // Load Swiper JS
      const swiperScript = document.createElement('script');
      swiperScript.src = 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js';
      swiperScript.onload = initSwiper;
      document.head.appendChild(swiperScript);
    } else {
      initSwiper();
    }
    
    function initSwiper() {
      new Swiper(".mySwiper", {
        loop: true,
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
        autoplay: {
          delay: 4000,
          disableOnInteraction: false,
        },
        speed: 600,
        // Reduce unnecessary animations on mobile
        preloadImages: false,
        lazy: true,
        // Pause autoplay when page is not visible
        observer: true,
        observeParents: true
      });
    }
    
    // Add image loading animation
    const images = document.querySelectorAll('img[loading]');
    images.forEach(img => {
      if (!img.complete) {
        img.classList.add('img-loading');
        img.onload = function() {
          this.classList.remove('img-loading');
          this.classList.add('img-loaded');
        };
      }
    });
  });
