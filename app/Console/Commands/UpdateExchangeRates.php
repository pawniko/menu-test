<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Services\CurrencyLayerApiClient;
use Illuminate\Console\Command;

class UpdateExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:exchange_rates';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws \Exception
     */
    public function handle(
        CurrencyLayerApiClient $currencyLayerApiClient,
        CurrencyRepositoryInterface $currencyRepository,
    ) {
        $exchangeRatesFromApi = $currencyLayerApiClient->getExchangeRates(config('currency.default'));

        $modifiedKeys = array_map(function ($key) {
            return substr($key, 3);
        }, array_keys($exchangeRatesFromApi));

        $exchangeRates = array_combine($modifiedKeys, $exchangeRatesFromApi);

        $currencyRepository->updateExchangeRates($exchangeRates);
    }

}
