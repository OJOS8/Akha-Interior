<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class CartService
{
    public function getOrCreateCart(?User $user = null, ?string $sessionId = null): Cart
    {
        if (! $user && ! $sessionId) {
            throw new InvalidArgumentException('A user or session ID is required to resolve a cart.');
        }

        if ($user) {
            $cart = Cart::query()->firstOrCreate(
                ['user_id' => $user->id],
                ['session_id' => $sessionId]
            );

            if ($sessionId) {
                $guestCart = Cart::query()
                    ->whereNull('user_id')
                    ->where('session_id', $sessionId)
                    ->with('items')
                    ->first();

                if ($guestCart && $guestCart->id !== $cart->id) {
                    foreach ($guestCart->items as $item) {
                        $this->addItem($cart, $item->product, $item->qty, $item->variant);
                    }

                    $guestCart->delete();
                }
            }

            return $cart->load('items');
        }

        return Cart::query()->firstOrCreate(['session_id' => $sessionId])->load('items');
    }

    public function addItem(Cart $cart, Product $product, int $qty = 1, ?ProductVariant $variant = null): CartItem
    {
        if ($qty < 1) {
            throw new InvalidArgumentException('Quantity must be at least 1.');
        }

        return DB::transaction(function () use ($cart, $product, $qty, $variant) {
            $price = (int) $product->discount_price ?: (int) $product->price;
            $price += (int) ($variant?->price_addition ?? 0);

            $item = CartItem::query()->firstOrNew([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => $variant?->id,
            ]);

            $item->qty = ($item->exists ? $item->qty : 0) + $qty;
            $item->price = $price;
            $item->subtotal = $item->qty * $price;
            $item->save();

            return $item->fresh(['product', 'variant']);
        });
    }

    public function updateItemQuantity(CartItem $item, int $qty): ?CartItem
    {
        if ($qty < 1) {
            $item->delete();

            return null;
        }

        $item->qty = $qty;
        $item->subtotal = $item->qty * $item->price;
        $item->save();

        return $item->fresh(['product', 'variant']);
    }

    public function removeItem(CartItem $item): void
    {
        $item->delete();
    }

    public function clear(Cart $cart): void
    {
        $cart->items()->delete();
    }

    public function totals(Cart $cart): array
    {
        $subtotal = (int) $cart->items()->sum('subtotal');

        return [
            'subtotal' => $subtotal,
            'total_items' => (int) $cart->items()->sum('qty'),
            'grand_total' => $subtotal,
        ];
    }
}
