<?php

namespace App\Helpers;

class CurrencyHelper
{
    // Exchange rates relative to USD
    public static $exchangeRates = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'GBP' => 0.79,
        'KES' => 130.50,
        'TZS' => 2540.00,
        'UGX' => 3800.00,
        'ZAR' => 18.50,
    ];

    public static $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'KES' => 'KSh',
        'TZS' => 'TSh',
        'UGX' => 'USh',
        'ZAR' => 'R',
    ];

    public static function convert($amount, $fromCurrency, $toCurrency)
    {
        $fromRate = self::$exchangeRates[$fromCurrency] ?? 1.0;
        $toRate = self::$exchangeRates[$toCurrency] ?? 1.0;

        $amountInUSD = $amount / $fromRate;
        return $amountInUSD * $toRate;
    }

    public static function format($amount, $currency)
    {
        $symbol = self::$currencySymbols[$currency] ?? '$';
        return $symbol . number_format($amount, 0);
    }

    public static function getSupportedCurrencies()
    {
        return array_keys(self::$exchangeRates);
    }
}
