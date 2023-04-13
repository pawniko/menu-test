<?php

if (!function_exists('currencyFormatter')) {
    function currencyFormatter($currency, $amount): bool|string
    {
        $formatter = new NumberFormatter(config('currency.formatter_local'), NumberFormatter::CURRENCY);
        $formatter->setTextAttribute(NumberFormatter::CURRENCY_CODE, $currency);

        return $formatter->format($amount);
    }
}
