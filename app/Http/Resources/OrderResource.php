<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        $defaultCurrency = config('currency.default');
        $currencyAmount  = round($this->currency_amount, 2);
        $surchargeAmount = round($this->surcharge_amount, 2);
        $totalPaidAmount = round($this->total_paid_amount, 2);
        $discountAmount  = round($this->discount_amount, 2);

        $response = [
            'id'                => $this->id,
            'currency_code'     => $this->purchasedCurrency->code,
            'currency_amount'   => currencyFormatter($this->purchasedCurrency->code, $currencyAmount),
            'exchange_rate'     => $this->exchange_rate,
            'surcharge_percent' => $this->surcharge_percent . '%',
            'surcharge_amount'  => currencyFormatter($defaultCurrency, $surchargeAmount),
            'total_paid_amount' => currencyFormatter($defaultCurrency, $totalPaidAmount),
            'created_at'        => $this->created_at->format('Y-m-d h:i:s'),
        ];

        if (!empty($this->discount_percent)) {
            $response += [
                'discount_percent' => $this->discount_percent,
                'discount_amount'  => currencyFormatter($defaultCurrency, $discountAmount),
            ];
        }

        return $response;
    }
}
