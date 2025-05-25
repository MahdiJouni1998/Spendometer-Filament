<?php

namespace App\Filament\Resources\RecurringPaymentResource\Pages;

use App\Filament\Resources\RecurringPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRecurringPayment extends EditRecord
{
    protected static string $resource = RecurringPaymentResource::class;

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
