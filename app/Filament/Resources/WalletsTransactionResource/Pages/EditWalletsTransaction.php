<?php

namespace App\Filament\Resources\WalletsTransactionResource\Pages;

use App\Filament\Resources\WalletsTransactionResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditWalletsTransaction extends EditRecord
{
    protected static string $resource = WalletsTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
            Action::make('New')
                ->color('info')
                ->url(WalletsTransactionResource::getUrl('create'))
        ];
    }
}
