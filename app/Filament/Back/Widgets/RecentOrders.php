<?php

namespace App\Filament\Back\Widgets;

use App\Models\Order;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrders extends BaseWidget
{
    protected static ?string $heading = 'Pesanan Terbaru';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Order::query()->with('user')->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Total')
                    ->formatStateUsing(fn (int $state): string => 'Rp '.number_format($state, 0, ',', '.')),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('order_status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'shipped' => 'info',
                        'pending', 'processed' => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->label('Dipesan')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->paginated([5, 10, 25])
            ->defaultPaginationPageOption(5);
    }
}
