@extends('layouts.app')

@section('content')
<!-- 800bypd Mobile-First Product Detail Page -->
<div class="bg-white border border-slate-200 rounded-3xl p-6 lg:p-10 shadow-sm max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Image Gallery Above Fold -->
        <div>
            <div class="h-80 lg:h-96 bg-amber-50/40 rounded-2xl overflow-hidden mb-4 relative flex items-center justify-center border border-amber-100">
                @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center p-6">
                        <i class="fa-solid fa-book-open-reader text-6xl text-amber-400 mb-3"></i>
                        <span class="block text-xs font-bold text-slate-400">800bypd Original Publication</span>
                    </div>
                @endif
                <span class="absolute top-4 left-4 bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow">
                    <i class="fa-solid fa-check mr-1"></i> In Stock ({{ $product->stock_quantity }} Available)
                </span>
            </div>

            @if($product->images->count() > 0)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 cursor-pointer hover:border-purple-600">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details Above Fold -->
        <div class="flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-700 bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">{{ $product->category->name ?? 'Books' }}</span>
                <h1 class="text-2xl lg:text-3xl font-black text-slate-900 mb-2 leading-tight">{{ $product->name }}</h1>
                <p class="text-xs text-slate-500 mb-4 font-mono">SKU: {{ $product->sku }} | Author: <strong>WrittenbyPD</strong></p>

                <!-- One-Sentence Key Benefit Summary -->
                <div class="text-xs text-purple-900 bg-purple-50/80 border border-purple-100 p-3.5 rounded-2xl mb-6 flex items-start gap-2">
                    <i class="fa-solid fa-sparkles text-amber-500 text-base mt-0.5"></i>
                    <div>
                        <strong>Why Kids & Parents Love This:</strong> Specially crafted to boost creativity, language development, and problem-solving skills in young learners.
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-black text-purple-950 price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                    @if($product->sale_price)
                        <span class="text-sm text-slate-400 line-through">{{ $product->formatted_original_price }}</span>
                        <span class="bg-amber-400 text-purple-950 text-xs font-black px-2 py-0.5 rounded-full">Discount Applied</span>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 mb-6">
                    @csrf
                    <div class="flex items-center gap-4">
                        <label class="text-xs font-bold text-slate-700">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 border border-slate-300 rounded-xl py-2 px-3 text-center text-sm font-bold focus:ring-2 focus:ring-purple-500">
                    </div>

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl shadow-lg hover:shadow-xl transition text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-bag-shopping"></i> Add to Cart (<span class="price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>)
                    </button>
                </form>
            </div>

            <!-- 3-Point Trust Signal Row -->
            <div class="border-t border-slate-100 pt-4 grid grid-cols-3 gap-2 text-center text-xs text-slate-600 bg-slate-50 p-3.5 rounded-2xl">
                <div>
                    <i class="fa-solid fa-truck-fast text-purple-600 text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">1-3 Days Delivery</span>
                    <span class="text-[10px] text-slate-400">Lagos & Nationwide</span>
                </div>
                <div>
                    <i class="fa-solid fa-shield-check text-green-600 text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Paystack & Bank</span>
                    <span class="text-[10px] text-slate-400">100% Secured</span>
                </div>
                <div>
                    <i class="fa-brands fa-spotify text-emerald-500 text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Spotify Audio</span>
                    <span class="text-[10px] text-slate-400">Listen Companion</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Below The Fold Details -->
    <div class="mt-12 border-t border-slate-100 pt-8">
        <h3 class="text-xl font-black text-slate-900 mb-3">Product Overview & Specifications</h3>
        <p class="text-sm text-slate-600 leading-relaxed mb-6">{{ $product->description }}</p>

        <!-- Customer Reviews & Star Ratings -->
        <div class="mt-8 bg-amber-50/50 p-6 rounded-3xl border border-amber-200/60">
            <h4 class="font-black text-slate-900 mb-4 text-base flex items-center gap-2">
                <i class="fa-solid fa-star text-amber-500"></i> Verified Customer Reviews
            </h4>
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 text-xs shadow-sm">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-slate-900">{{ $review->customer_name }} <span class="text-green-600 text-[10px] font-normal ml-1"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span></span>
                            <div class="text-amber-400 text-xs">
                                @for($i=0; $i<$review->rating; $i++) ★ @endfor
                            </div>
                        </div>
                        <p class="text-slate-600 leading-relaxed">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-500">No reviews yet for this product. Be the first to leave feedback after purchase!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
