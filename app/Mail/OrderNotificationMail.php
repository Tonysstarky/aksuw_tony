<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '💧 Täze Suw Sargydy #' . $this->order->id . ' — ' . ($this->order->water->name ?? 'Suw'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-notification',
        );
    }
}
