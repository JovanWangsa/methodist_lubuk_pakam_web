<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Email tautan atur ulang password admin.
 */
class AturUlangPassword extends Notification
{
    public function __construct(public string $token) {}

    /** @return array<int, string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $menit = config('auth.passwords.users.expire');

        return (new MailMessage)
            ->subject('Atur Ulang Password Admin Website')
            ->greeting('Halo, '.$notifiable->name)
            ->line('Kami menerima permintaan atur ulang password untuk akun admin website '.config('app.name').'.')
            ->action('Atur Ulang Password', route('password.reset', [
                'token' => $this->token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]))
            ->line("Tautan ini berlaku {$menit} menit.")
            ->line('Bila Anda tidak meminta atur ulang password, abaikan email ini.')
            ->salutation('Salam, Tim Website');
    }
}
