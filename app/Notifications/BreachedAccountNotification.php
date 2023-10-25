<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BreachedAccountNotification extends Notification
{
    use Queueable;

    protected $product;
    /**
     * Create a new notification instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
        //
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
            ->subject("Your assigned trading account has been breached")
            ->line("Dear {$notifiable->name}, Your assigned trading account {$this->product->account_number} on server {$this->product->server} was disabled for the following reason:
                ")
            ->line("Disqualified: - 20 percent maximum allowable loss.")
            ->line('If you have any questions, please contact us at: hi@fund9jatraders.com');
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
