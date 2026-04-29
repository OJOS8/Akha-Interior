<?php

namespace App\Filament\Back\Resources;

use App\Filament\Back\Resources\PaymentResource\Pages\ManagePayments;
use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pembayaran')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('order_id')
                            ->relationship('order', 'order_code')
                            ->required()
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('payment_code')
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        Forms\Components\TextInput::make('method')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('Rp'),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'paid' => 'Paid',
                                'failed' => 'Failed',
                                'expired' => 'Expired',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->native(false),
                        Forms\Components\DateTimePicker::make('paid_at'),
                        Forms\Components\FileUpload::make('proof_image')
                            ->image()
                            ->directory('payments')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('transaction_ref')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.order_code')
                    ->label('Order')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('method')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Jumlah')
                    ->formatStateUsing(fn (int $state): string => 'Rp '.number_format($state, 0, ',', '.'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'paid' => 'success',
                        'pending' => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('paid_at')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManagePayments::route('/'),
        ];
    }
}
