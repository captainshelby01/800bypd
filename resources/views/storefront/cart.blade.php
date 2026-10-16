@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 sm:space-y-8">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
        <div>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#312E81]">Your Shopping Cart</h1>
            <p class="text-xs text-slate-500">Review your selected items and fill your box before checkout</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-xs text-[#7C3AED] font-bold hover:underline flex items-center gap-1.5">
            <i class="bi bi-arrow-left"></i> Continue Shopping
        </a>
    </div>

    @if(session('error'))
        <div class="bg-rose-50 border-2 border-rose-200 text-rose-800 p-4 sm:p-5 rounded-3xl text-xs flex items-center gap-3 shadow-sm">
            <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center flex-shrink-0 text-rose-600 font-bold text-sm">
                <i class="bi bi-exclamation-circle-fill"></i>
            </div>
            <div>
                <p class="font-bold text-rose-900">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(count($cart) > 0)
        <!-- "FILL YOUR BOX" GAMIFIED PROGRESS CARD -->
        <div class="rounded-3xl border-2 p-5 sm:p-7 shadow-sm transition-all duration-300 {{ $box['is_box_full'] ? 'bg-gradient-to-br from-emerald-50 via-[#FFFDF9] to-teal-50 border-emerald-300' : 'bg-gradient-to-br from-amber-50 via-[#FFFDF9] to-purple-50 border-[#FACC15]' }}">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-sm {{ $box['is_box_full'] ? 'bg-emerald-500 text-white' : 'bg-[#FACC15] text-[#312E81]' }}">
                        @if($box['is_box_full'])
                            <i class="bi bi-box2-heart-fill"></i>
                        @else
                            <i class="bi bi-box-seam-fill"></i>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $box['is_box_full'] ? 'bg-emerald-200 text-emerald-900' : 'bg-amber-200 text-amber-900' }}">
                                {{ $box['is_box_full'] ? '🎉 Box Complete' : '📦 Fill Your Box Activity' }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 font-mono">Min: {{ $box['required_minimum'] }} items</span>
                        </div>
                        <h2 class="font-whimsical font-bold text-xl sm:text-2xl text-[#312E81] mt-0.5">
                            Fill Your Box
                        </h2>
                    </div>
                </div>

                <div class="text-right flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto">
                    <span class="text-2xl sm:text-3xl font-whimsical font-bold {{ $box['is_box_full'] ? 'text-emerald-700' : 'text-[#7C3AED]' }}">
                        {{ $box['total_items'] }} <span class="text-base text-slate-400 font-medium">/ {{ $box['required_minimum'] }} items</span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-500">
                        {{ $box['is_box_full'] ? 'Ready for checkout!' : $box['remaining_items'] . ' more needed' }}
                    </span>
                </div>
            </div>

            <!-- Animated Progress Bar -->
            <div class="w-full bg-slate-200/80 rounded-full h-3.5 overflow-hidden mb-3 p-0.5">
                <div class="h-full rounded-full transition-all duration-500 ease-out {{ $box['is_box_full'] ? 'bg-emerald-500' : 'bg-gradient-to-r from-[#7C3AED] to-[#FACC15]' }}" style="width: {{ $box['progress_percent'] }}%"></div>
            </div>

            <!-- Dynamic Prompt Banner -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 text-xs">
                <p class="font-bold {{ $box['is_box_full'] ? 'text-emerald-800' : 'text-[#312E81]' }} flex items-center gap-1.5">
                    @if($box['is_box_full'])
                        <i class="bi bi-stars text-amber-500 text-base"></i>
                        {{ $box['prompt_message'] }}
                    @else
                        <i class="bi bi-info-circle-fill text-[#7C3AED] text-base"></i>
                        {{ $box['prompt_message'] }}
                    @endif
                </p>

                @if(!$box['is_box_full'])
                    <a href="{{ route('catalog.index') }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-4 py-2 rounded-xl text-[11px] shadow-sm transition inline-flex items-center gap-1.5 flex-shrink-0">
                        <i class="bi bi-plus-circle-fill"></i> Add Items to Fill Box
                    </a>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 sm:gap-8">
            <!-- Cart Items List (8 Cols) -->
            <div class="lg:col-span-8 space-y-4">
                @foreach($cart as $key => $item)
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-purple-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:border-[#7C3AED]/60 transition">
                        <div class="flex items-start sm:items-center gap-4">
                            <!-- Thumbnail -->
                            <div class="w-16 h-16 sm:w-20 sm:h-20 bg-purple-50 rounded-2xl overflow-hidden flex items-center justify-center border border-purple-100 flex-shrink-0">
                                @if(!empty($item['image']))
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                @else
                                    @if(isset($item['type']) && $item['type'] === 'bundle')
                                        <i class="bi bi-box2-heart-fill text-2xl text-[#7C3AED]"></i>
                                    @else
                                        <i class="bi bi-journal-bookmark-fill text-2xl text-[#FACC15]"></i>
                                    @endif
                                @endif
                            </div>

                            <!-- Details -->
                            <div>
                                <div class="flex flex-wrap items-center gap-1.5 mb-1">
                                    @if(isset($item['type']) && $item['type'] === 'bundle')
                                        <span class="bg-[#FACC15] text-[#312E81] text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">
                                            {{ $item['badge'] ?? 'Bundle Package' }}
                                        </span>
                                        <span class="bg-purple-100 text-[#7C3AED] text-[10px] font-extrabold px-2 py-0.5 rounded-md">
                                            Adds {{ $item['box_units_per_item'] }} items to box
                                        </span>
                                    @elseif(!empty($item['variation_name']))
                                        <span class="bg-purple-100 text-[#7C3AED] text-[10px] font-bold px-2 py-0.5 rounded-md">
                                            {{ $item['variation_name'] }}
                                        </span>
                                    @endif
                                </div>

                                <h4 class="font-whimsical font-bold text-[#312E81] text-base mb-1">{{ $item['name'] }}</h4>

                                <!-- Bundle Items Breakdown (if bundle) -->
                                @if(!empty($item['items_breakdown']))
                                    <div class="text-[11px] text-slate-500 mb-2 space-y-0.5">
                                        <span class="font-bold text-slate-700">Contains:</span>
                                        @foreach($item['items_breakdown'] as $component)
                                            <span class="inline-block bg-slate-100 text-slate-600 px-1.5 py-0.5 rounded text-[10px] mr-1">
                                                ✔ {{ $component }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-extrabold text-[#7C3AED] price-convertible" data-price-ngn="{{ $item['price'] }}">
                                        ₦{{ number_format($item['price'], 2) }}
                                    </span>
                                    @if(isset($item['type']) && $item['type'] === 'bundle')
                                        <span class="text-[11px] text-slate-400">/ bundle</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Quantity & Remove Controls -->
                        <div class="flex items-center justify-between sm:justify-end gap-4 border-t sm:border-t-0 pt-3 sm:pt-0">
                            <form action="{{ route('cart.update', $key) }}" method="POST" class="flex items-center gap-1.5">
                                @csrf
                                <label class="text-[10px] font-bold text-slate-400 uppercase sm:hidden">Qty:</label>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="50" onchange="this.form.submit()" class="w-16 border border-slate-200 rounded-xl py-1.5 px-2 text-center text-xs font-extrabold text-[#312E81] focus:ring-2 focus:ring-[#7C3AED] focus:outline-none bg-slate-50">
                            </form>

                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs p-2 rounded-xl hover:bg-rose-50 transition" title="Remove item from box">
                                    <i class="bi bi-trash-fill text-base"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Order Summary & Checkout Gating (4 Cols) -->
            <div class="lg:col-span-4 space-y-4">
                <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm space-y-4 h-fit">
                    <h3 class="font-whimsical font-bold text-[#312E81] text-lg border-b border-slate-100 pb-3">Order Summary</h3>

                    <div class="space-y-3 text-xs font-semibold text-slate-600">
                        <div class="flex justify-between items-center">
                            <span>Box Contents</span>
                            <span class="font-extrabold {{ $box['is_box_full'] ? 'text-emerald-700' : 'text-amber-600' }}">
                                {{ $box['total_items'] }} / {{ $box['required_minimum'] }} items
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $subtotal }}">₦{{ number_format($subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimated Shipping (Lagos)</span>
                            <span class="font-bold text-slate-900 price-convertible" data-price-ngn="{{ $shippingFee }}">₦{{ number_format($shippingFee, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-[#312E81] border-t border-slate-100 pt-3">
                            <span>Total Payable</span>
                            <span class="price-convertible font-whimsical" data-price-ngn="{{ $subtotal + $shippingFee }}">₦{{ number_format($subtotal + $shippingFee, 2) }}</span>
                        </div>
                    </div>

                    <!-- Checkout Button: Gated by Fill Your Box status -->
                    <div class="pt-2">
                        @if($box['is_box_full'])
                            <a href="{{ route('checkout.show') }}" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5">
                                <span>Proceed to Checkout</span> <i class="bi bi-arrow-right font-black"></i>
                            </a>
                            <p class="text-[10px] text-center text-emerald-700 font-bold mt-2 flex items-center justify-center gap-1">
                                <i class="bi bi-shield-check"></i> Minimum order met! Ready to order.
                            </p>
                        @else
                            <button type="button" disabled class="w-full bg-slate-200 text-slate-400 font-extrabold py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 cursor-not-allowed shadow-none">
                                <i class="bi bi-lock-fill"></i> Checkout Locked
                            </button>
                            <div class="bg-amber-50 p-3 rounded-2xl border border-amber-200/80 text-[11px] text-amber-900 text-center font-medium mt-2">
                                Add <strong>{{ $box['remaining_items'] }}</strong> more {{ $box['remaining_items'] === 1 ? 'item' : 'items' }} to unlock checkout!
                            </div>
                            <a href="{{ route('catalog.index') }}" class="w-full mt-2 bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold py-3 rounded-2xl text-xs flex items-center justify-center gap-1.5 transition shadow-sm">
                                <i class="bi bi-cart-plus-fill"></i> Browse Items to Fill Box
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white border-2 border-dashed border-purple-200/80 rounded-3xl p-8 sm:p-14 text-center text-slate-500 max-w-xl mx-auto space-y-4">
            <div class="w-20 h-20 bg-purple-50 text-[#7C3AED] rounded-full flex items-center justify-center mx-auto text-4xl border border-purple-100 shadow-inner">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <h3 class="font-whimsical text-xl font-bold text-[#312E81] mb-1">Your Box is Empty</h3>
                <p class="text-xs text-slate-500 max-w-sm mx-auto leading-relaxed">
                    Start filling your box with fun jigsaw puzzles, educational flashcards, coloring books, or grab one of our ready-made bundles!
                </p>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                <a href="{{ route('home') }}#bundles-section" class="bg-[#FACC15] hover:bg-amber-300 text-[#312E81] font-extrabold px-6 py-3 rounded-full text-xs shadow-md transition">
                    🎁 Buy Pre-made Bundles
                </a>
                <a href="{{ route('catalog.index') }}" class="bg-[#312E81] text-white hover:bg-indigo-950 font-extrabold px-6 py-3 rounded-full text-xs shadow-md transition">
                    Browse All Products
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
