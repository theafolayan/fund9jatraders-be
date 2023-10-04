<?php

namespace App\Filament\Resources\ProductTwoResource\Pages;

use App\Filament\Resources\ProductTwoResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateProductTwo extends CreateRecord
{
    protected static string $resource = ProductTwoResource::class;
}
