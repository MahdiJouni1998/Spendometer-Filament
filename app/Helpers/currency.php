<?php

use App\Models\Currency;

function currencies(): array
{
    return Currency::all()->pluck('symbol', 'name')->toArray();
}

function currencyNames(): array
{
    return Currency::all()->pluck('name')->toArray();
}

function getAllCurrenciesSymbols(): array
{
    $currencies = [];
    $all_currencies = \Akaunting\Money\Currency::getCurrencies();
//    dd($all_currencies);
    foreach ($all_currencies as $currency => $details) {
        $currency_lower = strtolower($currency);
        if($currency_lower == 'ils') continue;
        $currencies[$currency_lower] = $details['symbol'];
    }
    return $currencies;
}

function getAllCurrenciesNames(): array
{
    $currencies = [];
    $all_currencies = \Akaunting\Money\Currency::getCurrencies();
//    dd($all_currencies);
    foreach ($all_currencies as $currency => $details) {
        $currency_lower = strtolower($currency);
        if($currency_lower == 'ils') continue;
        $currencies[$currency_lower] = $currency;
    }
    return $currencies;
}
