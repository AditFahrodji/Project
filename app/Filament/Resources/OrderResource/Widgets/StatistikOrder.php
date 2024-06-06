<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

class StatistikOrder extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Baru', Order::query()->where('status', 'baru')->count()),
            Stat::make('Proses', Order::query()->where('status', 'sedang diproses')->count()),
            Stat::make('Dikirim', Order::query()->where('status', 'dikirim')->count()),
            Stat::make('Total Harga', Number::currency(Order::query()->sum('total'))),
        ];
    }
}
