<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Page;
use App\Models\Product;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('name')
            ->take(6)
            ->get();

        $featuredProducts = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(8)
            ->get();

        $newProducts = Product::query()
            ->with('category')
            ->where('is_active', true)
            ->latest()
            ->take(4)
            ->get();

        $testimonials = Review::query()
            ->with('user')
            ->where('is_approved', true)
            ->latest()
            ->take(3)
            ->get();

        return view('front.home', compact(
            'banners', 'categories', 'featuredProducts', 'newProducts', 'testimonials'
        ));
    }

    public function about()
    {
        return view('front.about');
    }

    public function page(string $slug)
    {
        $page = Page::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('front.page', compact('page'));
    }
}
