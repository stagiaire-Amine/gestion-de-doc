<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Password Changed Successfully - ' . config('app.name'))
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('This is a confirmation that the password for your **' . config('app.name') . '** account has been successfully changed.')
            ->line('If you performed this action, no further steps are required.')
            ->line('**If you did not change your password, please contact our support team immediately or reset your password using the "Forgot Password" link on the login page.**')
            ->action('Login to Your Account', url('/login'))
            ->line('Thank you for using ' . config('app.name') . '!');
    }

    public function toArray($notifiable): array
    {
        return [];
    }
}
