(function () {
    'use strict';

    var tokenUrl = (window.siteUrl || window.location.origin).replace(/\/$/, '') + '/ajax/csrf-token';
    var tokenPromise = null;

    function setToken(token) {
        if (!token) {
            return token;
        }

        var meta = document.querySelector('meta[name="csrf-token"]');

        if (!meta) {
            meta = document.createElement('meta');
            meta.setAttribute('name', 'csrf-token');
            document.head.appendChild(meta);
        }

        meta.setAttribute('content', token);

        if (window.jQuery) {
            window.jQuery.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': token
                }
            });
        }

        return token;
    }

    window.RubyshopEnsureCsrfToken = function () {
        var existing = document.querySelector('meta[name="csrf-token"]');

        if (existing && existing.getAttribute('content')) {
            return Promise.resolve(existing.getAttribute('content'));
        }

        if (!tokenPromise) {
            tokenPromise = fetch(tokenUrl, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (payload) {
                    tokenPromise = null;
                    return setToken(payload.token);
                })
                .catch(function (error) {
                    tokenPromise = null;
                    throw error;
                });
        }

        return tokenPromise;
    };

    if (window.jQuery && !window.jQuery.ajax.__rubyshopCsrfWrapped) {
        var originalAjax = window.jQuery.ajax;

        window.jQuery.ajax = function (url, options) {
            var settings = typeof url === 'object' ? window.jQuery.extend(true, {}, url) : window.jQuery.extend(true, { url: url }, options || {});
            var method = (settings.type || settings.method || 'GET').toUpperCase();

            if (!/^(POST|PUT|PATCH|DELETE)$/.test(method) || settings.__rubyshopCsrfReady) {
                return originalAjax.apply(window.jQuery, arguments);
            }

            var existing = document.querySelector('meta[name="csrf-token"]');

            if (existing && existing.getAttribute('content')) {
                settings.headers = window.jQuery.extend({}, settings.headers || {}, {
                    'X-CSRF-TOKEN': existing.getAttribute('content')
                });
                settings.__rubyshopCsrfReady = true;

                return originalAjax.call(window.jQuery, settings);
            }

            var deferred = window.jQuery.Deferred();
            var jqXHR = deferred.promise();

            window.RubyshopEnsureCsrfToken()
                .then(function (freshToken) {
                    settings.headers = window.jQuery.extend({}, settings.headers || {}, {
                        'X-CSRF-TOKEN': freshToken
                    });
                    settings.__rubyshopCsrfReady = true;

                    originalAjax.call(window.jQuery, settings)
                        .done(function () {
                            deferred.resolveWith(this, arguments);
                        })
                        .fail(function () {
                            deferred.rejectWith(this, arguments);
                        });
                })
                .catch(function (error) {
                    deferred.rejectWith(settings.context || settings, [null, 'error', error]);
                });

            jqXHR.abort = function () {
                deferred.rejectWith(settings.context || settings, [null, 'abort', 'abort']);
            };

            return jqXHR;
        };

        window.jQuery.ajax.__rubyshopCsrfWrapped = true;
    }

    document.addEventListener('submit', function (event) {
        var form = event.target;

        if (!form || String(form.method || 'GET').toUpperCase() === 'GET' || form.dataset.csrfReady === '1') {
            return;
        }

        var token = document.querySelector('meta[name="csrf-token"]');

        if (token && token.getAttribute('content')) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        window.RubyshopEnsureCsrfToken().then(function (freshToken) {
            var input = form.querySelector('input[name="_token"]');

            if (!input) {
                input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                form.appendChild(input);
            }

            input.value = freshToken;
            form.dataset.csrfReady = '1';
            form.requestSubmit ? form.requestSubmit() : form.submit();
        });
    }, true);
}());
