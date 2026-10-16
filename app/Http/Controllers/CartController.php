<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $box = $this->cartService->getBoxMetrics();
        $shippingFee = 2500.00; // Flat Delivery Fee in NGN Naira

        return view('storefront.cart', compact('cart', 'subtotal', 'box', 'shippingFee'));
    }

    public function add(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $variantId = $request->filled('variant_id') ? (int) $request->input('variant_id') : null;

        $result = $this->cartService->addProduct((int) $id, $quantity, $variantId);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$result['item']['name']} added to your box!",
                'cart_count' => count($this->cartService->getCart()),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', "{$result['item']['name']} added to your box!");
    }

    public function addBundle(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $result = $this->cartService->addBundle((int) $id, $quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Bundle '{$result['item']['name']}' added! Added {$result['item']['box_units_per_item']} items to your box.",
                'cart_count' => count($this->cartService->getCart()),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', "Bundle '{$result['item']['name']}' added to your box!");
    }

    public function update(Request $request, $key)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $result = $this->cartService->updateQuantity($key, $quantity);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully.',
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
            ]);
        }

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Request $request, $key)
    {
        $result = $this->cartService->removeItem($key);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from your box.',
                'cart_count' => count($this->cartService->getCart()),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
            ]);
        }

        return back()->with('success', 'Item removed from your box.');
    }
}
