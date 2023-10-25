<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Models\ProductThree;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductThreesRelationManager extends RelationManager
{
    protected static string $relationship = 'ProductThrees';

    protected static ?string $recordTitleAttribute = 'account_number';

    public static function canViewForRecord(Model $ownerRecord): bool
    {
        return $ownerRecord->product_type == "THREE";
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_number')
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
                Tables\Columns\TextColumn::make('purchased_at')
                    ->date()->sortable(),
                // status

                Tables\Columns\TextColumn::make('status')->color(fn (ProductThree $record) => match ($record->status) {
                    'inactive' => 'warning',
                    'active' => 'success',
                    'breached' => 'red',
                    'passed' => 'success'
                })->searchable()
                // Tables\Columns\TextColumn::make('purchased_at')
                //     ->date(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
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
