<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index() {
        $featuredProducts = Product::with('primaryImage', 'category')
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        $books = Product::with('primaryImage', 'category')
            ->whereHas('category', function($q) {
                $q->where('slug', 'childrens-story-books');
            })
            ->where('is_active', true)
            ->take(6)
            ->get();

        $audios = Product::with('primaryImage', 'category')
            ->whereHas('category', function($q) {
                $q->where('slug', 'childrens-audios');
            })
            ->where('is_active', true)
            ->take(6)
            ->get();

        $otherProducts = Product::with('primaryImage', 'category')
            ->whereHas('category', function($q) {
                $q->where('slug', 'other-products');
            })
            ->where('is_active', true)
            ->take(6)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('storefront.homepage', compact('featuredProducts', 'books', 'audios', 'otherProducts', 'categories'));
    }
}
