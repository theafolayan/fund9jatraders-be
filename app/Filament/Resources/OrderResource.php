<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Filament\Resources\OrderResource\RelationManagers\ProductOnesRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\ProductThreesRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\ProductTwosRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\UserRelationManager;
use App\Models\Order;
use App\Settings\PlatformSettings;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('product_type')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('product_id'),
                Forms\Components\TextInput::make('cost')
                    ->required(),
                Forms\Components\TextInput::make('phase')
                    ->required(),
                Forms\Components\DatePicker::make('breached_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('product_type')->description(fn (Order $record) => match ($record->product_type) {
                    'ONE' =>  app(PlatformSettings::class)->product_one_title,
                    'TWO' => app(PlatformSettings::class)->product_two_title,
                    'THREE' => app(PlatformSettings::class)->product_three_title,
                }),
                // Tables\Columns\TextColumn::make('product_id'),
                Tables\Columns\TextColumn::make('cost'),
                Tables\Columns\TextColumn::make('phase'),
                Tables\Columns\TextColumn::make('breached_at')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                Filter::make('breached_at')->label("Hide breached orders")->query(
                    fn (Builder $query): Builder => $query->whereNull('breached_at')
                ),
                SelectFilter::make('product_type')->label("Challenge Type")->options([
                    'ONE' =>  app(PlatformSettings::class)->product_one_title,
                    'TWO' => app(PlatformSettings::class)->product_two_title,
                    'THREE' => app(PlatformSettings::class)->product_three_title,
                ])->multiple(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Assign account'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('breach')
                        ->label('Mark As Breached')->requiresConfirmation()->action(
                            function (Order $record) {
                                $record->markAsBreached();
                                Notification::make()->title('Order marked as breached')->success()->send();
                            }
                        )->visible(function (Order $record) {
                            return !$record->isBreached();
                        }),
                    Tables\Actions\Action::make('promote')
                        ->label('Promote Account')->requiresConfirmation()->action(
                            function (Order $record) {
                                if ($record->promote()) {
                                    Notification::make()->title('Order Promoted and new account assigned successfully')->success()->send();
                                } else {
                                    Notification::make()->title('No available product, please add an account manually ')->danger()->send();
                                }
                            }
                        )->visible(function (Order $record) {
                            return !$record->isBreached() && $record->phase <= 2;
                        }),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            UserRelationManager::class,
            ProductOnesRelationManager::class,
            ProductTwosRelationManager::class,
            ProductThreesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            // 'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
