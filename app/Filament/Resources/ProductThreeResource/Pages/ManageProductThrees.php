<?php

namespace App\Filament\Resources\ProductThreeResource\Pages;

use App\Filament\Resources\ProductThreeResource;
use App\Filament\Resources\ProductThreeResource\Widgets\ProductThreeOverviewWidget;
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

    protected function getHeaderWidgets(): array
    {

        return [
            ProductThreeOverviewWidget::class,
        ];
    }
}
