<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'from_currency',
        'purchased_currency',
        'currency_amount',
        'exchange_rate',
        'surcharge_percent',
        'surcharge_amount',
        'total_paid_amount',
        'discount_percent',
        'discount_amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchasedCurrency()
    {
        return $this->belongsTo(Currency::class, 'purchased_currency', 'code');
    }
}
