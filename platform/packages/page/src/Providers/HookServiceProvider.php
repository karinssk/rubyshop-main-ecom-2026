<?php

namespace Botble\Page\Providers;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Supports\RepositoryHelper;
use Botble\Base\Supports\ServiceProvider;
use Botble\Dashboard\Events\RenderingDashboardWidgets;
use Botble\Dashboard\Supports\DashboardWidgetInstance;
use Botble\Media\Facades\RvMedia;
use Botble\Menu\Events\RenderingMenuOptions;
use Botble\Menu\Facades\Menu;
use Botble\Page\Models\Page;
use Botble\Page\Services\PageService;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Models\Slug;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\NameColumn;
use Botble\Theme\Events\RenderingThemeOptionSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class HookServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Menu::addMenuOptionModel(Page::class);

        $this->app['events']->listen(RenderingMenuOptions::class, function (): void {
            add_action(MENU_ACTION_SIDEBAR_OPTIONS, [$this, 'registerMenuOptions'], 10);
        });

        $this->app['events']->listen(RenderingDashboardWidgets::class, function (): void {
            add_filter(DASHBOARD_FILTER_ADMIN_LIST, [$this, 'addPageStatsWidget'], 15, 2);
        });

        add_filter(BASE_FILTER_PUBLIC_SINGLE_DATA, [$this, 'handleSingleView'], 1);

        $this->app['events']->listen(RenderingThemeOptionSettings::class, function (): void {
            $pages = Page::query()
                ->wherePublished();

            $pages = RepositoryHelper::applyBeforeExecuteQuery($pages, new Page())
                ->pluck('name', 'id')
                ->all();

            theme_option()
                ->when($pages, function () use ($pages): void {
                    theme_option()
                        ->setSection([
                            'title' => trans('packages/page::pages.theme_options.title'),
                            'id' => 'opt-text-subsection-page',
                            'subsection' => true,
                            'icon' => 'ti ti-book',
                            'fields' => [
                                [
                                    'id' => 'homepage_id',
                                    'type' => 'customSelect',
                                    'label' => trans('packages/page::pages.theme_options.your_home_page_display'),
                                    'attributes' => [
                                        'name' => 'homepage_id',
                                        'list' => [0 => trans('core/base::forms.select_placeholder')] + $pages,
                                        'value' => '',
                                        'options' => [
                                            'class' => 'form-control',
                                        ],
                                    ],
                                ],
                            ],
                        ]);
                });
        });

        $this->app['events']->listen(RouteMatched::class, function (): void {
            if (defined('THEME_FRONT_HEADER')) {
                add_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, function ($screen, $page): void {
                    add_filter(THEME_FRONT_HEADER, function (?string $html) use ($page): string|null {
                        if (get_class($page) != Page::class) {
                            return $html;
                        }

                        // Check if this is the home page
                        $isHomePage = $page->url === BaseHelper::getHomepageUrl() || $page->template === 'homepage';
                        
                        if ($isHomePage) {
                            // Static/Hardcoded LocalBusiness schema for home page with complete business information
                            $schema = [
                                '@context' => 'https://schema.org',
                                '@type' => 'LocalBusiness',
                                'name' => 'RUBYSHOP',
                                'alternateName' => 'รูบี้ช๊อป',
                                'description' => 'ศูนย์รวมเครื่องมือช่าง อุปกรณ์ก่อสร้าง และเทคโนโลยีงานช่างครบวงจร - พ่นปูน, พ่นสีแรงดันสูง, กรีดผนังเซาะร่อง, ฉีดโพม, กันซึม',
                                'image' => 'https://www.rubyshop.co.th/logo.png',
                                '@id' => 'https://www.rubyshop.co.th/',
                                'url' => 'https://www.rubyshop.co.th/',
                                'telephone' => '+66-89-666-7802',
                                'email' => 'info@rubyshop.co.th',
                                'address' => [
                                    '@type' => 'PostalAddress',
                                    'streetAddress' => '9 ถนนประชาอุทิศ แขวงสีกัน เขตดอนเมือง',
                                    'addressLocality' => 'เขตดอนเมือง',
                                    'addressRegion' => 'กรุงเทพมหานคร',
                                    'postalCode' => '10210',
                                    'addressCountry' => 'TH'
                                ],
                                'geo' => [
                                    '@type' => 'GeoCoordinates',
                                    'latitude' => 14.0273154,
                                    'longitude' => 100.1725207
                                ],
                                'openingHoursSpecification' => [
                                    [
                                        '@type' => 'OpeningHoursSpecification',
                                        'dayOfWeek' => [
                                            'Monday',
                                            'Tuesday',
                                            'Wednesday',
                                            'Thursday',
                                            'Friday',
                                            'Saturday'
                                        ],
                                        'opens' => '08:30',
                                        'closes' => '17:30'
                                    ]
                                ],
                                'sameAs' => [
                                    'https://www.facebook.com/photo/?fbid=707251024751513&set=a.432474452229173',
                                    'https://maps.app.goo.gl/8QtWpT29vT1Rspgq8',
                                    'https://www.instagram.com/rubyshop_168/',
                                    'https://www.youtube.com/channel/UCxiaZiIC8qs2C228jwIjcHg'
                                ],
                                'priceRange' => '฿฿',
                                'paymentAccepted' => ['Cash', 'Credit Card', 'Bank Transfer'],
                                'currenciesAccepted' => 'THB',
                                'areaServed' => [
                                    [
                                        '@type' => 'Country',
                                        'name' => 'Thailand'
                                    ],
                                    [
                                        '@type' => 'City',
                                        'name' => 'Bangkok'
                                    ]
                                ],
                                'serviceArea' => [
                                    '@type' => 'GeoCircle',
                                    'geoMidpoint' => [
                                        '@type' => 'GeoCoordinates',
                                        'latitude' => 14.0273154,
                                        'longitude' => 100.1725207
                                    ],
                                    'geoRadius' => '50000'
                                ],
                                'hasOfferCatalog' => [
                                    '@type' => 'OfferCatalog',
                                    'name' => 'เครื่องมือช่างและอุปกรณ์ก่อสร้าง',
                                    'itemListElement' => [
                                        [
                                            '@type' => 'OfferCatalog',
                                            'name' => 'เครื่องพ่นสีแรงดันสูง Airless Sprayer'
                                        ],
                                        [
                                            '@type' => 'OfferCatalog',
                                            'name' => 'เครื่องพ่นปูน Mortar Sprayer'
                                        ],
                                        [
                                            '@type' => 'OfferCatalog',
                                            'name' => 'เครื่องกรีดผนัง Wall Chaser'
                                        ],
                                        [
                                            '@type' => 'OfferCatalog',
                                            'name' => 'เครื่องฉีดโพม Foam Injection'
                                        ]
                                    ]
                                ],
                                'founder' => [
                                    '@type' => 'Person',
                                    'name' => 'RUBYSHOP Founder'
                                ],
                                'foundingDate' => '2015',
                                'slogan' => 'ศูนย์รวมเครื่องมือช่างครบวงจร'
                            ];
                        } else {
                            // Regular Organization schema for other pages
                            $schema = [
                                '@context' => 'https://schema.org',
                                '@type' => 'Organization',
                                'name' => rescue(fn () => SeoHelper::openGraph()->getProperty('site_name')),
                                'url' => $page->url,
                                'logo' => [
                                    '@type' => 'ImageObject',
                                    'url' => RvMedia::getImageUrl(theme_option('logo')),
                                ],
                            ];
                        }

                        return $html . Html::tag('script', json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT), ['type' => 'application/ld+json'])
                                ->toHtml();
                    }, 2);
                }, 2, 2);
            }

            add_filter(PAGE_FILTER_FRONT_PAGE_CONTENT, fn (?string $html) => (string) $html, 1, 2);

            add_filter('table_name_column_data', [$this, 'appendPageName'], 2, 3);
        });
    }

    public function appendPageName(string $value, Model $model, Column $column)
    {
        if ($column instanceof NameColumn && $model instanceof Page) {
            $value = apply_filters(PAGE_FILTER_PAGE_NAME_IN_ADMIN_LIST, $value, $model);
        }

        return $value;
    }

    public function registerMenuOptions(): void
    {
        if (Auth::guard()->user()->hasPermission('pages.index')) {
            Menu::registerMenuOptions(Page::class, trans('packages/page::pages.menu'));
        }
    }

    public function addPageStatsWidget(array $widgets, Collection $widgetSettings): array
    {
        $pages = Page::query()->wherePublished()->count();

        return (new DashboardWidgetInstance())
            ->setType('stats')
            ->setPermission('pages.index')
            ->setTitle(trans('packages/page::pages.pages'))
            ->setKey('widget_total_pages')
            ->setIcon('ti ti-files')
            ->setColor('yellow')
            ->setStatsTotal($pages)
            ->setRoute(route('pages.index'))
            ->setColumn('col-12 col-md-6 col-lg-3')
            ->init($widgets, $widgetSettings);
    }

    public function handleSingleView(Slug|array $slug): Slug|array
    {
        return (new PageService())->handleFrontRoutes($slug);
    }
}
