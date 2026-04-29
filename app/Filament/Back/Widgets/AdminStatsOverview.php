<?php

namespace App\Filament\Back\Widgets;

use App\Models\Category;
use App\Models\Inquiry;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        return [
            Stat::make('Total Produk', number_format(Product::query()->count()))
                ->description('Produk aktif dan nonaktif')
                ->icon('heroicon-o-cube')
                ->color('primary'),
            Stat::make('Total Kategori', number_format(Category::query()->count()))
                ->description('Struktur katalog')
                ->icon('heroicon-o-tag')
                ->color('success'),
            Stat::make('Total Pesanan', number_format(Order::query()->count()))
                ->description('Semua status order')
                ->icon('heroicon-o-shopping-bag')
                ->color('warning'),
            Stat::make('Total User', number_format(User::query()->count()))
                ->description('Admin dan customer')
                ->icon('heroicon-o-users')
                ->color('gray'),
            Stat::make('Inquiry Baru', number_format(Inquiry::query()->where('status', 'new')->count()))
                ->description('Butuh respons admin')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('danger'),
        ];
    }
}
