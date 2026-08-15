(function () {
    'use strict';

    if (typeof fbq === 'function') {
        document.addEventListener('submit', function (event) {
            var form = event.target.closest('form.cart-form, form[action*="cart/add"], form[action*="add-to-cart"]');

            if (!form) {
                return;
            }

            var productId = form.querySelector('[name="id"], .hidden-product-id');
            var qty = form.querySelector('[name="qty"]');

            fbq('track', 'AddToCart', {
                content_ids: [productId ? productId.value : ''],
                content_type: 'product',
                quantity: qty ? parseInt(qty.value, 10) || 1 : 1,
                currency: 'THB'
            });
        }, true);

        document.addEventListener('click', function (event) {
            var btn = event.target.closest('a[href*="checkout"], .checkout-btn, [data-checkout]');

            if (btn) {
                fbq('track', 'InitiateCheckout', { currency: 'THB' });
            }
        }, true);
    }

    var isHomepage = document.body.classList.contains('ruby-homepage');

    function enforceNavHide() {
        if (isHomepage) {
            return;
        }

        var width = window.innerWidth;
        var cats = document.querySelector('.header-bottom .header-nav-categories');
        var hot = document.querySelector('.header-bottom .header-nav-hotline');
        var hide = width >= 992 && !isHomepage;

        [cats, hot].forEach(function (el) {
            if (!el) {
                return;
            }

            if (hide) {
                el.style.setProperty('display', 'none', 'important');
            } else {
                el.style.removeProperty('display');
            }
        });
    }

    enforceNavHide();
    window.addEventListener('load', enforceNavHide);
    window.addEventListener('load', function () {
        setTimeout(enforceNavHide, 300);
    });
    window.addEventListener('resize', enforceNavHide);
}());
