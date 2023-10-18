<?php

namespace App\Filament\Resources\ProductThreeResource\Pages;

use App\Filament\Resources\ProductThreeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProductThrees extends ManageRecords
{
    protected static string $resource = ProductThreeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
