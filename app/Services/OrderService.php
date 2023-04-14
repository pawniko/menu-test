<?php

namespace App\Services;

use App\Enums\AvailableCurrencies;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Repositories\Interfaces\OrderRepositoryInterface;

class OrderService
{
    public function __construct(
        protected CurrencyRepositoryInterface $currencyRepository,
        protected OrderRepositoryInterface $orderRepository,
    ) {
    }

    public function getCalculation(string $currencyCode, float $amount): array
    {
        $currency        = $this->currencyRepository->findBy(['code' => $currencyCode])->first();
        $currencyEnum    = AvailableCurrencies::from($currencyCode);
        $currencyAmount  = $amount;
        $surcharge       = $currencyEnum->surchargePercent();
        $price           = $currencyAmount / $currency->exchange_rate;
        $surchargeAmount = $price * ($surcharge / 100);
        $totalPaidAmount = $price + $surchargeAmount;

        if ($discount = $currencyEnum->discountPercentage()) {
            $totalDiscount   = ($discount / 100) * $surchargeAmount;
            $totalPaidAmount -= $totalDiscount;
        }

        return [
            'from_currency'         => config('currency.default'),
            'purchased_currency'    => $currency->code,
            'currency_amount'       => $currencyAmount,
            'exchange_rate'         => $currency->exchange_rate,
            'surcharge_percent'     => $surcharge,
            'surcharge_amount'      => $surchargeAmount,
            'total_paid_amount'     => $totalPaidAmount,
            'discount_percent'      => $discount,
            'discount_amount'       => $totalDiscount ?? null,
        ];
    }

    public function create(string $currencyCode, float $amount)
    {
        $data = $this->getCalculation($currencyCode, $amount);

        return $this->orderRepository->create($data);
    }
}
