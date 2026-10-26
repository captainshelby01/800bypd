<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>800BYPD - Faith-Based Children's Books, Scripture Puzzles & Learning by PD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-whimsical { font-family: 'Fredoka', cursive, sans-serif; }
    </style>
</head>
<body class="bg-[#FFFDF9] text-slate-800 flex flex-col min-h-screen">

    <!-- Top Announcement Strip -->
    <!-- <div class="bg-[#2D1B4E] text-[#FDE68A] text-xs font-semibold py-2.5 px-4 border-b border-amber-500/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide">800 by PD Store</span>
                <span>✨ Fast Delivery Across Lagos (1-3 Days) & All States in Nigeria!</span>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold"> -->
                <!-- Spotify Channel Modal Trigger -->
                <!-- <button onclick="openSpotifyModal()" class="hover:text-white transition flex items-center gap-1.5 text-emerald-400 font-bold">
                    <i class="bi bi-spotify text-sm"></i> Spotify Audiobooks
                </button> -->

                <!-- Multi-Currency Switcher -->
                <!-- <div class="flex items-center gap-1 bg-[#1F1235] px-3 py-1 rounded-full border border-purple-800/50">
                    <i class="bi bi-coin text-amber-400 text-[11px]"></i>
                    <select id="currencySelector" onchange="changeCurrency(this.value)" class="bg-transparent text-amber-200 font-bold focus:outline-none cursor-pointer text-xs">
                        <option value="NGN" class="bg-[#2D1B4E] text-amber-200">🇳🇬 NGN (₦)</option>
                        <option value="USD" class="bg-[#2D1B4E] text-amber-200">🇺🇸 USD ($)</option>
                        <option value="GBP" class="bg-[#2D1B4E] text-amber-200">🇬🇧 GBP (£)</option>
                        <option value="EUR" class="bg-[#2D1B4E] text-amber-200">🇪🇺 EUR (€)</option>
                    </select>
                </div>
            </div>
        </div>
    </div> -->

    <!-- Main Navigation Bar -->
    <header class="bg-[#FFFDF9]/90 backdrop-blur-md sticky top-0 z-40 border-b border-amber-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group flex-shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-[#FBBF24] text-[#2D1B4E] rounded-2xl flex items-center justify-center font-whimsical font-bold text-xl sm:text-2xl shadow-md rotate-2 group-hover:rotate-0 transition duration-300">
                    8
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-whimsical text-xl sm:text-2xl font-bold text-[#2D1B4E]">800BY<span class="text-amber-500">PD</span></span>
                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest">Faith & Learning for Kids</span>
                </div>
            </a>

            <!-- Desktop Navigation Links (Option 1: Clean Categories Dropdown + Highlighted Bundles) -->
            <nav class="hidden lg:flex items-center gap-3 xl:gap-6 text-xs font-bold text-slate-700 tracking-wide flex-shrink-0">
                <!-- 1. Home -->
                <a href="{{ route('home') }}" class="hover:text-[#7C3AED] transition flex items-center gap-1.5 py-2">
                    <i class="bi bi-house-door-fill text-slate-400 hover:text-[#7C3AED]"></i>
                    <span>Home</span>
                </a>

                <!-- 2. Shop Categories Dropdown -->
                <div class="relative group">
                    <button type="button" class="flex items-center gap-1.5 py-2 hover:text-[#7C3AED] transition text-slate-800 font-bold focus:outline-none">
                        <span>Shop Categories</span>
                        <i class="bi bi-chevron-down text-[10px] text-slate-400 group-hover:rotate-180 group-hover:text-[#7C3AED] transition-transform duration-200"></i>
                    </button>

                    <!-- Dropdown Menu Card -->
                    <div class="absolute left-0 top-full pt-2 w-72 hidden group-hover:block z-50 transition-all duration-200">
                        <div class="bg-white rounded-3xl shadow-2xl border border-purple-200/90 p-3 space-y-1 text-xs font-medium">
                            <div class="px-3 pt-2 pb-1 text-[10px] font-black uppercase tracking-wider text-slate-400">
                                Product Collections
                            </div>

                            <!-- Jigsaw Puzzles -->
                            <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-purple-50 transition group/item">
                                <div class="w-9 h-9 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg flex-shrink-0 group-hover/item:scale-105 transition">
                                    <i class="bi bi-puzzle-fill"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block group-hover/item:text-[#7C3AED]">Jigsaw Puzzles</span>
                                    <span class="text-[10px] text-slate-400 block font-normal">Easy (6 pcs) & 12 pieces</span>
                                </div>
                            </a>

                            <!-- Coloring Books -->
                            <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-purple-50 transition group/item">
                                <div class="w-9 h-9 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg flex-shrink-0 group-hover/item:scale-105 transition">
                                    <i class="bi bi-palette-fill"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block group-hover/item:text-[#7C3AED]">Coloring Books</span>
                                    <span class="text-[10px] text-slate-400 block font-normal">Creative doodle & bleed-free pages</span>
                                </div>
                            </a>

                            <!-- Flashcards -->
                            <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-purple-50 transition group/item">
                                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg flex-shrink-0 group-hover/item:scale-105 transition">
                                    <i class="bi bi-card-text"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block group-hover/item:text-[#7C3AED]">Flashcards</span>
                                    <span class="text-[10px] text-slate-400 block font-normal">Pocket & Big learning sizes</span>
                                </div>
                            </a>

                            <!-- Storybooks -->
                            <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="flex items-center gap-3 p-2.5 rounded-2xl hover:bg-purple-50 transition group/item">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0 group-hover/item:scale-105 transition">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block group-hover/item:text-[#7C3AED]">Storybooks</span>
                                    <span class="text-[10px] text-slate-400 block font-normal">Illustrated bedtime adventures</span>
                                </div>
                            </a>

                            <!-- Divider & All Products -->
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="{{ route('catalog.index') }}" class="flex items-center justify-between p-2.5 rounded-2xl hover:bg-purple-50 text-[#7C3AED] font-bold transition">
                                <span class="flex items-center gap-2">
                                    <i class="bi bi-grid-fill"></i> View All Products
                                </span>
                                <i class="bi bi-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- 3. Buy Bundles -->
                <a href="{{ route('bundles.index') }}" class="bg-purple-100/70 hover:bg-purple-200/80 text-[#312E81] px-3.5 py-1.5 rounded-full font-black flex items-center gap-1.5 transition border border-purple-200 shadow-2xs">
                    <i class="bi bi-box2-heart-fill text-[#7C3AED]"></i>
                    <span>Buy Bundles</span>
                </a>

                <!-- 4. Spotify Audios -->
                <a href="{{ route('audios.index') }}" class="hover:text-[#7C3AED] transition flex items-center gap-1.5 py-2">
                    <i class="bi bi-spotify text-emerald-500"></i>
                    <span>Audios</span>
                </a>
            </nav>

            <!-- Search, Cart & User Menu -->
            <div class="flex items-center gap-2 sm:gap-2.5 flex-shrink-0">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative hidden 2xl:block">
                    <input type="text" name="search" placeholder="Search books, audios..." class="w-36 xl:w-44 pl-8 pr-3 py-2 border border-purple-200/80 bg-purple-50/30 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-[#7C3AED]">
                    <i class="bi bi-search absolute left-3 top-2.5 text-[#7C3AED] text-xs"></i>
                </form>

                @php
                    $sessionCart = session('cart', []);
                    $boxItemsTotal = 0;
                    $cartSubtotalVal = 0;
                    foreach ($sessionCart as $cartItm) {
                        $units = isset($cartItm['box_units_per_item']) ? (int)$cartItm['box_units_per_item'] : 1;
                        $q = isset($cartItm['quantity']) ? (int)$cartItm['quantity'] : 1;
                        $boxItemsTotal += ($units * $q);
                        $cartSubtotalVal += (($cartItm['price'] ?? 0) * $q);
                    }
                    $minBoxReq = \App\Models\Setting::get('checkout_min_order_quantity', 3);
                @endphp
                <a href="{{ route('cart.index') }}" class="relative bg-[#312E81] hover:bg-indigo-950 text-white px-3 sm:px-3.5 py-2 rounded-full font-bold text-xs flex items-center gap-1.5 shadow-md transition flex-shrink-0" title="Fill Your Box ({{ $boxItemsTotal }}/{{ $minBoxReq }} items)">
                    <i class="bi bi-box-seam-fill text-sm text-[#FACC15]"></i>
                    <span class="hidden sm:inline">My Box</span>
                    <span id="cartCountBadge" class="bg-[#FACC15] text-[#312E81] font-black px-2 py-0.5 rounded-full text-[10px]">{{ $boxItemsTotal }}</span>
                    @if($boxItemsTotal > 0 && $boxItemsTotal < $minBoxReq)
                        <span class="hidden md:inline text-[9px] bg-amber-400/20 text-amber-200 border border-amber-300/30 px-1.5 py-0.5 rounded-md font-extrabold">
                            {{ $minBoxReq - $boxItemsTotal }} more
                        </span>
                    @elseif($boxItemsTotal >= $minBoxReq)
                        <span class="hidden md:inline text-[9px] bg-emerald-400/20 text-emerald-300 border border-emerald-300/30 px-1.5 py-0.5 rounded-md font-extrabold">
                            Full 🎉
                        </span>
                    @endif
                </a>

                @auth
                    <div class="relative group hidden sm:block flex-shrink-0">
                        <a href="{{ in_array(auth()->user()->role, ['admin', 'staff']) ? route('admin.dashboard') : route('account.dashboard') }}" class="bg-purple-100 hover:bg-purple-200 text-[#312E81] px-3 sm:px-3.5 py-2 rounded-full font-bold text-xs flex items-center gap-1.5 transition border border-purple-300/60 shadow-sm">
                            <i class="bi bi-person-circle text-sm text-[#7C3AED] flex-shrink-0"></i>
                            <span class="truncate max-w-[80px] md:max-w-[100px] inline-block font-bold">{{ explode(' (', auth()->user()->name)[0] }}</span>
                            <i class="bi bi-chevron-down text-[10px] text-slate-500 flex-shrink-0"></i>
                        </a>
                        <div class="absolute right-0 mt-1 w-52 bg-white rounded-2xl shadow-xl border border-purple-200 py-2 hidden group-hover:block z-50 text-xs font-semibold">
                            @if(in_array(auth()->user()->role, ['admin', 'staff']))
                                <div class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Admin Controls</div>
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-purple-50 text-[#7C3AED] font-bold"><i class="bi bi-speedometer2 mr-2 text-[#7C3AED]"></i> Overview Dashboard</a>
                                <a href="{{ route('admin.verifications') }}" class="block px-4 py-2 hover:bg-purple-50 text-slate-700 font-medium"><i class="bi bi-receipt mr-2 text-amber-600"></i> Orders & Receipts</a>
                                <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 hover:bg-purple-50 text-slate-700 font-medium"><i class="bi bi-journal-bookmark-fill mr-2 text-indigo-600"></i> Products</a>
                                <div class="border-t border-slate-100 my-1"></div>
                                <div class="px-4 py-1 text-[10px] font-black uppercase tracking-wider text-slate-400">Personal</div>
                                <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 hover:bg-purple-50 text-slate-700 font-medium"><i class="bi bi-person-badge mr-2 text-slate-500"></i> Customer Portal</a>
                            @else
                                <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 hover:bg-purple-50 text-slate-800 font-bold"><i class="bi bi-speedometer2 mr-2 text-[#7C3AED]"></i> Dashboard</a>
                                <a href="{{ route('account.orders') }}" class="block px-4 py-2 hover:bg-purple-50 text-slate-800"><i class="bi bi-archive-fill mr-2 text-amber-600"></i> Order History</a>
                            @endif
                            <div class="border-t border-slate-100 my-1"></div>
                            <form action="{{ route('account.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-700 font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex bg-purple-100/80 hover:bg-purple-200 text-[#312E81] px-4 py-2.5 rounded-full text-xs font-extrabold transition border border-purple-300/60 items-center gap-1.5 flex-shrink-0">
                        <i class="bi bi-person-fill text-[#7C3AED] text-sm"></i> Log In
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button id="mobileMenuBtn" onclick="toggleMobileMenu(event)" class="lg:hidden bg-purple-100 hover:bg-purple-200 text-[#312E81] w-10 h-10 rounded-full flex items-center justify-center text-xl transition border border-purple-300/60 focus:outline-none">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer Overlay (Option 1: Arranged in Clear Order) -->
        <div id="mobileMenuDrawer" class="hidden lg:hidden bg-[#F5F3FF] border-t border-purple-200/80 px-4 pt-4 pb-6 space-y-4 shadow-xl">
            <form action="{{ route('catalog.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search books, audios..." class="w-full pl-9 pr-4 py-2.5 border border-purple-200 bg-white rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-[#7C3AED]">
                <i class="bi bi-search absolute left-3 top-3 text-[#7C3AED] text-xs"></i>
            </form>

            <nav class="flex flex-col space-y-2 text-xs font-extrabold text-slate-800 border-b border-purple-200 pb-4">
                <!-- 1. Home -->
                <a href="{{ route('home') }}" class="p-2.5 rounded-xl hover:bg-white transition flex items-center gap-2.5 text-slate-700">
                    <i class="bi bi-house-door-fill text-[#7C3AED] text-sm"></i>
                    <span>Home</span>
                </a>

                <!-- 2. Buy Bundles (Highlighted Banner) -->
                <a href="{{ route('bundles.index') }}" class="p-3 rounded-2xl bg-gradient-to-r from-purple-100 via-amber-50 to-amber-100 border border-purple-200/80 text-[#312E81] font-black transition flex items-center justify-between shadow-2xs">
                    <span class="flex items-center gap-2">
                        <i class="bi bi-box2-heart-fill text-[#7C3AED] text-base"></i>
                        <span>Buy Our Bundles</span>
                    </span>
                    <span class="bg-[#312E81] text-[#FACC15] text-[10px] font-black px-2 py-0.5 rounded-full uppercase">Curated</span>
                </a>

                <!-- 3. All Products Catalog -->
                <a href="{{ route('catalog.index') }}" class="p-2.5 rounded-xl hover:bg-white transition flex items-center justify-between text-slate-700">
                    <span class="flex items-center gap-2.5">
                        <i class="bi bi-grid-fill text-[#7C3AED] text-sm"></i>
                        <span>All Products Catalog</span>
                    </span>
                    <i class="bi bi-chevron-right text-[10px] text-slate-400"></i>
                </a>

                <!-- 4. Collections 2x2 Grid -->
                <div class="pt-2">
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400 px-2.5 block mb-1.5">
                        Collections & Categories
                    </span>
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="p-2.5 rounded-xl bg-white border border-purple-100 hover:border-purple-300 transition flex items-center gap-2">
                            <i class="bi bi-puzzle-fill text-amber-500 text-base"></i>
                            <div class="leading-tight">
                                <span class="block text-slate-800 font-bold text-[11px]">Puzzles</span>
                                <span class="text-[9px] text-slate-400">6 & 12 pcs</span>
                            </div>
                        </a>
                        <a href="{{ route('catalog.index', ['category' => 'coloring-books']) }}" class="p-2.5 rounded-xl bg-white border border-purple-100 hover:border-purple-300 transition flex items-center gap-2">
                            <i class="bi bi-palette-fill text-pink-500 text-base"></i>
                            <div class="leading-tight">
                                <span class="block text-slate-800 font-bold text-[11px]">Coloring</span>
                                <span class="text-[9px] text-slate-400">Doodle Books</span>
                            </div>
                        </a>
                        <a href="{{ route('catalog.index', ['category' => 'flashcards']) }}" class="p-2.5 rounded-xl bg-white border border-purple-100 hover:border-purple-300 transition flex items-center gap-2">
                            <i class="bi bi-card-text text-indigo-500 text-base"></i>
                            <div class="leading-tight">
                                <span class="block text-slate-800 font-bold text-[11px]">Flashcards</span>
                                <span class="text-[9px] text-slate-400">Pocket & Big</span>
                            </div>
                        </a>
                        <a href="{{ route('catalog.index', ['category' => 'storybooks']) }}" class="p-2.5 rounded-xl bg-white border border-purple-100 hover:border-purple-300 transition flex items-center gap-2">
                            <i class="bi bi-book-half text-emerald-500 text-base"></i>
                            <div class="leading-tight">
                                <span class="block text-slate-800 font-bold text-[11px]">Storybooks</span>
                                <span class="text-[9px] text-slate-400">Bedtime Tales</span>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- 5. Spotify Audios -->
                <a href="{{ route('audios.index') }}" class="p-2.5 rounded-xl hover:bg-white transition flex items-center gap-2.5 text-slate-700">
                    <i class="bi bi-spotify text-emerald-500 text-base"></i>
                    <span>Spotify Storytime Audios</span>
                </a>
            </nav>

            <div class="pt-1">
                @auth
                    <div class="space-y-2 text-xs font-bold">
                        <div class="text-slate-500 text-[11px]">Logged in as: <strong class="text-slate-800">{{ auth()->user()->name }}</strong></div>
                        @if(in_array(auth()->user()->role, ['admin', 'staff']))
                            <a href="{{ route('admin.dashboard') }}" class="block bg-purple-600 text-white p-3 rounded-2xl shadow font-extrabold"><i class="bi bi-speedometer2 mr-2 text-[#FACC15]"></i> Admin Overview Dashboard</a>
                            <a href="{{ route('admin.verifications') }}" class="block bg-amber-100 text-amber-900 p-3 rounded-2xl border border-amber-200 font-extrabold"><i class="bi bi-receipt text-amber-600 mr-2"></i> Orders & Payment Receipts</a>
                        @endif
                        <a href="{{ route('account.dashboard') }}" class="block bg-white p-3 rounded-2xl border border-purple-200 text-[#312E81]"><i class="bi bi-person-badge text-[#7C3AED] mr-2"></i> Customer Portal</a>
                        <a href="{{ route('account.orders') }}" class="block bg-white p-3 rounded-2xl border border-purple-200 text-[#312E81]"><i class="bi bi-archive-fill text-amber-600 mr-2"></i> My Order History</a>
                        <form action="{{ route('account.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left bg-rose-50 text-rose-700 p-3 rounded-2xl font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <a href="{{ route('login') }}" class="bg-[#312E81] text-[#FACC15] font-extrabold py-3 rounded-2xl text-center shadow">Log In</a>
                        <a href="{{ route('register') }}" class="bg-purple-100 text-[#312E81] font-extrabold py-3 rounded-2xl text-center border border-purple-300">Create Account</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    @if(request()->routeIs('home'))
    <!-- Spotify Storytime Banner (Homepage Only) -->
    <div class="bg-gradient-to-r from-[#7C3AED] via-purple-700 to-[#312E81] text-white text-xs font-semibold py-2.5 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <i class="bi bi-spotify text-[#FACC15] text-base flex-shrink-0"></i>
                <span>🎧 <strong>Spotify Storytime Companion:</strong> Listen to 800BYPD children's audiobooks & podcasts narrated by PD!</span>
            </div>
            <a href="{{ route('audios.index') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold px-3.5 py-1 rounded-full text-[11px] transition shadow flex-shrink-0">
                Explore Audios <i class="bi bi-play-fill ml-0.5"></i>
            </a>
        </div>
    </div>
    @endif

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
        @if(session('success'))
            <div class="bg-purple-50 border border-purple-300 text-purple-900 px-4 py-3 rounded-2xl relative mb-4 text-xs font-semibold flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-base text-[#7C3AED]"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-2xl relative mb-4 text-xs font-semibold flex items-center gap-2">
                <i class="bi bi-exclamation-circle-fill text-base text-rose-600"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Floating Cart Bar (Accessible While Browsing across all mobile devices) -->
    <div id="floatingCartBar" class="{{ $boxItemsTotal > 0 ? '' : 'hidden' }} fixed bottom-4 left-3 sm:bottom-6 sm:left-6 z-40 max-w-[calc(100vw-5.5rem)] sm:max-w-none transition-all duration-300">
        <div class="bg-[#312E81] text-white px-3.5 sm:px-5 py-2 sm:py-3 rounded-full shadow-2xl border-2 border-[#FACC15] flex items-center gap-2.5 sm:gap-4 backdrop-blur-md">
            <div class="flex items-center gap-2 sm:gap-2.5">
                <div class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-[#FACC15] text-[#312E81] flex items-center justify-center font-bold text-xs sm:text-sm shadow flex-shrink-0">
                    <i class="bi bi-box-seam-fill"></i>
                </div>
                <div>
                    <div class="text-[8px] sm:text-[9px] text-purple-200 uppercase font-black tracking-wider leading-none">Your Box</div>
                    <div class="text-[11px] sm:text-xs font-black leading-tight mt-0.5 whitespace-nowrap">
                        <span id="floatingCartItemCount">{{ $boxItemsTotal }}</span>
                        <span id="floatingCartItemLabel">{{ $boxItemsTotal === 1 ? 'Item' : 'Items' }}</span>
                        <span class="text-purple-300 font-normal">·</span>
                        <span id="floatingCartSubtotal" class="text-[#FACC15] price-convertible" data-price-ngn="{{ $cartSubtotalVal }}">₦{{ number_format($cartSubtotalVal, 2) }}</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('cart.index') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold text-[11px] sm:text-xs px-3 sm:px-4 py-1.5 sm:py-2 rounded-full shadow transition flex items-center gap-1 whitespace-nowrap">
                <span>View Box</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>

    @if(request()->routeIs('home'))
        <!-- 6.2 Scroll to Top Button (Homepage Only, positioned safely above WhatsApp across all mobile viewports) -->
        <button id="scrollToTopBtn" onclick="window.scrollTo({top: 0, behavior: 'smooth'})" class="fixed bottom-20 right-3.5 sm:bottom-24 sm:right-6 z-40 bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] w-10 h-10 sm:w-12 sm:h-12 rounded-full shadow-2xl border-2 border-[#FACC15] hidden items-center justify-center text-lg sm:text-xl transition transform hover:scale-110 focus:outline-none" title="Scroll to top">
            <i class="bi bi-arrow-up font-bold"></i>
        </button>
    @endif

    <!-- Floating WhatsApp Support Button (+2348164254442) -->
    <a href="https://wa.me/2348164254442?text=Hello%20800byPD!%20I%20have%20a%20question%20about%20your%20children%27s%20books%20and%20puzzles." target="_blank" class="fixed bottom-4 right-3.5 sm:bottom-6 sm:right-6 z-50 bg-[#7C3AED] hover:bg-purple-800 text-white rounded-full p-3 sm:p-3.5 md:p-4 shadow-2xl flex items-center justify-center gap-2 group transition transform hover:scale-105 border-2 border-[#FACC15]">
        <i class="bi bi-whatsapp text-xl sm:text-2xl text-[#FACC15]"></i>
        <span class="hidden group-hover:inline text-xs font-extrabold pr-2">Chat with 800byPD</span>
    </a>

    <!-- Nourishark-Style Quick-Add Product Modal Popup -->
    <div id="quickAddModal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full border border-purple-200/80 shadow-2xl overflow-hidden relative">
            <!-- Close Button -->
            <button onclick="closeQuickAddModal()" class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-slate-900/60 text-white flex items-center justify-center hover:bg-slate-900 transition shadow">
                <i class="bi bi-x-lg text-sm"></i>
            </button>

            <!-- Product Header Image (Uncropped, text never cut off) -->
            <div class="h-60 sm:h-64 bg-gradient-to-b from-purple-50/80 via-indigo-50/20 to-white relative overflow-hidden flex items-center justify-center p-3 border-b border-slate-100">
                <img id="quickAddImage" src="" alt="Product Cover" class="max-h-full max-w-full object-contain drop-shadow-md" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                <div id="quickAddPlaceholderIcon" class="hidden text-center p-6">
                    <i class="bi bi-book-half text-6xl text-[#FACC15] mb-2"></i>
                    <span class="block text-xs font-bold text-slate-400">800byPD Original</span>
                </div>
            </div>

            <!-- Product Info & Stepper Controls -->
            <div class="p-6 space-y-4">
                <div>
                    <span id="quickAddCategory" class="text-[10px] font-extrabold text-[#7C3AED] uppercase tracking-wide bg-purple-50 px-2.5 py-0.5 rounded-md inline-block mb-1">Category</span>
                    <h3 id="quickAddTitle" class="font-whimsical font-bold text-slate-900 text-2xl leading-tight">Product Title</h3>
                    <p id="quickAddDescription" class="text-xs text-slate-500 line-clamp-2 mt-1"></p>
                </div>

                <!-- Stock Indicator -->
                <div class="flex items-center gap-2">
                    <span id="quickAddStock" class="bg-purple-100 text-[#7C3AED] text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">In Stock</span>
                </div>

                <!-- Quantity Stepper & Add Button Row -->
                <div class="pt-2 flex items-center gap-3">
                    <!-- Quantity Stepper (- 1 +) -->
                    <div class="flex items-center bg-purple-50 p-1 rounded-full border border-purple-200 text-xs font-bold">
                        <button type="button" onclick="changeModalQty(-1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-purple-100 transition flex items-center justify-center text-sm shadow-sm">-</button>
                        <span id="quickAddQtyDisplay" class="w-8 text-center text-slate-900 text-sm font-extrabold">1</span>
                        <button type="button" onclick="changeModalQty(1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-purple-100 transition flex items-center justify-center text-sm shadow-sm">+</button>
                    </div>

                    <!-- Add Button with dynamic price -->
                    <button type="button" onclick="submitQuickAddModal()" id="quickAddSubmitBtn" class="flex-1 bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-3.5 px-5 rounded-full shadow-lg transition flex items-center justify-center gap-2 text-xs">
                        <i class="bi bi-box-seam text-[#FACC15] text-sm"></i>
                        <span>Add to Box</span>
                        <span id="quickAddBtnPriceDisplay" class="price-convertible font-black" data-price-ngn="0">₦0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Toast Notification -->
    <div id="toastNotification" class="fixed top-20 right-6 z-50 hidden bg-[#312E81] text-white px-5 py-3 rounded-2xl shadow-2xl border border-[#FACC15]/40 text-xs font-bold flex items-center gap-2 transition">
        <i class="bi bi-check-circle-fill text-[#FACC15] text-base"></i>
        <span id="toastMessage">Product added to cart!</span>
    </div>

    <!-- Spotify Channel Popup Modal -->
    <div id="spotifyModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full border border-purple-200 shadow-2xl relative">
            <button onclick="closeSpotifyModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="text-center mb-5">
                <div class="w-14 h-14 bg-purple-100 text-[#7C3AED] rounded-full flex items-center justify-center text-2xl mx-auto mb-2">
                    <i class="bi bi-spotify"></i>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-2xl">Spotify Audio Channel</h3>
                <p class="text-xs text-slate-500 mt-1">Listen to bedtime story audiobooks and podcasts narrated by PD.</p>
            </div>

            <!-- Spotify Player Widget -->
            <div class="bg-[#1F1235] text-white p-4 rounded-2xl mb-5 border border-[#A78BFA]/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-[#FACC15] text-[#312E81] rounded-xl flex items-center justify-center font-whimsical font-bold text-xl">800</div>
                    <div class="text-left">
                        <h4 class="font-bold text-xs text-white">Bedtime Stories</h4>
                        <span class="text-[10px] text-[#A78BFA] font-semibold">Narrated by PD</span>
                    </div>
                </div>
                <div class="bg-purple-900/60 rounded-full h-1.5 w-full mb-2">
                    <div class="bg-[#FACC15] h-1.5 rounded-full w-2/3"></div>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-[10px] text-purple-300">03:12 / 09:45</span>
                    <div class="space-x-3 text-sm flex items-center text-[#FACC15]">
                        <i class="bi bi-skip-backward-fill cursor-pointer hover:text-white"></i>
                        <i class="bi bi-play-circle-fill text-2xl cursor-pointer hover:scale-110"></i>
                        <i class="bi bi-skip-forward-fill cursor-pointer hover:text-white"></i>
                    </div>
                </div>
            </div>

            <a href="https://open.spotify.com" target="_blank" class="w-full bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg">
                Open Spotify App <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
    </div>

    @if(!request()->routeIs('catalog.show'))
    <!-- Footer (Omitted on product details page per requirement 3.2) -->
    <footer class="bg-[#312E81] text-purple-100 mt-20 py-14 border-t-4 border-[#FACC15]">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-9 text-xs">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-[#FACC15] text-[#312E81] rounded-xl flex items-center justify-center font-whimsical font-bold text-xl">8</div>
                    <span class="font-whimsical text-2xl font-bold text-white">800by<span class="text-[#FACC15]">PD</span></span>
                </div>
                <p class="text-purple-200 leading-relaxed mb-3">A faith-based children's bookstore and audio workshop created by <strong>PD</strong>. Nurturing young hearts in God's love, character, and wisdom through scripture puzzles, biblical affirmations, illustrated storybooks, and audio episodes.</p>
                <p class="text-[#FACC15] font-bold"><i class="bi bi-geo-alt-fill mr-1"></i> Based in Lagos, Nigeria</p>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Customer Care & Delivery</h4>
                <ul class="space-y-2.5 text-purple-200">
                    <li><i class="bi bi-whatsapp text-[#FACC15] mr-2 text-sm"></i> WhatsApp: +234 816 425 4442</li>
                    <li><i class="bi bi-envelope-fill text-[#A78BFA] mr-2 text-sm"></i> Email: 800bypd@gmail.com</li>
                    <li><i class="bi bi-truck text-purple-300 mr-2 text-sm"></i> Lagos: 1–2 Days Flat (₦2,500)</li>
                    <li><i class="bi bi-send-check text-amber-300 mr-2 text-sm"></i> Nationwide: 3–5 Days Tracked (₦4,000)</li>
                    <li><i class="bi bi-shield-check text-emerald-400 mr-2 text-sm"></i> 7-Day Damaged Piece Replacement</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Secure Checkout</h4>
                <div class="space-y-2.5 text-purple-200">
                    <p><i class="bi bi-shield-lock-fill text-emerald-400 mr-2"></i> Paystack 256-Bit SSL Encrypted</p>
                    <p><i class="bi bi-credit-card-fill text-[#FACC15] mr-2"></i> Visa, Mastercard, Verve</p>
                    <p><i class="bi bi-bank text-[#A78BFA] mr-2"></i> Direct Bank Transfer (GTBank)</p>
                    <p><i class="bi bi-phone text-amber-300 mr-2"></i> USSD & Instant Mobile Transfer</p>
                </div>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Quick Links & Audio</h4>
                <div class="space-y-2 mb-4">
                    <a href="{{ route('bundles.index') }}" class="block text-purple-200 hover:text-[#FACC15] transition">→ Buy Curated Bundles</a>
                    <a href="{{ route('catalog.index') }}" class="block text-purple-200 hover:text-[#FACC15] transition">→ Explore All Products</a>
                </div>
                <button onclick="openSpotifyModal()" class="bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-md">
                    <i class="bi bi-spotify text-[#FACC15]"></i> Listen on Spotify
                </button>
            </div>
        </div>

        <div class="text-center text-purple-300 border-t border-purple-900/60 mt-12 pt-6 text-xs space-y-2">
            <p class="text-purple-200 font-bold flex flex-wrap items-center justify-center gap-2 sm:gap-4">
                <span><i class="bi bi-shield-lock-fill text-[#FACC15]"></i> Paystack 256-Bit SSL Encrypted Checkout</span>
                <span>•</span>
                <span><i class="bi bi-flower1 text-[#FACC15]"></i> 100% Non-Toxic Child-Safe Materials</span>
                <span>•</span>
                <span><i class="bi bi-truck text-[#FACC15]"></i> Tracked Nationwide Delivery</span>
                <span>•</span>
                <span><i class="bi bi-arrow-repeat text-[#FACC15]"></i> 7-Day Damaged Piece Replacement</span>
            </p>
            <p>
                &copy; {{ date('Y') }} <strong>800byPD</strong> (WrittenbyPD). All rights reserved.
            </p>
        </div>
    </footer>
    @endif

    <!-- Currency Conversion & Quick Add Modal Script -->
    <script>
        const exchangeRates = { NGN: 1, USD: 0.00065, GBP: 0.00051, EUR: 0.00060 };
        const currencySymbols = { NGN: '₦', USD: '$', GBP: '£', EUR: '€' };
        const currencyNames = { NGN: 'Naira (₦)', USD: 'US Dollars ($)', GBP: 'British Pounds (£)', EUR: 'Euros (€)' };

        function changeCurrency(curr) {
            sessionStorage.setItem('selected_currency', curr);

            document.querySelectorAll('.price-convertible').forEach(el => {
                const baseNaira = parseFloat(el.getAttribute('data-price-ngn'));
                if (!isNaN(baseNaira)) {
                    const converted = (baseNaira * exchangeRates[curr]).toFixed(2);
                    const formatted = parseFloat(converted).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                    el.textContent = currencySymbols[curr] + formatted;
                }
            });

            document.querySelectorAll('.currency-name').forEach(el => {
                el.textContent = currencyNames[curr] || curr;
            });
        }

        function toggleMobileMenu(e) {
            if (e) e.stopPropagation();
            const drawer = document.getElementById('mobileMenuDrawer');
            if (drawer) drawer.classList.toggle('hidden');
        }

        // 5.1 Close mobile menu when clicking/tapping outside
        document.addEventListener('click', function (e) {
            const drawer = document.getElementById('mobileMenuDrawer');
            const menuBtn = document.getElementById('mobileMenuBtn');
            if (drawer && !drawer.classList.contains('hidden')) {
                if (!drawer.contains(e.target) && (!menuBtn || !menuBtn.contains(e.target))) {
                    drawer.classList.add('hidden');
                }
            }
        });

        // 6.2 Scroll to Top Button Visibility Listener
        window.addEventListener('scroll', function () {
            const btn = document.getElementById('scrollToTopBtn');
            if (btn) {
                if (window.scrollY > 300) {
                    btn.classList.remove('hidden');
                    btn.classList.add('flex');
                } else {
                    btn.classList.add('hidden');
                    btn.classList.remove('flex');
                }
            }
        });

        function openSpotifyModal() {
            document.getElementById('spotifyModal').classList.remove('hidden');
        }

        function closeSpotifyModal() {
            document.getElementById('spotifyModal').classList.add('hidden');
        }

        /* 4.1 Floating Cart Bar Dynamic Update Helper */
        window.updateFloatingCartBar = function (box, subtotal, cartCount) {
            const bar = document.getElementById('floatingCartBar');
            if (!bar) return;
            const totalItems = (box && typeof box.total_items !== 'undefined') ? box.total_items : (cartCount || 0);
            if (totalItems > 0) {
                bar.classList.remove('hidden');
                const countEl = document.getElementById('floatingCartItemCount');
                const labelEl = document.getElementById('floatingCartItemLabel');
                const subtotalEl = document.getElementById('floatingCartSubtotal');
                if (countEl) countEl.textContent = totalItems;
                if (labelEl) labelEl.textContent = totalItems === 1 ? 'Item' : 'Items';
                if (subtotalEl && typeof subtotal !== 'undefined') {
                    subtotalEl.setAttribute('data-price-ngn', subtotal);
                    const curr = sessionStorage.getItem('selected_currency') || 'NGN';
                    changeCurrency(curr);
                }
            }
        };

        /* Nourishark-Style Quick Add Product Modal Logic */
        let currentModalProduct = null;
        let currentModalQty = 1;

        function triggerQuickAddFromBtn(btn) {
            const product = {
                id: btn.getAttribute('data-id'),
                name: btn.getAttribute('data-name'),
                price: btn.getAttribute('data-price'),
                sale_price: btn.getAttribute('data-saleprice') || null,
                stock_quantity: parseInt(btn.getAttribute('data-stock') || 0),
                description: btn.getAttribute('data-desc'),
                category_name: btn.getAttribute('data-category'),
                image: btn.getAttribute('data-image') || null
            };
            openQuickAddModal(product);
        }

        function openQuickAddModal(product) {
            currentModalProduct = product;
            currentModalQty = 1;

            document.getElementById('quickAddTitle').textContent = product.name;
            document.getElementById('quickAddCategory').textContent = product.category_name || 'Book';
            const stockBadge = document.getElementById('quickAddStock');
            if (product.stock_quantity > 0) {
                stockBadge.textContent = 'In Stock';
                stockBadge.className = 'bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase';
            } else {
                stockBadge.textContent = 'Out of Stock';
                stockBadge.className = 'bg-rose-100 text-rose-700 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase';
            }
            
            const imageEl = document.getElementById('quickAddImage');
            if (product.image) {
                imageEl.src = '/storage/' + product.image;
                imageEl.classList.remove('hidden');
                document.getElementById('quickAddPlaceholderIcon').classList.add('hidden');
            } else {
                imageEl.classList.add('hidden');
                document.getElementById('quickAddPlaceholderIcon').classList.remove('hidden');
            }

            updateModalPriceAndQtyDisplay();
            document.getElementById('quickAddModal').classList.remove('hidden');
        }

        function closeQuickAddModal() {
            document.getElementById('quickAddModal').classList.add('hidden');
        }

        function changeModalQty(delta) {
            const newQty = currentModalQty + delta;
            if (newQty >= 1 && newQty <= (currentModalProduct?.stock_quantity || 99)) {
                currentModalQty = newQty;
                updateModalPriceAndQtyDisplay();
            }
        }

        function updateModalPriceAndQtyDisplay() {
            document.getElementById('quickAddQtyDisplay').textContent = currentModalQty;
            const unitPrice = parseFloat(currentModalProduct.sale_price || currentModalProduct.price);
            const totalPrice = unitPrice * currentModalQty;
            
            const btnPriceEl = document.getElementById('quickAddBtnPriceDisplay');
            btnPriceEl.setAttribute('data-price-ngn', totalPrice);
            
            const curr = sessionStorage.getItem('selected_currency') || 'NGN';
            changeCurrency(curr);
        }

        function submitQuickAddModal() {
            if (!currentModalProduct) return;

            const submitBtn = document.getElementById('quickAddSubmitBtn');
            const originalHtml = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="bi bi-arrow-repeat animate-spin mr-1"></i> Adding...';

            fetch(`/cart/add/${currentModalProduct.id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    quantity: currentModalQty
                })
            })
            .then(res => res.json())
            .then(data => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                if (data.success) {
                    const badge = document.getElementById('cartCountBadge');
                    if (badge) {
                        badge.textContent = (data.box && typeof data.box.total_items !== 'undefined') ? data.box.total_items : data.cart_count;
                    }
                    window.updateFloatingCartBar(data.box, data.subtotal, data.cart_count);
                    closeQuickAddModal();
                    showToastNotification(data.message || 'Item added to your box!');
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                console.error(err);
            });
        }

        function showToastNotification(msg) {
            const toast = document.getElementById('toastNotification');
            document.getElementById('toastMessage').textContent = msg;
            toast.classList.remove('hidden');
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        window.addEventListener('DOMContentLoaded', () => {
            const saved = sessionStorage.getItem('selected_currency') || 'NGN';
            document.getElementById('currencySelector').value = saved;
            changeCurrency(saved);
        });
    </script>
</body>
</html>
