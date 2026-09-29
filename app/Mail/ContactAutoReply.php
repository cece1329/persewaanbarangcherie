<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $contactMessage) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✉️ Terima kasih sudah menghubungi ChérieRent!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-auto-reply',
        );
    }
}
