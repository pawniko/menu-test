<?php

namespace App\Enums;

enum AvailableCurrencies: string
{
    use EnumHelper;

    case JPY = 'JPY';
    case GBP = 'GBP';
    case EUR = 'EUR';

    public function label(): ?string
    {
        return config('currency.available_currencies.'.$this->value.'.label');
    }

    public function surchargePercent(): ?float
    {
        return config('currency.available_currencies.'.$this->value.'.surcharge_percent');
    }

    public function sendEmail(): bool
    {
        return config('currency.available_currencies.'.$this->value.'.send_email');
    }

    public function discountPercentage(): ?int
    {
        return config('currency.available_currencies.'.$this->value.'.discount_percentage');
    }

    public function exchangeRate(): float
    {
        return config('currency.available_currencies.'.$this->value.'.exchange_rate');
    }
}
