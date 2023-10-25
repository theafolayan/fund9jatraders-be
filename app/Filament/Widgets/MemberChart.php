<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\LineChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;


class MemberChart extends LineChartWidget
{
    protected static ?string $heading = 'Member Registerations';

    protected function getData(): array
    {
        $data = Trend::model(User::class)
            ->between(
                start: now()->startOfYear(),
                end: now(),
            )
            ->perMonth()
            ->count();
        return [
            'datasets' => [
                [
                    'label' => 'Signups',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'yellow',

                ],
            ],
            'colors' => [
                '#4c51bf',
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
}
