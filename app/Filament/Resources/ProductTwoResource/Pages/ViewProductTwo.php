<?php

namespace App\Filament\Resources\ProductTwoResource\Pages;

use App\Filament\Resources\ProductTwoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProductTwo extends ViewRecord
{
    protected static string $resource = ProductTwoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
