<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail
{
    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(120),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Get the verify email notification mail message for the given URL.
     *
     * @param  string  $url
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject('🎀 Verifikasi Alamat Email Akun ChérieRent')
            ->greeting('Halo, Cantik!')
            ->line('Terima kasih telah bergabung di ChérieRent Couture & Rental Atelier.')
            ->line('Untuk mengaktifkan akunmu dan memastikan reservasi gaun aman, silakan klik tombol di bawah ini untuk memverifikasi alamat email kamu:')
            ->action('Verifikasi Email Saya ✨', $url)
            ->line('Tautan verifikasi ini berlaku selama 120 menit.')
            ->line('Jika kamu tidak merasa mendaftar di ChérieRent, abaikan saja email ini.')
            ->salutation("Salam hangat,\nTim Atelier ChérieRent");
    }
}

