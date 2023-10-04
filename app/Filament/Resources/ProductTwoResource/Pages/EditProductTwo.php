<?php

namespace App\Filament\Resources\ProductTwoResource\Pages;

use App\Filament\Resources\ProductTwoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductTwo extends EditRecord
{
    protected static string $resource = ProductTwoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
