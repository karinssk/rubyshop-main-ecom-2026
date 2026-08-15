<?php

namespace App\Providers;

use App\Listeners\LandingSitemapListener;
use Botble\Theme\Events\RenderingSiteMapEvent;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Line\LineExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        SocialiteWasCalled::class => [
            LineExtendSocialite::class . '@handle',
        ],
        RenderingSiteMapEvent::class => [
            LandingSitemapListener::class,
        ],
    ];
}
