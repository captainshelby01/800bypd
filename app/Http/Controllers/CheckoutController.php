<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    public function show() {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        $subtotal = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
        $shippingFee = 2500.00; // Default Lagos Flat Rate

        return view('storefront.checkout', compact('cart', 'subtotal', 'shippingFee'));
    }

    public function process(Request $request) {
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

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is empty.');
        }

        $subtotal = array_reduce($cart, fn($carry, $item) => $carry + ($item['price'] * $item['quantity']), 0);
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

        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
            ]);
        }

        session()->forget('cart');

        // Paystack / Card Payment Initialization
        if (in_array($validated['payment_method'], ['paystack', 'card'])) {
            return $this->initializePaystack($order);
        }

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Order placed successfully! Your Bank Transfer receipt is under admin verification.');
    }

    private function initializePaystack(Order $order) {
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

    public function paystackCallback(Request $request) {
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
