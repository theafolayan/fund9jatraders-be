<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductLowStockNotification extends Notification
{
    use Queueable;
    protected $stock;
    protected $productType;

    /**
     * Create a new notification instance.
     */
    public function __construct($stock, $productType)
    {
        $this->stock = $stock;
        $this->productType = $productType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('Hello Admin')
            ->line($this->productType . 'is running out of stock, you have' . $this->stock . 'left . Please restock as soon as possible to avoid errors.')
            ->action('Go to dashboard', url('https://admin.fund9jatraders.com'));
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
