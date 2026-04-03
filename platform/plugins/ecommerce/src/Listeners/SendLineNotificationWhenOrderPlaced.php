<?php

namespace Botble\Ecommerce\Listeners;

use Botble\Base\Facades\BaseHelper;
use Botble\Ecommerce\Events\OrderPlacedEvent;
use Botble\Ecommerce\Models\Order;
use Botble\Ecommerce\Models\OrderProduct;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SendLineNotificationWhenOrderPlaced
{
    public function handle(OrderPlacedEvent $event): void
    {
        $order = $event->order->loadMissing([
            'shippingAddress',
            'payment',
            'products.product',
            'user',
        ]);

        $message = $this->buildLineMessage($order);

        if ($this->sendLineMessagingApiNotification($message)) {
            return;
        }

        $this->sendLineNotifyNotification($message);
    }

    protected function buildLineMessage(Order $order): string
    {
        $shippingAddress = $order->shippingAddress;

        $customerName = $shippingAddress->name ?: $order->user->name ?: '-';
        $customerPhone = $shippingAddress->phone ?: '-';
        $customerEmail = $shippingAddress->email ?: $order->user->email ?: '-';
        $paymentMethod = $this->resolvePaymentMethod($order);
        $paymentStatus = $this->resolvePaymentStatus($order);
        $orderStatus = $this->resolveLabel($order->status);
        $products = $this->formatProducts($order);

        return Str::limit(implode("\n", [
            'แจ้งเตือนออเดอร์ใหม่',
            'เลขที่คำสั่งซื้อ: ' . ($order->code ?: '#' . $order->id),
            'ชื่อลูกค้า: ' . $customerName,
            'เบอร์โทร: ' . $customerPhone,
            'อีเมล: ' . $customerEmail,
            'ยอดรวม: ' . format_price($order->amount),
            'ชำระเงิน: ' . $paymentMethod,
            'สถานะชำระเงิน: ' . $paymentStatus,
            'สถานะคำสั่งซื้อ: ' . $orderStatus,
            'สินค้า: ' . $products,
            'เวลา: ' . optional($order->created_at)->format('Y-m-d H:i:s'),
            'ดูออเดอร์: ' . route('orders.edit', $order->id),
        ]), 4900, '');
    }

    protected function formatProducts(Order $order): string
    {
        $items = $order->products
            ->take(5)
            ->map(function (OrderProduct $item): string {
                $name = trim((string) ($item->product_name ?: $item->product?->name ?: 'Product #' . $item->product_id));
                $options = $item->product_options_implode ? ' ' . $item->product_options_implode : '';

                return $name . $options . ' x' . $this->formatQuantity($item->qty);
            })
            ->implode(', ');

        $remaining = $order->products->count() - 5;

        if ($remaining > 0) {
            $items .= ' +' . $remaining . ' more';
        }

        return $items ?: '-';
    }

    protected function formatQuantity(float|int|string|null $quantity): string
    {
        $quantity = (float) $quantity;

        if ((int) $quantity == $quantity) {
            return (string) (int) $quantity;
        }

        return rtrim(rtrim(number_format($quantity, 2, '.', ''), '0'), '.');
    }

    protected function resolvePaymentMethod(Order $order): string
    {
        if (! is_plugin_active('payment') || ! $order->payment->id) {
            return '-';
        }

        return $this->resolveLabel($order->payment->payment_channel);
    }

    protected function resolvePaymentStatus(Order $order): string
    {
        if (! is_plugin_active('payment') || ! $order->payment->id) {
            return '-';
        }

        return $this->resolveLabel($order->payment->status);
    }

    protected function resolveLabel(mixed $value): string
    {
        if (is_object($value) && method_exists($value, 'label')) {
            return (string) $value->label();
        }

        if (is_object($value) && method_exists($value, 'getValue')) {
            return (string) $value->getValue();
        }

        return $value ? (string) $value : '-';
    }

    protected function sendLineMessagingApiNotification(string $message): bool
    {
        $token = trim((string) (
            config('services.line.notification_channel_access_token')
            ?: config('services.line.messaging_channel_access_token')
        ));
        $to = trim((string) (
            config('services.line.notification_to')
            ?: config('services.line.messaging_to')
        ));

        if (! $token || ! $to) {
            return false;
        }

        try {
            $response = Http::withToken($token)
                ->acceptJson()
                ->asJson()
                ->timeout(10)
                ->post('https://api.line.me/v2/bot/message/push', [
                    'to' => $to,
                    'messages' => [
                        [
                            'type' => 'text',
                            'text' => $message,
                        ],
                    ],
                ]);

            if ($response->successful()) {
                return true;
            }

            BaseHelper::logError(new Exception(sprintf(
                'LINE order notification failed (%s): %s',
                $response->status(),
                $response->body()
            )));
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }

        return false;
    }

    protected function sendLineNotifyNotification(string $message): bool
    {
        $token = trim((string) config('services.line.notify_token'));

        if (! $token) {
            return false;
        }

        try {
            $response = Http::withToken($token)
                ->asForm()
                ->timeout(10)
                ->post('https://notify-api.line.me/api/notify', [
                    'message' => $message,
                ]);

            if ($response->successful()) {
                return true;
            }

            BaseHelper::logError(new Exception(sprintf(
                'LINE Notify order notification failed (%s): %s',
                $response->status(),
                $response->body()
            )));
        } catch (Exception $exception) {
            BaseHelper::logError($exception);
        }

        return false;
    }
}
