<?php

namespace App\Repositories\Interfaces;

interface CurrencyRepositoryInterface extends RepositoryInterface
{
    public function updateExchangeRates(array $exchangeRates): void;
}
