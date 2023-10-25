<?php

namespace App\Filament\Resources\ProductOneResource\Widgets;

use App\Models\ProductOne;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Card;

use Filament\Widgets\Widget;

class ProductOneOverview extends BaseWidget
{

    protected function getCards(): array
    {
        return [
            Card::make('Remaining Stock', ProductOne::where('status', 'inactive')->count())->description("All accounts remaining"),
            Card::make('Demo Stock', ProductOne::where('status', 'inactive')->where('mode', 'demo')->count())->description("All Demo accounts remaining"),
            Card::make('Product 1 Orders', ProductOne::whereNot('status', 'inactive')->count())->description('All active accounts that have been purchased'),
            Card::make('Product 1 Breached', ProductOne::where('status', 'breached')->count())->description('All accounts that have been breached'),
            Card::make('Product 1 Passed', ProductOne::where('status', 'passed')->count())->description('All accounts that have been passed'),
            Card::make('Product 1 Real Promoted', ProductOne::whereNotNull('is_assigned')->where('mode', 'real')->count())->description('Real accounts that have been promoted'),
        ];
    }
    // protected static string $view = 'filament.resources.product-one-resource.widgets.product-one-overview';
}
