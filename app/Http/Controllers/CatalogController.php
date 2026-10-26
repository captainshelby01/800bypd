<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['primaryImage', 'category', 'variants'])->where('is_active', true);

        // Filter by category
        if ($request->filled('category')) {
            $category = Category::where('slug', $request->category)->first();
            if ($category) {
                $query->where('category_id', $category->id);
            }
        }

        // Filter by price range (NGN)
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search query
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Sorting
        switch ($request->get('sort', 'newest')) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'bestsellers':
                $query->orderBy('is_featured', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('storefront.catalog', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'reviews', 'variants'])->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::with(['primaryImage', 'variants'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->take(4)
            ->get();

        return view('storefront.product_detail', compact('product', 'relatedProducts'));
    }

    public function storeReview(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:4|max:1000',
        ]);

        $validated['product_id'] = $product->id;
        $validated['user_id'] = auth()->id();
        $validated['is_approved'] = true;

        \App\Models\Review::create($validated);

        return back()->with('success', 'Thank you! Your rating and review have been published.');
    }
}
