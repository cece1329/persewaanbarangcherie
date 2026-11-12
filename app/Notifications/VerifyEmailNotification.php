<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmailNotification extends BaseVerifyEmail
{
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
            ->line('Tautan verifikasi ini berlaku selama 60 menit.')
            ->line('Jika kamu tidak merasa mendaftar di ChérieRent, abaikan saja email ini.')
            ->salutation("Salam hangat,\nTim Atelier ChérieRent");
    }
}
