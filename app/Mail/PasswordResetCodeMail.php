<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordResetCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $code,
        public string $userName,
        public int $minutes = 15,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('messages.mail_subject'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reset-code',
        );
    }
}
