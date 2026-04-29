<?php

namespace App\Services;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

class CheckoutService
{
    public function __construct(
        protected CartService $cartService
    ) {
    }

    public function checkout(User $user, Address $address, Cart $cart, array $payload = []): Order
    {
        $cart->loadMissing(['items.product', 'items.variant']);

        if ($cart->items->isEmpty()) {
            throw new RuntimeException('Cart is empty.');
        }

        $shippingCost = (int) ($payload['shipping_cost'] ?? 0);
        $discountAmount = (int) ($payload['discount_amount'] ?? 0);
        $subtotal = (int) $cart->items->sum('subtotal');
        $grandTotal = max($subtotal + $shippingCost - $discountAmount, 0);

        return DB::transaction(function () use ($user, $address, $cart, $payload, $shippingCost, $discountAmount, $subtotal, $grandTotal) {
            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'order_code' => $this->generateCode('ORD'),
                'invoice_number' => $this->generateCode('INV'),
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'discount_amount' => $discountAmount,
                'grand_total' => $grandTotal,
                'payment_method' => $payload['payment_method'] ?? null,
                'payment_status' => $payload['payment_status'] ?? 'pending',
                'order_status' => $payload['order_status'] ?? 'pending',
                'notes' => $payload['notes'] ?? null,
                'ordered_at' => now(),
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_name' => $item->product?->name ?? 'Unknown Product',
                    'product_price' => $item->price,
                    'qty' => $item->qty,
                    'subtotal' => $item->subtotal,
                ]);

                if ($item->variant) {
                    $item->variant->decrement('stock', $item->qty);
                } elseif ($item->product) {
                    $item->product->decrement('stock', $item->qty);
                }
            }

            $order->payment()->create([
                'payment_code' => $this->generateCode('PAY'),
                'method' => $payload['payment_method'] ?? null,
                'amount' => $grandTotal,
                'status' => $payload['payment_status'] ?? 'pending',
                'transaction_ref' => $payload['transaction_ref'] ?? null,
                'proof_image' => $payload['proof_image'] ?? null,
                'paid_at' => $payload['payment_status'] === 'paid' ? now() : null,
            ]);

            $this->cartService->clear($cart);

            return $order->load(['items', 'payment']);
        });
    }

    protected function generateCode(string $prefix): string
    {
        return $prefix . '-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(6));
    }
}
