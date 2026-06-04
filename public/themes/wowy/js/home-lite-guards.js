(function (window, $) {
    'use strict';

    if (!window.WOW) {
        window.WOW = function () {
            return {
                init: function () {}
            };
        };
    }

    if (!$ || !$.fn) {
        return;
    }

    window.showAlert = window.showAlert || function (type, message) {
        if (!type || !message) {
            return;
        }

        var id = 'ruby-alert-' + Date.now();
        var icon = type === 'alert-success' ? 'check-circle' : 'exclamation-circle';
        var alert = $(
            '<div class="alert ' + type + ' alert-dismissible" id="' + id + '">' +
                '<span class="btn-close" data-bs-dismiss="alert" aria-label="close"></span>' +
                '<i class="fas fa-' + icon + ' message-icon"></i>' +
                message +
            '</div>'
        );

        $('#alert-container').append(alert);
        window.setTimeout(function () {
            $('#' + id).remove();
        }, 6000);
    };

    if (!$.fn.imagesLoaded) {
        $.fn.imagesLoaded = function (callback) {
            if (typeof callback === 'function') {
                callback.call(this);
            }

            return this;
        };
    }

    ['countdown', 'syotimer', 'vTicker', 'theiaStickySidebar', 'elevateZoom', 'slick', 'isotope', 'magnificPopup', 'lightGallery', 'mCustomScrollbar'].forEach(function (pluginName) {
        if (!$.fn[pluginName]) {
            $.fn[pluginName] = function () {
                return this;
            };
        }
    });

    (function initHomeQuickSearch() {
        var currentRequest = null;
        var quickSearch = '.form--quick-search';

        $('body').on('click', function (event) {
            if (!$(event.target).closest(quickSearch).length) {
                $('.panel--search-result').removeClass('active');
            }
        });

        $(document).on('keyup', quickSearch + ' .input-search-product', function () {
            ajaxSearchProduct($(this).closest('form'));
        });

        $(document).on('change', quickSearch + ' .product-category-select', function () {
            ajaxSearchProduct($(this).closest('form'));
        });

        $(document).on('click', quickSearch + ' .loadmore', function (event) {
            event.preventDefault();
            $(this).addClass('loading');
            ajaxSearchProduct($(this).closest('form'), $(this).attr('href'));
        });

        function ajaxSearchProduct($form, url) {
            var $panel = $form.find('.panel--search-result');
            var keyword = $form.find('.input-search-product').val();

            if (!keyword) {
                $panel.html('').removeClass('active');
                return;
            }

            $('.form--quick-search .input-search-product').val(keyword);

            if (currentRequest) {
                currentRequest.abort();
            }

            currentRequest = $.ajax({
                type: 'GET',
                url: url || $form.data('ajax-url'),
                dataType: 'json',
                data: url ? [] : $form.serialize(),
                beforeSend: function () {
                    $form.find('button[type=submit]').addClass('loading');
                },
                success: function (response) {
                    if (response.error) {
                        $panel.html('').removeClass('active');
                        return;
                    }

                    if (url) {
                        var $content = $('<div>' + response.data + '</div>');
                        $panel.find('.panel__content').find('.loadmore-container').remove();
                        $panel.find('.panel__content').append($content.find('.panel__content').contents());
                    } else {
                        $panel.html(response.data).addClass('active');
                    }
                },
                complete: function () {
                    $form.find('button[type=submit]').removeClass('loading');
                    currentRequest = null;
                }
            });
        }
    })();
})(window, window.jQuery);

(function () {
    'use strict';

    var initFeaturedProducts = function () {
        document.querySelectorAll('[data-featuredv1-section]').forEach(function (section) {
            var node = section.previousSibling;

            while (node) {
                if (node.nodeType === Node.TEXT_NODE) {
                    if ((node.textContent || '').trim() === '') {
                        var textNode = node;
                        node = node.previousSibling;
                        textNode.remove();
                        continue;
                    }

                    break;
                }

                if (node.nodeType === Node.ELEMENT_NODE && node.tagName === 'P') {
                    var normalized = (node.innerHTML || '')
                        .replace(/&nbsp;|\u00a0/gi, '')
                        .replace(/<br\s*\/?>/gi, '')
                        .trim();

                    if (normalized === '' && (node.textContent || '').trim() === '') {
                        var pNode = node;
                        node = node.previousSibling;
                        pNode.remove();
                        continue;
                    }
                }

                break;
            }
        });

        document.querySelectorAll('[data-featuredv1-section]').forEach(function (section) {
            var track = section.querySelector('[data-featuredv1-track]');
            var prevBtn = section.querySelector('[data-featuredv1-prev]');
            var nextBtn = section.querySelector('[data-featuredv1-next]');

            if (!track || !prevBtn || !nextBtn || section.dataset.featuredv1Ready === '1') {
                return;
            }

            var isDesktop = function () {
                return window.innerWidth >= 1024;
            };

            var scrollAmount = function () {
                var card = track.querySelector('a');
                return (card ? card.offsetWidth : track.clientWidth) + 24;
            };

            var scrollSlider = function (direction) {
                if (isDesktop()) {
                    return;
                }

                track.scrollBy({
                    left: direction * scrollAmount(),
                    behavior: 'smooth'
                });
            };

            prevBtn.addEventListener('click', function () {
                scrollSlider(-1);
            });

            nextBtn.addEventListener('click', function () {
                scrollSlider(1);
            });

            section.dataset.featuredv1Ready = '1';
        });
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFeaturedProducts);
    } else {
        initFeaturedProducts();
    }
})();
