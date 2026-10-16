<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Bundle;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Featured Products
        $featuredProducts = Product::with(['primaryImage', 'category', 'variants'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(8)
            ->get();

        // 2. Active Product Bundles for "Buy Our Bundles" section
        $bundles = Bundle::with(['items.product.primaryImage', 'items.variant'])
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // 3. Products by Four Main Categories
        $puzzles = Product::with(['primaryImage', 'category', 'variants'])
            ->whereHas('category', fn($q) => $q->where('slug', 'jigsaw-puzzles'))
            ->where('is_active', true)
            ->take(6)
            ->get();

        $colouring = Product::with(['primaryImage', 'category', 'variants'])
            ->whereHas('category', fn($q) => $q->where('slug', 'coloring-books'))
            ->where('is_active', true)
            ->take(6)
            ->get();

        $flashcards = Product::with(['primaryImage', 'category', 'variants'])
            ->whereHas('category', fn($q) => $q->where('slug', 'flashcards'))
            ->where('is_active', true)
            ->take(6)
            ->get();

        $storybooks = Product::with(['primaryImage', 'category', 'variants'])
            ->whereHas('category', fn($q) => $q->whereIn('slug', ['storybooks', 'childrens-story-books']))
            ->where('is_active', true)
            ->take(6)
            ->get();

        $audios = Product::with(['primaryImage', 'category'])
            ->whereHas('category', fn($q) => $q->where('slug', 'childrens-audios'))
            ->where('is_active', true)
            ->take(4)
            ->get();

        $categories = Category::withCount('products')->get();

        return view('storefront.homepage', compact(
            'featuredProducts',
            'bundles',
            'puzzles',
            'colouring',
            'flashcards',
            'storybooks',
            'audios',
            'categories'
        ));
    }
}
