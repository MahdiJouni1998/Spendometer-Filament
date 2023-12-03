<?php

namespace App\Filament\Resources\IouResource\Pages;

use App\Filament\Resources\IouResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewIou extends ViewRecord
{
    protected static string $resource = IouResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
