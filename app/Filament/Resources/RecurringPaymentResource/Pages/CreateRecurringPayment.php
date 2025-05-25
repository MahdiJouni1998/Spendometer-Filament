<?php

namespace App\Filament\Resources\RecurringPaymentResource\Pages;

use App\Filament\Resources\RecurringPaymentResource;
use App\Models\RecurringPaymentsLog;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateRecurringPayment extends CreateRecord
{
    protected static string $resource = RecurringPaymentResource::class;
}
