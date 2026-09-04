@extends('layouts.app')

@section('content')

<!-- 1. Hero Section -->
<div class="relative bg-gradient-to-br from-[#F5F3FF] via-[#FFFDF9] to-[#EDE9FE] border-2 border-purple-200/80 rounded-3xl md:rounded-[2.5rem] p-6 sm:p-10 md:p-14 mb-12 sm:mb-16 overflow-hidden shadow-sm">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        
        <!-- Left Hero Copy -->
        <div class="lg:col-span-7 z-10 text-center sm:text-left">
            <span class="bg-[#FACC15] text-[#312E81] font-extrabold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider mb-5 inline-flex items-center gap-1.5 shadow-sm">
                <i class="bi bi-stars text-[#7C3AED]"></i> Children's Books & Audios by PD
            </span>
            <h1 class="font-whimsical text-3xl sm:text-5xl md:text-6xl font-bold text-[#312E81] leading-[1.1] mb-5 tracking-tight">
                Ignite Young Minds With Every Story & Song.
            </h1>
            <p class="text-slate-600 text-sm sm:text-base md:text-lg mb-8 leading-relaxed font-medium">
                Explore a vibrant collection of children's storybooks, audio episodes on Spotify, brain-boosting puzzles, and creative activity books.
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-4 justify-center sm:justify-start">
                <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-8 py-4 rounded-full shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    Explore Books <i class="bi bi-book-half text-[#FACC15]"></i>
                </a>
                <a href="{{ route('audios.index') }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-7 py-4 rounded-full shadow-lg transition flex items-center justify-center gap-2 text-xs uppercase tracking-wider">
                    <i class="bi bi-spotify text-base text-[#FACC15]"></i> Listen to Audios
                </a>
            </div>
        </div>

        <!-- Right Hero Visual Card -->
        <div class="lg:col-span-5 flex justify-center z-10">
            <div class="relative w-full max-w-sm bg-white p-6 rounded-[2.5rem] shadow-xl border-4 border-[#FACC15] transform rotate-1 hover:rotate-0 transition duration-300">
                <div class="h-64 bg-purple-50 rounded-2xl flex flex-col items-center justify-center text-center p-6 border border-purple-100 mb-4">
                    <i class="bi bi-[#spotify] bi-journal-bookmark-fill text-6xl text-[#7C3AED] mb-3 animate-bounce"></i>
                    <h3 class="font-whimsical font-bold text-[#312E81] text-xl">800BYPD Originals</h3>
                    <p class="text-xs text-slate-500 mt-1">Storybooks • Audios • Puzzles • Apparel</p>
                </div>
                <div class="flex justify-between items-center bg-purple-50 p-3.5 rounded-xl border border-purple-200 text-xs">
                    <span class="font-extrabold text-[#312E81]"><i class="bi bi-truck text-[#FACC15] mr-1"></i> Fast Delivery</span>
                    <span class="font-extrabold text-[#7C3AED]">Lagos & All Nigeria</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Featured Children's Content Categories -->
