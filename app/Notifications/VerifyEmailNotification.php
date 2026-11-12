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
        $otpCode = method_exists($notifiable, 'generateEmailOtp')
            ? $notifiable->generateEmailOtp()
            : '123456';

        $recipientName = ! empty($notifiable->name) ? $notifiable->name : 'Pelanggan ChérieRent';

        return (new MailMessage)
            ->from('rentcherie@gmail.com', 'ChérieRent Atelier')
            ->replyTo('rentcherie@gmail.com', 'ChérieRent Atelier')
            ->subject('Kode Verifikasi Akun ChérieRent: '.$otpCode)
            ->view('emails.verify-email-code', [
                'recipientName' => $recipientName,
                'otpCode' => $otpCode,
                'verificationUrl' => $verificationUrl,
            ]);
    }
}

