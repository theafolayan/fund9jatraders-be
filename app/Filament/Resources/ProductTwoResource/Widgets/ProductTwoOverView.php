<?php

namespace App\Filament\Resources\ProductTwoResource\Widgets;

use App\Models\ProductTwo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Card;

use Filament\Widgets\Widget;

class ProductTwoOverView extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Product 2 Payments', 0),
            Card::make('Product 2 subs', 0),
            Card::make('Product 2 failed', 0),
            Card::make('Remaining stock', ProductTwo::where('status', 'inactive')->count()),
        ];
    }
    // protected static string $view = 'filament.resources.product-two-resource.widgets.product-two-over-view';
}
