<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    /**
     * Display the checkout settings page (Minimum Order Quantity / Fill Your Box settings).
     */
    public function checkout()
    {
        $minOrderQty = Setting::get('checkout_min_order_quantity', 3);

        return view('admin.settings.checkout', compact('minOrderQty'));
    }

    /**
     * Update checkout settings.
     */
    public function updateCheckout(Request $request)
    {
        $validated = $request->validate([
            'checkout_min_order_quantity' => 'required|integer|min:1|max:100',
        ], [
            'checkout_min_order_quantity.required' => 'Minimum Order Quantity is required.',
            'checkout_min_order_quantity.integer' => 'Minimum Order Quantity must be a valid whole number.',
            'checkout_min_order_quantity.min' => 'Minimum Order Quantity must be at least 1 item.',
        ]);

        Setting::set(
            'checkout_min_order_quantity',
            $validated['checkout_min_order_quantity'],
            'checkout',
            'integer'
        );

        return redirect()->route('admin.settings.checkout')
            ->with('success', "Checkout settings updated! Minimum order requirement is now {$validated['checkout_min_order_quantity']} items.");
    }
}
