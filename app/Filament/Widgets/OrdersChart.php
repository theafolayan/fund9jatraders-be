<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrdersChart extends BarChartWidget
{
    protected static ?string $heading = 'Orders';
    public ?string $filter = 'today';

    protected function getData(): array
    {

        $activeFilter = $this->filter;

        $data = Trend::model(Order::class)
            ->between(
                start: now()->startOfYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#4c51bf',

                ],
            ],
            'colors' => [
                '#4c51bf',
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    // protected function getFilters(): ?array
    // {
    //     return [
    //         'today' => 'Today',
    //         'week' => 'Last week',
    //         'month' => 'Last month',
    //         'year' => 'This year',
    //     ];
    // }
}
