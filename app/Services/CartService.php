<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Bundle;
use App\Models\Setting;

class CartService
{
    /**
     * Get raw cart contents from session.
     */
    public function getCart(): array
    {
        return session()->get('cart', []);
    }

    /**
     * Compute "Fill Your Box" metrics and progress status.
     */
    public function getBoxMetrics(): array
    {
        $cart = $this->getCart();
        $requiredMinimum = (int) Setting::get('checkout_min_order_quantity', 3);

        $totalItemsInBox = 0;
        foreach ($cart as $item) {
            $units = isset($item['box_units_per_item']) ? (int) $item['box_units_per_item'] : 1;
            $qty = isset($item['quantity']) ? (int) $item['quantity'] : 1;
            $totalItemsInBox += ($units * $qty);
        }

        $isBoxFull = $totalItemsInBox >= $requiredMinimum;
        $remainingItems = max(0, $requiredMinimum - $totalItemsInBox);
        $progressPercent = $requiredMinimum > 0 ? min(100, (int) round(($totalItemsInBox / $requiredMinimum) * 100)) : 100;

        if ($totalItemsInBox === 0) {
            $promptMessage = "Your box is empty. Add at least {$requiredMinimum} items to complete your box!";
            $badgeMessage = "0 / {$requiredMinimum} items added";
        } elseif (!$isBoxFull) {
            $unitWord = $remainingItems === 1 ? 'item' : 'items';
            $promptMessage = "Add {$remainingItems} more {$unitWord} to complete your box.";
            $badgeMessage = "{$totalItemsInBox} / {$requiredMinimum} items added";
        } elseif ($totalItemsInBox === $requiredMinimum) {
            $promptMessage = "Your box is full! You can checkout now or add more items.";
            $badgeMessage = "{$totalItemsInBox} / {$requiredMinimum} items added (Box Full)";
        } else {
            $promptMessage = "{$totalItemsInBox} items added! You can checkout now or add more items.";
            $badgeMessage = "{$totalItemsInBox} items added";
        }

        return [
            'total_items' => $totalItemsInBox,
            'required_minimum' => $requiredMinimum,
            'is_box_full' => $isBoxFull,
            'remaining_items' => $remainingItems,
            'progress_percent' => $progressPercent,
            'prompt_message' => $promptMessage,
            'badge_message' => $badgeMessage,
        ];
    }

    /**
     * Calculate cart subtotal.
     */
    public function getSubtotal(): float
    {
        $cart = $this->getCart();
        return (float) array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    /**
     * Add a standard product (or product variant) to cart.
     */
    public function addProduct(int $productId, int $quantity = 1, ?int $variantId = null): array
    {
        $product = Product::with(['primaryImage', 'variants'])->where('is_active', true)->findOrFail($productId);
        $cart = $this->getCart();

        $variant = null;
        if ($variantId) {
            $variant = ProductVariant::where('product_id', $product->id)->find($variantId);
        }

        $key = $variant ? "product_{$product->id}_{$variant->id}" : "product_{$product->id}";
        $price = $variant && $variant->price ? (float) $variant->price : (float) ($product->sale_price ?? $product->price);
        $displayName = $variant && $variant->name ? "{$product->name} ({$variant->name})" : $product->name;
        $imagePath = $product->image_url;

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'key' => $key,
                'type' => 'product',
                'id' => $product->id,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'name' => $displayName,
                'raw_name' => $product->name,
                'variation_name' => $variant ? $variant->name : null,
                'sku' => $variant ? $variant->sku : $product->sku,
                'price' => $price,
                'quantity' => $quantity,
                'box_units_per_item' => 1,
                'image' => $imagePath,
            ];
        }

        session()->put('cart', $cart);

        return [
            'item' => $cart[$key],
            'box' => $this->getBoxMetrics(),
            'subtotal' => $this->getSubtotal(),
        ];
    }

    /**
     * Add a pre-defined bundle to cart.
     */
    public function addBundle(int $bundleId, int $quantity = 1): array
    {
        $bundle = Bundle::with(['items.product', 'items.variant'])->findOrFail($bundleId);
        $cart = $this->getCart();

        $key = "bundle_{$bundle->id}";
        $unitsPerItem = max(1, $bundle->total_items_count);

        $breakdown = $bundle->items->map(function ($item) {
            return "{$item->quantity}x " . $item->display_name;
        })->toArray();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += $quantity;
        } else {
            $cart[$key] = [
                'key' => $key,
                'type' => 'bundle',
                'id' => $bundle->id,
                'bundle_id' => $bundle->id,
                'variant_id' => null,
                'name' => $bundle->name,
                'badge' => $bundle->badge ?? ($bundle->total_items_count . '-Item Bundle'),
                'variation_name' => $bundle->badge ?? ($bundle->total_items_count . '-Item Bundle'),
                'price' => (float) $bundle->price,
                'quantity' => $quantity,
                'box_units_per_item' => $unitsPerItem,
                'image' => $bundle->image_url,
                'items_breakdown' => $breakdown,
            ];
        }

        session()->put('cart', $cart);

        return [
            'item' => $cart[$key],
            'box' => $this->getBoxMetrics(),
            'subtotal' => $this->getSubtotal(),
        ];
    }

    /**
     * Update quantity of an item by its cart key.
     */
    public function updateQuantity(string $key, int $quantity): array
    {
        if ($quantity <= 0) {
            return $this->removeItem($key);
        }

        $cart = $this->getCart();

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return [
            'box' => $this->getBoxMetrics(),
            'subtotal' => $this->getSubtotal(),
        ];
    }

    /**
     * Remove an item from the cart by its key.
     */
    public function removeItem(string $key): array
    {
        $cart = $this->getCart();

        if (isset($cart[$key])) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        return [
            'box' => $this->getBoxMetrics(),
            'subtotal' => $this->getSubtotal(),
        ];
    }

    /**
     * Clear entire cart.
     */
    public function clear(): void
    {
        session()->forget('cart');
    }
}
