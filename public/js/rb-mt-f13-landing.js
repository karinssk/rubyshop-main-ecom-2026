(function () {
    'use strict';

    const track = function (eventName, parameters) {
        if (typeof window.gtag === 'function') {
            window.gtag('event', eventName, Object.assign({
                page_path: window.location.pathname,
                item_name: 'RB-MT-F13'
            }, parameters || {}));
        }
    };

    document.querySelectorAll('.track-phone').forEach(function (link) {
        link.addEventListener('click', function () {
            track('phone_click', { event_category: 'CTA', contact_method: 'phone' });
        });
    });

    document.querySelectorAll('.track-line').forEach(function (link) {
        link.addEventListener('click', function () {
            track('line_click', { event_category: 'CTA', contact_method: 'line' });
        });
    });

    document.querySelectorAll('.track-lead').forEach(function (link) {
        link.addEventListener('click', function () {
            track('quote_cta_click', { event_category: 'CTA' });
        });
    });

    const modal = document.getElementById('video-modal');
    const videoFrame = document.getElementById('video-frame');

    const closeVideo = function () {
        if (!modal) {
            return;
        }

        modal.hidden = true;
        videoFrame.innerHTML = '';
        document.body.classList.remove('modal-open');
    };

    document.querySelectorAll('.js-video-open').forEach(function (button) {
        button.addEventListener('click', function () {
            const videoId = button.dataset.videoId;

            if (!videoId || !modal) {
                return;
            }

            videoFrame.innerHTML = '<iframe src="https://www.youtube-nocookie.com/embed/' + encodeURIComponent(videoId) + '?autoplay=1&rel=0" title="วิดีโอ RB-MT-F13" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>';
            modal.hidden = false;
            document.body.classList.add('modal-open');
            modal.querySelector('.video-close').focus();
            track('video_play', { event_category: 'Video', video_id: videoId });
        });
    });

    document.querySelectorAll('.js-video-close').forEach(function (button) {
        button.addEventListener('click', closeVideo);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal && !modal.hidden) {
            closeVideo();
        }
    });

    const form = document.getElementById('f13-lead-form');

    if (!form) {
        return;
    }

    form.addEventListener('submit', async function (event) {
        event.preventDefault();

        const submitButton = form.querySelector('.form-submit');
        const successMessage = form.querySelector('.contact-success-message');
        const errorMessage = form.querySelector('.contact-error-message');
        const originalLabel = submitButton.textContent;

        successMessage.hidden = true;
        errorMessage.hidden = true;

        if (!form.reportValidity()) {
            return;
        }

        submitButton.classList.add('loading');
        submitButton.disabled = true;
        submitButton.textContent = 'กำลังส่งข้อมูล...';

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const payload = await response.json();

            if (!response.ok || payload.error) {
                const errors = payload.errors ? Object.values(payload.errors).flat().join(' ') : payload.message;
                throw new Error(errors || 'ส่งข้อมูลไม่สำเร็จ กรุณาลองใหม่');
            }

            successMessage.textContent = 'ได้รับข้อมูลแล้ว ทีมงานจะติดต่อกลับโดยเร็วที่สุด';
            successMessage.className = 'form-status contact-success-message success';
            successMessage.hidden = false;
            form.reset();

            track('generate_lead', {
                event_category: 'Lead',
                currency: 'THB',
                value: 75000,
                lead_source: 'f13_google_ads_landing'
            });

            if (typeof window.fbq === 'function') {
                window.fbq('track', 'Lead', { content_name: 'RB-MT-F13', value: 75000, currency: 'THB' });
            }
        } catch (error) {
            errorMessage.textContent = error.message || 'ส่งข้อมูลไม่สำเร็จ กรุณาโทร 089-666-7802';
            errorMessage.className = 'form-status contact-error-message error';
            errorMessage.hidden = false;
        } finally {
            submitButton.classList.remove('loading');
            submitButton.disabled = false;
            submitButton.textContent = originalLabel;
        }
    });
})();
