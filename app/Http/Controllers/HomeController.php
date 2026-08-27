<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
        $featuredProducts = Product::with('primaryImage')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('storefront.homepage', compact('featuredProducts', 'categories'));
    }
}
