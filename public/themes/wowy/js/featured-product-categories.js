(function () {
    var init = function (root) {
        var slider = root.querySelector('[data-featured-categories-slider]');
        var prev = root.querySelector('[data-featured-categories-prev]');
        var next = root.querySelector('[data-featured-categories-next]');

        if (!slider || !prev || !next) {
            return;
        }

        var getScrollAmount = function () {
            var card = slider.querySelector('[data-featured-category-card]');
            return (card ? card.getBoundingClientRect().width : slider.clientWidth) + 14;
        };

        prev.addEventListener('click', function () {
            slider.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
        });

        next.addEventListener('click', function () {
            slider.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
        });
    };

    var boot = function () {
        document.querySelectorAll('[data-featured-categories-root]').forEach(init);
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', boot);
    } else {
        boot();
    }
})();