<div class="mb-14 sm:mb-16">
    <div class="text-center max-w-2xl mx-auto mb-8">
        <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3.5 py-1 rounded-full border border-purple-200">Explore Content</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81] mt-2">Discover The 800BYPD World</h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Books Card -->
        <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-[#7C3AED] text-white rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-book-half"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md mb-2 inline-block">Physical Books</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Storybooks</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Hardcover and paperback illustrated books written by PD.</p>
            </div>
            <span class="text-xs font-extrabold text-[#7C3AED] flex items-center gap-1 group-hover:translate-x-1 transition">Browse Books <i class="bi bi-chevron-right text-[10px]"></i></span>
        </a>

        <!-- Audios Card -->
        <a href="{{ route('audios.index') }}" class="bg-white border-2 border-purple-100 hover:border-[#7C3AED] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-[#312E81] text-[#FACC15] rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-spotify"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#312E81] bg-purple-50 px-2.5 py-1 rounded-md mb-2 inline-block">Audio & Podcasts</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Audios</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Bedtime audiobooks & story episodes streaming on Spotify.</p>
            </div>
            <span class="text-xs font-extrabold text-[#312E81] flex items-center gap-1 group-hover:translate-x-1 transition">Listen to Audios <i class="bi bi-chevron-right text-[10px]"></i></span>
        </a>

        <!-- Puzzles Card -->
        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="bg-white border-2 border-amber-100 hover:border-[#FACC15] p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-[#FACC15] text-[#312E81] rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-puzzle-fill"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md mb-2 inline-block">Brain Games</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Jigsaw Puzzles</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Floor puzzles designed to build problem-solving & critical thinking.</p>
            </div>
            <span class="text-xs font-extrabold text-amber-800 flex items-center gap-1 group-hover:translate-x-1 transition">Browse Puzzles <i class="bi bi-chevron-right text-[10px]"></i></span>
        </a>

        <!-- Colouring Books Card -->
        <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="bg-white border-2 border-pink-100 hover:border-pink-500 p-6 rounded-3xl shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-pink-500 text-white rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition shadow">
                    <i class="bi bi-palette-fill"></i>
                </div>
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-pink-700 bg-pink-50 px-2.5 py-1 rounded-md mb-2 inline-block">Art & Doodle</span>
                <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">Colouring Books</h3>
                <p class="text-xs text-slate-500 leading-relaxed mb-4">Doodle & mindfulness books with bleed-resistant pages.</p>
            </div>
            <span class="text-xs font-extrabold text-pink-700 flex items-center gap-1 group-hover:translate-x-1 transition">Browse Colouring <i class="bi bi-chevron-right text-[10px]"></i></span>
        </a>
    </div>
</div>

<!-- 3. Books Section -->
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">Category: Books</span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">Children's Story Books</h2>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Books <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @forelse($books as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <div class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 cursor-pointer" 
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
                                <i class="bi bi-book-half text-5xl text-[#FACC15] mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800BYPD Publication</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-[#FACC15] text-[#312E81] text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">Storybook</span>
                    </div>

                    <div class="p-6">
                        <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">PD</span>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0 flex items-center justify-between mt-auto">
                    <div>
                        <span class="text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
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
                        class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5">
                        <i class="bi bi-bag-fill text-[#FACC15]"></i> Add
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-8 text-center text-slate-500 bg-white border border-purple-100 rounded-3xl">
                <p class="font-bold text-sm">No books available right now.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- 4. Audios Section -->
<div class="mb-16 bg-gradient-to-br from-[#312E81] to-purple-950 text-white rounded-3xl sm:rounded-[2.5rem] p-8 sm:p-12 border-4 border-[#FACC15] shadow-xl">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-700/50 pb-4">
        <div>
            <span class="bg-[#FACC15] text-[#312E81] font-black text-xs px-3.5 py-1 rounded-full uppercase tracking-wider inline-flex items-center gap-1.5">
                <i class="bi bi-spotify text-[#7C3AED]"></i> Spotify Companion
            </span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-white mt-2">Audiobooks & Story Podcasts</h2>
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
                    <span class="text-[10px] font-bold text-[#FACC15] uppercase tracking-wide">Narrated by PD</span>
                    <h3 class="font-whimsical font-bold text-white text-lg mb-1">{{ $audio->name }}</h3>
                    <p class="text-xs text-purple-200 line-clamp-2 mb-3">{{ $audio->description }}</p>
                    <button onclick="openSpotifyModal()" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold text-xs px-4 py-2 rounded-full inline-flex items-center gap-1.5 transition">
                        <i class="bi bi-play-fill text-sm"></i> Listen Now
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full py-8 text-center text-purple-200">
                <p class="font-bold text-sm">No audio tracks listed yet.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- 5. Other Products Section (e.g. Joggers & Apparel) -->
@if(count($otherProducts) > 0)
<div class="mb-16">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 mb-8 border-b border-purple-100 pb-4">
        <div>
            <span class="text-[#7C3AED] font-extrabold text-xs uppercase tracking-wider bg-purple-50 px-3 py-1 rounded-full border border-purple-200">Apparel & Merch</span>
            <h2 class="font-whimsical font-bold text-2xl sm:text-3xl text-[#312E81] mt-2">800BYPD Other Products</h2>
        </div>
        <a href="{{ route('catalog.index', ['category' => 'other-products']) }}" class="text-xs font-extrabold text-[#7C3AED] hover:underline flex items-center gap-1">
            View All Apparel <i class="bi bi-arrow-right text-[10px]"></i>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
        @foreach($otherProducts as $product)
            <div class="bg-white border border-purple-100 rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition duration-300 group flex flex-col justify-between">
                <div>
                    <div class="h-56 sm:h-64 bg-purple-50/60 relative overflow-hidden flex items-center justify-center border-b border-slate-100 cursor-pointer" 
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-saleprice="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock_quantity }}"
                        data-desc="{{ $product->description }}"
                        data-category="{{ $product->category->name ?? 'Merch' }}"
                        data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                        onclick="triggerQuickAddFromBtn(this)">
                        @if($product->primaryImage)
                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="text-center p-6">
                                <i class="bi bi-bag-check-fill text-5xl text-[#7C3AED] mb-2"></i>
                                <span class="block text-[11px] font-black text-slate-400">800BYPD Apparel</span>
                            </div>
                        @endif
                        <span class="absolute top-4 left-4 bg-[#7C3AED] text-white text-[10px] font-extrabold px-3 py-1 rounded-full uppercase shadow-sm">Cozy Wear</span>
                    </div>

                    <div class="p-6">
                        <span class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-1 rounded-md inline-block mb-3">Children Apparel</span>
                        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-2 line-clamp-1">
                            <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-[#7C3AED] transition">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed mb-4">{{ $product->description }}</p>
                    </div>
                </div>

                <div class="p-6 pt-0 flex items-center justify-between mt-auto">
                    <div>
                        <span class="text-2xl font-extrabold text-[#312E81] price-convertible" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                    </div>
                    
                    <button type="button" 
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                        data-saleprice="{{ $product->sale_price }}"
                        data-stock="{{ $product->stock_quantity }}"
                        data-desc="{{ $product->description }}"
                        data-category="{{ $product->category->name ?? 'Merch' }}"
                        data-image="{{ $product->primaryImage ? $product->primaryImage->image_path : '' }}"
                        onclick="triggerQuickAddFromBtn(this)"
                        class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] text-xs font-extrabold px-5 py-2.5 rounded-full flex items-center gap-1.5 shadow-md transition transform hover:-translate-y-0.5">
                        <i class="bi bi-bag-fill text-[#FACC15]"></i> Add
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

<!-- 6. About / Author / Brand Section -->
<div class="bg-gradient-to-r from-[#312E81] via-purple-900 to-[#312E81] text-white rounded-3xl sm:rounded-[2.5rem] p-6 sm:p-10 md:p-14 mb-14 sm:mb-16 shadow-xl border-4 border-[#FACC15] flex flex-col md:flex-row items-center gap-6 sm:gap-9 text-center md:text-left">
    <div class="w-32 h-32 md:w-44 md:h-44 bg-[#FACC15] text-[#312E81] rounded-full flex items-center justify-center font-whimsical font-bold text-4xl sm:text-5xl shadow-2xl flex-shrink-0 border-4 border-white">
        <i class="bi bi-pen-fill text-[#7C3AED]"></i>
    </div>
    <div>
        <span class="bg-[#FACC15] text-[#312E81] font-black text-[11px] px-3.5 py-1 rounded-full uppercase tracking-wider mb-3 inline-block">Meet The Author</span>
        <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-white mb-3">PD</h2>
        <p class="text-xs md:text-sm text-purple-100 leading-relaxed mb-5 font-medium">
            "Every story we publish and every audio tale we record is crafted to inspire courage, empathy, and creative curiosity in children. 800BYPD brings physical books and digital audio together for young growing minds."
        </p>
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 sm:gap-5 text-xs font-bold text-[#FACC15]">
            <span><i class="bi bi-geo-alt-fill text-[#FACC15] mr-1"></i> Based in Lagos, Nigeria</span>
            <span><i class="bi bi-spotify text-purple-300 mr-1"></i> Spotify Audiobook Creator</span>
        </div>
    </div>
</div>

<!-- 7. Call To Action (CTA) Section -->
<div class="bg-purple-50 border-2 border-purple-200/80 rounded-3xl sm:rounded-[2.5rem] p-8 sm:p-12 text-center max-w-4xl mx-auto shadow-sm">
    <span class="bg-[#7C3AED] text-white font-extrabold text-xs px-4 py-1.5 rounded-full uppercase tracking-wider mb-4 inline-block">
        Start Exploring Today
    </span>
    <h2 class="font-whimsical font-bold text-2xl sm:text-4xl text-[#312E81] mb-4">
        Ready to Bring Stories to Life for Your Child?
    </h2>
    <p class="text-slate-600 text-xs sm:text-sm max-w-xl mx-auto mb-8 leading-relaxed font-medium">
        Order storybooks, puzzles, and apparel with fast 1-3 day delivery across Nigeria, or stream bedtime stories on Spotify.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="{{ route('catalog.index') }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-8 py-4 rounded-full shadow-lg transition text-xs uppercase tracking-wider">
            Shop Full Catalog
        </a>
        <a href="{{ route('audios.index') }}" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-8 py-4 rounded-full shadow-lg transition text-xs uppercase tracking-wider">
            Listen on Spotify
        </a>
    </div>
</div>

@endsection
