<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\ProductOne;
use App\Models\ProductThree;
use App\Models\ProductTwo;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{


    protected function getCards(): array

    {
        $activeProducts = ProductOne::where('status', 'active')->where('mode', 'demo')->count() + ProductTwo::where('status', 'active')->where('mode', 'demo')->count() + ProductThree::where('status', 'active')->where('mode', 'demo')->count();
        $totalSales = Order::sum('cost') / 100;

        return [
            Card::make('All Purchases', Order::count()),
            Card::make('Total Members', User::count()),

            Card::make('Pending Cashouts', WithdrawalRequest::where('status', 'pending')->count()),
            Card::make('All active demo accounts', $activeProducts),

            Card::make("Product 1 Real", ProductOne::where('status', 'active')->where('mode', 'real')->count()),
            Card::make("Product 2 Real", ProductTwo::where('status', 'active')->where('mode', 'real')->count()),
            Card::make("Product 3 Real", ProductThree::where('status', 'active')->where('mode', 'real')->count()),



            // Total order cost

            Card::make('Total Sales', '₦' . $totalSales)






            // Card::make('Average time on page', '3:12'),
        ];
    }
}
