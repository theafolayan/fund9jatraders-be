<?php

namespace App\Filament\Resources\ProductOneResource\Pages;

use App\Filament\Resources\ProductOneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductOne extends ViewRecord
{
    protected static string $resource = ProductOneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
