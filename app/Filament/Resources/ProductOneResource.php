<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductOneResource\Pages;
use App\Filament\Resources\ProductOneResource\RelationManagers;
use App\Models\ProductOne;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductOneResource extends Resource
{
    protected static ?string $model = ProductOne::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Product One';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('account_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('traders_password')

                    ->maxLength(255),
                Forms\Components\TextInput::make('server')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('leverage')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('mode')
                    ->required()
                    ->options([
                        'demo' => 'Demo',
                        'real' => 'Real',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('account_number')->searchable(),
                Tables\Columns\TextColumn::make('traders_password')->searchable(),
                Tables\Columns\TextColumn::make('server')->searchable(),
                Tables\Columns\TextColumn::make('leverage')->sortable(),
                Tables\Columns\TextColumn::make('mode'),
                // status
                Tables\Columns\TextColumn::make('status')->color(fn (ProductOne $record) => match ($record->status) {
                    'active' => 'success',
                    'inactive' => 'warning',
                    'breached' => 'danger',
                    'passed' => 'success',
                }),
                Tables\Columns\TextColumn::make('purchased_at')
                    ->datetime(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('mode')
                    ->options([
                        'demo' => 'Demo',
                        'real' => 'Real',
                        // 'fresh' => 'Fresh',
                    ])->multiple(),

                SelectFilter::make('status')->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                    'breached' => 'Breached',
                    'passed' => 'Passed',
                ])->multiple(),
                // Filter::make('hide_breached')->label("Show breached products")->query(fn (Builder $query): Builder => $query->whereNull('breached_at')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->visible(fn (ProductOne $record) => $record->status == 'inactive'),
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
            'index' => Pages\ListProductOnes::route('/'),
            'create' => Pages\CreateProductOne::route('/create'),
            'view' => Pages\ViewProductOne::route('/{record}'),
            'edit' => Pages\EditProductOne::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->latest();
    }
}
