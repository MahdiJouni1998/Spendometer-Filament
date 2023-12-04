<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncomeSourceResource\Pages;
use App\Filament\Resources\IncomeSourceResource\RelationManagers;
use App\Models\IncomeSource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Filament\Support\format_number;

class IncomeSourceResource extends Resource
{
    protected static ?string $model = IncomeSource::class;

    protected static ?string $navigationIcon = 'fas-circle-dollar-to-slot';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make()
                            ->schema([
                                Forms\Components\TextInput::make('amount')
                                    ->columnSpan([
                                        'lg' => 2,
                                        'sm' => 2
                                    ])
                                    ->currencyMask()
                                    ->numeric(),
                                Forms\Components\Select::make('currency')
                                    ->native(false)
                                    ->options(config('global.currencies'))
                                    ->columnSpan([
                                        'lg' => 2,
                                        'sm' => 1
                                    ])
                                    ->default('usd'),
                            ])
                            ->columns([
                                'lg' => 4,
                                'sm' => 3
                            ])
                            ->columnSpan(1),
                    ])
                ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money(fn (Model $record) => $record->currency)
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
            'index' => Pages\ListIncomeSources::route('/'),
            'create' => Pages\CreateIncomeSource::route('/create'),
            'view' => Pages\ViewIncomeSource::route('/{record}'),
            'edit' => Pages\EditIncomeSource::route('/{record}/edit'),
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
