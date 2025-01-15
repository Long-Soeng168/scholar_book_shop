<?php

namespace App\Notifications;

use App\Models\Book;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramFile;
use NotificationChannels\Telegram\TelegramMessage;

class MyTelegramMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $phone;
    public $name;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($phone, $name, $message)
    {
        $this->phone = $phone;
        $this->name = $name;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    /**
     * Get the Telegram representation of the notification.
     */
    public function toTelegram(object $notifiable)
    {
        return TelegramMessage::create()
            ->content(
                "*📩 New Message Received!*\n\n" .
                    "👤 *Name:* {$this->name}\n" .
                    "📱 *Phone:* {$this->phone}\n" .
                    "💬 *Message:* {$this->message}\n"
            )->to('-1002219528184'); // Send the image as a photo
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
