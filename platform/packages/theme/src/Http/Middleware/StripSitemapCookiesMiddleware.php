<?php

namespace Botble\Theme\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StripSitemapCookiesMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $this->isSitemapRequest($request)) {
            return $response;
        }

        foreach ($response->headers->getCookies() as $cookie) {
            $response->headers->removeCookie($cookie->getName(), $cookie->getPath(), $cookie->getDomain());
        }

        $response->headers->remove('Set-Cookie');
        $response->headers->set('Cache-Control', 'public, max-age=14400, s-maxage=14400');

        return $response;
    }

    private function isSitemapRequest(Request $request): bool
    {
        if ($request->routeIs('public.sitemap.index')) {
            return true;
        }

        return in_array(trim($request->path(), '/'), [
            'sitemap.xml',
            'pages.xml',
            'blog-tags.xml',
        ], true);
    }
}
