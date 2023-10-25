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
            Card::make('Remaining Stock', ProductTwo::where('status', 'inactive')->count())->description("All accounts remaining"),
            Card::make('Demo Stock', ProductTwo::where('status', 'inactive')->where('mode', 'demo')->count())->description("All Demo accounts remaining"),
            Card::make('Product 2 Orders', ProductTwo::whereNot('status', 'inactive')->count())->description('All active accounts that have been purchased'),
            Card::make('Product 2 Breached', ProductTwo::where('status', 'breached')->count())->description('All accounts that have been breached'),
            Card::make('Product 2 Passed', ProductTwo::where('status', 'passed')->count())->description('All accounts that have been passed'),
            Card::make('Product 2 Real Promoted', ProductTwo::whereNotNull('is_assigned')->where('mode', 'real')->count())->description('Real accounts that have been promoted'),
        ];
    }
    // protected static string $view = 'filament.resources.product-two-resource.widgets.product-two-over-view';
}
