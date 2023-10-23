<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeUserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
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
            ->subject(sprintf('Welcome to Fund9jaTraders %s !', $notifiable->name))

            ->line(sprintf("Hello %s !", $notifiable->name))
            ->line("We provide the capital, you trade, and we pay you up to 80% of your profit plus your registration fee.
            ")
            ->line('Buy your first challenge account now to get started
            ')
            ->action('Buy Now', url('https://app.fund9jatraders.com'))
            ->line('If you run into issues while buying, you can get our real-time chat support via WhatsApp or  write to us at hi@fund9jatraders.com
            ')
            ->line('Happy Trading,
            ')->line(' Fund9jaTraders
            ');
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
