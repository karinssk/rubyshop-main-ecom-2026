<?php

namespace Botble\Theme\Supports;

use Botble\Base\Facades\BaseHelper;
use Botble\Sitemap\Sitemap;
use Botble\Slug\Facades\SlugHelper;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class SiteMapManager
{
    protected array $keys = ['sitemap', 'pages'];

    protected array $removedKeys = [];

    protected string $extension = 'xml';

    protected string $defaultDate = '2024-11-01 00:00';

    protected array $addedUrls = [];

    protected array $addedSitemaps = [];

    public function __construct(protected Sitemap $siteMap)
    {
    }

    public function init(?string $prefix = null, string $extension = 'xml'): self
    {
        // create new site map object
        $this->siteMap = app('sitemap');
        $this->addedUrls = [];
        $this->addedSitemaps = [];
        // set cache (key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean))
        // by default cache is disabled
        $this->siteMap->setCache('cache_site_map_key' . $prefix . $extension, setting('cache_time_site_map', 60), setting('enable_cache_site_map', true));

        if ($prefix == 'pages' && ! BaseHelper::getHomepageId()) {
            $this->add(BaseHelper::getHomepageUrl(), Carbon::now()->toDateTimeString());
        }

        $this->extension = $extension;

        if (! $prefix) {
            $this->addSitemap($this->route('pages'));
        }

        return $this;
    }

    public function addSitemap(string $loc, ?string $lastModified = null): self
    {
        $loc = $this->normalizeUrl($loc);
        $removedLoc = array_map(fn ($item) => $this->route($item), $this->removedKeys);

        if (! $this->isCached() && ! in_array($loc, $removedLoc) && ! isset($this->addedSitemaps[$loc])) {
            $this->addedSitemaps[$loc] = true;

            $this->siteMap->addSitemap($loc, $lastModified ?: $this->defaultDate);
        }

        return $this;
    }

    public function route(?string $key = null): string
    {
        return $this->normalizeUrl(route('public.sitemap.index', [$key, $this->extension]));
    }

    public function add(string $url, ?string $date = null, string $priority = '1.0', string $sequence = 'daily'): self
    {
        $url = $this->normalizeUrl($url);

        if (! $this->isCached()) {
            if ($this->shouldExcludeUrl($url) || isset($this->addedUrls[$url])) {
                return $this;
            }

            $this->addedUrls[$url] = true;

            $this->siteMap->add($url, $date ?: $this->defaultDate, $priority, $sequence);
        }

        return $this;
    }

    public function isCached(): bool
    {
        return $this->siteMap->isCached();
    }

    public function getSiteMap(): Sitemap
    {
        return $this->siteMap;
    }

    public function render(string $type = 'xml'): Response
    {
        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return $this->siteMap->render($type);
    }

    public function getKeys(): array
    {
        return array_filter($this->keys, fn ($item) => ! in_array($item, $this->removedKeys));
    }

    public function registerKey(string|array $key, ?string $value = null): self
    {
        if (is_array($key)) {
            $this->keys = array_merge($this->keys, $key);
        } else {
            $this->keys[$key] = $value ?: $key;
        }

        return $this;
    }

    public function removeKey(array|string $key): self
    {
        $this->removedKeys = [
            ...$this->removedKeys,
            ...(array) $key,
        ];

        return $this;
    }

    public function allowedExtensions(): array
    {
        $extensions = ['xml', 'html', 'txt', 'ror-rss', 'ror-rdf'];

        $slugPostfix = SlugHelper::getPublicSingleEndingURL();

        if (! $slugPostfix) {
            return $extensions;
        }

        $slugPostfix = trim($slugPostfix, '.');

        return array_filter($extensions, fn ($item) => $item != $slugPostfix);
    }

    protected function normalizeUrl(string $url): string
    {
        $canonicalRoot = $this->canonicalRoot();
        $parts = parse_url($url);

        if (! is_array($parts)) {
            return $url;
        }

        $path = preg_replace('#/+#', '/', $parts['path'] ?? '/');
        $path = '/' . ltrim($path, '/');

        if (Str::startsWith($path, '/index.php/')) {
            $path = '/' . Str::after($path, '/index.php/');
        } elseif ($path === '/index.php') {
            $path = '/';
        }

        return $canonicalRoot . ($path === '/' ? '/' : '/' . trim($path, '/'));
    }

    protected function canonicalRoot(): string
    {
        $parts = parse_url(config('app.url', 'https://www.rubyshop.co.th'));
        $scheme = $parts['scheme'] ?? 'https';
        $host = $parts['host'] ?? 'www.rubyshop.co.th';

        if ($host === 'rubyshop.co.th') {
            $host = 'www.rubyshop.co.th';
        }

        $port = isset($parts['port']) ? ':' . $parts['port'] : '';

        return sprintf('%s://%s%s', $scheme, $host, $port);
    }

    protected function shouldExcludeUrl(string $url): bool
    {
        $path = trim(parse_url($url, PHP_URL_PATH) ?: '/', '/');

        if (Str::startsWith($path, 'index.php/')) {
            $path = Str::after($path, 'index.php/');
        } elseif ($path === 'index.php') {
            $path = '';
        }

        $path = Str::lower($path);

        foreach (['th', 'en'] as $locale) {
            if ($path === $locale) {
                $path = '';

                break;
            }

            if (Str::startsWith($path, $locale . '/')) {
                $path = Str::after($path, $locale . '/');

                break;
            }
        }

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
            'homepage-3',
            'homepage-4',
            'blog-left-sidebar',
        ], $path);
    }
}
