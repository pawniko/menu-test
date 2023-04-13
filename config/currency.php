<?php

use App\Enums\AvailableCurrencies;

return [
    'default' => env('DEFAULT_CURRENCY', 'USD'),

    'formatter_local' => env('CURRENCY_FORMATTER_LOCAL', 'en_US'),

    'currency_layer_api_key' => env('CURRENCY_LAYER_API_KEY'),

    'currency_layer_api_url' => env('CURRENCY_LAYER_API_URL'),

    'available_currencies' => [
        AvailableCurrencies::JPY->value => [
            'label'               => 'Japanese Yen',
            'surcharge_percent'   => 7.5,
            'send_email'          => false,
            'discount_percentage' => null,
            'exchange_rate'       => 134,
        ],
        AvailableCurrencies::GBP->value => [
            'label'               => 'British Pound',
            'surcharge_percent'   => 5,
            'send_email'          => true,
            'discount_percentage' => null,
            'exchange_rate'       => 0.711178,
        ],
        AvailableCurrencies::EUR->value => [
            'label'               => 'Euro',
            'surcharge_percent'   => 5,
            'send_email'          => false,
            'discount_percentage' => 2,
            'exchange_rate'       => 0.884872,
        ],
    ],
];
