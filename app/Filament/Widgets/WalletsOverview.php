<?php

namespace App\Filament\Widgets;

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
                $amount = format_money($balance->amount, $balance->currency);
                $stats[] = Stat::make($balance->name, $amount);
            }
        }
        return $stats;
    }
}
