@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6 sm:space-y-8">
    <!-- Navigation & Title Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('account.orders') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to All Orders
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Order #{{ $order->order_number }}</h1>
            <p class="text-xs text-slate-500">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
        </div>

        <button onclick="window.print()" class="bg-amber-100 hover:bg-amber-200 text-[#2D1B4E] font-extrabold px-4 py-2.5 rounded-2xl text-xs flex items-center gap-2 shadow-sm transition">
            <i class="bi bi-printer-fill"></i> Print Order Receipt
        </button>
    </div>

    <!-- Status Progress Tracker Bar -->
    <div class="bg-white p-5 sm:p-6 md:p-8 rounded-3xl border border-amber-200/80 shadow-sm space-y-4">
        <h3 class="font-whimsical text-lg font-bold text-slate-800">Order Progress</h3>
        @php
            $statuses = ['pending', 'processing', 'dispatched', 'delivered'];
            $currentIndex = array_search($order->order_status, $statuses);
            if ($currentIndex === false) $currentIndex = 0;
        @endphp

        <div class="relative flex items-center justify-between max-w-2xl mx-auto py-4">
            <!-- Progress Line background -->
            <div class="absolute top-1/2 left-0 right-0 h-1 bg-slate-200 -translate-y-1/2 z-0"></div>
            <div class="absolute top-1/2 left-0 h-1 bg-emerald-500 -translate-y-1/2 z-0 transition-all duration-500" style="width: {{ ($currentIndex / (count($statuses) - 1)) * 100 }}%"></div>

            @foreach($statuses as $index => $st)
                @php
                    $isCompleted = $index <= $currentIndex;
                    $isCurrent = $index === $currentIndex;
                @endphp
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-full flex items-center justify-center font-bold text-xs shadow-md transition-all border-2 
                        {{ $isCompleted ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-slate-400 border-slate-300' }}">
                        @if($isCompleted && !$isCurrent)
                            <i class="bi bi-check-lg"></i>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="text-[10px] sm:text-[11px] font-bold capitalize mt-2 {{ $isCompleted ? 'text-slate-800' : 'text-slate-400' }}">
                        {{ $st }}
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Order Items & Pricing Breakdown -->
    <div class="bg-white p-5 sm:p-6 md:p-8 rounded-3xl border border-amber-200/80 shadow-sm space-y-6">
        <h3 class="font-whimsical text-xl font-bold text-[#2D1B4E]">Items Purchased</h3>

        <div class="divide-y divide-slate-100">
            @foreach($order->items as $item)
                <div class="py-4 flex justify-between items-center text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-amber-100 text-[#2D1B4E] rounded-xl flex items-center justify-center font-whimsical font-bold text-base flex-shrink-0">
                            📖
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $item->product_name }}</p>
                            <p class="text-slate-500">Unit Price: <span class="price-convertible" data-price-ngn="{{ $item->price }}">₦{{ number_format($item->price, 2) }}</span> &times; {{ $item->quantity }}</p>
                        </div>
                    </div>
                    <p class="font-bold text-slate-900 text-sm price-convertible" data-price-ngn="{{ $item->price * $item->quantity }}">₦{{ number_format($item->price * $item->quantity, 2) }}</p>
                </div>
            @endforeach
        </div>

        <div class="border-t border-slate-200 pt-4 space-y-2 text-xs font-semibold text-slate-600">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span class="price-convertible" data-price-ngn="{{ $order->subtotal }}">{{ $order->formatted_subtotal }}</span>
            </div>
            <div class="flex justify-between">
                <span>Shipping Fee ({{ $order->shipping_method === 'nationwide_courier' ? 'Nationwide Courier' : 'Lagos Flat Rate' }})</span>
                <span class="price-convertible" data-price-ngn="{{ $order->shipping_fee }}">₦{{ number_format($order->shipping_fee, 2) }}</span>
            </div>
            @if($order->discount_amount > 0)
                <div class="flex justify-between text-emerald-600">
                    <span>Discount</span>
                    <span class="price-convertible" data-price-ngn="{{ $order->discount_amount }}">-₦{{ number_format($order->discount_amount, 2) }}</span>
                </div>
            @endif
            <div class="flex justify-between border-t border-slate-200 pt-3 text-base font-bold text-[#2D1B4E]">
                <span>Total Paid / Due</span>
                <span class="price-convertible" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
            </div>
        </div>
    </div>

    <!-- Shipping & Payment Info Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs">
        <!-- Shipping Details -->
        <div class="bg-white p-6 rounded-3xl border border-amber-200/80 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h4 class="font-whimsical text-base font-bold text-slate-800">Shipping Details</h4>
                <i class="bi bi-truck text-amber-500 text-lg"></i>
            </div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Recipient Name</p>
                <p class="font-bold text-slate-800">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Phone Number</p>
                <p class="font-bold text-slate-800">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Delivery Address</p>
                <p class="font-bold text-slate-800">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->state }}</p>
            </div>
            @if($order->special_instructions)
                <div>
                    <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Delivery Note</p>
                    <p class="text-slate-700 italic bg-amber-50 p-2.5 rounded-xl border border-amber-100">{{ $order->special_instructions }}</p>
                </div>
            @endif
        </div>

        <!-- Payment Details -->
        <div class="bg-white p-6 rounded-3xl border border-amber-200/80 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h4 class="font-whimsical text-base font-bold text-slate-800">Payment Details</h4>
                <i class="bi bi-credit-card-fill text-purple-600 text-lg"></i>
            </div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Payment Method</p>
                <p class="font-bold text-slate-800 uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</p>
            </div>
            <div>
                <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Payment Status</p>
                <p class="font-bold">
                    @if($order->payment_status === 'paid')
                        <span class="text-emerald-600 flex items-center gap-1"><i class="bi bi-check-circle-fill"></i> Paid</span>
                    @elseif($order->payment_status === 'pending_verification')
                        <span class="text-amber-600 flex items-center gap-1"><i class="bi bi-clock-fill"></i> Pending Verification</span>
                    @else
                        <span class="text-rose-600">Unpaid</span>
                    @endif
                </p>
            </div>
            @if($order->payment_reference)
                <div>
                    <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Transaction Reference</p>
                    <p class="font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded inline-block text-[11px]">{{ $order->payment_reference }}</p>
                </div>
            @endif
            @if($order->bank_transfer_receipt)
                <div>
                    <p class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Bank Transfer Receipt</p>
                    <a href="{{ asset('storage/' . $order->bank_transfer_receipt) }}" target="_blank" class="text-purple-700 font-bold hover:underline flex items-center gap-1 mt-1">
                        <i class="bi bi-file-earmark-text-fill"></i> View Uploaded Receipt
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
