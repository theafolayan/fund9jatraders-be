<?php

namespace App\Filament\Resources\ProductTwoResource\Pages;

use App\Filament\Resources\ProductTwoResource;
use App\Filament\Resources\ProductTwoResource\Widgets\ProductTwoOverView;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductTwos extends ListRecords
{
    protected static string $resource = ProductTwoResource::class;
    protected static ?string $title = "Product Two ";


    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ProductTwoOverView::class,
        ];
    }
}
