@extends('layouts.app')

@section('content')
<div class="mb-6 sm:mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <div>
        <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#312E81]">Product Catalog</h1>
        <p class="text-xs text-slate-500">Explore all 800byPD products in <span class="currency-name font-bold text-[#312E81]">Naira (₦)</span></p>
    </div>

    <!-- Mobile Filters Collapsible Toggle Button -->
    <button onclick="toggleMobileFilters()" class="lg:hidden w-full sm:w-auto bg-purple-100 hover:bg-purple-200 text-[#312E81] font-bold text-xs px-4 py-2.5 rounded-2xl flex items-center justify-center gap-2 border border-purple-300">
        <i class="bi bi-funnel-fill text-[#7C3AED]"></i> Toggle Search & Filters
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 sm:gap-8">
    <!-- Sidebar Filters -->
    <div id="catalogFiltersSidebar" class="hidden lg:block bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm h-fit">
        <h3 class="font-whimsical font-bold text-[#312E81] text-base mb-4 flex items-center justify-between">
            <span>Filters</span>
            <a href="{{ route('catalog.index') }}" class="text-xs text-[#7C3AED] font-bold hover:underline">Reset</a>
        </h3>

        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
            <!-- Search -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Search Keywords</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Keyword..." class="w-full border border-slate-200 pl-8 pr-3 py-2 text-xs rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    <i class="bi bi-search absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-2">Category</label>
                <div class="space-y-2 max-h-48 overflow-y-auto text-xs">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 text-slate-600 font-medium cursor-pointer">
                            <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()" class="text-[#7C3AED] focus:ring-[#7C3AED]">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Sort By</label>
                <select name="sort" onchange="this.form.submit()" class="w-full border border-slate-200 px-3 py-2 text-xs rounded-xl bg-white font-medium focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="bestsellers" {{ request('sort') == 'bestsellers' ? 'selected' : '' }}>Bestsellers</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold text-xs py-3 rounded-xl shadow-md transition">Apply Filters</button>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white border border-purple-200/80 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                    <div>
                        <div class="h-48 sm:h-52 bg-purple-50/50 relative overflow-hidden flex items-center justify-center border-b border-slate-100 cursor-pointer" 
                            data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}"
                            data-price="{{ $product->price }}"
                            data-saleprice="{{ $product->sale_price }}"
                            data-stock="{{ $product->stock_quantity }}"
                            data-desc="{{ $product->description }}"
                            data-category="{{ $product->category->name ?? 'Book' }}"
                            data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                            onclick="triggerQuickAddFromBtn(this)">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="text-center p-4">
                                    <i class="bi bi-book-half text-4xl text-[#FACC15] mb-1"></i>
                                    <span class="block text-[10px] font-bold text-slate-400">800byPD Original</span>
                                </div>
                            @endif
                        </div>
                        <div class="p-5">
                            <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-2">{{ $product->category->name ?? 'Books' }}</span>
                            <h3 class="font-whimsical font-bold text-slate-900 text-lg mb-1 line-clamp-1">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-3">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="p-5 pt-0 flex items-center justify-between mt-auto">
                        <div>
                            <span class="text-xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                            @if($product->sale_price)
                                <span class="block text-[11px] line-through text-slate-400 price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                            @endif
                        </div>

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
                            class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-4 py-2 rounded-xl flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5">
                            <i class="bi bi-plus-lg text-[#FACC15]"></i> Add
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-slate-500 bg-white border border-purple-200/80 rounded-3xl">
                    <i class="bi bi-journal-bookmark text-4xl text-[#FACC15] mb-2"></i>
                    <p class="font-bold text-sm">No products matching your search criteria.</p>
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
