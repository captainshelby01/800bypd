@extends('layouts.app')

@section('content')

<!-- Hero Banner Section -->
<div class="relative bg-gradient-to-br from-[#FFF4E5] via-[#FFF9F0] to-[#F3E8FF] border-2 border-[#FDE68A] rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 md:p-16 mb-12 sm:mb-16 overflow-hidden shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 z-10 text-center sm:text-left">
            <span class="bg-[#FBBF24] text-[#2D1B4E] font-extrabold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider mb-5 inline-flex items-center gap-1.5 shadow-sm">
                <i class="bi bi-stars text-purple-900"></i> Children's Bookstore by WrittenbyPD
            </span>
            <h1 class="font-whimsical text-3xl sm:text-5xl md:text-6xl font-bold text-[#2D1B4E] leading-[1.1] mb-5 tracking-tight">
                Ignite Young Minds With Every Page.
            </h1>
            <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-8 leading-relaxed font-medium">
                Explore a whimsical collection of children's story books, brain-boosting jigsaw puzzles, and creative colouring books crafted by <strong>WrittenbyPD</strong>.
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center sm:justify-start">
                <a href="{{ route('catalog.index') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-white font-extrabold px-8 py-4 rounded-full shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    Shop The Collection <i class="bi bi-arrow-right text-amber-400"></i>
                </a>
                <button onclick="openSpotifyModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-4 rounded-full shadow-lg transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-spotify text-base"></i> Listen on Spotify
                </button>
            </div>
        </div>

        <!-- Right Hero Visual Card -->
        <div class="lg:col-span-5 flex justify-center z-10">
            <div class="relative w-full max-w-sm bg-white p-6 rounded-[2.5rem] shadow-xl border-4 border-[#FBBF24] transform rotate-1 hover:rotate-0 transition duration-300">
                <div class="h-64 bg-purple-50 rounded-2xl flex flex-col items-center justify-center text-center p-6 border border-purple-100 mb-4">
                    <i class="bi bi-journal-bookmark-fill text-6xl text-purple-600 mb-3 animate-bounce"></i>
                    <h3 class="font-whimsical font-bold text-slate-900 text-xl">800bypd Originals</h3>
                    <p class="text-xs text-slate-500 mt-1">Bedtime Stories, Puzzles & Activity Books</p>
                </div>
                <div class="flex justify-between items-center bg-amber-50 p-3.5 rounded-xl border border-amber-200 text-xs">
                    <span class="font-extrabold text-[#2D1B4E]"><i class="bi bi-truck text-amber-500 mr-1"></i> Fast Delivery</span>
                    <span class="font-extrabold text-emerald-700">Lagos & All Nigeria</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Collections -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 sm:gap-7 mb-12 sm:mb-16">
    <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="bg-[#F5F0FF] border-2 border-purple-200/80 hover:border-purple-600 p-6 sm:p-8 rounded-3xl sm:rounded-[2rem] shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
        <div>
            <div class="w-16 h-16 bg-purple-600 text-white rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:scale-110 group-hover:rotate-3 transition duration-300 shadow-md">
                <i class="bi bi-book-half"></i>
            </div>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-purple-700 bg-white px-2.5 py-1 rounded-md mb-3 inline-block shadow-sm">Category</span>
            <h3 class="font-whimsical font-bold text-slate-900 text-2xl mb-2">Children's Story Books</h3>
            <p class="text-xs text-slate-600 leading-relaxed mb-4">Bedtime tales and Spotify audiobooks written by WrittenbyPD that inspire kindness and courage.</p>
        </div>
        <span class="text-xs font-extrabold text-purple-700 flex items-center gap-1 group-hover:translate-x-1 transition">Browse Story Books <i class="bi bi-chevron-right text-[10px]"></i></span>
    </a>

    <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="bg-[#FFFBEB] border-2 border-amber-200/80 hover:border-amber-500 p-6 sm:p-8 rounded-3xl sm:rounded-[2rem] shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
        <div>
            <div class="w-16 h-16 bg-[#FBBF24] text-[#2D1B4E] rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:scale-110 group-hover:-rotate-3 transition duration-300 shadow-md">
                <i class="bi bi-puzzle-fill"></i>
            </div>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 bg-white px-2.5 py-1 rounded-md mb-3 inline-block shadow-sm">Category</span>
            <h3 class="font-whimsical font-bold text-slate-900 text-2xl mb-2">Jigsaw Puzzles</h3>
            <p class="text-xs text-slate-600 leading-relaxed mb-4">Vibrant, durable floor puzzles designed to enhance motor skills and critical thinking.</p>
        </div>
        <span class="text-xs font-extrabold text-amber-800 flex items-center gap-1 group-hover:translate-x-1 transition">Browse Puzzles <i class="bi bi-chevron-right text-[10px]"></i></span>
    </a>

    <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="bg-[#FDF2F8] border-2 border-pink-200/80 hover:border-pink-500 p-6 sm:p-8 rounded-3xl sm:rounded-[2rem] shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
        <div>
            <div class="w-16 h-16 bg-pink-500 text-white rounded-2xl flex items-center justify-center text-3xl mb-5 group-hover:scale-110 group-hover:rotate-3 transition duration-300 shadow-md">
                <i class="bi bi-palette-fill"></i>
            </div>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-pink-700 bg-white px-2.5 py-1 rounded-md mb-3 inline-block shadow-sm">Category</span>
            <h3 class="font-whimsical font-bold text-slate-900 text-2xl mb-2">Colouring Books</h3>
            <p class="text-xs text-slate-600 leading-relaxed mb-4">Interactive doodle & mindfulness colouring books with thick, bleed-resistant pages.</p>
        </div>
        <span class="text-xs font-extrabold text-pink-700 flex items-center gap-1 group-hover:translate-x-1 transition">Browse Colouring Books <i class="bi bi-chevron-right text-[10px]"></i></span>
    </a>
