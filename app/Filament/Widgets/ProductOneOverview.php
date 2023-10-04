<?php

namespace App\Filament\Widgets;

use App\Models\ProductOne;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class ProductOneOverview extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Product 1 Payments', 0),
            Card::make('Product 1 subs', 0),
            Card::make('Product 1 failed', 0),
            Card::make('Remaining stock', ProductOne::where('status', 'inactive')->count()),
        ];
    }
}
