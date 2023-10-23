<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Order;
use App\Settings\PlatformSettings;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'id';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('id')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label("ID"),
                Tables\Columns\TextColumn::make('product_type')->description(fn (Order $record) => match ($record->product_type) {
                    'ONE' =>  app(PlatformSettings::class)->product_one_title,
                    'TWO' => app(PlatformSettings::class)->product_two_title,
                    'THREE' => app(PlatformSettings::class)->product_three_title,
                }),

                Tables\Columns\TextColumn::make('phase'),
                Tables\Columns\TextColumn::make('breached_at')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('View')->url(fn (Order $record) => '/admin/orders/' . $record->id)->icon('heroicon-o-eye'),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
