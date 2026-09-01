<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

class AudioController extends Controller
{
    public function index()
    {
        $audios = Product::with('primaryImage', 'category')
            ->whereHas('category', function($q) {
                $q->where('slug', 'childrens-audios');
            })
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('storefront.audios', compact('audios'));
    }
}
