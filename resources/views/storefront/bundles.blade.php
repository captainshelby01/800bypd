@extends('layouts.app')

@section('content')

<!-- Bundles Page Header -->
<div class="mb-8 sm:mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-purple-100 pb-6">
    <div>
        <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-purple-100 text-[#7C3AED] text-xs font-black mb-2 shadow-2xs">
            <i class="bi bi-box2-heart-fill text-[#FACC15]"></i> Curated Combinations
        </div>
        <h1 class="font-whimsical text-3xl sm:text-4xl lg:text-5xl font-black text-[#312E81]">Curated Bundles</h1>
        <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
            Thoughtfully paired collections of scripture storybooks, Bible-verse jigsaw puzzles, biblical affirmation flashcards, and coloring books for comprehensive, faith-filled learning.
        </p>
    </div>

    <div class="flex items-center gap-2 w-full md:w-auto">
        <a href="{{ route('catalog.index') }}" class="flex-1 md:flex-none inline-flex items-center justify-center gap-2 bg-purple-100 hover:bg-purple-200 text-[#312E81] text-xs font-black px-4 py-2.5 rounded-2xl border border-purple-300 transition">
            <i class="bi bi-grid-fill text-[#7C3AED]"></i> Browse All Products
        </a>
    </div>
</div>

<!-- Category Quick Pills Bar -->
<div class="mb-8 overflow-x-auto pb-2 scrollbar-none">
    <div class="flex items-center gap-2 min-w-max">
        <a href="{{ route('catalog.index') }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50">
            <i class="bi bi-grid-fill"></i> All Products
        </a>
        <a href="{{ route('bundles.index') }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-[#312E81] text-[#FACC15] shadow-md">
            <i class="bi bi-box2-heart-fill text-[#FACC15]"></i> Curated Bundles
            <span class="text-[10px] bg-purple-800 text-[#FACC15] px-1.5 py-0.2 rounded-md font-extrabold">{{ $bundles->count() }} Packages</span>
        </a>
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50">
            <i class="bi bi-puzzle-fill text-amber-500"></i> Jigsaw Puzzles
        </a>
        <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50">
            <i class="bi bi-palette-fill text-pink-500"></i> Coloring Books
        </a>
        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50">
            <i class="bi bi-card-text text-indigo-500"></i> Flashcards
        </a>
        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" 
           class="px-4 py-2 rounded-2xl text-xs font-black transition flex items-center gap-2 bg-white border border-purple-200/80 text-slate-700 hover:bg-purple-50">
            <i class="bi bi-book-half text-emerald-500"></i> Storybooks
        </a>
    </div>
</div>

<!-- Bundles List -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-16">
    @forelse($bundles as $bundle)
        <div class="bg-white text-slate-800 rounded-3xl p-6 sm:p-8 flex flex-col justify-between shadow-lg border-2 border-purple-200/80 hover:border-[#7C3AED] transition duration-300 group">
            <div>
                <!-- Header with Badges -->
                <div class="flex items-center justify-between gap-2 mb-3">
                    <span class="bg-[#FACC15] text-[#312E81] text-xs font-black px-3 py-1 rounded-full uppercase tracking-wider shadow-sm flex items-center gap-1">
                        <i class="bi bi-star-fill text-[#7C3AED]"></i> 
                        {{ str_replace(['Best Value', 'best value', 'Discount', 'discount'], ['Curated Set', 'Curated Set', 'Curated', 'Curated'], $bundle->badge ?? $bundle->total_items_count . '-Item Bundle') }}
                    </span>
                    
                    <span class="bg-purple-100 text-[#7C3AED] text-xs font-extrabold px-3 py-1 rounded-full flex items-center gap-1">
                        <i class="bi bi-box-seam-fill"></i> {{ $bundle->total_items_count }} Items Combo
                    </span>
                </div>

                <h2 class="font-whimsical font-bold text-[#312E81] text-2xl sm:text-3xl mb-2">{{ $bundle->name }}</h2>
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
            <form action="{{ route('cart.addBundle', $bundle->id) }}" method="POST">
                @csrf
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-4 px-6 rounded-2xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs sm:text-sm uppercase tracking-wider">
                    <i class="bi bi-bag-plus-fill text-[#FACC15] text-base"></i>
                    <span>Add Bundle to Cart</span>
                </button>
            </form>
        </div>
    @empty
        <div class="col-span-full py-16 text-center text-slate-500 bg-white border border-purple-200/80 rounded-3xl p-8">
            <i class="bi bi-box2-heart text-5xl text-purple-300 mb-3 block"></i>
            <h4 class="font-whimsical text-lg font-bold text-slate-800 mb-1">Bundles are being updated</h4>
            <p class="font-medium text-xs text-slate-500 max-w-sm mx-auto mb-4">Please check back shortly or explore our individual collections.</p>
            <a href="{{ route('catalog.index') }}" class="inline-flex items-center gap-1.5 bg-[#312E81] text-[#FACC15] text-xs font-bold px-4 py-2.5 rounded-xl shadow">
                <i class="bi bi-grid-fill"></i> Browse All Products
            </a>
        </div>
    @endforelse
</div>

<!-- Convenience Value Proposition Banner -->
<div class="bg-gradient-to-r from-purple-50 via-indigo-50/60 to-purple-50 border border-purple-200/80 rounded-3xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6 shadow-sm">
    <div class="flex items-center gap-4">
        <div class="w-14 h-14 bg-purple-100 text-[#7C3AED] rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 shadow-inner">
            <i class="bi bi-stars"></i>
        </div>
        <div>
            <h4 class="font-whimsical font-bold text-[#312E81] text-lg">Looking for Custom Combinations?</h4>
            <p class="text-xs text-slate-600 mt-0.5">You can also explore individual books, puzzles, flashcards, and colouring sheets to build your own box.</p>
        </div>
    </div>
    <a href="{{ route('catalog.index') }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold text-xs px-6 py-3.5 rounded-xl transition shadow flex items-center gap-2 flex-shrink-0">
        <span>Explore Full Catalog</span>
        <i class="bi bi-arrow-right"></i>
    </a>
</div>

@endsection
