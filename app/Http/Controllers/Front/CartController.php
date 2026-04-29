<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private const SESSION_KEY = 'cart.items';

    public function index()
    {
        $items = $this->resolveItems();
        $subtotal = collect($items)->sum('subtotal');

        return view('front.cart.index', compact('items', 'subtotal'));
    }

    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_active, 404);

        $qty = max(1, (int) $request->input('qty', 1));
        $cart = session(self::SESSION_KEY, []);
        $key = (string) $product->id;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $product->id,
                'qty' => $qty,
            ];
        }

        session([self::SESSION_KEY => $cart]);

        return redirect()
            ->route('front.cart.index')
            ->with('status', "{$product->name} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Product $product)
    {
        $qty = (int) $request->input('qty', 1);
        $cart = session(self::SESSION_KEY, []);
        $key = (string) $product->id;

        if ($qty <= 0) {
            unset($cart[$key]);
        } elseif (isset($cart[$key])) {
            $cart[$key]['qty'] = $qty;
        }

        session([self::SESSION_KEY => $cart]);

        return redirect()->route('front.cart.index')->with('status', 'Keranjang diperbarui.');
    }

    public function remove(Product $product)
    {
        $cart = session(self::SESSION_KEY, []);
        unset($cart[(string) $product->id]);
        session([self::SESSION_KEY => $cart]);

        return redirect()->route('front.cart.index')->with('status', 'Item dihapus dari keranjang.');
    }

    public function clear()
    {
        session()->forget(self::SESSION_KEY);

        return redirect()->route('front.cart.index')->with('status', 'Keranjang dikosongkan.');
    }

    private function resolveItems(): array
    {
        $cart = session(self::SESSION_KEY, []);

        if (empty($cart)) {
            return [];
        }

        $products = Product::query()
            ->whereIn('id', array_column($cart, 'product_id'))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $items = [];

        foreach ($cart as $row) {
            $product = $products->get($row['product_id']);
            if (! $product) {
                continue;
            }

            $price = $product->discount_price && $product->discount_price < $product->price
                ? $product->discount_price
                : $product->price;

            $items[] = [
                'product' => $product,
                'qty' => (int) $row['qty'],
                'price' => (int) $price,
                'subtotal' => (int) $price * (int) $row['qty'],
            ];
        }

        return $items;
    }
}
