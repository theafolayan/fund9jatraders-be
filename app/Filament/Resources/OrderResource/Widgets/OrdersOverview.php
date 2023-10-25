<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

use Filament\Widgets\StatsOverviewWidget\Card;

// use Filament\Widgets\Widget;
use Filament\Widgets\Widget;

class OrdersOverview extends BaseWidget
{
    // protected static string $view = 'filament.resources.order-resource.widgets.orders-overview';
    protected function getCards(): array
    {

        $activePhaseOne = Order::where("product_type", "ONE")->whereNull("breached_at")->count();
        $activePhaseTwo = Order::where("product_type", "TWO")->whereNull("breached_at")->count();
        $activePhaseThree = Order::where("product_type", "THREE")->whereNull("breached_at")->count();
        return [
            Card::make('Total Orders', Order::count()),
            Card::make('Total Breached', Order::whereNotNull('breached_at')->count()),
            Card::make('Awaiting assignment', Order::whereNull('breached_at')->whereNull('product_id')->count()),

            Card::make('Phase 1 Total', Order::where("product_type", "ONE")->count())->description("Active - {$activePhaseOne}"),
            Card::make('Phase 2 Total', Order::where("product_type", "TWO")->count())->description("Active - {$activePhaseTwo}"),
            Card::make('Phase 3 Total', Order::where("product_type", "THREE")->count())->description("Active - {$activePhaseThree}")



        ];
    }
}
