<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class MyTelegramBotNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param  mixed  $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \NotificationChannels\Telegram\TelegramMessage
     */
    public function toTelegram($notifiable)
    {
        $url = url('/admin/orders/' . $this->order->id); // Link to the order details

        return TelegramMessage::create()
            ->content(
                "*🎉 New Order Received!*\n\n" .
                "👤 *Name:* {$this->order->name}\n" .
                "📞 *Phone:* {$this->order->phone}\n" .
                "📝 *Note:* {$this->order->note}\n" .
                "💰 *Total Price:* \${$this->order->total}\n"
            )
            ->button('View Order', $url)
            ->to('-1002219528184');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'name' => $this->order->name,
            'phone' => $this->order->phone,
            'total' => $this->order->total,
            'note' => $this->order->note,
        ];
    }
}
