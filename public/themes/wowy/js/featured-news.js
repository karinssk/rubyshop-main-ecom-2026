document.addEventListener('DOMContentLoaded', function() {
    const sliderContainer = document.getElementById('slider-container');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    let position = 0;
    let currentSlide = 0;
    const totalImages = sliderContainer.children.length;

    // Function to update slider dimensions and positions
    function updateSlider() {
        // Determine images per slide based on current window width
        const imagesPerSlide = window.innerWidth < 640 ? 1 : 4;

        // Get the width of single slide item
        const slideWidth = sliderContainer.children[0].offsetWidth;

        // Update position based on current slide index
        position = -currentSlide * slideWidth;
        sliderContainer.style.transform = `translateX(${position}px)`;

        // Calculate max position (index of the last slide)
        const maxSlideIndex = totalImages - imagesPerSlide;

        // If current position is beyond the max allowed, adjust it
        if (currentSlide > maxSlideIndex) {
            currentSlide = maxSlideIndex;
            position = -currentSlide * slideWidth;
            sliderContainer.style.transform = `translateX(${position}px)`;
        }
    }

    nextBtn.addEventListener('click', function() {
        const imagesPerSlide = window.innerWidth < 640 ? 1 : 4;
        const maxSlideIndex = totalImages - imagesPerSlide;

        currentSlide++;
        if (currentSlide > maxSlideIndex) {
            currentSlide = 0; // Loop back to the start
        }

        const slideWidth = sliderContainer.children[0].offsetWidth;
        position = -currentSlide * slideWidth;
        sliderContainer.style.transform = `translateX(${position}px)`;
    });

    prevBtn.addEventListener('click', function() {
        const imagesPerSlide = window.innerWidth < 640 ? 1 : 4;
        const maxSlideIndex = totalImages - imagesPerSlide;

        currentSlide--;
        if (currentSlide < 0) {
            currentSlide = maxSlideIndex; // Loop to the end
        }

        const slideWidth = sliderContainer.children[0].offsetWidth;
        position = -currentSlide * slideWidth;
        sliderContainer.style.transform = `translateX(${position}px)`;
    });

    // Initialize slider
    updateSlider();

    // Update slider on window resize
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(updateSlider, 250); // Debounce resize events
    });

    // Add touch swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    sliderContainer.addEventListener('touchstart', function(e) {
        touchStartX = e.changedTouches[0].screenX;
    }, false);

    sliderContainer.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, false);

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            // Swipe left - next slide
            nextBtn.click();
        } else if (touchEndX > touchStartX + 50) {
            // Swipe right - previous slide
            prevBtn.click();
        }
    }
});
