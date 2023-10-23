<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\ProductOne;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductOnesRelationManager extends RelationManager
{
    protected static string $relationship = 'productOnes';

    protected static ?string $recordTitleAttribute = 'account_number';

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return $ownerRecord->product_type == "ONE";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('traders_password')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('server')
                    ->required()
                    ->maxLength(255),

                Forms\Components\TextInput::make('leverage')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('traders_password'),
                // Tables\Columns\TextColumn::make('traders_password'),
                Tables\Columns\TextColumn::make('server'),
                Tables\Columns\TextColumn::make('leverage'),
                Tables\Columns\TextColumn::make('mode'),
                // status

                Tables\Columns\TextColumn::make('status')->color(fn (ProductOne $record) => match ($record->status) {
                    'inactive' => 'warning',
                    'active' => 'green',
                    'breached' => 'red',
                }),
                // Tables\Columns\TextColumn::make('purchased_at')
                //     ->date(),


            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