</div>

<!-- Meet The Author Highlight Section -->
<div class="bg-gradient-to-r from-purple-900 to-[#2D1B4E] text-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-10 md:p-14 mb-12 sm:mb-16 shadow-xl border-4 border-[#FBBF24] flex flex-col md:flex-row items-center gap-6 sm:gap-9 text-center md:text-left">
    <div class="w-32 h-32 md:w-44 md:h-44 bg-[#FBBF24] text-[#2D1B4E] rounded-full flex items-center justify-center font-whimsical font-bold text-4xl sm:text-5xl shadow-2xl flex-shrink-0 border-4 border-white">
        <i class="bi bi-pen-fill"></i>
    </div>
    <div>
        <span class="bg-[#FBBF24] text-[#2D1B4E] font-extrabold text-[11px] px-3.5 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Meet The Author</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-white mb-3">WrittenbyPD (800bypd)</h2>
        <p class="text-xs md:text-sm text-purple-100 leading-relaxed mb-5 font-medium">
            "Every story we share and every puzzle we build is a step toward helping children discover their inner creativity. 800bypd was born out of a deep passion for early childhood storytelling and interactive learning."
        </p>
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 sm:gap-5 text-xs font-bold text-amber-300">
            <span><i class="bi bi-geo-alt-fill text-amber-400 mr-1"></i> Based in Lagos, Nigeria</span>
            <span><i class="bi bi-spotify text-emerald-400 mr-1"></i> Spotify Audiobook Producer</span>
        </div>
    </div>
</div>

<!-- Bestsellers Grid -->
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8">
        <div>
            <span class="text-purple-700 font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full">Top Recommendations</span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900 mt-2">Curated Children's Products</h2>
        </div>
        <a href="{{ route('catalog.index') }}" class="text-xs font-extrabold text-purple-700 hover:underline flex items-center gap-1">View Full Catalog <i class="bi bi-chevron-right text-[10px]"></i></a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($featuredProducts as $product)
            <div class="bg-white border border-slate-200/90 rounded-3xl sm:rounded-[2.2rem] overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <div class="h-56 sm:h-64 bg-[#FFFBF5] relative overflow-hidden flex items-center justify-center border-b border-slate-100 cursor-pointer" 
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
                            <div class="text-center p-6">
                                <i class="bi bi-book-half text-5xl text-amber-400 mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800bypd Publication</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-[#FBBF24] text-[#2D1B4E] text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">Bestseller</span>
                    </div>

                    <div class="p-6">
                        <span class="text-[10px] font-extrabold text-purple-700 uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">{{ $product->category->name ?? 'Books' }}</span>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-purple-700 transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0 flex items-center justify-between mt-auto">
                    <div>
                        <span class="text-2xl font-extrabold text-[#2D1B4E] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <!-- Nourishark Style Quick Add Modal Trigger Button -->
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
                        class="bg-[#2D1B4E] hover:bg-purple-900 text-white text-xs font-extrabold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5">
                        <i class="bi bi-bag-fill text-amber-400"></i> Add
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-500 bg-white border rounded-[2rem]">
                <i class="bi bi-journal-bookmark text-5xl text-amber-400 mb-3"></i>
                <p class="font-bold text-sm">No products added yet.</p>
            </div>
        @endforelse
    </div>
</div>

@endsection
