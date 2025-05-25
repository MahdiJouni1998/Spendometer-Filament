<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecurringPaymentResource\Pages;
use App\Filament\Resources\RecurringPaymentResource\RelationManagers;
use App\Models\RecurringPayment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RecurringPaymentResource extends Resource
{
    protected static ?string $model = RecurringPayment::class;

    protected static ?string $navigationIcon = 'fas-table-list';
    protected static ?string $navigationGroup = 'Recurring';

    public static function form(Form $form): Form
    {
        $currencies = currencies();
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make()
                            ->columnSpan([
                                'lg' => 1,
                                'xs' => 1,
                            ])
                            ->columns([
                                'sm' => 2,
                                'xs' => 1,
                            ])
                            ->schema([
                                Forms\Components\DatePicker::make('start_date')
                                    ->nullable(),
                                Forms\Components\DatePicker::make('end_date')
                                    ->nullable(),
                            ]),
                        Forms\Components\Grid::make()
                            ->columnSpan(2)
                            ->columns(4)
                            ->schema([
                                Forms\Components\TextInput::make('recurring_amount')
                                    ->currencyMask()
                                    ->required()
                                    ->numeric(),
                                Forms\Components\TextInput::make('total_amount')
                                    ->currencyMask()
                                    ->nullable()
                                    ->numeric(),
                                Forms\Components\Select::make('currency')
                                    ->native(false)
                                    ->required()
                                    ->live()
                                    ->options($currencies),
                                Forms\Components\Grid::make()
                                    ->columnSpan(1)
                                    ->columns(2)
                                    ->schema([
                                        Forms\Components\TextInput::make('cycle_count')
                                            ->numeric()
                                            ->default(1)
                                            ->required(),
                                        Forms\Components\Select::make('cycle_type')
                                            ->default('month')
                                            ->native(false)
                                            ->options([
                                                'day' => 'Daily',
                                                'week' => 'Weekly',
                                                'month' => 'Monthly',
                                                'year' => 'Yearly',
                                            ])
                                            ->required(),
                                    ]),
                            ]),
                        Forms\Components\Textarea::make('details')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('recurring_amount')
                    ->formatStateUsing(function ($record) {
                        return money($record->recurring_amount * 100, $record->currency)->formatWithoutZeroes()
                            . " per " . $record->cycle_count . " " .
                            Str::plural($record->cycle_type, $record->cycle_count);
                    })
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_amount')
                    ->formatStateUsing(fn ($record) => money($record->total_amount * 100,
                        $record->currency)->formatWithoutZeroes())
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->searchable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->searchable(),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\RecurringPaymentsLogsRelationManager::make()
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRecurringPayments::route('/'),
            'create' => Pages\CreateRecurringPayment::route('/create'),
            'view' => Pages\ViewRecurringPayment::route('/{record}'),
            'edit' => Pages\EditRecurringPayment::route('/{record}/edit'),
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
