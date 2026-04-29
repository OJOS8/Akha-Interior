<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    public function show(string $slug)
    {
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = $category->products()
            ->with('category')
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('front.categories.show', compact('category', 'products'));
    }
}
