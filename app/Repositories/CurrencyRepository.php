<?php

namespace App\Repositories;

use App\Models\Currency;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CurrencyRepository extends Repository implements CurrencyRepositoryInterface
{
    protected string $model = Currency::class;

    public function updateExchangeRates(array $exchangeRates): void
    {
        $this->getModel()->query()
            ->whereIn('code', array_keys($exchangeRates))
            ->update(['exchange_rate' => DB::raw('CASE code '.
                implode(' ', array_map(function ($code, $rate) {
                    return "WHEN '{$code}' THEN {$rate} ";
                }, array_keys($exchangeRates), $exchangeRates))
                .' END')
            ]);
    }
}
