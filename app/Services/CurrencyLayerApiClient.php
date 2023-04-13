<?php

namespace App\Services;

use App\Enums\AvailableCurrencies;
use App\Exceptions\ApiException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyLayerApiClient
{
    protected string $url;

    private PendingRequest $http;

    public function __construct()
    {
        $this->http = Http::withHeaders(['apikey' => config('currency.currency_layer_api_key')])
            ->baseUrl(config('currency.currency_layer_api_url'));
    }

    public function getExchangeRates($baseCurrency)
    {
        $query = [
            'base'       => $baseCurrency,
            'currencies' => implode(', ', AvailableCurrencies::names()),
        ];

        $response = $this->http->get('/live', $query);

        if ($response->ok()) {
            return $response->json('quotes');
        }

        $errorInfo = $response['error']['info'];
        $errorCode = $response['error']['code'];
        Log::error('Currency Layer API error: ' . $errorInfo);

        throw new ApiException($errorInfo, $errorCode, null);
    }
}
