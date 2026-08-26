<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static $exchangeRates = [
        'USD' => 1.0,
        'EUR' => 0.92,
        'GBP' => 0.79,
        'JPY' => 151.0,
        'CAD' => 1.36,
        'AUD' => 1.53,
        'INR' => 83.0,
        'TZS' => 2540.0,
        'KES' => 130.5,
        'UGX' => 3800.0,
        'ZAR' => 18.5,
    ];

    public static $currencySymbols = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'CAD' => 'C$',
        'AUD' => 'A$',
        'INR' => '₹',
        'TZS' => 'TSh',
        'KES' => 'KSh',
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

    public static function getRatesWithSymbols()
    {
        return array_map(fn($code) => [
            'rate' => self::$exchangeRates[$code],
            'symbol' => self::$currencySymbols[$code],
        ], array_keys(self::$exchangeRates));
    }
}
