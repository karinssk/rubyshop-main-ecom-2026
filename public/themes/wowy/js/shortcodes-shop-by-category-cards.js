(function () {
    'use strict';

    var init = function (root) {
        var slider = root.querySelector('[data-shop-by-category-slider]');
        var prev = root.querySelector('[data-shop-by-category-prev]');
        var next = root.querySelector('[data-shop-by-category-next]');

        if (!slider || !prev || !next) {
            return;
        }

        var getScrollAmount = function () {
            var card = slider.querySelector('.shop-by-category-cards__card');

            if (!card) {
                return slider.clientWidth;
            }

            var style = getComputedStyle(slider);
            var gap = parseFloat((style.columnGap || style.gap || '18').toString()) || 18;
            var isMobile = window.matchMedia('(max-width: 767px)').matches;
            var cardsPerStep = isMobile ? 1 : 4;

            return (card.getBoundingClientRect().width + gap) * cardsPerStep;
        };

        prev.addEventListener('click', function () {
            slider.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        next.addEventListener('click', function () {
            slider.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });
    };

    var boot = function () {
        document.querySelectorAll('[data-shop-by-category-root]').forEach(init);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
}());
