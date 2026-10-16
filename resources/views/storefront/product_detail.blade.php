@extends('layouts.app')

@section('content')
<div class="bg-white border border-purple-200/80 rounded-3xl p-5 sm:p-8 lg:p-10 shadow-sm max-w-5xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Image Gallery Above Fold -->
        <div>
            <div class="h-72 sm:h-80 lg:h-96 bg-purple-50/50 rounded-2xl overflow-hidden mb-4 relative flex items-center justify-center border border-purple-100">
                @if($product->primaryImage)
                    <img id="mainProductImage" src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="text-center p-6">
                        <i class="bi bi-box-seam-fill text-6xl text-amber-400 mb-3"></i>
                        <span class="block text-xs font-bold text-slate-400">800BYPD Original Publication</span>
                    </div>
                @endif
                <span class="absolute top-4 left-4 bg-[#7C3AED] text-white text-xs font-bold px-3 py-1 rounded-full shadow flex items-center gap-1.5">
                    <i class="bi bi-check-lg"></i> In Stock (<span id="stockDisplay">{{ $product->stock_quantity }}</span> Available)
                </span>
            </div>

            @if($product->images->count() > 0)
                <div class="flex gap-3 overflow-x-auto pb-2">
                    @foreach($product->images as $img)
                        <img src="{{ asset('storage/' . $img->image_path) }}" onclick="document.getElementById('mainProductImage').src = this.src" class="w-16 h-16 object-cover rounded-xl border border-slate-200 cursor-pointer hover:border-[#7C3AED] transition">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details Above Fold -->
        <div class="flex flex-col justify-between">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md inline-block">
                        {{ $product->category->name ?? 'Children\'s Store' }}
                    </span>
                    @if($product->variants->count() > 0)
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">
                            Multiple Variations Available
                        </span>
                    @endif
                </div>

                <h1 class="font-whimsical text-2xl lg:text-3xl font-bold text-[#312E81] mb-2 leading-tight">{{ $product->name }}</h1>
                <p class="text-xs text-slate-500 mb-4 font-mono">
                    SKU: <span id="skuDisplay" class="font-bold text-[#7C3AED]">{{ $product->variants->first()?->sku ?? $product->sku }}</span> | Brand: <strong>800BYPD</strong>
                </p>

                <!-- Value Proposition Banner -->
                <div class="text-xs text-[#312E81] bg-purple-50/80 border border-purple-100 p-3.5 rounded-2xl mb-6 flex items-start gap-2">
                    <i class="bi bi-stars text-[#FACC15] text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong>Why Kids & Parents Love This:</strong> Crafted to stimulate imagination, problem-solving, and vocabulary development in young minds.
                    </div>
                </div>

                <!-- Pricing Display -->
                <div class="flex items-baseline gap-3 mb-6">
                    <span id="priceDisplay" class="text-3xl font-black text-[#312E81] price-convertible" data-price-ngn="{{ $product->variants->first()?->price ?? ($product->sale_price ?? $product->price) }}">
                        ₦{{ number_format($product->variants->first()?->price ?? ($product->sale_price ?? $product->price), 2) }}
                    </span>
                    @if($product->sale_price && $product->variants->isEmpty())
                        <span class="text-sm text-slate-400 line-through price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                        <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-2.5 py-0.5 rounded-full">Special Offer</span>
                    @endif
                </div>

                <!-- Add to Cart Form with Variation Selector -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-5 mb-6">
                    @csrf

                    <!-- 1. Variation Selector (Flashcards Size / Puzzle Difficulty) -->
                    @if($product->variants->count() > 0)
                        <div class="p-4 rounded-2xl bg-purple-50/50 border border-purple-200/80 space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="text-xs font-bold text-[#312E81] flex items-center gap-1.5">
                                    <i class="bi bi-sliders2-vertical text-[#7C3AED]"></i>
                                    @if(str_contains(strtolower($product->category->name ?? ''), 'puzzle'))
                                        Select Difficulty / Pieces:
                                    @elseif(str_contains(strtolower($product->category->name ?? ''), 'flashcard'))
                                        Select Card Size:
                                    @else
                                        Select Option / Variation:
                                    @endif
                                </label>
                                <span class="text-[10px] text-slate-500 font-semibold">Choose your variation</span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                @foreach($product->variants as $index => $variant)
                                    <label class="variant-pill-label relative flex items-center justify-between p-3 rounded-xl border-2 cursor-pointer transition {{ $index === 0 ? 'border-[#7C3AED] bg-white ring-2 ring-[#7C3AED]/30 shadow-sm' : 'border-purple-200/80 bg-white/60 hover:border-purple-400' }}">
                                        <input 
                                            type="radio" 
                                            name="variant_id" 
                                            value="{{ $variant->id }}" 
                                            {{ $index === 0 ? 'checked' : '' }} 
                                            data-price="{{ $variant->price }}"
                                            data-sku="{{ $variant->sku }}"
                                            data-stock="{{ $variant->stock }}"
                                            data-name="{{ $variant->name }}"
                                            onchange="handleVariantSelection(this)" 
                                            class="sr-only"
                                        >
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-full border-2 border-slate-300 flex items-center justify-center variant-indicator">
                                                <span class="w-2 h-2 rounded-full bg-[#7C3AED] {{ $index === 0 ? '' : 'hidden' }}"></span>
                                            </span>
                                            <div>
                                                <span class="font-extrabold text-xs text-slate-900 block leading-tight">{{ $variant->name }}</span>
                                                <span class="text-[10px] text-slate-400 font-mono">{{ $variant->sku }}</span>
                                            </div>
                                        </div>
                                        <span class="text-xs font-extrabold text-[#7C3AED]">₦{{ number_format($variant->price, 2) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 2. Quantity & Add to Cart -->
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <label class="text-xs font-bold text-slate-700">Quantity:</label>
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" class="w-20 border border-slate-300 rounded-xl py-2.5 px-3 text-center text-sm font-bold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none bg-slate-50">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 rounded-2xl shadow-lg hover:shadow-xl transition text-sm flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bi bi-box-seam-fill text-[#FACC15]"></i>
                        <span>Add to My Box</span>
                    </button>
                </form>
            </div>

            <!-- Trust Signals -->
            <div class="border-t border-slate-100 pt-4 grid grid-cols-3 gap-2 text-center text-xs text-slate-600 bg-purple-50/40 p-3.5 rounded-2xl">
                <div>
                    <i class="bi bi-truck text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">1-3 Days Delivery</span>
                    <span class="text-[10px] text-slate-400">Lagos & Nationwide</span>
                </div>
                <div>
                    <i class="bi bi-shield-check text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Secure Payment</span>
                    <span class="text-[10px] text-slate-400">Paystack & Bank Transfer</span>
                </div>
                <div>
                    <i class="bi bi-box2-heart text-[#7C3AED] text-base mb-1 block"></i>
                    <span class="font-bold block text-slate-800">Fills Your Box</span>
                    <span class="text-[10px] text-slate-400">Counts Toward Minimum</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Below The Fold Product Description & Specifications -->
    <div class="mt-12 border-t border-slate-100 pt-8">
        <h3 class="font-whimsical text-xl font-bold text-slate-900 mb-3">Product Overview & Details</h3>
        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-6">{{ $product->description }}</p>

        @if($product->variants->count() > 0)
            <div class="bg-purple-50/60 p-5 rounded-2xl border border-purple-100 mb-6 space-y-2">
                <h4 class="font-whimsical font-bold text-sm text-[#312E81] flex items-center gap-1.5">
                    <i class="bi bi-info-circle-fill text-[#7C3AED]"></i> About Available Variations
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs text-slate-600">
                    @foreach($product->variants as $variant)
                        <div class="bg-white p-3 rounded-xl border border-purple-200/60">
                            <span class="font-extrabold text-[#312E81] block mb-0.5">{{ $variant->name }}</span>
                            <span class="text-slate-500 text-[11px]">
                                @if(!empty($variant->attributes['description']))
                                    {{ $variant->attributes['description'] }}
                                @elseif(!empty($variant->attributes['pieces']))
                                    Contains {{ $variant->attributes['pieces'] }} large, durable puzzle pieces.
                                @elseif(!empty($variant->attributes['size']))
                                    Format: {{ $variant->attributes['size'] }} cards.
                                @else
                                    Price: ₦{{ number_format($variant->price, 2) }}
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Customer Reviews -->
        <div class="mt-8 bg-purple-50/50 p-6 rounded-3xl border border-purple-200/60">
            <h4 class="font-whimsical font-bold text-slate-900 mb-4 text-base flex items-center gap-2">
                <i class="bi bi-star-fill text-[#FACC15]"></i> Verified Customer Reviews
            </h4>
            
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-4 rounded-2xl border border-purple-100 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-bold text-slate-800 text-xs">{{ $review->customer_name }}</span>
                            <div class="text-[#FACC15] text-xs">
                                @for($i = 0; $i < $review->rating; $i++)
                                    <i class="bi bi-star-fill"></i>
                                @endfor
                            </div>
                        </div>
                        <p class="text-xs text-slate-600">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic">No reviews yet for this item. Be the first to order and review!</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
function handleVariantSelection(input) {
    // 1. Update active styling on pills
    document.querySelectorAll('.variant-pill-label').forEach(label => {
        label.classList.remove('border-[#7C3AED]', 'ring-2', 'ring-[#7C3AED]/30', 'shadow-sm');
        label.classList.add('border-purple-200/80', 'bg-white/60');
        const dot = label.querySelector('.variant-indicator span');
        if (dot) dot.classList.add('hidden');
    });

    const activeLabel = input.closest('.variant-pill-label');
    activeLabel.classList.remove('border-purple-200/80', 'bg-white/60');
    activeLabel.classList.add('border-[#7C3AED]', 'bg-white', 'ring-2', 'ring-[#7C3AED]/30', 'shadow-sm');
    
    const activeDot = activeLabel.querySelector('.variant-indicator span');
    if (activeDot) activeDot.classList.remove('hidden');

    // 2. Update price, SKU, stock display
    const price = parseFloat(input.getAttribute('data-price')) || 0;
    const sku = input.getAttribute('data-sku') || '';
    const stock = input.getAttribute('data-stock') || 'In Stock';

    const priceDisplay = document.getElementById('priceDisplay');
    priceDisplay.textContent = '₦' + price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    priceDisplay.setAttribute('data-price-ngn', price);

    document.getElementById('skuDisplay').textContent = sku;
    document.getElementById('stockDisplay').textContent = stock;
}
</script>
@endsection
