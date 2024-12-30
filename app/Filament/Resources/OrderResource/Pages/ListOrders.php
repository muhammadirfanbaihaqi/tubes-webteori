<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\OrderResource\Widgets\OrderStats;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All'),
            'Pending' => Tab::make()->query(fn($query) => $query->where('status', 'Pending')),
            'Sedang Dimasak' => Tab::make()->query(fn($query) => $query->where('status', 'Sedang Dimasak')),
            'matang' => Tab::make()->query(fn($query) => $query->where('status', 'matang')),
            'cancelled' => Tab::make()->query(fn($query) => $query->where('status', 'cancelled')),
        ];
    }
}