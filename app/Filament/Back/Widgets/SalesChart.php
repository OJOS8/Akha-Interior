<?php

namespace App\Filament\Back\Widgets;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesChart extends ChartWidget
{
    protected static ?string $heading = 'Penjualan 6 Bulan Terakhir';

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '280px';

    protected function getData(): array
    {
        $end = CarbonImmutable::now()->endOfMonth();
        $start = $end->subMonths(5)->startOfMonth();

        $rows = Order::query()
            ->where('payment_status', 'paid')
            ->whereBetween('ordered_at', [$start, $end])
            ->select(
                DB::raw("strftime('%Y-%m', ordered_at) as bucket"),
                DB::raw('COUNT(*) as orders_count'),
                DB::raw('COALESCE(SUM(grand_total), 0) as revenue'),
            )
            ->groupBy('bucket')
            ->pluck('revenue', 'bucket');

        $counts = Order::query()
            ->where('payment_status', 'paid')
            ->whereBetween('ordered_at', [$start, $end])
            ->select(
                DB::raw("strftime('%Y-%m', ordered_at) as bucket"),
                DB::raw('COUNT(*) as orders_count'),
            )
            ->groupBy('bucket')
            ->pluck('orders_count', 'bucket');

        $labels = [];
        $revenue = [];
        $orders = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $start->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat('M Y');
            $revenue[] = (int) ($rows[$key] ?? 0);
            $orders[] = (int) ($counts[$key] ?? 0);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Omzet (Rp)',
                    'data' => $revenue,
                    'borderColor' => '#b45309',
                    'backgroundColor' => 'rgba(180, 83, 9, 0.15)',
                    'fill' => true,
                    'tension' => 0.35,
                    'yAxisID' => 'y',
                ],
                [
                    'label' => 'Jumlah Order',
                    'data' => $orders,
                    'borderColor' => '#0f766e',
                    'backgroundColor' => 'rgba(15, 118, 110, 0.15)',
                    'fill' => false,
                    'tension' => 0.35,
                    'yAxisID' => 'y1',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => true],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'position' => 'left',
                    'title' => ['display' => true, 'text' => 'Omzet'],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'grid' => ['drawOnChartArea' => false],
                    'title' => ['display' => true, 'text' => 'Order'],
                ],
            ],
        ];
    }
}
