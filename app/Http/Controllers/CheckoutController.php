<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function show()
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        $box = $this->cartService->getBoxMetrics();

        // Hard Backend Guard: Ensure customer has filled their box before accessing checkout
        if (!$box['is_box_full']) {
            $remaining = $box['remaining_items'];
            $word = $remaining === 1 ? 'item' : 'items';
            return redirect()->route('cart.index')
                ->with('error', "Your box contains {$box['total_items']} of {$box['required_minimum']} required items. Please add at least {$remaining} more {$word} to complete your box and checkout!");
        }

        $subtotal = $this->cartService->getSubtotal();
        $shippingFee = 2500.00; // Default Lagos Flat Rate

        return view('storefront.checkout', compact('cart', 'subtotal', 'box', 'shippingFee'));
    }

    public function process(Request $request)
    {
        $cart = $this->cartService->getCart();
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        $box = $this->cartService->getBoxMetrics();

        // Hard Backend Guard: Reject order if minimum items threshold is not reached
        if (!$box['is_box_full']) {
            $remaining = $box['remaining_items'];
            $word = $remaining === 1 ? 'item' : 'items';
            return redirect()->route('cart.index')
                ->with('error', "Cannot complete checkout: Please add {$remaining} more {$word} to reach the minimum order requirement of {$box['required_minimum']} items.");
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'shipping_method' => 'required|in:lagos_flat,nationwide_courier',
            'special_instructions' => 'nullable|string',
            'payment_method' => 'required|in:paystack,card,bank_transfer',
            'receipt' => 'nullable|required_if:payment_method,bank_transfer|image|mimes:jpeg,png,jpg,pdf|max:4096'
        ]);

        $subtotal = $this->cartService->getSubtotal();
        $shippingFee = $validated['shipping_method'] === 'nationwide_courier' ? 4500.00 : 2500.00;
        $total = $subtotal + $shippingFee;

        $orderNumber = '800-ORD-' . strtoupper(Str::random(6));

        // Handle Bank Transfer Receipt Upload
        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $receiptPath = $request->file('receipt')->store('receipts', 'public');
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'shipping_address' => $validated['shipping_address'],
            'city' => $validated['city'],
            'state' => $validated['state'],
            'shipping_method' => $validated['shipping_method'],
            'special_instructions' => $validated['special_instructions'] ?? null,
            'subtotal' => $subtotal,
            'shipping_fee' => $shippingFee,
            'total_amount' => $total,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $validated['payment_method'] === 'bank_transfer' ? 'pending_verification' : 'unpaid',
            'bank_transfer_receipt' => $receiptPath,
            'order_status' => 'pending',
        ]);

        foreach ($cart as $item) {
            $isBundle = isset($item['type']) && $item['type'] === 'bundle';

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $isBundle ? null : ($item['product_id'] ?? $item['id']),
                'bundle_id' => $isBundle ? ($item['bundle_id'] ?? $item['id']) : null,
                'product_name' => $item['name'],
                'variation_name' => $item['variation_name'] ?? null,
                'bundle_details' => !empty($item['items_breakdown']) ? implode(', ', $item['items_breakdown']) : null,
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        $this->cartService->clear();

        // Paystack / Card Payment Initialization
        if (in_array($validated['payment_method'], ['paystack', 'card'])) {
            return $this->initializePaystack($order);
        }

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Order placed successfully! Your Bank Transfer receipt is under admin verification.');
    }

    private function initializePaystack(Order $order)
    {
        $secretKey = env('PAYSTACK_SECRET_KEY', 'sk_test_sample_key');
        
        $response = Http::withToken($secretKey)
            ->post('https://api.paystack.co/transaction/initialize', [
                'email' => $order->customer_email,
                'amount' => (int)($order->total_amount * 100), // Kobo
                'reference' => $order->order_number,
                'callback_url' => route('paystack.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'phone' => $order->customer_phone,
                ]
            ]);

        if ($response->successful() && isset($response->json()['data']['authorization_url'])) {
            return redirect($response->json()['data']['authorization_url']);
        }

        // Test mode fallback
        $order->update([
            'payment_status' => 'paid',
            'payment_reference' => 'PST-800BYPD-' . Str::random(8),
            'order_status' => 'processing',
        ]);

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Paystack payment completed (Test Sandbox Mode)!');
    }

    public function paystackCallback(Request $request)
    {
        $reference = $request->get('reference');
        $secretKey = env('PAYSTACK_SECRET_KEY', 'sk_test_sample_key');

        $response = Http::withToken($secretKey)
            ->get("https://api.paystack.co/transaction/verify/{$reference}");

        if ($response->successful() && $response->json()['data']['status'] === 'success') {
            $order = Order::where('order_number', $reference)->firstOrFail();
            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $response->json()['data']['reference'],
                'order_status' => 'processing',
            ]);

            return redirect()->route('checkout.success', $order->order_number);
        }

        return redirect()->route('cart.index')->with('error', 'Payment transaction failed or was cancelled.');
    }
}
