<?php

namespace App\Filament\Resources\WalletsTransactionResource\Pages;

use App\Filament\Resources\WalletsTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWalletsTransaction extends ViewRecord
{
    protected static string $resource = WalletsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
