@extends('layouts.app')

@section('content')

<!-- 1. HERO SECTION -->
<div class="relative bg-gradient-to-br from-[#F5F3FF] via-[#FFFDF9] to-[#EDE9FE] border-2 border-purple-200/80 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 md:p-12 mb-8 sm:mb-12 overflow-hidden shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
        
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 z-10 text-center sm:text-left">
            <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-4 py-1.5 rounded-full uppercase tracking-wider mb-4 inline-flex items-center gap-1.5 shadow-xs">
                <i class="bi bi-heart-fill text-[#7C3AED]"></i> Faith &amp; Learning for Kids
            </span>
            <h1 class="font-whimsical text-3xl sm:text-5xl md:text-6xl font-bold text-[#312E81] leading-[1.12] mb-4 tracking-tight">
                Faith-filled books and activities for growing young minds.
            </h1>
            <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-7 leading-relaxed font-medium max-w-xl">
                Scripture-inspired jigsaw puzzles, biblical affirmations, illustrated storybooks, and creative coloring books crafted for young disciples.
            </p>
            
            <div class="flex flex-col sm:flex-row flex-wrap gap-3.5 justify-center sm:justify-start mb-6">
                <a href="#bestsellers" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-7 py-3.5 rounded-full shadow-md transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-star-fill text-[#FACC15]"></i> Shop Bestsellers
                </a>
                <a href="#bundles-section" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-7 py-3.5 rounded-full shadow-md transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-box2-heart-fill text-[#FACC15]"></i> Buy Ready-Made Bundles
                </a>
                <a href="{{ route('catalog.index') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-bold text-[#7C3AED] hover:text-[#312E81] px-4 py-3.5 transition">
                    <span>Full Catalogue (14+ items)</span> <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- Quick Trust Badges in Hero -->
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-4 text-[11px] text-slate-500 font-semibold pt-2 border-t border-purple-200/60">
                <span class="flex items-center gap-1.5"><i class="bi bi-shield-check text-emerald-600 font-bold"></i> 100% Child-Safe &amp; Thick Board</span>
                <span class="flex items-center gap-1.5"><i class="bi bi-truck text-amber-500"></i> Lagos (1–2 Days) &amp; Nationwide Delivery</span>
            </div>
        </div>

        <!-- Right Hero Visual Card: Actual Product Arrangement (Requirement 3) -->
        <div class="lg:col-span-5 flex justify-center z-10">
            <div class="relative w-full max-w-md bg-white p-5 sm:p-6 rounded-[2.5rem] shadow-xl border-4 border-[#FACC15] transform rotate-1 hover:rotate-0 transition duration-300">
                <div class="flex items-center justify-between border-b border-purple-100 pb-3 mb-4">
                    <span class="text-xs font-black uppercase text-[#312E81] tracking-wider flex items-center gap-1.5">
                        <i class="bi bi-stars text-amber-500"></i> Featured Physical Products
                    </span>
                    <span class="text-[10px] bg-purple-100 text-[#7C3AED] font-extrabold px-2.5 py-0.5 rounded-full">
                        Ages 2 to 9
                    </span>
                </div>

                <!-- 2x2 Actual Products Grid Showcase -->
                <div class="grid grid-cols-2 gap-3 mb-4">
                    <!-- 1. Jigsaw Puzzle Photo -->
                    <a href="{{ route('catalog.show', 'give-thanks-psalm-107-jigsaw-puzzle') }}" class="group/p bg-amber-50/60 rounded-2xl p-2.5 border border-amber-200/80 hover:border-amber-400 transition flex flex-col items-center text-center">
                        <div class="w-full h-24 rounded-xl overflow-hidden mb-2 bg-white flex items-center justify-center shadow-2xs">
                            <img src="{{ asset('storage/products/easy_puzzle_1_cover.jpg') }}" alt="Give Thanks Jigsaw Puzzle" class="w-full h-full object-cover group-hover/p:scale-105 transition" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </div>
                        <span class="text-[11px] font-bold text-slate-900 group-hover/p:text-[#7C3AED] leading-tight line-clamp-1">Give Thanks Puzzle</span>
                        <span class="text-[9px] text-amber-800 font-extrabold">6 &amp; 12 Pieces</span>
                    </a>

                    <!-- 2. Psalm 23 Colouring Book -->
                    <a href="{{ route('catalog.show', 'psalm-23-colouring-book') }}" class="group/p bg-pink-50/60 rounded-2xl p-2.5 border border-pink-200/80 hover:border-pink-400 transition flex flex-col items-center text-center">
                        <div class="w-full h-24 rounded-xl overflow-hidden mb-2 bg-white flex items-center justify-center shadow-2xs">
                            <img src="{{ asset('storage/products/psalm_23_colouring_book_cover.jpg') }}" alt="Psalm 23 Colouring Book" class="w-full h-full object-cover group-hover/p:scale-105 transition" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </div>
                        <span class="text-[11px] font-bold text-slate-900 group-hover/p:text-[#7C3AED] leading-tight line-clamp-1">Psalm 23 Colouring</span>
                        <span class="text-[9px] text-pink-700 font-extrabold">Bleed-Free Pages</span>
                    </a>

                    <!-- 3. Affirmations Flashcards -->
                    <a href="{{ route('catalog.show', 'affirmations-flashcards') }}" class="group/p bg-indigo-50/60 rounded-2xl p-2.5 border border-indigo-200/80 hover:border-indigo-400 transition flex flex-col items-center text-center">
                        <div class="w-full h-24 rounded-xl overflow-hidden mb-2 bg-white flex items-center justify-center shadow-2xs">
                            <img src="{{ asset('storage/products/affirmations_flashcards_cover.jpg') }}" alt="Affirmations Flashcards" class="w-full h-full object-cover group-hover/p:scale-105 transition" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </div>
                        <span class="text-[11px] font-bold text-slate-900 group-hover/p:text-[#7C3AED] leading-tight line-clamp-1">Affirmations Cards</span>
                        <span class="text-[9px] text-indigo-700 font-extrabold">Pocket &amp; Big</span>
                    </a>

                    <!-- 4. Storybook -->
                    <a href="{{ route('catalog.show', 'adventures-of-the-little-explorer') }}" class="group/p bg-purple-50/60 rounded-2xl p-2.5 border border-purple-200/80 hover:border-purple-400 transition flex flex-col items-center text-center">
                        <div class="w-full h-24 rounded-xl overflow-hidden mb-2 bg-white flex items-center justify-center shadow-2xs">
                            <img src="{{ asset('storage/products/story_little_explorer.svg') }}" alt="Little Explorer Storybook" class="w-full h-full object-cover group-hover/p:scale-105 transition" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </div>
                        <span class="text-[11px] font-bold text-slate-900 group-hover/p:text-[#7C3AED] leading-tight line-clamp-1">Little Explorer Book</span>
                        <span class="text-[9px] text-purple-700 font-extrabold">Written by PD</span>
                    </a>
                </div>

                <!-- Fast Delivery Banner -->
                <div class="flex justify-between items-center bg-purple-50 p-3 rounded-2xl border border-purple-200 text-xs">
                    <span class="font-extrabold text-[#312E81] flex items-center gap-1.5"><i class="bi bi-box-seam-fill text-[#FACC15]"></i> Custom Box or Bundles</span>
                    <a href="{{ route('bundles.index') }}" class="font-extrabold text-[#7C3AED] hover:underline">View All &rarr;</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. MINIMUM ORDER & SHOPPING PROCESS GUIDE (Requirement 4) -->
<div class="mb-12 bg-white border border-purple-200/80 rounded-3xl p-5 sm:p-7 shadow-xs">
    <div class="flex items-center gap-2 mb-3">
        <span class="bg-[#312E81] text-[#FACC15] font-black text-[10px] uppercase px-3 py-1 rounded-full">How Shopping Works</span>
        <h2 class="font-whimsical font-bold text-lg sm:text-xl text-[#312E81]">Two Simple Ways to Order at 800 by PD</h2>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Option A: Build Your Box -->
        <div class="bg-purple-50/70 border border-purple-200/80 rounded-2xl p-4 flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-purple-200 text-[#7C3AED] flex items-center justify-center text-xl flex-shrink-0 mt-0.5">
                <i class="bi bi-box-seam"></i>
            </div>
            <div>
                <h3 class="font-whimsical font-bold text-slate-900 text-base mb-1">Option 1: Build Your Own Custom Box</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-2">
                    Select any <strong>3 or more items</strong> across puzzles, flashcards, storybooks, and colouring books to fulfill the minimum checkout requirement. Mix and match freely!
                </p>
                <a href="{{ route('catalog.index') }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline inline-flex items-center gap-1">
                    Start Custom Box <i class="bi bi-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Option B: Ready-Made Bundles -->
        <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 flex items-start gap-3.5">
            <div class="w-10 h-10 rounded-xl bg-amber-200 text-amber-900 flex items-center justify-center text-xl flex-shrink-0 mt-0.5">
                <i class="bi bi-box2-heart-fill"></i>
            </div>
            <div>
                <h3 class="font-whimsical font-bold text-slate-900 text-base mb-1">Option 2: Pick a Ready-Made Bundle</h3>
                <p class="text-xs text-slate-600 leading-relaxed mb-2">
                    Want an all-in-one package without counting items? Grab our <strong>Starter (5 items)</strong> or <strong>Explorer (10 items)</strong> bundle for instant 1-click checkout.
                </p>
                <a href="#bundles-section" class="text-xs font-extrabold text-amber-900 hover:underline inline-flex items-center gap-1">
                    See Ready-Made Bundles <i class="bi bi-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 3. SHOP BY CATEGORY & AGE FILTER (Requirement 5) -->
<div class="mb-14 sm:mb-16">
    <div class="text-center max-w-2xl mx-auto mb-6">
        <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3.5 py-1 rounded-full border border-purple-200">Shop by Category &amp; Age</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81] mt-2">Explore by Category</h2>
        <p class="text-xs text-slate-500 mt-1">Thoughtfully crafted resources to help children know God and grow in wisdom</p>
    </div>

    <!-- Quick "Shop by Age" Pills (Requirement 5) -->
    <div class="flex items-center justify-center gap-2 mb-8 flex-wrap">
        <span class="text-xs font-bold text-slate-500 mr-1 flex items-center gap-1"><i class="bi bi-funnel text-[#7C3AED]"></i> Filter by Age:</span>
        <a href="{{ route('catalog.index') }}" class="px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-[#312E81] text-[#FACC15] shadow-xs">All Ages</a>
        <a href="{{ route('catalog.index', ['age' => '2-4']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-white border border-purple-200 text-slate-700 hover:bg-purple-50 transition">Toddlers (Ages 2–4)</a>
        <a href="{{ route('catalog.index', ['age' => '4-7']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-white border border-purple-200 text-slate-700 hover:bg-purple-50 transition">Early Learners (Ages 4–7)</a>
        <a href="{{ route('catalog.index', ['age' => '7+']) }}" class="px-3.5 py-1.5 rounded-full text-xs font-bold bg-white border border-purple-200 text-slate-700 hover:bg-purple-50 transition">Growing Readers (Ages 7+)</a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- 1. Jigsaw Puzzles Card -->
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-5 sm:p-6 rounded-3xl shadow-xs hover:shadow-lg transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-amber-400 text-[#312E81] rounded-2xl flex items-center justify-center text-xl mb-3 group-hover:scale-105 transition shadow-xs">
                    <i class="bi bi-puzzle-fill"></i>
                </div>
                <div class="flex items-center gap-1 mb-2">
                    <span class="text-[9px] font-black uppercase text-amber-900 bg-amber-100 px-2 py-0.5 rounded">Ages 2–7 yrs</span>
                    <span class="text-[9px] font-extrabold text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">6 &amp; 12 Pcs</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Jigsaw Puzzles</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Vibrant scripture-inspired puzzles that teach God's Word while developing fine motor and problem-solving skills.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Puzzles &rarr;
            </span>
        </a>

        <!-- 2. Coloring Books Card -->
        <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-5 sm:p-6 rounded-3xl shadow-xs hover:shadow-lg transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-pink-500 text-white rounded-2xl flex items-center justify-center text-xl mb-3 group-hover:scale-105 transition shadow-xs">
                    <i class="bi bi-palette-fill"></i>
                </div>
                <div class="flex items-center gap-1 mb-2">
                    <span class="text-[9px] font-black uppercase text-pink-900 bg-pink-100 px-2 py-0.5 rounded">Ages 3–8 yrs</span>
                    <span class="text-[9px] font-extrabold text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">Bleed-Free</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Coloring Books</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Inspiring, bleed-resistant doodle and colouring sheets celebrating God's love, friendship, and joyful worship.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Coloring &rarr;
            </span>
        </a>

        <!-- 3. Flashcards Card -->
        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-5 sm:p-6 rounded-3xl shadow-xs hover:shadow-lg transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-indigo-600 text-white rounded-2xl flex items-center justify-center text-xl mb-3 group-hover:scale-105 transition shadow-xs">
                    <i class="bi bi-card-text"></i>
                </div>
                <div class="flex items-center gap-1 mb-2">
                    <span class="text-[9px] font-black uppercase text-indigo-900 bg-indigo-100 px-2 py-0.5 rounded">Ages 2–6 yrs</span>
                    <span class="text-[9px] font-extrabold text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">Pocket &amp; Big</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Flashcards</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Daily biblical affirmations and vocabulary cards in Pocket and Big sizes to build identity in Christ.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Flashcards &rarr;
            </span>
        </a>

        <!-- 4. Storybooks Card -->
        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-5 sm:p-6 rounded-3xl shadow-xs hover:shadow-lg transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-[#7C3AED] text-white rounded-2xl flex items-center justify-center text-xl mb-3 group-hover:scale-105 transition shadow-xs">
                    <i class="bi bi-book-half"></i>
                </div>
                <div class="flex items-center gap-1 mb-2">
                    <span class="text-[9px] font-black uppercase text-emerald-900 bg-emerald-100 px-2 py-0.5 rounded">Ages 3–9 yrs</span>
                    <span class="text-[9px] font-extrabold text-[#7C3AED] bg-purple-50 px-2 py-0.5 rounded">Illustrated</span>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Storybooks</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Illustrated bedtime stories by WrittenbyPD designed to cultivate godly character, empathy, and courage.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">
                Browse Storybooks &rarr;
            </span>
        </a>
    </div>
</div>

<!-- 4. CURATED BESTSELLERS (Requirement 6 & 7: Shortens homepage & unclutters inventory) -->
<div id="bestsellers" class="mb-16 scroll-mt-24">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1 mb-2">
                <i class="bi bi-trophy-fill text-[#7C3AED]"></i> Parent Favorites
            </span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81]">Curated Bestsellers</h2>
            <p class="text-xs text-slate-500 mt-1">Our most loved physical products for family devotions and active learning</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            <span>Explore All 14+ Items</span> <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <!-- 4 Flagship Cards (1 from each Category) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($bestsellers as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-xs hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <!-- Product Image with clean fallback -->
                    <a href="{{ route('catalog.show', $product->slug) }}" class="h-52 sm:h-56 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 block">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                 onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        @else
                            <img src="{{ asset('images/products/placeholder.svg') }}" class="w-24 h-24 object-contain">
                        @endif

                        <!-- Category & Age Tag (Requirement 5) -->
                        <span class="absolute top-3 left-3 bg-[#312E81] text-[#FACC15] text-[10px] font-black px-2.5 py-1 rounded-full uppercase shadow-xs">
                            {{ $product->category->name ?? 'Product' }}
                        </span>
                    </a>

                    <div class="p-5">
                        <!-- Two-Line Title Format (Requirement 7) -->
                        @php
                            // Separate title and scripture subtitle
                            $titleParts = explode('(', $product->name);
                            $cleanTitle = trim($titleParts[0]);
                            $subReference = isset($titleParts[1]) ? trim(rtrim($titleParts[1], ')')) : null;
                        @endphp

                        <h3 class="font-whimsical font-bold text-slate-900 text-lg leading-snug mb-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">
                                {{ $cleanTitle }}
                            </a>
                        </h3>

                        @if($subReference)
                            <p class="text-[11px] font-bold text-[#7C3AED] mb-2">{{ $subReference }}</p>
                        @else
                            <p class="text-[11px] font-semibold text-slate-400 mb-2">Written by PD • 800byPD Original</p>
                        @endif

                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-5 pt-0 flex items-center justify-between gap-2 mt-auto border-t border-purple-50">
                    <span class="text-xl font-black text-[#312E81] price-convertible" data-price-ngn="{{ $product->price }}">
                        {{ $product->formatted_price }}
                    </span>

                    @if($product->variants->count() > 0)
                        <a href="{{ route('catalog.show', $product->slug) }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 py-2.5 rounded-full flex items-center gap-1.5 shadow-xs transition transform hover:-translate-y-0.5">
                            <i class="bi bi-sliders"></i> Choose Option
                        </a>
                    @else
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
                            class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 py-2.5 rounded-full flex items-center gap-1.5 shadow-xs transition transform hover:-translate-y-0.5">
                            <i class="bi bi-box-seam"></i> Add to Box
                        </button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <!-- More Products Banner -->
    <div class="mt-8 bg-purple-50/70 border border-purple-200/80 rounded-2xl p-4 sm:p-5 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
        <div>
            <h4 class="font-whimsical font-bold text-slate-900 text-base">Looking for more puzzles, flashcards, or colouring books?</h4>
            <p class="text-xs text-slate-500">We have 14+ faith-anchored educational titles ready to ship nationwide.</p>
        </div>
        <a href="{{ route('catalog.index') }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold text-xs px-6 py-3 rounded-full shadow-xs transition flex items-center gap-2 flex-shrink-0">
            <span>Browse Full Catalogue</span> <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</div>

<!-- 5. BUY OUR BUNDLES: Compact & Mobile-Optimized (Requirements 2 & 8) -->
<div id="bundles-section" class="mb-16 scroll-mt-24">
    <div class="bg-gradient-to-br from-[#312E81] via-[#3730A3] to-[#4338CA] text-white rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 border-4 border-[#FACC15] shadow-xl relative overflow-hidden">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8 border-b border-indigo-400/30 pb-6">
            <div>
                <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5 mb-2 shadow-xs">
                    <i class="bi bi-box2-heart-fill text-[#7C3AED]"></i> Curated Value Packages
                </span>
                <h2 class="font-whimsical font-bold text-3xl sm:text-4xl text-white tracking-tight">
                    Ready-Made Bundles
                </h2>
                <p class="text-indigo-200 text-xs sm:text-sm mt-1 max-w-xl leading-relaxed">
                    Thoughtfully combined collections for families and classrooms. Instantly fulfills your box order for seamless 1-click checkout.
                </p>
            </div>
            
            <a href="{{ route('bundles.index') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold text-xs px-5 py-2.5 rounded-2xl shadow transition flex items-center gap-1.5 flex-shrink-0">
                <span>View Dedicated Bundles Page</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <!-- Mobile-Shorter Bundle Cards Container (Requirement 2 & 8) -->
        <div id="bundlesCarousel" class="flex lg:grid lg:grid-cols-2 gap-6 overflow-x-auto lg:overflow-x-visible snap-x snap-mandatory pb-4 pt-1 px-1 -mx-2 sm:mx-0 scrollbar-none">
            @forelse($bundles as $index => $bundle)
                <div class="min-w-[88vw] max-w-[360px] sm:min-w-[420px] sm:max-w-[460px] lg:min-w-0 lg:max-w-none w-full shrink-0 lg:shrink snap-center bg-white text-slate-800 rounded-3xl p-5 sm:p-7 flex flex-col justify-between shadow-lg border-2 border-purple-200 hover:border-[#FACC15] transition duration-300">
                    <div>
                        <!-- Header with Badges & Age suitability -->
                        <div class="flex items-center justify-between gap-2 mb-3">
                            <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-xs flex items-center gap-1">
                                <i class="bi bi-star-fill text-[#7C3AED]"></i> {{ $bundle->total_items_count }}-Item Package
                            </span>
                            
                            <span class="bg-purple-100 text-[#7C3AED] text-xs font-extrabold px-3 py-1 rounded-full">
                                Best for Ages 2–7
                            </span>
                        </div>

                        <!-- Bundle Visual Thumbnail & Title -->
                        <div class="flex gap-4 items-center mb-3">
                            <div class="w-16 h-16 rounded-2xl overflow-hidden bg-purple-100 flex-shrink-0 border border-purple-200 flex items-center justify-center">
                                <img src="{{ asset('storage/products/bundle_starter_box.svg') }}" alt="{{ $bundle->name }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                            </div>
                            <div>
                                <h3 class="font-whimsical font-bold text-[#312E81] text-xl sm:text-2xl leading-tight">{{ $bundle->name }}</h3>
                                <p class="text-xs text-slate-500 leading-snug mt-0.5 line-clamp-2">{{ $bundle->description }}</p>
                            </div>
                        </div>

                        <!-- Price & Purchase Button DIRECTLY TOGETHER (Requirement 2) -->
                        <div class="bg-purple-50/80 rounded-2xl p-4 border border-purple-200/80 mb-3 flex items-center justify-between gap-3">
                            <div>
                                <span class="text-xs text-slate-500 block font-bold">Bundle Price:</span>
                                <span class="text-2xl sm:text-3xl font-whimsical font-bold text-[#312E81] price-convertible" data-price-ngn="{{ $bundle->price }}">
                                    {{ $bundle->formatted_price }}
                                </span>
                            </div>

                            <form action="{{ route('cart.addBundle', $bundle->id) }}" method="POST" onsubmit="handleHomepageAddBundle(event)" class="m-0">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-3 px-5 rounded-2xl shadow-md transition transform hover:-translate-y-0.5 flex items-center gap-1.5 text-xs sm:text-sm uppercase tracking-wider">
                                    <i class="bi bi-bag-plus-fill text-[#FACC15]"></i>
                                    <span>Add to Cart</span>
                                </button>
                            </form>
                        </div>

                        <!-- Collapsible Detailed Contents (Requirement 2) -->
                        <details class="group/details bg-slate-50 rounded-2xl p-3.5 border border-slate-200 text-xs">
                            <summary class="cursor-pointer font-extrabold text-[#7C3AED] hover:underline flex items-center justify-between select-none">
                                <span class="flex items-center gap-1.5">
                                    <i class="bi bi-box-seam-fill text-amber-500"></i> See what's included ({{ $bundle->total_items_count }} items)
                                </span>
                                <i class="bi bi-chevron-down group-open/details:rotate-180 transition-transform duration-200 text-slate-400"></i>
                            </summary>

                            <div class="grid grid-cols-1 gap-1.5 pt-3 mt-2 border-t border-slate-200/60">
                                @foreach($bundle->items as $item)
                                    <div class="flex items-center gap-2 text-slate-700 bg-white p-2 rounded-xl border border-slate-100 shadow-2xs">
                                        <i class="bi bi-check-circle-fill text-emerald-600 text-xs flex-shrink-0"></i>
                                        <span class="font-extrabold text-[#312E81]">{{ $item->quantity }}x</span>
                                        <span class="font-semibold text-slate-800 line-clamp-1">{{ $item->display_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </details>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-8 text-center text-indigo-200">
                    <p class="font-bold text-sm">Bundles are currently being configured.</p>
                </div>
            @endforelse
        </div>

        <!-- Mobile Carousel Dots Navigation & Discovery Hint (Requirement 2) -->
        <div class="flex lg:hidden items-center justify-between mt-4 text-xs font-semibold text-indigo-200">
            <span class="flex items-center gap-1.5">
                <i class="bi bi-arrow-left-right text-[#FACC15]"></i> Swipe to compare bundles
            </span>
            <div class="flex items-center gap-1.5">
                <span class="w-2.5 h-2.5 rounded-full bg-[#FACC15]"></span>
                <span class="w-2.5 h-2.5 rounded-full bg-indigo-400/50"></span>
            </div>
        </div>
    </div>
</div>

<!-- 6. GENUINE CUSTOMER REVIEWS & TESTIMONIALS (Requirement 9) -->
<div class="mb-16">
    <div class="text-center max-w-2xl mx-auto mb-8">
        <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3.5 py-1 rounded-full border border-purple-200">Parent Testimonials</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81] mt-2">Loved by Families Across Nigeria</h2>
        <div class="flex items-center justify-center gap-1 text-amber-400 mt-2 text-sm">
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <i class="bi bi-star-fill"></i>
            <span class="text-xs font-black text-slate-700 ml-1.5">4.9 / 5.0 (Verified Purchases)</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Testimonial 1 -->
        <div class="bg-white border border-purple-100 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex text-amber-400 text-xs mb-3">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 italic">
                    "The Give Thanks puzzle has become our morning devotion routine. The pieces are thick, durable, and don't bend when my 3-year-old handles them. Seeing her memorize Psalm 107:1 while playing is pure joy!"
                </p>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-purple-50">
                <div class="w-9 h-9 rounded-full bg-purple-100 text-[#7C3AED] font-black flex items-center justify-center text-xs">
                    CO
                </div>
                <div>
                    <span class="text-xs font-black text-slate-900 block">Chidinma O.</span>
                    <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                        <i class="bi bi-patch-check-fill"></i> Verified Buyer • Lekki, Lagos
                    </span>
                </div>
            </div>
        </div>

        <!-- Testimonial 2 -->
        <div class="bg-white border border-purple-100 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex text-amber-400 text-xs mb-3">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 italic">
                    "We speak the Affirmations Flashcards together in the car on the school run every morning. It has built so much godly confidence in my son. Delivered to Abuja within 3 days without a scratch."
                </p>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-purple-50">
                <div class="w-9 h-9 rounded-full bg-indigo-100 text-indigo-700 font-black flex items-center justify-center text-xs">
                    EK
                </div>
                <div>
                    <span class="text-xs font-black text-slate-900 block">Pastor Emmanuel K.</span>
                    <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                        <i class="bi bi-patch-check-fill"></i> Verified Buyer • Abuja FCT
                    </span>
                </div>
            </div>
        </div>

        <!-- Testimonial 3 -->
        <div class="bg-white border border-purple-100 rounded-3xl p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex text-amber-400 text-xs mb-3">
                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 italic">
                    "The Psalm 23 Colouring Book paper quality is exceptional! My twins used both crayons and washable markers, and there was zero bleed-through. The Starter Bundle made checkout effortless."
                </p>
            </div>
            <div class="flex items-center gap-3 pt-3 border-t border-purple-50">
                <div class="w-9 h-9 rounded-full bg-pink-100 text-pink-700 font-black flex items-center justify-center text-xs">
                    GA
                </div>
                <div>
                    <span class="text-xs font-black text-slate-900 block">Grace A.</span>
                    <span class="text-[10px] text-emerald-600 font-bold flex items-center gap-1">
                        <i class="bi bi-patch-check-fill"></i> Verified Buyer • Ikeja, Lagos
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 7. DELIVERY & PEACE-OF-MIND REASSURANCE (Requirements 9 & 12) -->
<div class="mb-16 bg-white border border-purple-200/80 rounded-3xl p-6 sm:p-10 shadow-xs">
    <div class="text-center max-w-xl mx-auto mb-8">
        <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3.5 py-1 rounded-full border border-purple-200">Shipping &amp; Support</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Fast, Safe &amp; Dependable Delivery</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-xs">
        <!-- 1. Lagos Delivery -->
        <div class="p-4 rounded-2xl bg-purple-50/60 border border-purple-100 text-center flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-purple-200 text-[#7C3AED] flex items-center justify-center text-2xl mb-3 shadow-2xs">
                <i class="bi bi-truck"></i>
            </div>
            <h4 class="font-whimsical font-bold text-slate-900 text-sm mb-1">Lagos Express</h4>
            <p class="text-slate-600">1–2 business days flat delivery across all Lagos locations.</p>
        </div>

        <!-- 2. Nationwide Delivery -->
        <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-100 text-center flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-amber-200 text-amber-900 flex items-center justify-center text-2xl mb-3 shadow-2xs">
                <i class="bi bi-geo-alt-fill"></i>
            </div>
            <h4 class="font-whimsical font-bold text-slate-900 text-sm mb-1">All 36 States</h4>
            <p class="text-slate-600">3–5 business days nationwide delivery via dependable tracked courier.</p>
        </div>

        <!-- 3. Damaged Piece Guarantee -->
        <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 text-center flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-emerald-200 text-emerald-900 flex items-center justify-center text-2xl mb-3 shadow-2xs">
                <i class="bi bi-shield-check"></i>
            </div>
            <h4 class="font-whimsical font-bold text-slate-900 text-sm mb-1">7-Day Guarantee</h4>
            <p class="text-slate-600">Missing or damaged piece upon arrival? We'll replace it hassle-free.</p>
        </div>

        <!-- 4. Secure Paystack -->
        <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-100 text-center flex flex-col items-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-200 text-blue-900 flex items-center justify-center text-2xl mb-3 shadow-2xs">
                <i class="bi bi-lock-fill"></i>
            </div>
            <h4 class="font-whimsical font-bold text-slate-900 text-sm mb-1">Secure Payments</h4>
            <p class="text-slate-600">Encrypted checkout via Paystack with Cards, Bank Transfer, &amp; USSD.</p>
        </div>
    </div>
</div>

<!-- 8. MEET THE CREATOR: ABOUT PD (Requirement 9) -->
<div class="mb-16 bg-gradient-to-r from-purple-50 via-amber-50 to-pink-50 border-2 border-purple-200/80 rounded-3xl p-6 sm:p-10 shadow-xs">
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
        <div class="md:col-span-4 flex justify-center">
            <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-3xl bg-[#312E81] text-[#FACC15] flex flex-col items-center justify-center shadow-lg border-4 border-white rotate-2 hover:rotate-0 transition duration-300">
                <span class="font-whimsical font-bold text-5xl">PD</span>
                <span class="text-[10px] uppercase font-bold tracking-widest text-purple-200 mt-1">WrittenbyPD</span>
            </div>
        </div>

        <div class="md:col-span-8 text-center sm:text-left">
            <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-3.5 py-1 rounded-full uppercase tracking-wider inline-block mb-3">
                Behind the Brand
            </span>
            <h3 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mb-2">
                A Mission to Anchor Young Hearts in Faith
            </h3>
            <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-5">
                "As an author and educator, I created <strong>800 by PD</strong> out of a desire to make God’s Word accessible, engaging, and memorable for children. From bedtime storybooks to hands-on scripture puzzles and affirmation flashcards, every item is prayerfully designed to help parents raise confident, joyful, and faith-filled children."
                <br><span class="font-bold text-slate-800 mt-2 block">— Pelumi Dada (PD), Founder &amp; Author</span>
            </p>
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-3">
                <a href="https://wa.me/2348164254442?text=Hello%20PD!%20I%20have%20a%20question%20about%20your%20products." target="_blank" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold text-xs px-5 py-2.5 rounded-full shadow-xs transition flex items-center gap-1.5">
                    <i class="bi bi-whatsapp text-[#FACC15]"></i> Chat with PD on WhatsApp
                </a>
            </div>
        </div>
    </div>
</div>

<!-- 9. COMPACT SPOTIFY AUDIOS BANNER (Requirement 11) -->
<div class="mb-16 bg-gradient-to-br from-[#1E1B4B] to-[#312E81] text-white rounded-3xl p-6 sm:p-8 border-4 border-[#FACC15] shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-center gap-6">
        <div class="flex items-center gap-4 text-center md:text-left">
            <div class="w-16 h-16 rounded-2xl bg-[#1DB954] text-white flex items-center justify-center text-3xl flex-shrink-0 shadow-md">
                <i class="bi bi-spotify"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-[#FACC15] uppercase tracking-wider">Audio Companion Stream</span>
                <h3 class="font-whimsical font-bold text-xl sm:text-2xl text-white">Bedtime Faith Stories &amp; Scripture Audio</h3>
                <p class="text-xs text-indigo-200 mt-0.5">Listen to "The Steadfast Love of God" &amp; "Starry Night Journey" narrated by WrittenbyPD.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 flex-shrink-0">
            <button onclick="openSpotifyModal()" class="bg-[#1DB954] hover:bg-emerald-600 text-white font-black text-xs px-5 py-3 rounded-full shadow-md transition flex items-center gap-2">
                <i class="bi bi-play-circle-fill text-base"></i> Listen on Spotify
            </button>
        </div>
    </div>
</div>

<script>
function handleHomepageAddBundle(e) {
    e.preventDefault();
    const form = e.target;
    const btn = form.querySelector('button[type="submit"]');
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

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
        btn.innerHTML = '<i class="bi bi-check2-circle text-[#FACC15] mr-1"></i> Added!';
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
