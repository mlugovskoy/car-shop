<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(private Order $order)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            to: [
                'admin@example.com',
                $this->order->email
            ],
            subject: 'Заказ оформлен',
            tags: ['shipment'],
            metadata: [
                'order_id' => $this->order->id
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-shipped',
            with: [
                'order' => $this->order
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
