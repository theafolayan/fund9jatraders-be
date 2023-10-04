<?php

namespace App\Filament\Resources\ProductTwoResource\Pages;

use App\Filament\Resources\ProductTwoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTwos extends ListRecords
{
    protected static string $resource = ProductTwoResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
