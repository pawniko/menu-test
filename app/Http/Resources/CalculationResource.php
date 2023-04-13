<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CalculationResource extends JsonResource
{
    public function toArray($request): array
    {
        $defaultCurrency = config('currency.default');
        $surchargeAmount = round($this['surcharge_amount'], 2);
        $totalPaidAmount = round($this['total_paid_amount'], 2);
        $discountAmount  = round($this['discount_amount'], 2);

        $response = [
            'exchange_rate'     => $this['exchange_rate'],
            'surcharge_amount'  => currencyFormatter($defaultCurrency, $surchargeAmount),
            'total_paid_amount' => currencyFormatter($defaultCurrency, $totalPaidAmount),
        ];

        if (!empty($this['discount_percent'])) {
            $response += [
                'discount_percent' => $this['discount_percent'] . '%',
                'discount_amount'  => currencyFormatter($defaultCurrency, $discountAmount),
            ];
        }

        return $response;
    }
}
