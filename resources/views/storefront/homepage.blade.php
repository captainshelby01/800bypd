@extends('layouts.app')

@section('content')

<!-- 1. Hero Section -->
<div class="relative bg-gradient-to-br from-[#F5F3FF] via-[#FFFDF9] to-[#EDE9FE] border-2 border-purple-200/80 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 md:p-14 mb-12 sm:mb-16 overflow-hidden shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 z-10 text-center sm:text-left">
            <span class="bg-[#FACC15] text-[#312E81] font-extrabold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider mb-5 inline-flex items-center gap-1.5 shadow-sm">
                <i class="bi bi-heart-fill text-[#7C3AED]"></i> Faith-Filled Books, Scripture Puzzles & Games
            </span>
            <h1 class="font-whimsical text-3xl sm:text-5xl md:text-6xl font-bold text-[#312E81] leading-[1.1] mb-5 tracking-tight">
                Nurturing Young Hearts & Minds in Faith, Joy & Wisdom.
            </h1>
            <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-8 leading-relaxed font-medium">
                Discover scripture-inspired jigsaw puzzles, biblical affirmation flashcards, wholesome coloring books, and heartwarming Christian storybooks crafted to help children grow in God's love.
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center sm:justify-start">
                <a href="{{ route('bundles.index') }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-8 py-4 rounded-full shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-box2-heart-fill text-[#FACC15]"></i> Buy Our Bundles
                </a>
                <a href="{{ route('catalog.index') }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-7 py-4 rounded-full shadow-lg transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-grid-fill text-[#FACC15]"></i> Browse All Products
                </a>
            </div>
        </div>

        <!-- Right Hero Visual Card -->
        <div class="lg:col-span-5 flex justify-center z-10">
            <div class="relative w-full max-w-sm bg-white p-6 rounded-[2.5rem] shadow-xl border-4 border-[#FACC15] transform rotate-1 hover:rotate-0 transition duration-300">
                <div class="h-64 bg-purple-50 rounded-2xl flex flex-col items-center justify-center text-center p-6 border border-purple-100 mb-4">
                    <div class="w-20 h-20 bg-purple-100 text-[#7C3AED] rounded-full flex items-center justify-center text-4xl mb-3 shadow-inner">
                        <i class="bi bi-box-seam-fill"></i>
                    </div>
                    <h3 class="font-whimsical font-bold text-[#312E81] text-xl">Fill Your Box</h3>
                    <p class="text-xs text-slate-500 mt-1">Curate faith-building resources for home, Sunday school, or gift giving!</p>
                </div>
                <div class="flex justify-between items-center bg-purple-50 p-3.5 rounded-xl border border-purple-200 text-xs">
                    <span class="font-extrabold text-[#312E81] flex items-center gap-1.5"><i class="bi bi-truck text-[#FACC15]"></i> Fast Delivery</span>
                    <span class="font-extrabold text-[#7C3AED]">Lagos & Nationwide</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. PROMINENT SECTION: "BUY OUR BUNDLES" -->
