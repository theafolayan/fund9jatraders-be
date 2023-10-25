<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserRelationManager extends RelationManager
{
    protected static string $relationship = 'user';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                Tables\Columns\TextColumn::make('status')->color(
                    fn (User $record) => match ($record->status) {
                        'inactive' => 'warning',
                        'active' => 'success',
                        'suspended' => 'danger',
                    }
                ),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label("Registered On"),
                // Tables\Columns\TextColumn::make('ph')->dateTime(),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                // View User action

                Tables\Actions\Action::make('view')
                    ->url(fn (User $record) => '/admin/users/' . $record->id)
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->openUrlInNewTab()


                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
