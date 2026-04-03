<?php

namespace App\Http\Controllers\Admin;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Contact\Models\Contact;
use Botble\Ecommerce\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

class LineFeatureController extends BaseController
{
    public function index(): View
    {
        $this->pageTitle('LINE Feature');

        $notificationTo = (string) (
            config('services.line.notification_to')
            ?: config('services.line.messaging_to')
        );

        $channelSecret = (string) config('services.line.notification_channel_secret');
        $accessToken = (string) (
            config('services.line.notification_channel_access_token')
            ?: config('services.line.messaging_channel_access_token')
        );

        $contactStats = $this->getContactStats();
        $orderStats = $this->getOrderStats();

        $quickLinks = array_filter([
            [
                'label' => 'View Orders',
                'description' => 'Open ecommerce order list',
                'url' => Route::has('orders.index') ? route('orders.index') : null,
            ],
            [
                'label' => 'View Contacts',
                'description' => 'Open contact form messages',
                'url' => Route::has('contacts.index') ? route('contacts.index') : null,
            ],
            [
                'label' => 'Contact Settings',
                'description' => 'Open contact plugin settings',
                'url' => Route::has('contact.settings') ? route('contact.settings') : null,
            ],
        ], fn (array $item) => filled($item['url']));

        return view('admin.line-feature', [
            'pageData' => [
                'config' => [
                    'user_id' => $this->maskValue($notificationTo),
                    'user_id_configured' => filled($notificationTo),
                    'channel_secret' => $this->maskValue($channelSecret),
                    'channel_secret_configured' => filled($channelSecret),
                    'access_token' => $this->maskValue($accessToken, 10, 6),
                    'access_token_configured' => filled($accessToken),
                ],
                'features' => [
                    [
                        'title' => 'Contact Form Notification',
                        'description' => 'Promotion/contact submissions send a LINE push after the contact is saved.',
                        'status' => filled($notificationTo) && filled($accessToken),
                        'link' => Route::has('contacts.index') ? route('contacts.index') : null,
                    ],
                    [
                        'title' => 'Customer Order Notification',
                        'description' => 'Customer checkout orders send a LINE push when an order is placed.',
                        'status' => filled($notificationTo) && filled($accessToken),
                        'link' => Route::has('orders.index') ? route('orders.index') : null,
                    ],
                    [
                        'title' => 'Messaging API Credentials',
                        'description' => 'Uses the notification mapping from your .env values for LINE user ID and channel access token.',
                        'status' => filled($notificationTo) && filled($channelSecret) && filled($accessToken),
                        'link' => null,
                    ],
                ],
                'stats' => [
                    'contacts' => $contactStats,
                    'orders' => $orderStats,
                ],
                'quick_links' => $quickLinks,
            ],
        ]);
    }

    protected function getContactStats(): array
    {
        if (! function_exists('is_plugin_active') || ! is_plugin_active('contact')) {
            return [
                'enabled' => false,
                'count' => 0,
                'latest_at' => null,
            ];
        }

        return [
            'enabled' => true,
            'count' => Contact::query()->count(),
            'latest_at' => Contact::query()->latest('created_at')->value('created_at'),
        ];
    }

    protected function getOrderStats(): array
    {
        if (! function_exists('is_plugin_active') || ! is_plugin_active('ecommerce')) {
            return [
                'enabled' => false,
                'count' => 0,
                'latest_at' => null,
            ];
        }

        return [
            'enabled' => true,
            'count' => Order::query()->count(),
            'latest_at' => Order::query()->latest('created_at')->value('created_at'),
        ];
    }

    protected function maskValue(?string $value, int $visibleStart = 6, int $visibleEnd = 4): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return 'Not configured';
        }

        $length = strlen($value);

        if ($length <= ($visibleStart + $visibleEnd)) {
            return str_repeat('*', $length);
        }

        return substr($value, 0, $visibleStart)
            . str_repeat('*', max($length - $visibleStart - $visibleEnd, 4))
            . substr($value, -$visibleEnd);
    }
}
