@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white border rounded-3xl p-8 text-center shadow-sm">
    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
        <i class="fa-solid fa-circle-check"></i>
    </div>

    <h1 class="text-2xl font-black text-gray-900 mb-2">Order Confirmed!</h1>
    <p class="text-xs text-gray-500 mb-6">Thank you for your purchase. Your order has been registered.</p>

    <div class="bg-gray-50 p-6 rounded-2xl border text-left text-xs space-y-2 mb-6">
        <div class="flex justify-between">
            <span class="text-gray-500">Order Number:</span>
            <span class="font-bold font-mono text-indigo-900">{{ $order->order_number }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Payment Method:</span>
            <span class="font-bold uppercase">{{ str_replace('_', ' ', $order->payment_method) }}</span>
        </div>
        <div class="flex justify-between">
            <span class="text-gray-500">Payment Status:</span>
            <span class="font-bold px-2 py-0.5 rounded text-[10px] {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ strtoupper($order->payment_status) }}
            </span>
        </div>
        <div class="flex justify-between border-t pt-2 font-bold text-sm">
            <span>Total Amount Paid:</span>
            <span class="text-indigo-900">{{ $order->formatted_total }}</span>
        </div>
    </div>

    @if($order->payment_method === 'bank_transfer')
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl text-xs mb-6 text-left">
            <i class="fa-solid fa-circle-info mr-1"></i> <strong>Bank Transfer Status:</strong> Your payment receipt screenshot has been uploaded. An administrator will verify your receipt and dispatch your package shortly.
        </div>
    @endif

    <a href="{{ route('home') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3 rounded-xl text-xs inline-block">Return to Homepage</a>
</div>
@endsection
