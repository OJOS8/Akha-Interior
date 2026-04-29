<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(
            Order::query()->with(['user', 'payment'])->latest()->paginate()
        );
    }

    public function create()
    {
        return response()->json(['message' => 'Orders are created through checkout']);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        $data['ordered_at'] = $data['ordered_at'] ?? now();

        $order = Order::create($data);

        return response()->json($order, 201);
    }

    public function show(Order $order)
    {
        return response()->json($order->load(['user', 'address', 'items.product', 'payment']));
    }

    public function edit(Order $order)
    {
        return response()->json($order->load(['items', 'payment']));
    }

    public function update(Request $request, Order $order)
    {
        $data = $this->validateRequest($request, true);
        $order->update($data);

        return response()->json($order->refresh()->load(['items', 'payment']));
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json(status: 204);
    }

    protected function validateRequest(Request $request, bool $updating = false): array
    {
        $required = $updating ? 'sometimes' : 'required';

        return $request->validate([
            'user_id' => [$required, 'integer', 'exists:users,id'],
            'address_id' => ['nullable', 'integer', 'exists:addresses,id'],
            'order_code' => [$required, 'string', 'max:255'],
            'invoice_number' => [$required, 'string', 'max:255'],
            'subtotal' => [$required, 'integer', 'min:0'],
            'shipping_cost' => ['nullable', 'integer', 'min:0'],
            'discount_amount' => ['nullable', 'integer', 'min:0'],
            'grand_total' => [$required, 'integer', 'min:0'],
            'payment_method' => ['nullable', 'string', 'max:255'],
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed', 'expired', 'refunded'])],
            'order_status' => ['nullable', Rule::in(['pending', 'processed', 'shipped', 'completed', 'cancelled'])],
            'notes' => ['nullable', 'string'],
            'ordered_at' => ['nullable', 'date'],
        ]);
    }
}
