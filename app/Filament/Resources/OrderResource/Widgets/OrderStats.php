<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Illuminate\Support\Number;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class OrderStats extends BaseWidget
{
    // php artisan make:filament-widget OrderStats --resource=OrderResource
    protected function getStats(): array
    {
        return [
            Stat::make('Pending', Order::query()->where('status', 'Pending')->count()),
            Stat::make('Sedang Dimasak', Order::query()->where('status', 'Sedang Dimasak')->count()),
            Stat::make('Matang', Order::query()->where('status', 'Matang')->count()),
            Stat::make('Cancelled', Order::query()->where('status', 'Cancelled')->count()),
            Stat::make('Average Total Price Orders', !(empty(Order::query()->avg('grand_total'))) ? Number::currency(Order::query()->avg('grand_total'), 'IDR') : '-'),
        ];
    }
}