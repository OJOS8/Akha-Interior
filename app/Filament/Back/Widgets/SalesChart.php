<?php

namespace App\Filament\Back\Widgets;

use App\Models\Order;
use Carbon\CarbonImmutable;
use Filament\Widgets\ChartWidget;

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

        $buckets = Order::query()
            ->where('payment_status', 'paid')
            ->whereBetween('ordered_at', [$start, $end])
            ->get(['ordered_at', 'grand_total'])
            ->groupBy(fn (Order $order) => CarbonImmutable::parse($order->ordered_at)->format('Y-m'))
            ->map(fn ($group) => [
                'orders' => $group->count(),
                'revenue' => (int) $group->sum('grand_total'),
            ]);

        $labels = [];
        $revenue = [];
        $orders = [];

        for ($i = 0; $i < 6; $i++) {
            $month = $start->addMonths($i);
            $key = $month->format('Y-m');
            $labels[] = $month->translatedFormat('M Y');
            $revenue[] = (int) ($buckets[$key]['revenue'] ?? 0);
            $orders[] = (int) ($buckets[$key]['orders'] ?? 0);
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
