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
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $verificationUrl);
        }

        $recipientName = ! empty($notifiable->name) ? $notifiable->name : 'Pelanggan ChérieRent';

        return (new MailMessage)
            ->from('rentcherie@gmail.com', 'ChérieRent Atelier')
            ->replyTo('rentcherie@gmail.com', 'ChérieRent Atelier')
            ->subject('Verifikasi Alamat Email - ChérieRent Atelier')
            ->greeting('Halo, ' . $recipientName . '!')
            ->line('Terima kasih telah mendaftar di ChérieRent Couture & Rental Atelier.')
            ->line('Untuk mengaktifkan akunmu dan memastikan keamanan reservasi gaun, silakan klik tombol di bawah ini untuk memverifikasi email kamu:')
            ->action('Verifikasi Email Saya', $verificationUrl)
            ->line('Tautan verifikasi ini berlaku selama 120 menit.')
            ->line('Jika kamu tidak merasa mendaftar di ChérieRent, abaikan email ini.')
            ->salutation("Salam hangat,\nTim ChérieRent Atelier\nJl. Flower Ribbon No. 12, Jakarta Selatan");
    }
}

