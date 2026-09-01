@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-purple-200/80 rounded-3xl p-6 sm:p-10 text-center shadow-sm">
    <div class="w-16 h-16 bg-purple-100 text-[#7C3AED] rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
        <i class="bi bi-check-circle-fill"></i>
    </div>

    <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#312E81] mb-2">Order Confirmed!</h1>
    <p class="text-xs text-slate-500 mb-6">Thank you for your purchase. Your order has been registered.</p>

    <div class="bg-purple-50/50 p-6 rounded-2xl border border-purple-200/60 text-left text-xs space-y-2.5 mb-6">
        <div class="flex justify-between">
            <span class="text-slate-500 font-semibold">Order Number:</span>
            <span class="font-bold font-mono text-[#312E81] text-sm">{{ $order->order_number }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-slate-500 font-semibold">Payment Method:</span>
            <span class="font-bold uppercase text-slate-800">{{ str_replace('_', ' ', $order->payment_method) }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-slate-500 font-semibold">Payment Status:</span>
            <span class="font-bold px-2.5 py-1 rounded-full text-[10px] {{ $order->payment_status === 'paid' ? 'bg-purple-100 text-[#7C3AED]' : 'bg-amber-100 text-amber-800' }}">
                {{ strtoupper($order->payment_status) }}
            </span>
        </div>
        <div class="flex justify-between border-t border-slate-200 pt-3 font-bold text-sm">
            <span class="text-slate-700">Total Amount Paid:</span>
            <span class="text-[#312E81] price-convertible" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</span>
        </div>
    </div>

    @if($order->payment_method === 'bank_transfer')
        <div class="bg-purple-50 border border-purple-200 text-[#312E81] p-4 rounded-2xl text-xs mb-6 text-left flex items-start gap-2">
            <i class="bi bi-info-circle-fill text-base text-[#7C3AED] flex-shrink-0 mt-0.5"></i>
            <div>
                <strong>Bank Transfer Status:</strong> Your payment receipt screenshot has been uploaded. An administrator will verify your receipt and dispatch your package shortly.
            </div>
        </div>
    @endif

    <a href="{{ route('home') }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-3.5 rounded-2xl text-xs inline-block shadow-md transition">Return to Storefront</a>
</div>
@endsection
