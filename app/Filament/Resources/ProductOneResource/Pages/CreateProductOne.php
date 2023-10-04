<?php

namespace App\Filament\Resources\ProductOneResource\Pages;

use App\Filament\Resources\ProductOneResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductOne extends CreateRecord
{
    protected static string $resource = ProductOneResource::class;
}
