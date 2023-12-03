<?php

namespace App\Filament\Resources\IouResource\Pages;

use App\Filament\Resources\IouResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIous extends ListRecords
{
    protected static string $resource = IouResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
