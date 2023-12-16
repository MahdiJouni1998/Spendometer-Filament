<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletsTransactionResource\Pages;
use App\Filament\Resources\WalletsTransactionResource\RelationManagers;
use App\Models\WalletsTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Filament\Support\format_number;

class WalletsTransactionResource extends Resource
{
    protected static ?string $model = WalletsTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-s-wallet';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\DatePicker::make('date')
                            ->required(),
                        Forms\Components\Select::make('type')
                            ->default('exchange')
                            ->options([
                                'exchange' => 'Exchange',
                                'transfer' => 'Transfer',
                            ])
                            ->required(),
                        Forms\Components\Fieldset::make("From")
                            ->schema([
                                Forms\Components\Select::make('balance_from')
                                    ->label('Balance')
                                    ->native(false)
                                    ->relationship('balanceFrom', 'name')
                                    ->required(),
                                Forms\Components\TextInput::make('amount_from')
                                    ->label('Amount')
                                    ->currencyMask()
                                    ->required()
                                    ->numeric(),
                            ]),
                        Forms\Components\Fieldset::make("To")
                            ->schema([
                                Forms\Components\Select::make('balance_to')
                                    ->label('Balance')
                                    ->native(false)
                                    ->relationship('balanceTo', 'name')
                                    ->required(),
                                Forms\Components\TextInput::make('amount_to')
                                    ->label('Amount')
                                    ->currencyMask()
                                    ->required()
                                    ->numeric(),
                            ]),
                        Forms\Components\Textarea::make('description')
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
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('balanceFrom.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('balanceTo.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_from')
                    ->money(fn (Model $record) => $record->currency_from)
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount_to')
                    ->money(fn (Model $record) => $record->currency_to)
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWalletsTransactions::route('/'),
            'create' => Pages\CreateWalletsTransaction::route('/create'),
            'view' => Pages\ViewWalletsTransaction::route('/{record}'),
            'edit' => Pages\EditWalletsTransaction::route('/{record}/edit'),
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
