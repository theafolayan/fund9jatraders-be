<?php

namespace App\Filament\Resources\ProductOneResource\Pages;

use App\Filament\Resources\ProductOneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductOne extends EditRecord
{
    protected static string $resource = ProductOneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
