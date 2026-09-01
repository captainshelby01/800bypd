@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#312E81]">Shopping Cart</h1>
            <p class="text-xs text-slate-500">Review your selected items before proceeding to checkout</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-xs text-[#7C3AED] font-bold hover:underline flex items-center gap-1">
            <i class="bi bi-arrow-left"></i> Continue Shopping
        </a>
    </div>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-purple-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-purple-50 rounded-2xl overflow-hidden flex items-center justify-center border border-purple-100 flex-shrink-0">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="bi bi-book-half text-2xl text-[#FACC15]"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-whimsical font-bold text-[#312E81] text-base mb-1 line-clamp-1">{{ $item['name'] }}</h4>
                                <span class="text-xs font-extrabold text-[#7C3AED] price-convertible" data-price-ngn="{{ $item['price'] }}">₦{{ number_format($item['price'], 2) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-4 border-t sm:border-t-0 pt-3 sm:pt-0">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()" class="w-16 border border-slate-200 rounded-xl py-1.5 px-2 text-center text-xs font-bold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                            </form>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-2 rounded-xl hover:bg-rose-50 transition" title="Remove item"><i class="bi bi-trash-fill text-base"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm h-fit space-y-4">
                <h3 class="font-whimsical font-bold text-[#312E81] text-lg border-b border-slate-100 pb-3">Order Summary</h3>
                <div class="space-y-3 text-xs font-semibold text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Estimated Shipping</span>
                        <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $shippingFee }}">₦{{ number_format($shippingFee, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-bold text-[#312E81] border-t border-slate-100 pt-3">
                        <span>Total Payable</span>
                        <span class="price-convertible" data-price-ngn="{{ $subtotal + $shippingFee }}">₦{{ number_format($subtotal + $shippingFee, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.show') }}" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition">
                    Proceed to Checkout <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    @else
        <div class="bg-white border border-purple-200/80 rounded-3xl p-8 sm:p-12 text-center text-slate-500">
            <i class="bi bi-bag-fill text-5xl text-[#FACC15] mb-3 block"></i>
            <p class="text-base font-bold text-slate-700 mb-4">Your cart is currently empty.</p>
            <a href="{{ route('catalog.index') }}" class="bg-[#312E81] text-[#FACC15] px-6 py-3 rounded-full text-xs font-extrabold inline-block hover:bg-indigo-950 shadow-md">Browse Books & Audios</a>
        </div>
    @endif
</div>
@endsection
