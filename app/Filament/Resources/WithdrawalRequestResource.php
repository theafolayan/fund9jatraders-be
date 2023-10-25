<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WithdrawalRequestResource\Pages;
use App\Filament\Resources\WithdrawalRequestResource\RelationManagers;
use App\Models\WithdrawalRequest;
use App\Notifications\WithdrawalApprovedNotification;
use App\Notifications\WithdrawalRejectedNotification;
use Filament\Forms;
use Filament\Notifications\Actions\ActionGroup;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup as ActionsActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WithdrawalRequestResource extends Resource
{
    protected static ?string $model = WithdrawalRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('bank_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('account_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('bank_code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reason')
                    ->maxLength(255),
                Forms\Components\TextInput::make('admin_id'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('bank_name'),
                Tables\Columns\TextColumn::make('account_number'),
                Tables\Columns\TextColumn::make('account_name'),
                // Tables\Columns\TextColumn::make('bank_code'),
                Tables\Columns\TextColumn::make('amount'),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                // Tables\Columns\TextColumn::make('deleted_at')
                //     ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionsActionGroup::make([
                    Action::make('approve')
                        ->label('Approve')
                        ->color('success')
                        ->icon('heroicon-o-check')
                        ->action(function (WithdrawalRequest $record, array $data) {
                            $record->update(['status' => 'approved', 'amount' => $data['amount']]);
                            // $record->markAsApproved();
                            $record->user->notify(new WithdrawalApprovedNotification($record));
                        })->form([
                            Forms\Components\TextInput::make('amount')->label('Enter an amount')
                                ->required()
                                ->maxLength(255),
                        ])
                        ->visible(fn (WithdrawalRequest $record) => $record->status == 'pending')

                        ->requiresConfirmation('Are you sure you want to approve this withdrawal request?', 'Approve'),
                    Action::make('reject')
                        ->label('Reject')
                        ->color('danger')
                        ->icon('heroicon-o-x')
                        // ->visible(fn (WithdrawalRequest $record) => $record->status == 'pending')

                        ->action(function (WithdrawalRequest $record, array $data) {
                            $record->update([
                                'status' => 'rejected',
                                'reason' => $data['reason'],
                            ]);
                            // dd($data);
                            $record->user->notify(new WithdrawalRejectedNotification($record));
                        })->visible(fn (WithdrawalRequest $record) => $record->status == 'pending')
                        // ->action(function (array $data, WithdrawalRequest $record): void {
                        //     $record->->associate($data['reason']);
                        //     $this->record->save();
                        // })
                        ->form([
                            Forms\Components\TextArea::make('reason')->label('Give a reason')
                                ->required()
                                ->maxLength(255),
                        ]),
                    // Tables\Actions\EditAction::make(),
                    // Tables\Actions\DeleteAction::make(),


                ])

            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageWithdrawalRequests::route('/'),
        ];
    }
}
