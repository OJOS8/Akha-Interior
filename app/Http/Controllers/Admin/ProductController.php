<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(
            Product::query()->with('category')->latest()->paginate()
        );
    }

    public function create()
    {
        return response()->json(['message' => 'Product create form placeholder']);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
        $data['is_featured'] = $data['is_featured'] ?? false;
        $data['is_active'] = $data['is_active'] ?? true;

        $product = Product::create($data);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product->load(['category', 'images', 'variants', 'reviews']));
    }

    public function edit(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validateRequest($request, $product);

        if (array_key_exists('name', $data) && ! array_key_exists('slug', $data)) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        return response()->json($product->refresh());
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(status: 204);
    }

    protected function validateRequest(Request $request, ?Product $product = null): array
    {
        $productId = $product?->id;
        $required = $product ? 'sometimes' : 'required';

        return $request->validate([
            'category_id' => [$required, 'integer', 'exists:categories,id'],
            'name' => [$required, 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('product', 'slug')->ignore($productId)],
            'sku' => [$required, 'string', 'max:255', Rule::unique('product', 'sku')->ignore($productId)],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'price' => [$required, 'integer', 'min:0'],
            'discount_price' => ['nullable', 'integer', 'min:0'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'material' => ['nullable', 'string', 'max:255'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'thumbnail' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
