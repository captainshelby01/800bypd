@extends('layouts.app')

@section('content')
<!-- Catalog Header -->
<div class="mb-6 sm:mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-100 text-[#7C3AED] text-xs font-bold mb-2">
            <i class="bi bi-box-seam-fill"></i> Fill Your Box Store
        </div>
        <h1 class="font-whimsical text-2xl sm:text-3xl lg:text-4xl font-black text-[#312E81]">Product Catalog</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Explore our 4 faith-nurturing collections & curated bundles in <span class="currency-name font-bold text-[#312E81]">Naira (₦)</span></p>
    </div>

    <!-- Mobile Filters Collapsible Toggle Button -->
    <div class="flex items-center gap-2 w-full md:w-auto">
        <a href="{{ route('bundles.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-1.5 bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] text-xs font-black px-4 py-2.5 rounded-2xl shadow-sm transition">
            <i class="bi bi-box2-heart-fill"></i> View Bundles
        </a>
        <button onclick="toggleMobileFilters()" class="lg:hidden flex-1 md:flex-none bg-purple-100 hover:bg-purple-200 text-[#312E81] font-bold text-xs px-4 py-2.5 rounded-2xl flex items-center justify-center gap-2 border border-purple-300 transition">
            <i class="bi bi-funnel-fill text-[#7C3AED]"></i> Filters
        </button>
    </div>
</div>

<!-- Category Quick Pills Bar -->
<div class="mb-3 overflow-x-auto pb-2 scrollbar-none">
    <div class="flex items-center gap-2 min-w-max">
        <a href="{{ route('catalog.index', array_filter(['age' => request('age'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ !request('category') ? 'bg-[#312E81] text-[#FACC15] shadow-md' : 'bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50' }}">
            <i class="bi bi-grid-fill"></i> All Categories
        </a>
        <a href="{{ route('catalog.index', array_filter(['category' => 'jigsaw-puzzles', 'age' => request('age'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ request('category') === 'jigsaw-puzzles' ? 'bg-[#312E81] text-[#FACC15] shadow-md' : 'bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50' }}">
            <i class="bi bi-puzzle-fill text-amber-500"></i> Jigsaw Puzzles
            <span class="text-[10px] bg-amber-100 text-amber-900 px-1.5 py-0.2 rounded-md font-extrabold">Easy & 12-pc</span>
        </a>
        <a href="{{ route('catalog.index', array_filter(['category' => 'coloring-books', 'age' => request('age'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ request('category') === 'coloring-books' ? 'bg-[#312E81] text-[#FACC15] shadow-md' : 'bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50' }}">
            <i class="bi bi-palette-fill text-pink-500"></i> Coloring Books
        </a>
        <a href="{{ route('catalog.index', array_filter(['category' => 'flashcards', 'age' => request('age'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ request('category') === 'flashcards' ? 'bg-[#312E81] text-[#FACC15] shadow-md' : 'bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50' }}">
            <i class="bi bi-card-text text-indigo-500"></i> Flashcards
            <span class="text-[10px] bg-purple-100 text-purple-900 px-1.5 py-0.2 rounded-md font-extrabold">Pocket & Big</span>
        </a>
        <a href="{{ route('catalog.index', array_filter(['category' => 'storybooks', 'age' => request('age'), 'search' => request('search'), 'sort' => request('sort')])) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 {{ request('category') === 'storybooks' ? 'bg-[#312E81] text-[#FACC15] shadow-md' : 'bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50' }}">
            <i class="bi bi-book-half text-emerald-500"></i> Storybooks
        </a>
        <a href="{{ route('bundles.index') }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-300 text-[#7C3AED] hover:from-purple-100 hover:to-pink-100">
            <i class="bi bi-gift-fill text-[#FACC15]"></i> Pre-defined Bundles
            <span class="text-[10px] bg-[#312E81] text-[#FACC15] px-1.5 py-0.2 rounded-md font-extrabold">Curated</span>
        </a>
    </div>
</div>

