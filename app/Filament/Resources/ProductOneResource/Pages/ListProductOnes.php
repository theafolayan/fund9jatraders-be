<?php

namespace App\Filament\Resources\ProductOneResource\Pages;

use App\Filament\Resources\ProductOneResource;
use App\Filament\Resources\ProductOneResource\Widgets\ProductOneOverview;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductOnes extends ListRecords
{
    protected static string $resource = ProductOneResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            ProductOneOverview::class,

        ];
    }
}
