<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class OptimizePublicContentResponses
{
    /**
     * Cache only public content pages that do not contain cart or POST tokens.
     *
     * Ecommerce listing/product pages need the Laravel session for add-to-cart,
     * wishlist, compare, and checkout flows, so they are intentionally excluded.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->isCacheablePublicContentRequest($request, $response)) {
            return $response;
        }

        $content = method_exists($response, 'getContent') ? (string) $response->getContent() : '';

        if ($this->containsUnsafePublicForm($content)) {
            return $response;
        }

        if ($content !== '' && method_exists($response, 'setContent')) {
            $content = preg_replace(
                '/<meta\s+name=["\']csrf-token["\']\s+content=["\'][^"\']*["\']\s*>\s*/i',
                '',
                $content
            );
            $content = preg_replace(
                '/<input\s+[^>]*name=["\']_token["\'][^>]*>\s*/i',
                '',
                $content
            );

            $response->setContent($content);
        }

        $response->headers->remove('Set-Cookie');
        $response->headers->set('Cache-Control', 'public, max-age=300, s-maxage=1800, stale-while-revalidate=600');
        $response->headers->set('Vary', trim($response->headers->get('Vary') . ', Accept-Encoding, Cookie', ', '));

        return $response;
    }

    private function isCacheablePublicContentRequest(Request $request, Response $response): bool
    {
        if (! $request->isMethodCacheable() || $response->getStatusCode() !== 200) {
            return false;
        }

        if ($request->ajax() || $request->expectsJson()) {
            return false;
        }

        $contentType = (string) $response->headers->get('Content-Type');

        if ($contentType !== '' && ! Str::contains($contentType, ['text/html', 'text/plain', 'application/xml', 'text/xml'])) {
            return false;
        }

        $path = trim($request->path(), '/');

        if (Str::is([
            'admin*',
            'api*',
            'cart*',
            'checkout*',
            'compare*',
            'wishlist*',
            'customer*',
            'ajax*',
            'login',
            'register',
            'contact*',
            'orders/tracking*',
            'currency/switch*',
        ], $path)) {
            return false;
        }

        return Str::is([
            '',
            'products',
            'products/*',
            'product-categories',
            'product-categories/*',
            'categories',
            'allproducts',
            'allproducts/*',
            'search*',
            'blog*',
            'about*',
            'aboutcompany*',
            'privacy-policy*',
            'terms*',
            'return-policy*',
            'warranty*',
            'robots.txt',
            '*sitemap*.xml',
        ], $path);
    }

    private function containsUnsafePublicForm(string $content): bool
    {
        if ($content === '') {
            return false;
        }

        return Str::contains(Str::lower($content), [
            'checkout-token',
            'payment_method',
            'customer-address',
            'password_confirmation',
        ]);
    }
}
