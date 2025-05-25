<?php

namespace App\Filament\Widgets;

use Akaunting\Money\Currency;
use App\Models\Wallet;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use function Filament\Support\format_money;

class WalletsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $wallets = Wallet::all();
        $stats = [];
        foreach ($wallets as $wallet) {
            foreach ($wallet->balances()->get() as $balance) {
                $c = $balance->currency;
                $amount = money($balance->amount * 100, $c)->formatWithoutZeroes();
                $stats[] = Stat::make($balance->name, $amount);
            }
        }
        return $stats;
    }
}
