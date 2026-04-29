<?php

namespace App\Filament\Back\Widgets;

use App\Models\Banner;
use App\Models\Order;
use App\Models\Page;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminSalesOverview extends BaseWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $revenue = (int) Order::query()
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        return [
            Stat::make('Omzet Tercatat', 'Rp '.number_format($revenue, 0, ',', '.'))
                ->description('Dari order berstatus paid')
                ->icon('heroicon-o-banknotes')
                ->color('success'),
            Stat::make('Pembayaran Pending', number_format(Payment::query()->where('status', 'pending')->count()))
                ->description('Menunggu verifikasi')
                ->icon('heroicon-o-credit-card')
                ->color('warning'),
            Stat::make('Banner Aktif', number_format(Banner::query()->where('is_active', true)->count()))
                ->description('Siap tampil di storefront')
                ->icon('heroicon-o-photo')
                ->color('primary'),
            Stat::make('Halaman Aktif', number_format(Page::query()->where('is_active', true)->count()))
                ->description('Konten statis dipublikasikan')
                ->icon('heroicon-o-document-text')
                ->color('info'),
        ];
    }
}
