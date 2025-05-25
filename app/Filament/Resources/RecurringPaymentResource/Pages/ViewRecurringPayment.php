<?php

namespace App\Filament\Resources\RecurringPaymentResource\Pages;

use App\Filament\Resources\RecurringPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewRecurringPayment extends ViewRecord
{
    protected static string $resource = RecurringPaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
