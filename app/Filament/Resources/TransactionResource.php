<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Balance;
use App\Models\Category;
use App\Models\RecurringPayment;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Filament\Support\format_number;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'fas-file-invoice-dollar';
    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Select::make('iou_id')
                            ->label('Third party')
                            ->relationship('iou', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->native(false)
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required(),
                            ])
                            ->required(),
                        Forms\Components\DatePicker::make('date')
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->default('out')
                            ->native(false)
                            ->options([
                                'in' => 'Into the wallet',
                                'out' => 'Out of the wallet',
                            ])
                            ->required(),
                        Forms\Components\Repeater::make('Payments')
                            ->required()
                            ->minItems(1)
                            ->schema([
                                Forms\Components\Select::make('balance_id')
                                    ->relationship('balance', 'name')
                                    ->native(false)
                                    ->required(),
                                Forms\Components\TextInput::make('amount')
                                    ->currencyMask()
                                    ->required()
                                    ->numeric()
                            ])
                            ->columnSpanFull()
                            ->columns(2)
                            ->relationship('payments')
                            ->addActionLabel('Add a payment to current transaction')
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get) {
                                $type = $get('type');
                                $amount = $data['amount'];
                                if($type == "out")
                                    $amount = -$amount;
                                $balance = Balance::findOrFail($data['balance_id']);
                                $balance->amount += $amount;
                                $balance->save();
                                return $data;
                            }),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Checkbox::make('is_recurring')
                                    ->visibleOn(['create', 'view'])
                                    ->live()
                                    ->label('Is this a recurring payment?'),
                                Forms\Components\Group::make([
                                    Forms\Components\Select::make('recurring_payment_id')
                                        ->options(RecurringPayment::all()->pluck('name', 'id'))
                                        ->label('Which one?')
                                        ->required(function ($get) {
                                            return $get('is_recurring');
                                        }),
                                ])
                                    ->visible(function ($operation, $get) {
                                        return $operation == 'create' && $get('is_recurring');
                                    })
                                    ->relationship('recurringPaymentsLog')
                                    ->mutateRelationshipDataBeforeCreateUsing(function (array $data, Get $get) {
                                        $data['payment_date'] = $get('date');
                                        return $data;
                                    })
                            ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('iou.name')
                    ->label('Third party')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type'),
                Tables\Columns\TextColumn::make('amount')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\SelectFilter::make('Third party')
                    ->searchable()
                    ->relationship('iou', 'name'),
                Tables\Filters\SelectFilter::make('Category')
                    ->searchable()
                    ->relationship('category', 'name'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'in', 'out'
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->recordUrl(
                fn(Model $record): string => Pages\EditTransaction::getUrl([$record->id]),
            );
    }

    public static function getRelations(): array
    {
        return [
            TransactionResource\RelationManagers\CashBacksRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'view' => Pages\ViewTransaction::route('/{record}'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
