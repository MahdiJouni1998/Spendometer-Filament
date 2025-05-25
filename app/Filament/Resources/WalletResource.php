<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WalletResource\Pages;
use App\Filament\Resources\WalletResource\RelationManagers;
use App\Models\Wallet;
use Filament\Forms;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use function Filament\Support\format_number;

class WalletResource extends Resource
{
    protected static ?string $model = Wallet::class;

    protected static ?string $navigationIcon = 'fas-wallet';
    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        $currencies = currencies();
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpanFull()
                            ->maxLength(255),
                        Forms\Components\Repeater::make('Balances')
                            ->relationship('balances')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\TextInput::make('amount')
                                            ->currencyMask()
                                            ->required()
                                            ->default(0)
                                            ->live()
                                            ->columnSpan([
                                                'lg' => 2,
                                                'sm' => 1
                                            ])
                                            ->numeric(),
                                        Forms\Components\Select::make('currency')
                                            ->native(false)
                                            ->required()
                                            ->live()
                                            ->columnSpan([
                                                'lg' => 2,
                                                'sm' => 1
                                            ])
                                            ->options($currencies),
                                    ])
                                    ->columns([
                                        'lg' => 4,
                                        'sm' => 2
                                    ])
                                    ->columnSpan(1)
                            ])
                            ->minItems(1)
                            ->itemLabel(fn (array $state): ?string =>  $state['name'] ?? "New balance")
                            ->deleteAction(fn (Action $action) => $action->requiresConfirmation())
                            ->columns(2)
                            ->columnSpanFull()
                            ->mutateRelationshipDataBeforeCreateUsing(function ($data) {
                                $data['user_id'] = auth()->user()->id;
                                return $data;
                            })
                    ])
                    ->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        $columns = [];
        $columns[] = Tables\Columns\TextColumn::make('name')->searchable();
        $currencies = currencyNames();
        foreach ($currencies as $currency) {
            $columns[] = Tables\Columns\TextColumn::make('Balance ' . $currency)
                ->label('Total balance ' . strtoupper($currency))
                ->getStateUsing(function (Model $record) use ($currency) {
                    $amount = 0;
                    $balances = $record->balances()
                        ->where('currency', $currency)
                        ->get();
                    foreach ($balances as $balance) {
                        $amount += $balance->amount;
                    }
                    $state = $amount != 0 ? (string) $amount : "";
//                    dd($record);
                    return money($state * 100, $currency)->formatWithoutZeroes();
                })
                ->searchable();
        }
        $columns[] = Tables\Columns\TextColumn::make('created_at')
            ->dateTime()
            ->sortable()
            ->toggleable(isToggledHiddenByDefault: true);
        $columns[] = Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true);
        $columns[] = Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true);
        return $table
            ->columns($columns)
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
            'index' => Pages\ListWallets::route('/'),
            'create' => Pages\CreateWallet::route('/create'),
            'view' => Pages\ViewWallet::route('/{record}'),
            'edit' => Pages\EditWallet::route('/{record}/edit'),
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
