<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use App\Models\Category;

class BundleController extends Controller
{
    /**
     * Display a dedicated storefront listing of all available product bundles.
     */
    public function index()
    {
        $bundles = Bundle::with(['items.product.primaryImage', 'items.variant'])
            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        $categories = Category::all();

        return view('storefront.bundles', compact('bundles', 'categories'));
    }
}
