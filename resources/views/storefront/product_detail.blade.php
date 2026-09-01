@extends('layouts.app')

@section('content')
<div class="bg-white border border-amber-200/80 rounded-3xl p-5 sm:p-8 lg:p-10 shadow-sm max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Image Gallery Above Fold -->
        <div>
            <div class="h-72 sm:h-80 lg:h-96 bg-purple-50/50 rounded-2xl overflow-hidden mb-4 relative flex items-center justify-center border border-purple-100">
                @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center p-6">
                        <i class="bi bi-journal-bookmark-fill text-6xl text-amber-400 mb-3"></i>
                        <span class="block text-xs font-bold text-slate-400">800bypd Original Publication</span>
                    </div>
                @endif
                <span class="absolute top-4 left-4 bg-[#7C3AED] text-white text-xs font-bold px-3 py-1 rounded-full shadow flex items-center gap-1">
                    <i class="bi bi-check-lg"></i> In Stock ({{ $product->stock_quantity }} Available)
                </span>
            </div>

            @if($product->images->count() > 0)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" class="w-16 h-16 object-cover rounded-xl border border-slate-200 cursor-pointer hover:border-[#7C3AED]">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details Above Fold -->
        <div class="flex flex-col justify-between">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">{{ $product->category->name ?? 'Books' }}</span>
                <h1 class="font-whimsical text-2xl lg:text-3xl font-bold text-[#312E81] mb-2 leading-tight">{{ $product->name }}</h1>
                <p class="text-xs text-slate-500 mb-4 font-mono">SKU: {{ $product->sku }} | Author: <strong>WrittenbyPD</strong></p>

                <!-- One-Sentence Key Benefit Summary -->
                <div class="text-xs text-[#312E81] bg-purple-50/80 border border-purple-100 p-3.5 rounded-2xl mb-6 flex items-start gap-2">
                    <i class="bi bi-stars text-[#FACC15] text-base mt-0.5"></i>
                    <div>
                        <strong>Why Kids & Parents Love This:</strong> Specially crafted to boost creativity, language development, and problem-solving skills in young learners.
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="flex items-baseline gap-3 mb-6">
                    <span class="text-3xl font-black text-[#312E81] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                    @if($product->sale_price)
                        <span class="text-sm text-slate-400 line-through price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                        <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-2.5 py-0.5 rounded-full">Discount Applied</span>
                    @endif
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 mb-6">
                    @csrf
                    <div class="flex items-center gap-4">
                        <label class="text-xs font-bold text-slate-700">Quantity:</label>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 border border-slate-300 rounded-xl py-2 px-3 text-center text-sm font-bold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    </div>

                    <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 rounded-2xl shadow-lg hover:shadow-xl transition text-sm flex items-center justify-center gap-2">
                        <i class="bi bi-bag-fill text-[#FACC15]"></i> Add to Cart (<span class="price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>)
                    </button>
                </form>
            </div>

            <!-- 3-Point Trust Signal Row -->
            <div class="border-t border-slate-100 pt-4 grid grid-cols-3 gap-2 text-center text-xs text-slate-600 bg-purple-50/40 p-3.5 rounded-2xl">
                <div>
                    <i class="bi bi-truck text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">1-3 Days Delivery</span>
                    <span class="text-[10px] text-slate-400">Lagos & Nationwide</span>
                </div>
                <div>
                    <i class="bi bi-shield-check text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Paystack & Bank</span>
                    <span class="text-[10px] text-slate-400">100% Secured</span>
                </div>
                <div>
                    <i class="bi bi-spotify text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Spotify Audio</span>
                    <span class="text-[10px] text-slate-400">Listen Companion</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Below The Fold Details -->
    <div class="mt-12 border-t border-slate-100 pt-8">
        <h3 class="font-whimsical text-xl font-bold text-slate-900 mb-3">Product Overview & Specifications</h3>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">{{ $product->description }}</p>

        <!-- Customer Reviews & Star Ratings -->
        <div class="mt-8 bg-purple-50/50 p-6 rounded-3xl border border-purple-200/60">
            <h4 class="font-whimsical font-bold text-slate-900 mb-4 text-base flex items-center gap-2">
                <i class="bi bi-star-fill text-[#FACC15]"></i> Verified Customer Reviews
            </h4>
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-4 rounded-2xl border border-slate-200 text-xs shadow-sm">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-slate-900">{{ $review->customer_name }} <span class="text-[#7C3AED] text-[10px] font-normal ml-1"><i class="bi bi-check-circle-fill"></i> Verified Buyer</span></span>
                            <div class="text-[#FACC15] text-xs">
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
