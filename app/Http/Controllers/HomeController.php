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
            ->whereHas('category', fn($q) => $q->whereIn('slug', ['colouring-books', 'coloring-books']))
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

        // 4. Curated Flagship Bestsellers (one from each primary category)
        $bestsellers = Product::with(['primaryImage', 'category', 'variants'])
            ->whereIn('slug', [
                'give-thanks-psalm-107-jigsaw-puzzle',
                'psalm-23-colouring-book',
                'affirmations-flashcards',
                'adventures-of-the-little-explorer'
            ])
            ->where('is_active', true)
            ->get();

        if ($bestsellers->count() < 4) {
            $bestsellers = $featuredProducts->take(4);
        }

        return view('storefront.homepage', compact(
            'featuredProducts',
            'bestsellers',
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
