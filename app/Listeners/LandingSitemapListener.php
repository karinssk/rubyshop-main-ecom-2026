<?php

namespace App\Listeners;

use Botble\Theme\Events\RenderingSiteMapEvent;
use Botble\Theme\Facades\SiteMapManager;

class LandingSitemapListener
{
    protected array $hardcodedLpPages = [
        ['url' => 'https://www.rubyshop.co.th/lp/rb-360', 'date' => '2025-01-01 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/rb-360-pro', 'date' => '2025-01-01 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/rb-360-quote', 'date' => '2025-01-01 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/rb-899-v2', 'date' => '2025-01-01 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/airless-sprayer-thailand', 'date' => '2026-06-05 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/airless-sprayer-price', 'date' => '2026-06-05 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/drywall-sander', 'date' => '2026-06-05 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/wall-chaser', 'date' => '2026-06-05 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/airless-spray-gun', 'date' => '2026-06-05 00:00:00'],
        ['url' => 'https://www.rubyshop.co.th/lp/airless-hose', 'date' => '2026-06-05 00:00:00'],
    ];

    public function handle(RenderingSiteMapEvent $event): void
    {
        if ($event->key === 'landings') {
            // Add hardcoded /lp/* pages
            foreach ($this->hardcodedLpPages as $page) {
                SiteMapManager::add($page['url'], $page['date'], '0.8', 'weekly');
            }

            return;
        }

        // When key is null we are building the sitemap index — add our sub-sitemap
        if ($event->key === null) {
            $latestUpdated = collect($this->hardcodedLpPages)->max('date');

            SiteMapManager::addSitemap(
                SiteMapManager::route('landings'),
                $latestUpdated ?: now()->toDateTimeString()
            );
        }
    }
}
