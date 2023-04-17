<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use NumberFormatter;

class OrderDetails extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Order $order)
    {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Details',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.details',
            with: [
                'currency_amount'   => currencyFormatter($this->order->purchased_currency, $this->order->currency_amount),
                'surcharge_amount'  => currencyFormatter(config('currency.default'), $this->order->surcharge_amount),
                'total_paid_amount' => currencyFormatter(config('currency.default'), $this->order->total_paid_amount),
            ],
        );
    }
}
