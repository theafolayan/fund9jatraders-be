<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductThreeResource\Pages;
use App\Filament\Resources\ProductThreeResource\RelationManagers;
use App\Models\ProductThree;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductThreeResource extends Resource
{
    protected static ?string $model = ProductThree::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id'),
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
                Forms\Components\DatePicker::make('failed_at'),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id'),
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('server'),
                Tables\Columns\TextColumn::make('leverage'),
                Tables\Columns\TextColumn::make('mode'),
                Tables\Columns\TextColumn::make('purchased_at')
                    ->date(),
                Tables\Columns\TextColumn::make('failed_at')
                    ->date(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageProductThrees::route('/'),
        ];
    }    
}
