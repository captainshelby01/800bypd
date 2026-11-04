<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'shipping_method' => 'required|in:lagos_flat,nationwide_courier',
            'special_instructions' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:paystack,card,bank_transfer',
            'receipt' => 'nullable|required_if:payment_method,bank_transfer|file|mimes:jpeg,png,jpg,pdf|max:4096'
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
            'payment_reference' => $validated['payment_method'] === 'bank_transfer' ? null : $orderNumber,
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

        // Direct Bank Transfer Flow
        if ($validated['payment_method'] === 'bank_transfer') {
            $this->cartService->clear();
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been confirmed! Please check your email for your order receipt.');
        }

        // Paystack / Online Card Flow: Initialize payment session
        return $this->initializePaystack($order);
    }

    /**
     * Retry payment for an existing unpaid order.
     */
    public function retryPayment($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        if ($order->payment_status === 'paid') {
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'This order has already been paid and confirmed.');
        }

        return $this->initializePaystack($order);
    }

    /**
     * Initialize Paystack Payment Gateway.
     */
    private function initializePaystack(Order $order)
    {
        $secretKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY'));
        $paymentUrl = rtrim(config('services.paystack.payment_url', env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co')), '/');

        if (empty($secretKey) || str_contains($secretKey, 'sample_key')) {
            Log::critical("Paystack Secret Key is missing or invalid in environment configuration.");
            return redirect()->route('checkout.show')
                ->with('error', 'Online payment gateway is temporarily unconfigured. Please select Bank Transfer or contact support.');
        }

        // Convert total to Kobo (Paystack requires minor units for NGN)
        $amountInKobo = (int) round($order->total_amount * 100);

        try {
            $response = Http::timeout(20)
                ->withToken($secretKey)
                ->post("{$paymentUrl}/transaction/initialize", [
                    'email' => $order->customer_email,
                    'amount' => $amountInKobo,
                    'reference' => $order->order_number,
                    'currency' => 'NGN',
                    'callback_url' => route('paystack.callback'),
                    'metadata' => [
                        'order_id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer_name,
                        'customer_phone' => $order->customer_phone,
                        'shipping_method' => $order->shipping_method,
                    ]
                ]);

            if ($response->successful()) {
                $authUrl = $response->json('data.authorization_url');
                if (!empty($authUrl)) {
                    $order->update([
                        'payment_reference' => $order->order_number,
                    ]);

                    return redirect()->away($authUrl);
                }
            }

            Log::error("Paystack Transaction Initialization Failed for Order #{$order->order_number}", [
                'status' => $response->status(),
                'response' => $response->json() ?? $response->body(),
            ]);

            $gatewayError = $response->json('message') ?? 'Unable to connect to Paystack payment gateway.';
            return redirect()->route('checkout.show')
                ->with('error', 'Online payment initialization failed: ' . $gatewayError . ' Please try again or use Bank Transfer.');

        } catch (\Exception $e) {
            Log::error("Paystack Connection Exception for Order #{$order->order_number}: " . $e->getMessage());
            return redirect()->route('checkout.show')
                ->with('error', 'Network error connecting to payment gateway. Please check your internet connection and try again.');
        }
    }

    /**
     * Handle Paystack Callback after user completes/cancels transaction on Paystack hosted checkout.
     */
    public function paystackCallback(Request $request)
    {
        $reference = $request->query('reference') ?? $request->query('trxref');

        if (empty($reference)) {
            Log::warning('Paystack callback received without reference parameter.', $request->all());
            return redirect()->route('cart.index')->with('error', 'Payment verification failed: No payment reference received.');
        }

        // Sanitize reference
        $reference = preg_replace('/[^a-zA-Z0-9_\-]/', '', $reference);

        $order = Order::where('order_number', $reference)
            ->orWhere('payment_reference', $reference)
            ->first();

        if (!$order) {
            Log::warning("Paystack callback: Order not found for reference '{$reference}'");
            return redirect()->route('cart.index')->with('error', 'Order not found for this payment reference.');
        }

        // Idempotency: If already confirmed paid (e.g. by Webhook), don't re-process
        if ($order->payment_status === 'paid') {
            $this->cartService->clear();
            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been confirmed! Please check your email for your order receipt.');
        }

        $secretKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY'));
        $paymentUrl = rtrim(config('services.paystack.payment_url', env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co')), '/');

        try {
            // Server-to-server transaction verification
            $response = Http::timeout(20)
                ->withToken($secretKey)
                ->get("{$paymentUrl}/transaction/verify/{$reference}");

            if (!$response->successful()) {
                Log::error("Paystack Verification HTTP Error for Order #{$order->order_number}", [
                    'status' => $response->status(),
                    'body' => $response->json() ?? $response->body(),
                ]);
                return redirect()->route('checkout.show')
                    ->with('error', 'Unable to verify payment with payment gateway. Please contact support.');
            }

            $payload = $response->json();
            if (!isset($payload['status']) || $payload['status'] !== true || !isset($payload['data'])) {
                Log::error("Paystack Verification Payload Error for Order #{$order->order_number}", [
                    'payload' => $payload,
                ]);
                return redirect()->route('checkout.show')
                    ->with('error', 'Invalid verification response received from payment gateway.');
            }

            $data = $payload['data'];
            $gatewayStatus = strtolower($data['status'] ?? '');

            // 1. Transaction Status Check
            if ($gatewayStatus !== 'success') {
                $order->update(['payment_status' => 'failed']);
                $failureReason = $data['gateway_response'] ?? 'Payment was cancelled or was not completed.';
                Log::info("Paystack Payment Unsuccessful for Order #{$order->order_number}: {$failureReason}");
                return redirect()->route('checkout.show')
                    ->with('error', "Payment was not completed: {$failureReason}. Please try again.");
            }

            // 2. Strict Security Measure: Verify Amount Paid in Kobo against Order Total
            $paidAmountKobo = (int) ($data['amount'] ?? 0);
            $expectedAmountKobo = (int) round($order->total_amount * 100);

            if ($paidAmountKobo !== $expectedAmountKobo) {
                Log::critical("Security Alert: Paystack Amount Mismatch for Order #{$order->order_number}!", [
                    'expected_kobo' => $expectedAmountKobo,
                    'paid_kobo' => $paidAmountKobo,
                    'paystack_reference' => $data['reference'] ?? $reference,
                ]);
                $order->update([
                    'payment_status' => 'failed',
                    'payment_reference' => $data['reference'] ?? $reference,
                ]);
                return redirect()->route('cart.index')
                    ->with('error', 'Payment verification failed: The amount paid does not match the order total. Please contact support.');
            }

            // 3. Strict Security Measure: Verify Currency
            $currency = strtoupper($data['currency'] ?? '');
            if ($currency !== 'NGN') {
                Log::critical("Security Alert: Paystack Currency Mismatch for Order #{$order->order_number}!", [
                    'currency' => $currency,
                ]);
                $order->update(['payment_status' => 'failed']);
                return redirect()->route('cart.index')
                    ->with('error', 'Payment verification failed: Currency mismatch.');
            }

            // Payment Verified Successfully!
            $order->update([
                'payment_status' => 'paid',
                'payment_reference' => $data['reference'] ?? $reference,
                'order_status' => 'processing',
            ]);

            // Clear Cart upon confirmed payment
            $this->cartService->clear();

            Log::info("Paystack Payment Successfully Verified for Order #{$order->order_number}", [
                'amount' => $order->total_amount,
                'paystack_reference' => $data['reference'] ?? $reference,
                'channel' => $data['channel'] ?? 'online',
            ]);

            return redirect()->route('checkout.success', $order->order_number)
                ->with('success', 'Your order has been confirmed! Please check your email for your order receipt.');

        } catch (\Exception $e) {
            Log::error("Paystack Verification Exception for Order #{$order->order_number}: " . $e->getMessage());
            return redirect()->route('checkout.show')
                ->with('error', 'An unexpected error occurred while verifying your payment. Please contact support.');
        }
    }

    /**
     * Handle Paystack Webhook events (Asynchronous Server-to-Server Notifications).
     */
    public function paystackWebhook(Request $request)
    {
        $secretKey = config('services.paystack.secret_key', env('PAYSTACK_SECRET_KEY'));

        if (empty($secretKey)) {
            Log::error('Paystack Webhook: Secret key is not configured.');
            return response()->json(['message' => 'Configuration error'], 500);
        }

        // Security Measure: Validate Paystack HMAC SHA512 Signature
        $signature = $request->header('x-paystack-signature');
        $payload = $request->getContent();

        if (empty($signature) || !hash_equals(hash_hmac('sha512', $payload, $secretKey), $signature)) {
            Log::warning('Paystack Webhook: Invalid or missing x-paystack-signature header.');
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $event = json_decode($payload, true);
        if (!$event || !isset($event['event'])) {
            return response()->json(['message' => 'Invalid payload format'], 400);
        }

        // Process successful charge events
        if ($event['event'] === 'charge.success') {
            $data = $event['data'] ?? [];
            $reference = $data['reference'] ?? null;

            if ($reference) {
                $order = Order::where('order_number', $reference)
                    ->orWhere('payment_reference', $reference)
                    ->first();

                if ($order && $order->payment_status !== 'paid') {
                    $paidAmountKobo = (int) ($data['amount'] ?? 0);
                    $expectedAmountKobo = (int) round($order->total_amount * 100);
                    $currency = strtoupper($data['currency'] ?? '');

                    if ($paidAmountKobo === $expectedAmountKobo && $currency === 'NGN') {
                        $order->update([
                            'payment_status' => 'paid',
                            'payment_reference' => $reference,
                            'order_status' => 'processing',
                        ]);

                        Log::info("Paystack Webhook marked Order #{$order->order_number} as PAID.", [
                            'amount' => $order->total_amount,
                            'paystack_reference' => $reference,
                        ]);
                    } else {
                        Log::critical("Paystack Webhook: Amount or currency mismatch for Order #{$order->order_number}!", [
                            'expected_kobo' => $expectedAmountKobo,
                            'paid_kobo' => $paidAmountKobo,
                            'currency' => $currency,
                        ]);
                    }
                }
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
