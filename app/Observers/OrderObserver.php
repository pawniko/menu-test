<?php

namespace App\Observers;

use App\Enums\AvailableCurrencies;
use App\Mail\OrderDetails;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OrderObserver
{
    public function creating(Order $order)
    {
        if (empty($order->user_id)) {
            $order->user_id = Auth::id();
        }
    }

    public function created(Order $order)
    {
        if (AvailableCurrencies::tryFrom($order->purchasedCurrency->code)?->sendEmail()) {
            Mail::to($order->user->email)->send(new OrderDetails($order));
        }
    }
}
