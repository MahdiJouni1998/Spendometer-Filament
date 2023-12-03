<?php

namespace App\Filament\Resources\IouResource\Pages;

use App\Filament\Resources\IouResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIou extends EditRecord
{
    protected static string $resource = IouResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