<div id="bundles-section" class="mb-16 sm:mb-20 scroll-mt-24">
    <div class="bg-gradient-to-br from-[#312E81] via-[#3730A3] to-[#4338CA] text-white rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 md:p-14 border-4 border-[#FACC15] shadow-2xl relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 sm:mb-12 border-b border-indigo-400/30 pb-6">
            <div>
                <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5 mb-3 shadow-sm">
                    <i class="bi bi-box2-heart-fill text-[#7C3AED]"></i> Curated Combinations
                </span>
                <h2 class="font-whimsical font-bold text-3xl sm:text-5xl text-white tracking-tight">
                    Buy Our Bundles
                </h2>
                <p class="text-indigo-200 text-xs sm:text-sm mt-2 max-w-xl leading-relaxed">
                    Enjoy complete convenience with our pre-defined packages! Each bundle brings together a curated mix of scripture puzzles, faith-affirming flashcards, coloring books, and storybooks that <strong>instantly fill your box</strong> for seamless 1-click checkout.
                </p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                <div class="bg-indigo-900/60 border border-indigo-400/40 px-4 py-2.5 rounded-2xl text-xs font-bold text-indigo-100 flex items-center gap-2 flex-shrink-0">
                    <i class="bi bi-check-circle-fill text-[#FACC15] text-base"></i>
                    <span>Fulfills Minimum Order Instantly</span>
                </div>
                <a href="{{ route('bundles.index') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold text-xs px-4 py-2.5 rounded-2xl shadow transition flex items-center gap-1.5 flex-shrink-0">
                    <span>View All Bundles</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Bundles Container: Horizontal/Sideways Swipe on Mobile, 2-Column Grid on Desktop -->
        <div class="flex lg:grid lg:grid-cols-2 gap-6 sm:gap-8 overflow-x-auto lg:overflow-x-visible snap-x snap-mandatory pb-4 pt-1 px-1 -mx-2 sm:mx-0 scrollbar-none">
            @forelse($bundles as $bundle)
                <div class="min-w-[85vw] max-w-[340px] sm:min-w-[420px] sm:max-w-[460px] lg:min-w-0 lg:max-w-none w-full shrink-0 lg:shrink snap-center bg-white text-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-lg border-2 border-purple-200/80 hover:border-[#FACC15] transition duration-300 group">
                    <div>
                        <!-- Header with Badges -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm flex items-center gap-1">
                                <i class="bi bi-star-fill text-[#7C3AED]"></i> 
                                {{ str_replace(['Best Value', 'best value', 'Discount', 'discount'], ['Curated Set', 'Curated Set', 'Curated', 'Curated'], $bundle->badge ?? $bundle->total_items_count . '-Item Bundle') }}
                            </span>
                            
                            <span class="bg-purple-100 text-[#7C3AED] text-xs font-extrabold px-3 py-1 rounded-full flex items-center gap-1">
                                <i class="bi bi-box-seam-fill"></i> Fills {{ $bundle->total_items_count }} Box Slots
                            </span>
                        </div>

                        <h3 class="font-whimsical font-bold text-[#312E81] text-2xl sm:text-3xl mb-2">{{ $bundle->name }}</h3>
                        <p class="text-xs sm:text-sm text-slate-500 leading-relaxed mb-5">{{ $bundle->description }}</p>

                        <!-- Products Included Checklist -->
                        <div class="bg-purple-50/60 rounded-2xl p-4 sm:p-5 border border-purple-100 mb-6 space-y-2.5">
                            <div class="flex items-center justify-between border-b border-purple-200/60 pb-2 mb-2">
                                <span class="text-xs font-extrabold text-[#312E81] uppercase tracking-wider flex items-center gap-1.5">
                                    <i class="bi bi-check2-circle text-[#7C3AED] text-base"></i> Products Included in This Bundle:
                                </span>
                                <span class="text-xs font-black text-[#7C3AED] bg-purple-200/60 px-2 py-0.5 rounded-md">
                                    {{ $bundle->total_items_count }} items total
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                @foreach($bundle->items as $item)
                                    <div class="flex items-start gap-2 text-slate-700 bg-white p-2.5 rounded-xl border border-purple-100/80 shadow-2xs">
                                        <i class="bi bi-check-lg text-emerald-600 font-bold text-sm mt-0.5 flex-shrink-0"></i>
                                        <div class="leading-tight">
                                            <span class="font-extrabold text-[#312E81]">{{ $item->quantity }}x</span>
                                            <span class="font-semibold text-slate-800">{{ $item->display_name }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Pricing Display (Pure price, no discounts or strikethrough savings) -->
                        <div class="flex items-baseline gap-2 mb-6">
                            <span class="text-3xl sm:text-4xl font-whimsical font-bold text-[#312E81] price-convertible" data-price-ngn="{{ $bundle->price }}">
                                {{ $bundle->formatted_price }}
                            </span>
                        </div>
                    </div>

                    <!-- Single-Click Purchase Button (No 'Fill Your Box') -->
                    <form action="{{ route('cart.addBundle', $bundle->id) }}" method="POST" onsubmit="handleHomepageAddBundle(event)">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs sm:text-sm uppercase tracking-wider">
                            <i class="bi bi-bag-plus-fill text-[#FACC15] text-base"></i>
                            <span>Add Bundle to Cart</span>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-indigo-200 bg-indigo-900/40 rounded-3xl border border-indigo-400/30">
                    <i class="bi bi-box2-heart text-5xl text-[#FACC15] mb-3 block"></i>
                    <p class="font-bold text-base text-white">Bundles are being configured.</p>
                    <p class="text-xs text-indigo-200 mt-1">Check back shortly or browse individual products below.</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Swipe Indicator Hint -->
        <div class="flex lg:hidden items-center justify-center gap-2 mt-4 text-indigo-200 text-xs font-semibold">
            <i class="bi bi-arrow-left-right text-[#FACC15]"></i>
            <span>Swipe sideways to explore all bundles</span>
        </div>
    </div>
</div>

<!-- 3. THE FOUR MAIN PRODUCT CATEGORIES -->
<div class="mb-14 sm:mb-16">
    <div class="text-center max-w-2xl mx-auto mb-8">
        <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3.5 py-1 rounded-full border border-purple-200">Faith & Learning Categories</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81] mt-2">Explore Our Product Range</h2>
        <p class="text-xs text-slate-500 mt-1">Four faith-focused collections designed for hands-on discovery, family devotion, and bedtime learning</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- 1. Jigsaw Puzzles Card -->
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-amber-400 text-[#312E81] rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-puzzle-fill"></i>
                </div>
                <div class="flex flex-wrap gap-1 mb-2">
                    <span class="text-[9px] font-extrabold uppercase text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">Easy (6 pcs)</span>
                    <span class="text-[9px] font-extrabold uppercase text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">Intermediate (12 pcs)</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Jigsaw Puzzles</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Vibrant, scripture-inspired puzzles designed to boost cognitive skills while hiding God's Word in young hearts.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Puzzles <i class="bi bi-chevron-right text-[10px]"></i>
            </span>
        </a>

        <!-- 2. Coloring Books Card -->
        <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-pink-500 text-white rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-palette-fill"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-pink-700 bg-pink-50 px-2.5 py-0.5 rounded-md mb-2 inline-block">Faith & Creativity</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Coloring Books</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Inspiring, bleed-resistant doodle sheets celebrating God’s love and joyful creative worship.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Coloring <i class="bi bi-chevron-right text-[10px]"></i>
            </span>
        </a>

        <!-- 3. Flashcards Card -->
        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-card-text"></i>
                </div>
                <div class="flex flex-wrap gap-1 mb-2">
                    <span class="text-[9px] font-extrabold uppercase text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">Pocket Size</span>
                    <span class="text-[9px] font-extrabold uppercase text-indigo-700 bg-indigo-50 px-2 py-0.5 rounded">Big Size</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Flashcards</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Daily biblical affirmations and vocabulary cards in Pocket and Big sizes to build identity in Christ.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Flashcards <i class="bi bi-chevron-right text-[10px]"></i>
            </span>
        </a>

        <!-- 4. Storybooks Card -->
        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-[#7C3AED] text-white rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-book-half"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-0.5 rounded-md mb-2 inline-block">Christian Parables</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Storybooks</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Illustrated bedtime stories by WrittenbyPD designed to cultivate godly character, empathy, and courage.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Storybooks <i class="bi bi-chevron-right text-[10px]"></i>
            </span>
        </a>
    </div>
</div>

<!-- 4. JIGSAW PUZZLES SHOWCASE -->
@if(count($puzzles) > 0)
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="text-[#7C3AED] hover:text-[#312E81] hover:bg-purple-100 transition inline-block font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">
                <i class="bi bi-puzzle-fill text-amber-500 mr-1"></i> Category: Jigsaw Puzzles
            </a>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Scripture & Brain-Boosting Jigsaw Puzzles</h2>
            <p class="text-xs text-slate-500">Featuring beloved Bible verses in Easy (6 pieces) and Intermediate (12 pieces)</p>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Puzzles <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($puzzles as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <a href="{{ route('catalog.show', $product->slug) }}" class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 block">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-6">
                                <i class="bi bi-puzzle-fill text-5xl text-amber-400 mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800BYPD Puzzle</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-amber-400 text-[#312E81] text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">
                            6 & 12 Pieces
                        </span>
                    </a>

                    <div class="p-5 sm:p-6">
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($product->variants as $v)
                                <span class="text-[9px] font-extrabold bg-purple-50 text-[#7C3AED] px-2 py-0.5 rounded">
                                    {{ $v->name }}
                                </span>
                            @endforeach
                        </div>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6 pt-0 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 mt-auto">
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <a href="{{ route('catalog.show', $product->slug) }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 sm:px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap">
                        <i class="bi bi-sliders text-[#FACC15]"></i> Choose Difficulty
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- 5. FLASHCARDS SHOWCASE -->
@if(count($flashcards) > 0)
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="text-[#7C3AED] hover:text-[#312E81] hover:bg-purple-100 transition inline-block font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">
                <i class="bi bi-card-text text-indigo-600 mr-1"></i> Category: Flashcards
            </a>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Biblical Affirmations & Early Learning Flashcards</h2>
            <p class="text-xs text-slate-500">Daily scripture confessions, identity in Christ & early vocabulary in Pocket & Big sizes</p>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Flashcards <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($flashcards as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <a href="{{ route('catalog.show', $product->slug) }}" class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 block">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-6">
                                <i class="bi bi-card-text text-5xl text-indigo-500 mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800BYPD Cards</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-indigo-600 text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">
                            Pocket & Big Sizes
                        </span>
                    </a>

                    <div class="p-5 sm:p-6">
                        <div class="flex flex-wrap gap-1 mb-2">
                            @foreach($product->variants as $v)
                                <span class="text-[9px] font-extrabold bg-indigo-50 text-indigo-700 px-2 py-0.5 rounded">
                                    {{ $v->name }}
                                </span>
                            @endforeach
                        </div>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6 pt-0 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 mt-auto">
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <a href="{{ route('catalog.show', $product->slug) }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 sm:px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap">
                        <i class="bi bi-aspect-ratio text-[#FACC15]"></i> Choose Size
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- 6. STORYBOOKS SHOWCASE -->
@if(count($storybooks) > 0)
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="text-[#7C3AED] hover:text-[#312E81] hover:bg-purple-100 transition inline-block font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">
                <i class="bi bi-book-half text-[#7C3AED] mr-1"></i> Category: Storybooks
            </a>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Faith-Filled Illustrated Storybooks</h2>
            <p class="text-xs text-slate-500">Inspiring Christian tales and bedtime stories written by WrittenbyPD to nurture godly character</p>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Storybooks <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($storybooks as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <a href="{{ route('catalog.show', $product->slug) }}" class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 block">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-6">
                                <i class="bi bi-book-half text-5xl text-[#FACC15] mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800BYPD Publication</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-[#FACC15] text-[#312E81] text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">Storybook</span>
                    </a>

                    <div class="p-6">
                        <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">Written by PD</span>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6 pt-0 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 mt-auto">
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <button type="button" 
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-saleprice="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock_quantity }}"
                        data-desc="{{ $product->description }}"
                        data-category="{{ $product->category->name ?? 'Storybook' }}"
                        data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                        onclick="triggerQuickAddFromBtn(this)"
                        class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 sm:px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap">
                        <i class="bi bi-box-seam text-[#FACC15]"></i>
                        <span>Add to Box</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- 7. COLORING BOOKS SHOWCASE -->
@if(count($colouring) > 0)
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="text-[#7C3AED] hover:text-[#312E81] hover:bg-purple-100 transition inline-block font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">
                <i class="bi bi-palette-fill text-pink-500 mr-1"></i> Category: Coloring Books
            </a>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Faith-Inspired & Creative Coloring Books</h2>
            <p class="text-xs text-slate-500">Inspiring, bleed-free coloring and doodle sheets celebrating God's love and creativity</p>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Coloring Books <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($colouring as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <a href="{{ route('catalog.show', $product->slug) }}" class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 block">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-6">
                                <i class="bi bi-palette-fill text-5xl text-pink-400 mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">Coloring Edition</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-pink-500 text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">Coloring</span>
                    </a>

                    <div class="p-5 sm:p-6">
                        <span class="text-[10px] font-extrabold text-pink-600 uppercase tracking-wide bg-pink-50 px-2.5 py-1 rounded-md inline-block mb-3">80+ Bleed-Free Pages</span>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-5 sm:p-6 pt-0 flex flex-wrap sm:flex-nowrap items-center justify-between gap-3 mt-auto">
                    <div>
                        <span class="text-xl sm:text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <button type="button" 
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-saleprice="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock_quantity }}"
                        data-desc="{{ $product->description }}"
                        data-category="{{ $product->category->name ?? 'Coloring Book' }}"
                        data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                        onclick="triggerQuickAddFromBtn(this)"
                        class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 sm:px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap">
                        <i class="bi bi-box-seam text-[#FACC15]"></i>
                        <span>Add to Box</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- 8. Spotify Audios Section -->
<div class="mb-16 bg-gradient-to-br from-[#312E81] to-purple-950 text-white rounded-3xl sm:rounded-[2.5rem] p-8 sm:p-12 border-4 border-[#FACC15] shadow-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-700/50 pb-4">
        <div>
            <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                <i class="bi bi-spotify text-[#7C3AED]"></i> Faith & Audio Companion
            </span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-white mt-2">Audiobooks & Faith Story Podcasts</h2>
            <p class="text-xs text-purple-200 mt-1">Bedtime scriptures, wholesome narrations & podcasts by WrittenbyPD on Spotify</p>
        </div>
        <a href="{{ route('audios.index') }}" class="text-xs font-extrabold text-[#FACC15] hover:underline flex items-center gap-1">
            Listen to More <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($audios as $audio)
            <div class="bg-white/10 backdrop-blur-md border border-purple-300/20 rounded-2xl p-5 flex flex-col sm:flex-row gap-5 items-center">
                <div class="w-20 h-20 bg-[#FACC15] text-[#312E81] rounded-2xl flex items-center justify-center text-3xl font-whimsical font-bold flex-shrink-0 shadow">
                    <i class="bi bi-spotify"></i>
                </div>
                <div class="flex-1 text-center sm:text-left">
                    <span class="text-[10px] font-bold text-[#FACC15] uppercase tracking-wide">Narrated by WrittenbyPD</span>
                    <h3 class="font-whimsical font-bold text-white text-lg mb-1">{{ $audio->name }}</h3>
                    <p class="text-xs text-purple-200 line-clamp-2 mb-3">{{ $audio->description }}</p>
                    <a href="{{ route('audios.index') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold text-xs px-4 py-2 rounded-full inline-flex items-center gap-1.5 transition">
                        <i class="bi bi-play-fill text-sm"></i> Listen Now
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-8 text-center text-purple-200">
                <p class="font-bold text-sm">Audio companion tracks available on Spotify.</p>
            </div>
        @endforelse
    </div>
</div>

<script>
function handleHomepageAddBundle(e) {
    e.preventDefault();
    const form = e.target;
    const btn = form.querySelector('button[type="submit"]');
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding Bundle...';

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="bi bi-check2-circle text-[#FACC15] mr-1"></i> Bundle Added!';
        setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
        if (data.success) {
            const badge = document.getElementById('cartCountBadge');
            if (badge) {
                badge.textContent = (data.box && typeof data.box.total_items !== 'undefined') ? data.box.total_items : data.cart_count;
            }
            if (window.updateFloatingCartBar) {
                window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
            }
            showToastNotification(data.message || 'Bundle added to your box!');
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        console.error(err);
        form.submit();
    });
}
</script>
@endsection
