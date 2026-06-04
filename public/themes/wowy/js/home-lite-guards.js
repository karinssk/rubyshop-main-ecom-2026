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

    if (!$.fn.imagesLoaded) {
        $.fn.imagesLoaded = function (callback) {
            if (typeof callback === 'function') {
                callback.call(this);
            }

            return this;
        };
    }

    ['countdown', 'syotimer', 'vTicker', 'theiaStickySidebar', 'elevateZoom'].forEach(function (pluginName) {
        if (!$.fn[pluginName]) {
            $.fn[pluginName] = function () {
                return this;
            };
        }
    });
})(window, window.jQuery);
