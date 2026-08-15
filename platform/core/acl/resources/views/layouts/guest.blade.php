@php
    $debugRender = request()->boolean('debug_render');
@endphp

<x-core::layouts.base :body-attributes="['data-bs-theme' => 'dark', 'data-ruby-admin-render-debug' => $debugRender ? 'enabled' : 'disabled']">
    @if ($debugRender)
        <div
            id="ruby-admin-render-debug"
            style="position:fixed;z-index:2147483647;right:12px;bottom:12px;max-width:min(420px,calc(100vw - 24px));padding:12px 14px;border:1px solid #22c55e;border-radius:8px;background:rgba(15,23,42,.96);color:#e5e7eb;font:12px/1.45 system-ui,-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;box-shadow:0 12px 30px rgba(0,0,0,.35);"
        >
            <strong style="display:block;margin-bottom:6px;color:#86efac;">RUBY Admin Render Debug</strong>
            <div data-debug-line="blade">Blade layout rendered</div>
            <div data-debug-line="time">Server: {{ now()->toDateTimeString() }}</div>
            <div data-debug-line="path">Path: {{ request()->path() }}</div>
            <div data-debug-line="assets">Waiting for browser checks...</div>
        </div>

        <script>
            (function () {
                var startedAt = Date.now();
                var panel = document.getElementById('ruby-admin-render-debug');

                function write(line, value) {
                    if (!panel) {
                        return;
                    }

                    var target = panel.querySelector('[data-debug-line="' + line + '"]');

                    if (target) {
                        target.textContent = value;
                    }
                }

                function assetStatus(selector) {
                    return Array.prototype.slice.call(document.querySelectorAll(selector)).map(function (node) {
                        return {
                            tag: node.tagName,
                            url: node.href || node.src || '',
                            loaded: node.sheet ? true : node.dataset.rubyLoaded === '1',
                        };
                    });
                }

                window.addEventListener('error', function (event) {
                    console.error('[RUBY Admin Render Debug] window error', {
                        message: event.message,
                        source: event.filename,
                        line: event.lineno,
                        column: event.colno,
                    });

                    write('assets', 'JS error: ' + event.message);
                }, true);

                window.addEventListener('unhandledrejection', function (event) {
                    console.error('[RUBY Admin Render Debug] promise rejection', event.reason);
                    write('assets', 'Promise error: ' + (event.reason && event.reason.message ? event.reason.message : event.reason));
                });

                document.addEventListener('DOMContentLoaded', function () {
                    var data = {
                        href: window.location.href,
                        readyState: document.readyState,
                        bodyChildren: document.body ? document.body.children.length : 0,
                        appExists: !!document.getElementById('app'),
                        formExists: !!document.querySelector('form'),
                        emailFieldExists: !!document.querySelector('input[name="username"], input[name="email"]'),
                        passwordFieldExists: !!document.querySelector('input[type="password"]'),
                        signInButtonExists: !!document.querySelector('button[type="submit"], input[type="submit"]'),
                        logoExists: !!document.querySelector('.navbar-brand img'),
                        bodyTextLength: document.body ? document.body.innerText.trim().length : 0,
                        viewport: window.innerWidth + 'x' + window.innerHeight,
                    };

                    console.group('[RUBY Admin Render Debug] DOMContentLoaded');
                    console.table(data);
                    console.table(assetStatus('link[rel="stylesheet"], script[src]'));
                    console.groupEnd();

                    write('assets', 'DOM ok, form=' + data.formExists + ', fields=' + data.emailFieldExists + '/' + data.passwordFieldExists);
                });

                window.addEventListener('load', function () {
                    var styles = window.getComputedStyle(document.body);
                    var data = {
                        readyState: document.readyState,
                        elapsedMs: Date.now() - startedAt,
                        bodyDisplay: styles.display,
                        bodyVisibility: styles.visibility,
                        bodyOpacity: styles.opacity,
                        scrollHeight: document.documentElement.scrollHeight,
                        appRect: document.getElementById('app') ? document.getElementById('app').getBoundingClientRect().toJSON() : null,
                    };

                    console.group('[RUBY Admin Render Debug] load');
                    console.table(data);
                    console.groupEnd();

                    write('assets', 'Load ok in ' + data.elapsedMs + 'ms, body=' + data.bodyDisplay + '/' + data.bodyVisibility + '/' + data.bodyOpacity);
                });
            })();
        </script>
    @endif

    <div class="row g-0 flex-fill vh-100">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    @if (setting('admin_logo') || config('core.base.general.logo'))
                        <a
                            href="{{ route('dashboard.index') }}"
                            class="navbar-brand"
                        >
                            <img
                                src="{{ setting('admin_logo') ? RvMedia::getImageUrl(setting('admin_logo')) : url(config('core.base.general.logo')) }}"
                                style="max-height: 50px; max-width: 100%;"
                                alt="{{ setting('admin_title', config('core.base.general.base_name')) }}"
                            >
                        </a>
                    @endif
                </div>

                @yield('content')
            </div>
        </div>
        <div class="position-relative col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <div
                class="bg-cover bg-white h-100 min-vh-100"
                style="background-image: url({{ $backgroundUrl }})"
            ></div>
            <div class="end-0 bottom-0 position-absolute">
                <div class="text-white me-5 mb-4">
                    <h1 class="mb-1">{{ setting('admin_title', config('core.base.general.base_name')) }}</h1>
                    <p>@include('core/base::partials.copyright')</p>
                </div>
            </div>
        </div>
    </div>
</x-core::layouts.base>
