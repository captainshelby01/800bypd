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

    public function sidebarData(Request $request)
    {
        $cart = $this->cartService->getCart();
        $subtotal = $this->cartService->getSubtotal();
        $box = $this->cartService->getBoxMetrics();

        return response()->json([
            'success' => true,
            'cart_count' => count($cart),
            'box' => $box,
            'subtotal' => $subtotal,
            'formatted_subtotal' => '₦' . number_format($subtotal, 2),
            'items' => array_values($this->formatCartItems($cart)),
        ]);
    }

    public function add(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));
        $variantId = $request->filled('variant_id') ? (int) $request->input('variant_id') : null;

        $result = $this->cartService->addProduct((int) $id, $quantity, $variantId);
        $cart = $this->cartService->getCart();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$result['item']['name']} added to your box!",
                'cart_count' => count($cart),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
                'formatted_subtotal' => '₦' . number_format($result['subtotal'], 2),
                'items' => array_values($this->formatCartItems($cart)),
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', "{$result['item']['name']} added to your box!");
    }

    public function addBundle(Request $request, $id)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        $result = $this->cartService->addBundle((int) $id, $quantity);
        $cart = $this->cartService->getCart();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Bundle '{$result['item']['name']}' added! Added {$result['item']['box_units_per_item']} items to your box.",
                'cart_count' => count($cart),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
                'formatted_subtotal' => '₦' . number_format($result['subtotal'], 2),
                'items' => array_values($this->formatCartItems($cart)),
            ]);
        }

        return redirect()->route('cart.index')
            ->with('success', "Bundle '{$result['item']['name']}' added to your box!");
    }

    public function update(Request $request, $key)
    {
        $quantity = (int) $request->input('quantity', 1);
        $result = $this->cartService->updateQuantity($key, $quantity);
        $cart = $this->cartService->getCart();
        $msg = $quantity <= 0 ? 'Item removed from your box.' : 'Cart updated successfully.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $msg,
                'cart_count' => count($cart),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
                'formatted_subtotal' => '₦' . number_format($result['subtotal'], 2),
                'items' => array_values($this->formatCartItems($cart)),
            ]);
        }

        return back()->with('success', $msg);
    }

    public function remove(Request $request, $key)
    {
        $result = $this->cartService->removeItem($key);
        $cart = $this->cartService->getCart();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Item removed from your box.',
                'cart_count' => count($cart),
                'box' => $result['box'],
                'subtotal' => $result['subtotal'],
                'formatted_subtotal' => '₦' . number_format($result['subtotal'], 2),
                'items' => array_values($this->formatCartItems($cart)),
            ]);
        }

        return back()->with('success', 'Item removed from your box.');
    }

    /**
     * Format cart items for JSON responses.
     */
    protected function formatCartItems(array $cart): array
    {
        $items = [];
        foreach ($cart as $key => $item) {
            $img = $item['image'] ?? null;
            if ($img) {
                if (!str_starts_with($img, 'http://') && !str_starts_with($img, 'https://') && !str_starts_with($img, '/')) {
                    $img = asset('storage/' . $img);
                }
            } else {
                $img = asset('images/products/placeholder.svg');
            }

            $price = (float) ($item['price'] ?? 0);
            $qty = (int) ($item['quantity'] ?? 1);

            $items[] = [
                'key' => $key,
                'type' => $item['type'] ?? 'product',
                'id' => $item['id'] ?? null,
                'product_id' => $item['product_id'] ?? null,
                'variant_id' => $item['variant_id'] ?? null,
                'name' => $item['name'] ?? '',
                'raw_name' => $item['raw_name'] ?? ($item['name'] ?? ''),
                'variation_name' => $item['variation_name'] ?? null,
                'badge' => $item['badge'] ?? null,
                'price' => $price,
                'formatted_price' => '₦' . number_format($price, 2),
                'quantity' => $qty,
                'line_total' => $price * $qty,
                'formatted_line_total' => '₦' . number_format($price * $qty, 2),
                'box_units_per_item' => (int) ($item['box_units_per_item'] ?? 1),
                'items_breakdown' => $item['items_breakdown'] ?? [],
            ];
        }
        return $items;
    }
}
