<?php

namespace App\Filament\Back\Pages;

use App\Filament\Back\Widgets\AdminSalesOverview;
use App\Filament\Back\Widgets\AdminStatsOverview;
use App\Filament\Back\Widgets\RecentOrders;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $view = 'Back.filament.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?int $navigationSort = -2;

    public function getTitle(): string
    {
        return 'Dashboard Admin';
    }

    public function getHeading(): string
    {
        return 'Dashboard Admin Akha';
    }

    public function getSubheading(): ?string
    {
        return 'Ringkasan katalog, pesanan, dan aktivitas customer.';
    }

    public function getWidgets(): array
    {
        return [
            AdminStatsOverview::class,
            AdminSalesOverview::class,
            RecentOrders::class,
        ];
    }
}
