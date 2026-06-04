<?php

namespace App\Providers;

use Botble\Base\Facades\DashboardMenu;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');

        add_filter('core_seo_canonical', fn (string $url): string => $this->canonicalUrl($url), 20);

        DashboardMenu::default()->beforeRetrieving(function (): void {
            DashboardMenu::make()->registerItem([
                'id' => 'cms-app-line-feature',
                'priority' => 125,
                'name' => 'LINE Feature',
                'icon' => 'ti ti-brand-line',
                'route' => 'line-feature.index',
                'permissions' => false,
            ]);

            DashboardMenu::make()->registerItem([
                'id' => 'cms-app-seo-machine',
                'priority' => 126,
                'name' => 'SEO Machine',
                'icon' => 'ti ti-search',
                'route' => 'seo-machine.index',
                'permissions' => false,
            ]);
        });
    }

    private function canonicalUrl(string $url): string
    {
        $parts = parse_url($url);

        if (! is_array($parts)) {
            return $url;
        }

        $path = $parts['path'] ?? '/';
        return rtrim(config('app.url'), '/') . '/' . ltrim($path, '/');
    }
}
