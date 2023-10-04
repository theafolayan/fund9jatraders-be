<?php

namespace App\Filament\Widgets;

use App\Models\ProductOne;
use App\Models\ProductTwo;
use App\Models\User;
use App\Models\WithdrawalRequest;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{


    protected function getCards(): array
    {
        return [
            Card::make('All Purchase', '0'),
            Card::make('Total Members', User::count()),
            Card::make('Pending Cashouts', WithdrawalRequest::count()),
            Card::make('All active accounts', User::where('status', 'active')->count()),


            // Card::make('Product 2 Payments', 0),
            // Card::make('Product 2 subs', 0),
            // Card::make('Product 2 failed', 0),
            // Card::make('Remaining stock', ProductTwo::where('status', 'inactive')->count()),


            // Card::make('Product 3 Payments', 0),
            // Card::make('Product 3 subs', 0),
            // Card::make('Product 3 failed', 0),
            // Card::make('Remaining stock', ProductTwo::where('status', 'inactive')->count()),



            Card::make("Today's vs yesterday purchase", 0),
            Card::make("This week's Vs Last week purchase", '0 -0'),
            Card::make('This month vs Last month purchase', '0 - 0'),
            Card::make("Phase 1 vs Phase 2 Failed percentage", "0% - 0%"),
            // Card::make('Average time on page', '3:12'),

        ];
    }
}
