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

    public function getCalculation(array $data): array
    {
        $currency     = $this->currencyRepository->findBy(['code' => $data['currency_code']])->first();
        $currencyEnum = AvailableCurrencies::from($data['currency_code']);

        $currencyAmount  = $data['amount'];
        $exchangeRate    = $currency->exchange_rate;
        $surcharge       = $currencyEnum->surchargePercent();
        $price           = $currencyAmount / $exchangeRate;
        $surchargeAmount = $price * ($surcharge / 100);
        $totalPaidAmount = $price + $surchargeAmount;

        if ($discount = $currencyEnum->discountPercentage()) {
            $totalDiscount   = ($discount / 100) * $surchargeAmount;
            $totalPaidAmount -= $totalDiscount;
        }

        return [
            'from_currency'         => config('currency.default'),
            'purchased_currency_id' => $currency->id,
            'currency_amount'       => $currencyAmount,
            'exchange_rate'         => $exchangeRate,
            'surcharge_percent'     => $surcharge,
            'surcharge_amount'      => $surchargeAmount,
            'total_paid_amount'     => $totalPaidAmount,
            'discount_percent'      => $discount,
            'discount_amount'       => $totalDiscount ?? null,
        ];
    }

    public function create(array $data)
    {
        $data = $this->getCalculation($data);

        return $this->orderRepository->create($data);
    }
}
