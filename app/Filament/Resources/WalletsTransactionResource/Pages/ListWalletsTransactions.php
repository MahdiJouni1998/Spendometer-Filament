<?php

namespace App\Filament\Resources\WalletsTransactionResource\Pages;

use App\Filament\Resources\WalletsTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWalletsTransactions extends ListRecords
{
    protected static string $resource = WalletsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
