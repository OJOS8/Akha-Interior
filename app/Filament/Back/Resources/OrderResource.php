<?php

namespace App\Filament\Back\Resources;

use App\Filament\Back\Resources\OrderResource\Pages\ManageOrders;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Order')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('address_id')
                            ->relationship('address', 'label')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('order_code')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('invoice_number')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('shipping_cost')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('discount_amount')
                            ->numeric()
                            ->default(0)
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('grand_total')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\TextInput::make('payment_method')
                            ->maxLength(255),
                        Forms\Components\Select::make('payment_status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'expired' => 'Expired',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\Select::make('order_status')
                            ->options([
                                'pending' => 'Pending',
                                'processed' => 'Processed',
                                'shipped' => 'Shipped',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('ordered_at'),
                        Forms\Components\Textarea::make('notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_code')
                    ->label('Kode Order')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->formatStateUsing(fn (int $state): string => 'Rp '.number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('order_status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'completed' => 'success',
                        'shipped' => 'info',
                        'pending', 'processed' => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('ordered_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'expired' => 'Expired',
                        'refunded' => 'Refunded',
                    ]),
                Tables\Filters\SelectFilter::make('order_status')
                    ->options([
                        'pending' => 'Pending',
                        'processed' => 'Processed',
                        'shipped' => 'Shipped',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageOrders::route('/'),
        ];
    }
}
