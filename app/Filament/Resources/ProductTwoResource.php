<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTwoResource\Pages;
use App\Filament\Resources\ProductTwoResource\RelationManagers;
use App\Models\ProductTwo;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductTwoResource extends Resource
{
    protected static ?string $model = ProductTwo::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('traders_password')
                    ->password()
                    ->maxLength(255),
                Forms\Components\TextInput::make('server')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('leverage')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('mode')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('purchased_at'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('server'),
                Tables\Columns\TextColumn::make('leverage'),
                Tables\Columns\TextColumn::make('mode'),
                Tables\Columns\TextColumn::make('purchased_at')
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProductTwos::route('/'),
            'create' => Pages\CreateProductTwo::route('/create'),
            'view' => Pages\ViewProductTwo::route('/{record}'),
            'edit' => Pages\EditProductTwo::route('/{record}/edit'),
        ];
    }    
}
