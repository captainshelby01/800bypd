@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mb-4">
    <!-- 3.1 Breadcrumbs (Home → Category → Product Name) -->
    <nav class="text-xs text-slate-500 font-bold flex items-center flex-wrap gap-2 px-1">
        <a href="{{ route('home') }}" class="hover:text-[#7C3AED] transition flex items-center gap-1 text-slate-600">
            <i class="bi bi-house-door-fill text-slate-400"></i>
            <span>Home</span>
        </a>
        <i class="bi bi-chevron-right text-[10px] text-slate-300"></i>
        @if($product->category)
            <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-[#7C3AED] transition text-slate-600">
                {{ $product->category->name }}
            </a>
            <i class="bi bi-chevron-right text-[10px] text-slate-300"></i>
        @else
            <a href="{{ route('catalog.index') }}" class="hover:text-[#7C3AED] transition text-slate-600">
                Products
            </a>
            <i class="bi bi-chevron-right text-[10px] text-slate-300"></i>
        @endif
        <span class="text-[#312E81] font-extrabold truncate max-w-[200px] sm:max-w-md">{{ $product->name }}</span>
    </nav>
</div>

<div class="bg-white border border-purple-200/80 rounded-3xl p-5 sm:p-8 lg:p-10 shadow-sm max-w-5xl mx-auto">
    
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-2xl text-xs font-bold flex items-center gap-2 shadow-xs">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
        
        <!-- Image Gallery Above Fold -->
        <div>
            <div class="h-72 sm:h-80 lg:h-96 bg-gradient-to-b from-purple-50/70 via-indigo-50/20 to-white rounded-3xl overflow-hidden mb-4 relative flex items-center justify-center p-4 sm:p-6 border border-purple-100/80">
                <img id="mainProductImage" 
                     src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="max-h-full max-w-full object-contain drop-shadow-lg"
                     onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
            </div>

            @if($product->images->count() > 0)
                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-none">
                    @foreach($product->images as $img)
                        <img src="{{ $img->url }}" 
                             onclick="document.getElementById('mainProductImage').src = this.src" 
                             class="w-16 h-16 object-contain p-1 bg-purple-50/40 rounded-xl border-2 border-slate-200 cursor-pointer hover:border-[#7C3AED] transition"
                             onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details Above Fold -->
        <div class="flex flex-col justify-between">
            <div>
                <!-- 2.4 Clickable Category Badge & 2.2 Stock Display (Never covering image text) -->
                <div class="flex items-center flex-wrap gap-2 mb-3">
                    @if($product->category)
                        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-xs font-extrabold uppercase tracking-wider text-[#7C3AED] hover:text-[#312E81] bg-purple-100 hover:bg-purple-200 px-3.5 py-1 rounded-full inline-flex items-center gap-1.5 transition shadow-2xs">
                            <i class="bi bi-tag-fill text-[#FACC15]"></i>
                            <span>{{ $product->category->name }}</span>
                        </a>
                    @else
                        <span class="text-xs font-bold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md inline-block">
                            Children's Store
                        </span>
                    @endif

                    <!-- Stock Status Badge -->
                    @if($product->stock_quantity > 0)
                        <span id="stockBadge" class="bg-emerald-100 text-emerald-800 border border-emerald-300 text-xs font-extrabold px-3 py-1 rounded-full flex items-center gap-1.5 shadow-2xs">
                            <i class="bi bi-check-circle-fill text-emerald-600"></i>
                            <span id="stockDisplay">In Stock</span>
                        </span>
                    @else
                        <span id="stockBadge" class="bg-rose-100 text-rose-800 border border-rose-300 text-xs font-extrabold px-3 py-1 rounded-full flex items-center gap-1.5 shadow-2xs">
                            <i class="bi bi-x-circle-fill text-rose-600"></i>
                            <span id="stockDisplay">Out of Stock</span>
                        </span>
                    @endif

                    @if($product->variants->count() > 0)
                        <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-full">
                            Multiple Variations
                        </span>
                    @endif
                </div>

                <h1 class="font-whimsical text-2xl lg:text-3xl font-bold text-[#312E81] mb-4 leading-tight">{{ $product->name }}</h1>

                <!-- Value Proposition Banner -->
                <div class="text-xs text-[#312E81] bg-purple-50/80 border border-purple-100 p-3.5 rounded-2xl mb-3 flex items-start gap-2">
                    <i class="bi bi-stars text-[#FACC15] text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <strong>Why Kids & Parents Love This:</strong> Crafted to stimulate imagination, problem-solving, and faith-filled learning in young minds.
                    </div>
                </div>

                <!-- Rating Preview Badge (Directly below "Why Kids & Parents Love This") -->
                <div class="flex items-center gap-2 mb-6">
                    <div class="flex text-[#FACC15] text-xs">
                        @php
                            $avgRating = round($product->reviews->avg('rating') ?: 5);
                        @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= $avgRating ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <a href="#reviews-section" class="text-xs text-slate-500 hover:text-[#7C3AED] font-semibold underline">
                        {{ $product->reviews->count() }} {{ Str::plural('Review', $product->reviews->count()) }}
                    </a>
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
                <form id="productAddToCartForm" action="{{ route('cart.add', $product->id) }}" method="POST" onsubmit="handleProductDetailAddToCart(event)" class="space-y-5 mb-6">
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
                                    <label class="variant-pill-label relative flex items-center justify-between p-3 rounded-xl border-2 cursor-pointer transition h-full min-h-[52px] {{ $index === 0 ? 'border-[#7C3AED] bg-white ring-2 ring-[#7C3AED]/30 shadow-sm' : 'border-purple-200/80 bg-white/60 hover:border-purple-400' }}">
                                        <input 
                                            type="radio" 
                                            name="variant_id" 
                                            value="{{ $variant->id }}" 
                                            {{ $index === 0 ? 'checked' : '' }} 
                                            data-price="{{ $variant->price }}"
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
                                                <!-- 2.3 SKU removed from variant pill -->
                                            </div>
                                        </div>
                                        <span class="text-xs font-extrabold text-[#7C3AED]">₦{{ number_format($variant->price, 2) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 3.5 Consistent Quantity Selector (Preferred Popup Design) -->
                    <div class="flex items-center gap-3">
                        <label class="text-xs font-bold text-slate-700">Quantity:</label>
                        <div class="flex items-center bg-purple-50 p-1 rounded-full border border-purple-200 text-xs font-bold">
                            <button type="button" onclick="changeProductDetailQty(-1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-purple-100 transition flex items-center justify-center text-sm shadow-sm">-</button>
                            <span id="productDetailQtyDisplay" class="w-8 text-center text-slate-900 text-sm font-extrabold">1</span>
                            <button type="button" onclick="changeProductDetailQty(1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-purple-100 transition flex items-center justify-center text-sm shadow-sm">+</button>
                            <input type="hidden" name="quantity" id="productDetailQtyInput" value="1">
                        </div>
                    </div>

                    <!-- 3.3 Add to Box Button (Stays active & ready for continuous additions) -->
                    <button type="submit" id="productDetailAddBtn" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 rounded-2xl shadow-lg hover:shadow-xl transition text-sm flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <i class="bi bi-box-seam-fill text-[#FACC15]"></i>
                        <span id="productDetailBtnText">Add to My Box</span>
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

        <!-- Age Suitability, Skills Supported & Materials (Item 5) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-purple-50/70 border border-purple-100 p-4 rounded-2xl">
                <div class="flex items-center gap-2 text-xs font-black text-[#312E81] mb-1">
                    <i class="bi bi-person-heart text-[#7C3AED] text-sm"></i> Recommended Age & Level
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    @if(str_contains(strtolower($product->category->name ?? ''), 'puzzle'))
                        <strong>Ages 3–8 yrs</strong> (Easy: 3–5 yrs, Intermediate: 5–8 yrs). Promotes hand-eye coordination, spatial awareness, and problem solving.
                    @elseif(str_contains(strtolower($product->category->name ?? ''), 'flashcard'))
                        <strong>Ages 2–6 yrs</strong> (Pocket & Big). Daily biblical identity affirmations and early vocabulary recognition.
                    @elseif(str_contains(strtolower($product->category->name ?? ''), 'colouring') || str_contains(strtolower($product->category->name ?? ''), 'coloring'))
                        <strong>Ages 3–8 yrs</strong>. Heavyweight, premium paper perfect for crayons, coloured pencils, and light felt-tip markers.
                    @else
                        <strong>Ages 3–9 yrs</strong>. Engaging character-building stories designed for read-aloud family devotionals.
                    @endif
                </p>
            </div>

            <div class="bg-indigo-50/70 border border-indigo-100 p-4 rounded-2xl">
                <div class="flex items-center gap-2 text-xs font-black text-[#312E81] mb-1">
                    <i class="bi bi-award text-indigo-600 text-sm"></i> Faith & Skills Supported
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    Scripture memorization, confidence in God's love, patience, fine motor dexterity, and independent active play.
                </p>
            </div>

            <div class="bg-amber-50/70 border border-amber-100 p-4 rounded-2xl">
                <div class="flex items-center gap-2 text-xs font-black text-[#312E81] mb-1">
                    <i class="bi bi-shield-check text-amber-600 text-sm"></i> Materials & Safety Guidance
                </div>
                <p class="text-xs text-slate-600 leading-relaxed">
                    100% non-toxic vegetable inks, thick rounded-corner boards, child-safe construction. Adult supervision recommended for small puzzle pieces under 3 yrs.
                </p>
            </div>
        </div>

        @if($product->variants->count() > 0)
            <div class="bg-purple-50/60 p-5 rounded-2xl border border-purple-100 mb-8 space-y-2">
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

        <!-- 2.5 PRODUCT REVIEWS, RATINGS & COMMENTS SECTION -->
        <div id="reviews-section" class="mt-10 bg-purple-50/50 p-6 sm:p-8 rounded-3xl border border-purple-200/80">
            
            <!-- Ratings Summary Header -->
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 border-b border-purple-200/70 pb-6 mb-6">
                <div>
                    <h3 class="font-whimsical font-bold text-[#312E81] text-2xl sm:text-3xl flex items-center gap-2">
                        <i class="bi bi-star-fill text-[#FACC15]"></i> Customer Ratings & Reviews
                    </h3>
                    <p class="text-xs text-slate-500 mt-1">Authentic experiences and comments from verified families and parents.</p>
                </div>

                <button type="button" onclick="toggleReviewForm()" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold text-xs px-5 py-3 rounded-2xl shadow-md transition flex items-center gap-2 flex-shrink-0">
                    <i class="bi bi-pencil-square"></i>
                    <span>Write a Review</span>
                </button>
            </div>

            <!-- Ratings Breakdown & Score Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center bg-white p-6 rounded-2xl border border-purple-100 shadow-2xs mb-8">
                <!-- Average Rating Score -->
                <div class="text-center md:border-r md:border-purple-100 md:pr-6">
                    @php
                        $ratingCount = $product->reviews->count();
                        $avgScore = $ratingCount > 0 ? round($product->reviews->avg('rating'), 1) : 5.0;
                    @endphp
                    <div class="font-whimsical text-5xl font-black text-[#312E81] leading-none mb-1">{{ number_format($avgScore, 1) }}</div>
                    <div class="flex justify-center text-[#FACC15] text-base mb-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi {{ $i <= round($avgScore) ? 'bi-star-fill' : 'bi-star' }}"></i>
                        @endfor
                    </div>
                    <span class="text-xs text-slate-500 font-semibold">Based on {{ $ratingCount }} {{ Str::plural('rating', $ratingCount) }}</span>
                </div>

                <!-- Star Rating Distribution Bars -->
                <div class="md:col-span-2 space-y-2 text-xs">
                    @for($stars = 5; $stars >= 1; $stars--)
                        @php
                            $starsCount = $product->reviews->where('rating', $stars)->count();
                            $percent = $ratingCount > 0 ? round(($starsCount / $ratingCount) * 100) : ($stars === 5 ? 100 : 0);
                        @endphp
                        <div class="flex items-center gap-3">
                            <span class="w-12 font-bold text-slate-700 flex items-center gap-1">
                                {{ $stars }} <i class="bi bi-star-fill text-[#FACC15] text-[10px]"></i>
                            </span>
                            <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                <div class="bg-[#FACC15] h-full rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="w-8 text-right font-medium text-slate-400 text-[11px]">{{ $starsCount }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Expandable Review Form -->
            <div id="reviewFormContainer" class="hidden mb-8 bg-white p-6 sm:p-7 rounded-2xl border-2 border-purple-300 shadow-md">
                <div class="flex items-center justify-between mb-4 border-b border-purple-100 pb-3">
                    <h4 class="font-whimsical font-bold text-[#312E81] text-lg flex items-center gap-2">
                        <i class="bi bi-chat-left-heart-fill text-[#7C3AED]"></i> Share Your Experience
                    </h4>
                    <button type="button" onclick="toggleReviewForm()" class="text-slate-400 hover:text-slate-600 text-sm">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <form action="{{ route('products.reviews.store', $product->id) }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Your Rating *</label>
                        <div class="flex items-center gap-2" id="starRatingSelector">
                            @for($i = 1; $i <= 5; $i++)
                                <button type="button" onclick="setFormRating({{ $i }})" class="star-rating-btn text-2xl text-slate-300 hover:text-[#FACC15] transition" data-rating="{{ $i }}">
                                    <i class="bi bi-star-fill"></i>
                                </button>
                            @endfor
                            <input type="hidden" name="rating" id="ratingInput" value="5" required>
                            <span id="ratingLabel" class="text-xs font-bold text-[#7C3AED] ml-2">5 Stars (Excellent)</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Your Name *</label>
                        <input type="text" name="customer_name" required value="{{ auth()->user()?->name ?? old('customer_name') }}" placeholder="e.g. Mrs. Folake (Lekki)" class="w-full border border-slate-300 px-3.5 py-2.5 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Customer Review & Comments *</label>
                        <textarea name="comment" rows="4" required placeholder="What did your children think of this product? How was the build quality, learning value, and packaging?" class="w-full border border-slate-300 p-3.5 rounded-xl text-xs font-medium focus:ring-2 focus:ring-[#7C3AED] focus:outline-none leading-relaxed">{{ old('comment') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" onclick="toggleReviewForm()" class="px-4 py-2 text-xs font-bold text-slate-600 hover:text-slate-800">
                            Cancel
                        </button>
                        <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold text-xs px-6 py-2.5 rounded-xl shadow transition">
                            Submit Review
                        </button>
                    </div>
                </form>
            </div>

            <!-- Customer Comments Feed -->
            <div class="space-y-4">
                @forelse($product->reviews as $review)
                    <div class="bg-white p-5 rounded-2xl border border-purple-100 shadow-2xs hover:border-purple-200 transition">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-purple-100 text-[#7C3AED] font-bold text-xs flex items-center justify-center flex-shrink-0 shadow-inner">
                                    {{ strtoupper(substr($review->customer_name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <span class="font-extrabold text-slate-900 text-xs">{{ $review->customer_name }}</span>
                                        <span class="bg-emerald-100 text-emerald-800 text-[9px] font-extrabold px-1.5 py-0.2 rounded-full uppercase flex items-center gap-0.5">
                                            <i class="bi bi-patch-check-fill text-emerald-600"></i> Verified
                                        </span>
                                    </div>
                                    <span class="text-[10px] text-slate-400 font-medium">{{ $review->created_at ? $review->created_at->diffForHumans() : 'Recent Customer' }}</span>
                                </div>
                            </div>
                            
                            <!-- Rating Stars -->
                            <div class="flex text-[#FACC15] text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                @endfor
                            </div>
                        </div>

                        <!-- Customer Comment Body -->
                        <p class="text-xs text-slate-600 leading-relaxed pl-1 sm:pl-12">{{ $review->comment }}</p>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-2xl border border-purple-100 p-6">
                        <i class="bi bi-chat-heart text-4xl text-purple-300 mb-2 block"></i>
                        <h5 class="font-whimsical font-bold text-slate-800 text-base mb-1">No reviews yet for this product</h5>
                        <p class="text-xs text-slate-500 max-w-sm mx-auto mb-4">Be the first parent to share feedback and let other families know about this item!</p>
                        <button type="button" onclick="toggleReviewForm()" class="inline-flex items-center gap-1.5 bg-[#312E81] text-[#FACC15] text-xs font-bold px-4 py-2 rounded-xl shadow">
                            <i class="bi bi-pencil-square"></i> Leave the First Review
                        </button>
                    </div>
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

    // 2. Update price and stock display (2.2 Only "In Stock" / "Out of Stock", no count)
    const price = parseFloat(input.getAttribute('data-price')) || 0;
    const stock = parseInt(input.getAttribute('data-stock'), 10);

    const priceDisplay = document.getElementById('priceDisplay');
    priceDisplay.textContent = '₦' + price.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    priceDisplay.setAttribute('data-price-ngn', price);

    const stockDisplay = document.getElementById('stockDisplay');
    const stockBadge = document.getElementById('stockBadge');
    if (stockDisplay && stockBadge) {
        if (!isNaN(stock) && stock <= 0) {
            stockDisplay.textContent = 'Out of Stock';
            stockBadge.className = 'absolute top-4 left-4 bg-rose-600 text-white text-xs font-bold px-3.5 py-1.5 rounded-full shadow flex items-center gap-1.5';
            const icon = stockBadge.querySelector('i');
            if (icon) icon.className = 'bi bi-x-circle-fill';
        } else {
            stockDisplay.textContent = 'In Stock';
            stockBadge.className = 'absolute top-4 left-4 bg-emerald-600 text-white text-xs font-bold px-3.5 py-1.5 rounded-full shadow flex items-center gap-1.5';
            const icon = stockBadge.querySelector('i');
            if (icon) icon.className = 'bi bi-check-circle-fill text-[#FACC15]';
        }
    }
}

function toggleReviewForm() {
    const form = document.getElementById('reviewFormContainer');
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

function setFormRating(rating) {
    document.getElementById('ratingInput').value = rating;
    const labels = {
        1: '1 Star (Needs Improvement)',
        2: '2 Stars (Fair)',
        3: '3 Stars (Good)',
        4: '4 Stars (Very Good)',
        5: '5 Stars (Excellent)'
    };
    document.getElementById('ratingLabel').textContent = labels[rating] || (rating + ' Stars');
    
    document.querySelectorAll('.star-rating-btn').forEach(btn => {
        const r = parseInt(btn.getAttribute('data-rating'), 10);
        if (r <= rating) {
            btn.classList.remove('text-slate-300');
            btn.classList.add('text-[#FACC15]');
        } else {
            btn.classList.remove('text-[#FACC15]');
            btn.classList.add('text-slate-300');
        }
    });
}

// 3.5 Consistent Quantity Selector Logic
let currentDetailQty = 1;
const maxDetailStock = {{ max(1, $product->stock_quantity) }};

function changeProductDetailQty(delta) {
    const newQty = currentDetailQty + delta;
    if (newQty >= 1 && newQty <= maxDetailStock) {
        currentDetailQty = newQty;
        document.getElementById('productDetailQtyDisplay').textContent = newQty;
        document.getElementById('productDetailQtyInput').value = newQty;
    }
}

// 3.3 Active Product Add-to-Box Handler (Stays active for continuous additions)
function handleProductDetailAddToCart(e) {
    e.preventDefault();
    const btn = document.getElementById('productDetailAddBtn');
    const btnText = document.getElementById('productDetailBtnText');
    const originalText = btnText.textContent;
    btn.disabled = true;
    btnText.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btnText.innerHTML = '<i class="bi bi-check2-circle text-[#FACC15] mr-1"></i> Added to Box!';
        setTimeout(() => {
            btnText.textContent = originalText;
        }, 1500);

        if (data.success) {
            if (window.updateFloatingCartBar) {
                window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
            }
            if (window.renderCartSidebar) {
                window.renderCartSidebar(data);
            }
            showToastNotification(data.message || 'Product added to your box!');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btnText.textContent = originalText;
        console.error(err);
        form.submit();
    });
}

// Initialise star selector to 5 stars
document.addEventListener('DOMContentLoaded', () => {
    setFormRating(5);
});
</script>
@endsection
