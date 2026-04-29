<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_id',
        'order_code',
        'invoice_number',
        'subtotal',
        'shipping_cost',
        'discount_amount',
        'grand_total',
        'payment_method',
        'payment_status',
        'order_status',
        'notes',
        'ordered_at',
    ];

    protected function casts(): array
    {
        return [
            'ordered_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
