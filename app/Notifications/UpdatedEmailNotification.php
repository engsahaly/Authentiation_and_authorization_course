<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdatedEmailNotification extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
            ->line('You are receiving this email because we received a password reset request for your account. 1111')
            ->line('You are receiving this email because we received a password reset request for your account. 2222')
            ->line('You are receiving this email because we received a password reset request for your account. 3333')
            ->line('You are receiving this email because we received a password reset request for your account. 4444')
            ->line('You are receiving this email because we received a password reset request for your account. 5555')
            ->action('Change Your Password', url('/reset-password', $this->token))
            ->line('This password reset link will expire in 60 minutes. 1111')
            ->line('This password reset link will expire in 60 minutes. 2222')
            ->line('This password reset link will expire in 60 minutes. 3333');
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
