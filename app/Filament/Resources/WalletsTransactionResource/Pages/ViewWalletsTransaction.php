<?php

namespace App\Filament\Resources\WalletsTransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Resources\WalletsTransactionResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewWalletsTransaction extends ViewRecord
{
    protected static string $resource = WalletsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Action::make('New')
                ->color('info')
                ->url(WalletsTransactionResource::getUrl('create'))
        ];
    }
}
