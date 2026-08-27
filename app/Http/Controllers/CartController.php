<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
        $cart = session()->get('cart', []);
        $subtotal = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $shippingFee = 2500.00; // Flat Delivery Fee in NGN Naira

        return view('storefront.cart', compact('cart', 'subtotal', 'shippingFee'));
    }

    public function add(Request $request, $id) {
        $product = Product::findOrFail($id);
        $cart = session()->get('cart', []);

        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->sale_price ?? $product->price,
                'quantity' => $quantity,
                'image' => $product->primaryImage ? $product->primaryImage->image_path : null,
            ];
        }

        session()->put('cart', $cart);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to cart!",
                'cart_count' => count($cart),
                'product_name' => $product->name,
            ]);
        }

        return redirect()->route('cart.index')->with('success', "{$product->name} added to shopping cart!");
    }

    public function update(Request $request, $id) {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->quantity);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove($id) {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item removed from cart.');
    }
}
