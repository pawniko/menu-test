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
        $fromCurrencyformatter = new NumberFormatter(config('currency.formatter_local'), NumberFormatter::CURRENCY);
        $fromCurrencyformatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, config('currency.default'));

        $toCurrencyformatter = clone $fromCurrencyformatter;
        $toCurrencyformatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $this->order->purchasedCurrency->code);

        return new Content(
            markdown: 'emails.orders.details',
            with: [
                'currencyAmount'  => $toCurrencyformatter->format($this->order->currency_amount),
                'surchargeAmount' => $fromCurrencyformatter->format($this->order->surcharge_amount),
                'totalPaidAmount' => $fromCurrencyformatter->format($this->order->total_paid_amount),
            ],
        );
    }
}