<!-- Age Quick Pills Bar (Item 5: Help parents choose by age) -->
<div class="mb-8 overflow-x-auto pb-2 scrollbar-none flex items-center gap-2">
    <span class="text-xs font-black text-slate-400 uppercase tracking-wider flex items-center gap-1 mr-1">
        <i class="bi bi-person-heart text-[#7C3AED]"></i> Shop by Age:
    </span>
    <a href="{{ route('catalog.index', array_filter(['category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}"
       class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ !request('age') ? 'bg-[#7C3AED] text-white shadow-xs' : 'bg-white border border-purple-200 text-slate-600 hover:bg-purple-50' }}">
        All Ages
    </a>
    <a href="{{ route('catalog.index', array_filter(['age' => '2-4', 'category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}"
       class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('age') === '2-4' ? 'bg-[#7C3AED] text-white shadow-xs' : 'bg-white border border-purple-200 text-slate-600 hover:bg-purple-50' }}">
        Ages 2–4 yrs (Toddlers)
    </a>
    <a href="{{ route('catalog.index', array_filter(['age' => '4-7', 'category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}"
       class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('age') === '4-7' ? 'bg-[#7C3AED] text-white shadow-xs' : 'bg-white border border-purple-200 text-slate-600 hover:bg-purple-50' }}">
        Ages 4–7 yrs (Early Learners)
    </a>
    <a href="{{ route('catalog.index', array_filter(['age' => '7+', 'category' => request('category'), 'search' => request('search'), 'sort' => request('sort')])) }}"
       class="px-3.5 py-1.5 rounded-full text-xs font-bold transition {{ request('age') === '7+' ? 'bg-[#7C3AED] text-white shadow-xs' : 'bg-white border border-purple-200 text-slate-600 hover:bg-purple-50' }}">
        Ages 7+ yrs (Growing Readers)
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8">
    <!-- Sidebar Filters -->
    <div id="catalogFiltersSidebar" class="hidden lg:block bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm h-fit">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-whimsical font-bold text-[#312E81] text-base flex items-center gap-2">
                <i class="bi bi-sliders text-[#7C3AED]"></i>
                <span>Filters</span>
            </h3>
            <a href="{{ route('catalog.index') }}" class="text-xs text-[#7C3AED] font-bold hover:underline flex items-center gap-1">
                <i class="bi bi-arrow-counterclockwise"></i> Reset
            </a>
        </div>

        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
            <!-- Search -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Search Products</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Puzzles, flashcards, stories..." class="w-full border border-slate-200 pl-8 pr-3 py-2 text-xs rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Product Categories</label>
                <div class="space-y-1.5 text-xs">
                    <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ !request('category') ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="category" value="" {{ !request('category') ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span><i class="bi bi-grid-fill text-slate-400 mr-1.5"></i> All Categories</span>
                        </span>
                    </label>

                    @foreach($categories as $cat)
                        <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ request('category') == $cat->slug ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                            <span class="flex items-center gap-2">
                                <input type="radio" name="category" value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                                <span>
                                    @if($cat->slug === 'jigsaw-puzzles')
                                        <i class="bi bi-puzzle-fill text-amber-500 mr-1.5"></i>
                                    @elseif($cat->slug === 'coloring-books')
                                        <i class="bi bi-palette-fill text-pink-500 mr-1.5"></i>
                                    @elseif($cat->slug === 'flashcards')
                                        <i class="bi bi-card-text text-indigo-500 mr-1.5"></i>
                                    @elseif($cat->slug === 'storybooks')
                                        <i class="bi bi-book-half text-emerald-500 mr-1.5"></i>
                                    @else
                                        <i class="bi bi-tag-fill text-purple-400 mr-1.5"></i>
                                    @endif
                                    {{ $cat->name }}
                                </span>
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Age Suitability (Item 5) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Age Group</label>
                <div class="space-y-1.5 text-xs">
                    <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ !request('age') ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="age" value="" {{ !request('age') ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span>All Ages</span>
                        </span>
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ request('age') === '2-4' ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="age" value="2-4" {{ request('age') === '2-4' ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span>Ages 2–4 yrs (Toddlers)</span>
                        </span>
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ request('age') === '4-7' ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="age" value="4-7" {{ request('age') === '4-7' ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span>Ages 4–7 yrs (Early Learners)</span>
                        </span>
                    </label>
                    <label class="flex items-center justify-between p-2 rounded-xl cursor-pointer hover:bg-purple-50 transition {{ request('age') === '7+' ? 'bg-purple-50 font-bold text-[#7C3AED]' : 'text-slate-600' }}">
                        <span class="flex items-center gap-2">
                            <input type="radio" name="age" value="7+" {{ request('age') === '7+' ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span>Ages 7+ yrs (Growing Readers)</span>
                        </span>
                    </label>
                </div>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sort By</label>
                <select name="sort" onchange="this.form.submit()" class="w-full border border-slate-200 px-3 py-2 text-xs rounded-xl bg-white font-medium focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="bestsellers" {{ request('sort') == 'bestsellers' ? 'selected' : '' }}>Featured / Bestsellers</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold text-xs py-3 rounded-xl shadow-md transition flex items-center justify-center gap-1.5">
                <i class="bi bi-check-lg text-sm"></i> Apply Filters
            </button>
        </form>

        <!-- Fill Your Box Helper Tip -->
        <div class="mt-6 p-4 rounded-2xl bg-amber-50 border border-amber-200 text-amber-900 text-xs">
            <div class="flex items-center gap-2 font-black mb-1 text-[#312E81]">
                <i class="bi bi-box-seam-fill text-[#7C3AED]"></i> Fill Your Box Tip
            </div>
            <p class="text-[11px] text-slate-600 leading-relaxed">
                Add at least <strong class="text-[#312E81] font-bold">{{ \App\Models\Setting::get('checkout_min_order_quantity', 3) }} items</strong> to unlock checkout. Bundles count as multiple items towards your box!
            </p>
        </div>
    </div>

    <!-- Product Grid -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white border border-purple-200/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                    <div>
                        <!-- Product Image Area (Large & prominent, uncropped, text never cut off) -->
                        <a href="{{ route('catalog.show', $product->slug) }}" class="block h-56 sm:h-64 bg-gradient-to-b from-purple-50/70 via-indigo-50/20 to-white relative overflow-hidden flex items-center justify-center p-2 sm:p-2.5 border-b border-purple-100/60 group">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="max-h-full max-w-full object-contain group-hover:scale-105 transition duration-300 drop-shadow-md rounded-lg"
                                     onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                            @else
                                <img src="{{ asset('images/products/placeholder.svg') }}" alt="{{ $product->name }}" class="w-24 h-24 object-contain">
                            @endif
                        </a>

                        <!-- Product Content Info -->
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                @if($product->category)
                                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="text-[10px] font-extrabold text-[#7C3AED] hover:text-[#312E81] hover:bg-purple-100 uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block transition">
                                        {{ $product->category->name }}
                                    </a>
                                @else
                                    <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block">
                                        Collection
                                    </span>
                                @endif

                                @php
                                    $ageLabel = 'Ages 3+';
                                    if ($product->category) {
                                        if ($product->category->slug === 'jigsaw-puzzles') $ageLabel = 'Ages 3–8 yrs';
                                        elseif ($product->category->slug === 'flashcards') $ageLabel = 'Ages 2–6 yrs';
                                        elseif ($product->category->slug === 'coloring-books') $ageLabel = 'Ages 3–8 yrs';
                                        elseif ($product->category->slug === 'storybooks') $ageLabel = 'Ages 3–9 yrs';
                                    }
                                @endphp
                                <span class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">
                                    {{ $ageLabel }}
                                </span>
                            </div>

                            @php
                                $titleParts = explode('(', $product->name);
                                $cleanTitle = trim($titleParts[0]);
                                $subReference = isset($titleParts[1]) ? trim(rtrim($titleParts[1], ')')) : null;
                            @endphp

                            <h3 class="font-whimsical font-bold text-slate-900 text-base sm:text-lg mb-0.5 leading-snug">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $cleanTitle }}</a>
                            </h3>

                            @if($subReference)
                                <p class="text-[11px] font-bold text-[#7C3AED] mb-2">{{ $subReference }}</p>
                            @else
                                <p class="text-[11px] font-semibold text-slate-400 mb-2">Written by PD • 800byPD Original</p>
                            @endif

                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">{{ $product->description }}</p>
                        </div>
                    </div>

                    <!-- Price & Action Footer -->
                    <div class="p-5 pt-0 flex items-center justify-between gap-2 mt-auto">
                        <div class="min-h-[46px] flex flex-col justify-center">
                            @if($product->variants->isNotEmpty())
                                <span class="text-[10px] text-slate-400 font-semibold block uppercase tracking-wider leading-none mb-0.5">Starting at</span>
                            @endif
                            <span class="text-xl font-extrabold text-[#312E81] price-convertible leading-tight" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                            @if($product->sale_price)
                                <span class="block text-[11px] line-through text-slate-400 price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                            @endif
                        </div>

                        @if($product->variants->isNotEmpty())
                            <!-- 3.4 Properly sized & aligned Choose Option button -->
                            <a href="{{ route('catalog.show', $product->slug) }}" class="h-10 bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap flex-shrink-0">
                                <i class="bi bi-sliders text-[#FACC15]"></i>
                                <span>Choose Options</span>
                            </a>
                        @else
                            <button type="button" 
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-saleprice="{{ $product->sale_price }}"
                                data-stock="{{ $product->stock_quantity }}"
                                data-desc="{{ $product->description }}"
                                data-category="{{ $product->category->name ?? 'Book' }}"
                                data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                                onclick="triggerQuickAddFromBtn(this)"
                                class="h-10 bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 rounded-xl inline-flex items-center justify-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5 whitespace-nowrap flex-shrink-0">
                                <i class="bi bi-box-seam text-[#FACC15]"></i>
                                <span>Add to Box</span>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center text-slate-500 bg-white border border-purple-200/80 rounded-3xl p-8">
                    <i class="bi bi-journal-x text-5xl text-purple-300 mb-3 block"></i>
                    <h4 class="font-whimsical text-lg font-bold text-slate-800 mb-1">No products found</h4>
                    <p class="font-medium text-xs text-slate-500 max-w-sm mx-auto mb-4">We couldn't find any products matching your filters. Try selecting another category or resetting the search.</p>
                    <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-1.5 bg-[#312E81] text-[#FACC15] text-xs font-bold px-4 py-2.5 rounded-xl shadow">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset All Filters
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>

<script>
    function toggleMobileFilters() {
        const sidebar = document.getElementById('catalogFiltersSidebar');
        sidebar.classList.toggle('hidden');
    }
</script>
@endsection
