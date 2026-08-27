@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-black text-gray-900 mb-6">Shopping Cart</h1>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items List -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white p-4 rounded-2xl border flex items-center justify-between shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-xl overflow-hidden flex items-center justify-center border">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <i class="fa-solid fa-box text-xl text-gray-300"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm mb-1">{{ $item['name'] }}</h4>
                                <span class="text-xs font-semibold text-indigo-600">₦{{ number_format($item['price'], 2) }}</span>
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" onchange="this.form.submit()" class="w-16 border rounded-lg py-1 px-2 text-center text-xs font-bold">
                            </form>

                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs p-1"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary -->
            <div class="bg-white p-6 rounded-2xl border shadow-sm h-fit">
                <h3 class="font-bold text-gray-900 text-base mb-4 border-b pb-2">Order Summary</h3>
                <div class="space-y-3 text-xs mb-6">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-bold text-gray-900">₦{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Delivery Fee</span>
                        <span class="font-bold text-gray-900">₦{{ number_format($shippingFee, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm font-black text-indigo-900 border-t pt-3">
                        <span>Total Payable</span>
                        <span>₦{{ number_format($subtotal + $shippingFee, 2) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.show') }}" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl text-xs flex items-center justify-center gap-2 shadow-lg">
                    Proceed to Checkout <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    @else
        <div class="bg-white border rounded-2xl p-12 text-center text-gray-500">
            <i class="fa-solid fa-cart-flatbed text-5xl text-gray-300 mb-3"></i>
            <p class="text-base font-semibold mb-4">Your cart is currently empty.</p>
            <a href="{{ route('catalog.index') }}" class="bg-indigo-600 text-white px-6 py-2.5 rounded-xl text-xs font-bold inline-block hover:bg-indigo-700">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
