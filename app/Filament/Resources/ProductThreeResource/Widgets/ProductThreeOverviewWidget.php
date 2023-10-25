<?php

namespace App\Filament\Resources\ProductThreeResource\Widgets;

use App\Models\ProductThree;
use App\Models\ProductTwo;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Card;

use Filament\Widgets\Widget;

class ProductThreeOverviewWidget extends BaseWidget
{
    // protected static string $view = 'filament.resources.product-three-resource.widgets.product-three-overview-widget';

    protected function getCards(): array
    {
        return [
            Card::make('Remaining Stock', ProductThree::where('status', 'inactive')->count())->description("All accounts remaining"),
            Card::make('Demo Stock', ProductThree::where('status', 'inactive')->where('mode', 'demo')->count())->description("All Demo accounts remaining"),
            Card::make('Product 2 Orders', ProductThree::whereNot('status', 'inactive')->count())->description('All active accounts that have been purchased'),
            Card::make('Product 2 Breached', ProductThree::where('status', 'breached')->count())->description('All accounts that have been breached'),
            Card::make('Product 2 Passed', ProductThree::where('status', 'passed')->count())->description('All accounts that have been passed'),
            Card::make('Product 2 Real Promoted', ProductThree::whereNotNull('is_assigned')->where('mode', 'real')->count())->description('Real accounts that have been promoted'),
        ];
    }
}
