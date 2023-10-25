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
            Card::make('Demo Stock', ProductOne::where('status', 'inactive')->where('mode', 'demo')->count()),
            Card::make('Product 1 Orders', ProductOne::where('status', 'active')->count()),
            Card::make('Product 1 Breached', ProductOne::where('status', 'breached')->count()),
            Card::make('Product 1 Passed', ProductOne::where('status', 'passed')->count()),
            Card::make('Product 1 Promoted', ProductOne::whereNotNull('is_assigned')->count()),

            Card::make('Remaining Stock', ProductOne::where('status', 'inactive')->count()),
        ];
    }
}
