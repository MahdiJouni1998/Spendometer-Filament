<?php

namespace App\Filament\Resources\IncomeResource\Pages;

use App\Filament\Resources\IncomeResource;
use App\Models\Balance;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $amount = $data['amount'];
        $balance = Balance::findOrFail($data['balance_id']);
        $balance->amount += $amount;
        $balance->save();
//        dd($balance);
        return parent::handleRecordCreation($data); // TODO: Change the autogenerated stub
    }
}
