(function () {
    'use strict';

    var initHero = function (hero) {
        var media = hero && hero.querySelector('.ruby-hero__media--desktop');
        var video = media && media.querySelector('video');
        var fallback = media && media.querySelector('.ruby-hero__media__fallback');

        if (!media || !video) {
            return;
        }

        var showVideo = function () {
            media.classList.add('is-video-ready');
        };

        video.addEventListener('error', function () {
            if (fallback) {
                fallback.style.opacity = '0';
            }
        });

        if (video.readyState >= 2) {
            showVideo();
        } else {
            video.addEventListener('loadeddata', showVideo, { once: true });
            video.addEventListener('canplay', showVideo, { once: true });
        }
    };

    var init = function () {
        var heroes = document.querySelectorAll('.ruby-hero');

        for (var i = 0; i < heroes.length; i++) {
            initHero(heroes[i]);
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
