<?php

namespace App\Notifications;

use App\Settings\PlatformSettings;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductPurchaseNotification extends Notification
{
    use Queueable;
    protected $product;
    protected $order;
    protected $challenge;

    /**
     * Create a new notification instance.
     */
    public function __construct($product, $order)
    {
        $this->product = $product;
        $this->order = $order;
        $this->challenge = $this->order->product_type == "ONE" ? app(PlatformSettings::class)->product_one_title : ($this->order->product_type == "TWO" ? app(PlatformSettings::class)->product_two_title : app(PlatformSettings::class)->product_three_title);
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
            ->subject("Your new trading account details ")
            ->line("Dear {$notifiable->name}, Access to your trading account is below:")
            ->line("Product: {$this->challenge} Account")
            ->line("Platform: MT4")
            ->line("Server: {$this->product->server}")
            ->line("Login: {$this->product->account_number}")
            ->line("Password: {$this->product->traders_password}")
            ->line("⛔ DO NOT CHANGE THIS PASSWORD OR YOU WILL BE BANNED ⛔ ")
            ->line("Leverage: {$this->product->leverage}")
            ->line("Thanks! You are now part of Fund9jatraders")
            ->line("If you have any questions, please contact us at: hi@fund9jatraders.com")
            ->line("Happy Trading!")
            ->action('Download Apps', url('https://app.fund9jatraders.com/admin/downloads'));
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
