<?php

namespace App\Filament\Resources\TransactionResource\RelationManagers;

use App\Models\Balance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CashBacksRelationManager extends RelationManager
{
    protected static string $relationship = 'cashBacks';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('balance_id')
                    ->relationship('balance', 'name')
                    ->native(false)
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->currencyMask()
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('amount')
            ->columns([
                Tables\Columns\TextColumn::make('balance.name'),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn (Model $record) => $record->balance->currency)
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $amount = $data['amount'];
                        $balance = Balance::findOrFail($data['balance_id']);
                        $balance->amount += $amount;
                        $balance->save();
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
