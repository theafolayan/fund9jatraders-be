<?php

namespace App\Notifications;

use App\Models\WithdrawalRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WithdrawalRejectedNotification extends Notification
{
    use Queueable;

    protected $withdrawal;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(WithdrawalRequest $withdrawal)
    {
        $this->withdrawal = $withdrawal;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        // dd($this->withdrawal->reason);
        return (new MailMessage())
            ->subject('Withdrawal Rejected')
            ->line(sprintf(
                'Hello %s,',
                $notifiable->name
            ))
            ->line("Unfortunately, your withdrawal has been declined due to the following reason:
                ")
            ->line("**********")
            ->line("{$this->withdrawal->amount}")
            ->line("**********")
            ->line(sprintf(
                'Reason: %s',
                $this->withdrawal->reason
            ));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
