<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    private const BASE_SCRIPT_SRC = [
        "'self'",
        "'unsafe-inline'",
        'https://cdnjs.cloudflare.com',
        'https://cdn.jsdelivr.net',
        'https://www.googletagmanager.com',
        'https://www.google-analytics.com',
        'https://analytics.google.com',
        'https://connect.facebook.net',
        'https://static.cloudflareinsights.com',
        'https://cdn.fastforwardssl.com',
        'https://embed.tawk.to',
        'https://tawk.to',
    ];

    private const BASE_STYLE_SRC = [
        "'self'",
        "'unsafe-inline'",
        'https://fonts.googleapis.com',
        'https://cdnjs.cloudflare.com',
        'https://cdn.jsdelivr.net',
    ];

    private const BASE_CONNECT_SRC = [
        "'self'",
        'https:',
        'wss:',
        'ws:',
    ];

    private const BASE_FRAME_SRC = [
        "'self'",
        'https://www.google.com',
        'https://maps.google.com',
        'https://www.google.co.th',
        'https://www.openstreetmap.org',
        'https://www.youtube.com',
        'https://www.youtube-nocookie.com',
        'https://embed.tawk.to',
        'https://tawk.to',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($redirect = $this->canonicalHostRedirect($request)) {
            return $redirect;
        }

        $response = $next($request);

        $this->injectFastForwardTracker($request, $response);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set(
            'Permissions-Policy',
            'accelerometer=(), autoplay=(self), camera=(), display-capture=(), encrypted-media=(), geolocation=(), gyroscope=(), microphone=(), midi=(), payment=(), usb=(), interest-cohort=()'
        );
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-site');
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');
        $response->headers->set('Content-Security-Policy', $this->buildContentSecurityPolicy($request));
        $response->headers->set('X-Robots-Tag', $this->buildRobotsHeader($request, $response));

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        return $response;
    }

    private function injectFastForwardTracker(Request $request, Response $response): void
    {
        $path = $this->withoutLocalePrefix(trim($request->path(), '/'));
        $content = $response->getContent();

        if (
            Str::startsWith($path, 'admin')
            || ! is_string($content)
            || ! Str::contains((string) $response->headers->get('Content-Type'), 'text/html')
            || ! Str::contains($content, '</head>')
            || Str::contains($content, 'data-site="pub_1wqI5My7qHml"')
        ) {
            return;
        }

        $tracker = '<script async src="https://cdn.fastforwardssl.com/tracker.js" data-site="pub_1wqI5My7qHml"></script>';

        $response->setContent(Str::replaceFirst('</head>', $tracker . "\n</head>", $content));
    }

    private function canonicalHostRedirect(Request $request): ?Response
    {
        if (! app()->environment('production')) {
            return null;
        }

        $host = Str::lower($request->getHost());
        $canonicalHost = 'www.rubyshop.co.th';

        // Keep local/dev hosts untouched.
        if (
            $host === '127.0.0.1'
            || $host === 'localhost'
            || Str::startsWith($host, '192.168.')
            || Str::startsWith($host, '10.')
        ) {
            return null;
        }

        $isRubyshopHost = $host === 'rubyshop.co.th'
            || $host === $canonicalHost
            || Str::endsWith($host, '.rubyshop.co.th');

        if ($isRubyshopHost && $host !== $canonicalHost) {
            return redirect()->to('https://' . $canonicalHost . $request->getRequestUri(), 301);
        }

        return null;
    }

    private function buildRobotsHeader(Request $request, Response $response): string
    {
        $host = Str::lower($request->getHost());
        $path = $this->withoutLocalePrefix(trim($request->path(), '/'));

        if ($response->isClientError() || $response->isServerError()) {
            return 'noindex, follow';
        }

        if ($host === 'shopdee198.rubyshop.co.th') {
            return 'noindex, nofollow';
        }

        if (Str::startsWith($path, 'admin')) {
            return 'noindex, nofollow';
        }

        if ($this->shouldNoindexUtilityPage($path)) {
            return 'noindex, follow';
        }

        if ($this->shouldNoindexListingPage($request, $path)) {
            return 'noindex, follow';
        }

        return 'index, follow';
    }

    private function shouldNoindexUtilityPage(string $path): bool
    {
        return Str::is([
            'cart',
            'compare',
            'wishlist',
            'login',
            'register',
            'password/reset*',
            'checkout*',
            'customer*',
            'orders/tracking*',
            'currency/switch/*',
        ], $path);
    }

    private function shouldNoindexListingPage(Request $request, string $path): bool
    {
        if ($request->getQueryString() === null || $request->getQueryString() === '') {
            return false;
        }

        $exactListingPaths = [
            'products',
            'product-categories',
            'allproducts',
            'search',
            'blog',
        ];

        if (in_array($path, $exactListingPaths, true)) {
            return true;
        }

        return Str::startsWith($path, 'allproducts/category/')
            || Str::startsWith($path, 'product-categories/')
            || Str::startsWith($path, 'sub/');
    }

    private function withoutLocalePrefix(string $path): string
    {
        foreach (['th', 'en'] as $locale) {
            if ($path === $locale) {
                return '';
            }

            if (Str::startsWith($path, $locale . '/')) {
                return Str::after($path, $locale . '/');
            }
        }

        return $path;
    }

    private function buildContentSecurityPolicy(Request $request): string
    {
        $scriptSrc = self::BASE_SCRIPT_SRC;
        $path = $this->withoutLocalePrefix(trim($request->path(), '/'));

        if (Str::startsWith($path, 'admin')) {
            $scriptSrc[] = "'unsafe-eval'";
        }

        $directives = [
            "default-src 'self'",
            "base-uri 'self'",
            "object-src 'none'",
            "frame-ancestors 'self'",
            "form-action 'self'",
            'script-src ' . implode(' ', $scriptSrc),
            'style-src ' . implode(' ', self::BASE_STYLE_SRC),
            "img-src 'self' data: blob: https:",
            "font-src 'self' data: https://fonts.gstatic.com https://cdnjs.cloudflare.com https://cdn.jsdelivr.net",
            'connect-src ' . implode(' ', self::BASE_CONNECT_SRC),
            'frame-src ' . implode(' ', self::BASE_FRAME_SRC),
            "media-src 'self' data: blob: https:",
            "worker-src 'self' blob:",
            "manifest-src 'self'",
            "upgrade-insecure-requests",
        ];

        return implode('; ', $directives);
    }
}
