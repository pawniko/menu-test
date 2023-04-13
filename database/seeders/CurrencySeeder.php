<?php

namespace Database\Seeders;

use App\Enums\AvailableCurrencies;
use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (AvailableCurrencies::cases() as $currency) {
            Currency::create([
                'code'          => $currency->name,
                'name'          => $currency->label(),
                'exchange_rate' => $currency->exchangeRate(),
            ]);
        }
    }
}
