<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>800bypd - Children's Story Books, Puzzles & Activity Books by WrittenbyPD</title>
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
    <div class="bg-[#2D1B4E] text-[#FDE68A] text-xs font-semibold py-2.5 px-4 border-b border-amber-500/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide">800bypd Store</span>
                <span>✨ Fast Delivery Across Lagos (1-3 Days) & All States in Nigeria!</span>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold">
                <!-- Spotify Channel Modal Trigger -->
                <button onclick="openSpotifyModal()" class="hover:text-white transition flex items-center gap-1.5 text-emerald-400 font-bold">
                    <i class="bi bi-spotify text-sm"></i> Spotify Audiobooks
                </button>

                <!-- Multi-Currency Switcher -->
                <div class="flex items-center gap-1 bg-[#1F1235] px-3 py-1 rounded-full border border-purple-800/50">
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
    </div>

    <!-- Main Navigation Bar -->
    <header class="bg-[#FFFDF9]/90 backdrop-blur-md sticky top-0 z-40 border-b border-amber-100/60 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 group flex-shrink-0">
                <div class="w-10 h-10 sm:w-11 sm:h-11 bg-[#FBBF24] text-[#2D1B4E] rounded-2xl flex items-center justify-center font-whimsical font-bold text-xl sm:text-2xl shadow-md rotate-2 group-hover:rotate-0 transition duration-300">
                    8
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-whimsical text-xl sm:text-2xl font-bold text-[#2D1B4E]">800by<span class="text-amber-500">pd</span></span>
                    <span class="text-[9px] sm:text-[10px] text-slate-400 font-bold uppercase tracking-widest">Children's Books & Games</span>
                </div>
            </a>

            <!-- Desktop Navigation Links -->
            <nav class="hidden lg:flex items-center gap-4 xl:gap-7 text-xs font-bold text-slate-700 uppercase tracking-wider flex-shrink-0 whitespace-nowrap">
                <a href="{{ route('home') }}" class="hover:text-purple-700 transition">Home</a>
                <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="hover:text-purple-700 transition">Story Books</a>
                <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="hover:text-purple-700 transition">Jigsaw Puzzles</a>
                <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="hover:text-purple-700 transition">Colouring Books</a>
            </nav>

            <!-- Search, Cart & User Menu -->
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative hidden xl:block">
                    <input type="text" name="search" placeholder="Search storybooks, puzzles..." class="w-40 xl:w-52 pl-8 pr-4 py-2 border border-amber-200/80 bg-amber-50/20 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <i class="bi bi-search absolute left-3 top-2.5 text-amber-500 text-xs"></i>
                </form>

                <a href="{{ route('cart.index') }}" class="relative bg-[#2D1B4E] hover:bg-purple-900 text-white px-3.5 sm:px-4 py-2.5 rounded-full font-bold text-xs flex items-center gap-2 shadow-md transition flex-shrink-0">
                    <i class="bi bi-bag-fill text-sm text-amber-400"></i>
                    <span class="hidden sm:inline">Cart</span>
                    @php $cartCount = count(session('cart', [])); @endphp
                    <span id="cartCountBadge" class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2 py-0.5 rounded-full text-[10px]">{{ $cartCount }}</span>
                </a>

                @auth
                    <div class="relative group hidden sm:block flex-shrink-0">
                        <a href="{{ route('account.dashboard') }}" class="bg-amber-100 hover:bg-amber-200 text-[#2D1B4E] px-3.5 sm:px-4 py-2.5 rounded-full font-bold text-xs flex items-center gap-2 transition border border-amber-300/60 shadow-sm">
                            <i class="bi bi-person-circle text-base text-purple-800 flex-shrink-0"></i>
                            <span class="truncate max-w-[90px] sm:max-w-[120px] inline-block">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down text-[10px] text-slate-500 flex-shrink-0"></i>
                        </a>
                        <div class="absolute right-0 mt-1 w-48 bg-white rounded-2xl shadow-xl border border-amber-200 py-2 hidden group-hover:block z-50 text-xs font-semibold">
                            <a href="{{ route('account.dashboard') }}" class="block px-4 py-2 hover:bg-amber-50 text-slate-800"><i class="bi bi-speedometer2 mr-2 text-purple-700"></i> Dashboard</a>
                            <a href="{{ route('account.orders') }}" class="block px-4 py-2 hover:bg-amber-50 text-slate-800"><i class="bi bi-archive-fill mr-2 text-amber-600"></i> Order History</a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form action="{{ route('account.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 hover:bg-rose-50 text-rose-700 font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:flex bg-amber-100/70 hover:bg-amber-200 text-[#2D1B4E] px-4 py-2.5 rounded-full text-xs font-extrabold transition border border-amber-300/60 items-center gap-1.5 flex-shrink-0">
                        <i class="bi bi-person-fill text-amber-600 text-sm"></i> Log In
                    </a>
                @endauth

                <!-- Mobile Hamburger Button -->
                <button onclick="toggleMobileMenu()" class="lg:hidden bg-amber-100 hover:bg-amber-200 text-[#2D1B4E] w-10 h-10 rounded-full flex items-center justify-center text-xl transition border border-amber-300/60 focus:outline-none">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Menu Drawer Overlay -->
        <div id="mobileMenuDrawer" class="hidden md:hidden bg-[#FFFDF9] border-t border-amber-200/80 px-4 pt-4 pb-6 space-y-4 shadow-xl">
            <form action="{{ route('catalog.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Search storybooks, puzzles..." class="w-full pl-9 pr-4 py-2.5 border border-amber-200 bg-amber-50/30 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-purple-500">
                <i class="bi bi-search absolute left-3 top-3 text-amber-500 text-xs"></i>
            </form>

            <nav class="flex flex-col space-y-3 text-xs font-extrabold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-4">
                <a href="{{ route('home') }}" class="hover:text-purple-700 transition flex items-center gap-2"><i class="bi bi-house-fill text-purple-600"></i> Home</a>
                <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="hover:text-purple-700 transition flex items-center gap-2"><i class="bi bi-book-half text-amber-500"></i> Story Books</a>
                <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="hover:text-purple-700 transition flex items-center gap-2"><i class="bi bi-puzzle-fill text-purple-600"></i> Jigsaw Puzzles</a>
                <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="hover:text-purple-700 transition flex items-center gap-2"><i class="bi bi-palette-fill text-pink-500"></i> Colouring Books</a>
            </nav>

            <div class="pt-1">
                @auth
                    <div class="space-y-2 text-xs font-bold">
                        <div class="text-slate-500 text-[11px]">Logged in as: <strong class="text-slate-800">{{ auth()->user()->name }}</strong></div>
                        <a href="{{ route('account.dashboard') }}" class="block bg-amber-50 p-3 rounded-2xl border border-amber-200 text-[#2D1B4E]"><i class="bi bi-speedometer2 text-purple-700 mr-2"></i> Account Dashboard</a>
                        <a href="{{ route('account.orders') }}" class="block bg-amber-50 p-3 rounded-2xl border border-amber-200 text-[#2D1B4E]"><i class="bi bi-archive-fill text-amber-600 mr-2"></i> My Order History</a>
                        <form action="{{ route('account.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left bg-rose-50 text-rose-700 p-3 rounded-2xl font-bold"><i class="bi bi-box-arrow-right mr-2"></i> Log Out</button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3 text-xs">
                        <a href="{{ route('login') }}" class="bg-[#2D1B4E] text-[#FBBF24] font-extrabold py-3 rounded-2xl text-center shadow">Log In</a>
                        <a href="{{ route('register') }}" class="bg-amber-100 text-[#2D1B4E] font-extrabold py-3 rounded-2xl text-center border border-amber-300">Create Account</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Spotify Storytime Banner -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 text-white text-xs font-semibold py-2.5 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2 text-center sm:text-left">
                <i class="bi bi-spotify text-amber-300 text-base flex-shrink-0"></i>
                <span>🎧 <strong>Spotify Storytime Companion:</strong> Listen to 800bypd children's audiobooks & podcasts narrated by WrittenbyPD!</span>
            </div>
            <button onclick="openSpotifyModal()" class="bg-[#FBBF24] hover:bg-amber-300 text-[#2D1B4E] font-extrabold px-3.5 py-1 rounded-full text-[11px] transition shadow flex-shrink-0">
                Listen Now <i class="bi bi-play-fill ml-0.5"></i>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-2xl relative mb-4 text-xs font-semibold flex items-center gap-2">
                <i class="bi bi-check-circle-fill text-base text-emerald-600"></i>
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

    <!-- Floating WhatsApp Support Button (+2348164254442) -->
    <a href="https://wa.me/2348164254442?text=Hello%20800bypd!%20I%20have%20a%20question%20about%20your%20children%27s%20books%20and%20puzzles." target="_blank" class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full p-3.5 md:p-4 shadow-2xl flex items-center justify-center gap-2 group transition transform hover:scale-105 border-2 border-white">
        <i class="bi bi-whatsapp text-2xl"></i>
        <span class="hidden group-hover:inline text-xs font-extrabold pr-2">Chat with 800bypd</span>
    </a>

    <!-- Nourishark-Style Quick-Add Product Modal Popup -->
    <div id="quickAddModal" class="fixed inset-0 bg-slate-950/70 backdrop-blur-md z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-md w-full border border-amber-200/80 shadow-2xl overflow-hidden relative">
            <!-- Close Button -->
            <button onclick="closeQuickAddModal()" class="absolute top-4 right-4 z-20 w-8 h-8 rounded-full bg-slate-900/60 text-white flex items-center justify-center hover:bg-slate-900 transition shadow">
                <i class="bi bi-x-lg text-sm"></i>
            </button>

            <!-- Product Header Image -->
            <div class="h-60 sm:h-64 bg-purple-50 relative overflow-hidden flex items-center justify-center border-b border-slate-100">
                <img id="quickAddImage" src="" alt="Product Cover" class="w-full h-full object-cover">
                <div id="quickAddPlaceholderIcon" class="hidden text-center p-6">
                    <i class="bi bi-book-half text-6xl text-amber-400 mb-2"></i>
                    <span class="block text-xs font-bold text-slate-400">800bypd Original</span>
                </div>
            </div>

            <!-- Product Info & Stepper Controls -->
            <div class="p-6 space-y-4">
                <div>
                    <span id="quickAddCategory" class="text-[10px] font-extrabold text-purple-700 uppercase tracking-wide bg-purple-50 px-2.5 py-0.5 rounded-md inline-block mb-1">Category</span>
                    <h3 id="quickAddTitle" class="font-whimsical font-bold text-slate-900 text-2xl leading-tight">Product Title</h3>
                    <p id="quickAddDescription" class="text-xs text-slate-500 line-clamp-2 mt-1"></p>
                </div>

                <!-- Stock Indicator -->
                <div class="flex items-center gap-2">
                    <span id="quickAddStock" class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-0.5 rounded-full uppercase">In Stock</span>
                </div>

                <!-- Quantity Stepper & Add Button Row -->
                <div class="pt-2 flex items-center gap-3">
                    <!-- Quantity Stepper (- 1 +) -->
                    <div class="flex items-center bg-slate-100 p-1 rounded-full border border-slate-200 text-xs font-bold">
                        <button type="button" onclick="changeModalQty(-1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-slate-200 transition flex items-center justify-center text-sm shadow-sm">-</button>
                        <span id="quickAddQtyDisplay" class="w-8 text-center text-slate-900 text-sm font-extrabold">1</span>
                        <button type="button" onclick="changeModalQty(1)" class="w-8 h-8 rounded-full bg-white text-slate-700 hover:bg-slate-200 transition flex items-center justify-center text-sm shadow-sm">+</button>
                    </div>

                    <!-- Add Button with dynamic price -->
                    <button type="button" onclick="submitQuickAddModal()" id="quickAddSubmitBtn" class="flex-1 bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold py-3.5 px-5 rounded-full shadow-lg transition flex items-center justify-center gap-2 text-xs">
                        <i class="bi bi-bag-fill text-amber-400 text-sm"></i>
                        <span>Add</span>
                        <span id="quickAddBtnPriceDisplay" class="price-convertible font-black" data-price-ngn="0">₦0.00</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Toast Notification -->
    <div id="toastNotification" class="fixed top-20 right-6 z-50 hidden bg-[#2D1B4E] text-white px-5 py-3 rounded-2xl shadow-2xl border border-amber-400/40 text-xs font-bold flex items-center gap-2 transition">
        <i class="bi bi-check-circle-fill text-amber-400 text-base"></i>
        <span id="toastMessage">Product added to cart!</span>
    </div>

    <!-- Spotify Channel Popup Modal -->
    <div id="spotifyModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full border border-emerald-200 shadow-2xl relative">
            <button onclick="closeSpotifyModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="bi bi-x-lg"></i>
            </button>

            <div class="text-center mb-5">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-2">
                    <i class="bi bi-spotify"></i>
                </div>
                <h3 class="font-whimsical font-bold text-slate-900 text-2xl">800bypd Spotify Channel</h3>
                <p class="text-xs text-slate-500 mt-1">Listen to bedtime story audiobooks and podcasts narrated by WrittenbyPD.</p>
            </div>

            <!-- Spotify Player Widget -->
            <div class="bg-[#181818] text-white p-4 rounded-2xl mb-5 border border-emerald-500/30">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 bg-amber-400 text-purple-950 rounded-xl flex items-center justify-center font-whimsical font-bold text-xl">800</div>
                    <div class="text-left">
                        <h4 class="font-bold text-xs text-white">Bedtime Stories for Curious Minds</h4>
                        <span class="text-[10px] text-emerald-400 font-semibold">Narrated by WrittenbyPD</span>
                    </div>
                </div>
                <div class="bg-slate-700 rounded-full h-1.5 w-full mb-2">
                    <div class="bg-emerald-400 h-1.5 rounded-full w-2/3"></div>
                </div>
                <div class="flex justify-between items-center text-xs">
                    <span class="text-[10px] text-slate-400">03:12 / 09:45</span>
                    <div class="space-x-3 text-sm flex items-center">
                        <i class="bi bi-skip-backward-fill cursor-pointer hover:text-emerald-400"></i>
                        <i class="bi bi-play-circle-fill text-emerald-400 text-xl cursor-pointer hover:scale-110"></i>
                        <i class="bi bi-skip-forward-fill cursor-pointer hover:text-emerald-400"></i>
                    </div>
                </div>
            </div>

            <a href="https://spotify.com" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg">
                Open Spotify App <i class="bi bi-box-arrow-up-right"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#2D1B4E] text-slate-300 mt-20 py-14 border-t-4 border-[#FBBF24]">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-9 text-xs">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-amber-400 text-purple-950 rounded-xl flex items-center justify-center font-whimsical font-bold text-xl">8</div>
                    <span class="font-whimsical text-2xl font-bold text-white">800by<span class="text-amber-400">pd</span></span>
                </div>
                <p class="text-slate-300 leading-relaxed mb-3">A children's bookstore and activity workshop created by <strong>WrittenbyPD</strong>. Inspiring early literacy through storybooks, jigsaw puzzles, and colouring books.</p>
                <p class="text-amber-300 font-bold"><i class="bi bi-geo-alt-fill mr-1"></i> Based in Lagos, Nigeria</p>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Customer Support</h4>
                <ul class="space-y-2.5 text-slate-300">
                    <li><i class="bi bi-whatsapp text-emerald-400 mr-2 text-sm"></i> WhatsApp: +234 816 425 4442</li>
                    <li><i class="bi bi-envelope-fill text-amber-400 mr-2 text-sm"></i> Email: 800bypd@gmail.com</li>
                    <li><i class="bi bi-truck text-purple-300 mr-2 text-sm"></i> Delivery: 1-3 Days Lagos & Nationwide</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Payment Methods</h4>
                <div class="space-y-2.5 text-slate-300">
                    <p><i class="bi bi-credit-card-fill text-amber-400 mr-2"></i> Visa, Mastercard, Verve</p>
                    <p><i class="bi bi-bank text-emerald-400 mr-2"></i> Direct Bank Transfer (GTBank)</p>
                    <p><i class="bi bi-lightning-charge-fill text-blue-400 mr-2"></i> Paystack (USSD & Transfer)</p>
                </div>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Spotify Storytime</h4>
                <p class="text-slate-300 mb-4">Stream audiobooks and bedtime stories directly on Spotify.</p>
                <button onclick="openSpotifyModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-md">
                    <i class="bi bi-spotify"></i> Listen on Spotify
                </button>
            </div>
        </div>

        <div class="text-center text-slate-400 border-t border-purple-900 mt-12 pt-6 text-xs">
            &copy; {{ date('Y') }} <strong>800bypd</strong> (WrittenbyPD). All rights reserved. Designed to International E-Commerce Standards.
        </div>
    </footer>

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

        function toggleMobileMenu() {
            const drawer = document.getElementById('mobileMenuDrawer');
            drawer.classList.toggle('hidden');
        }

        function openSpotifyModal() {
            document.getElementById('spotifyModal').classList.remove('hidden');
        }

        function closeSpotifyModal() {
            document.getElementById('spotifyModal').classList.add('hidden');
        }

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
            document.getElementById('quickAddDescription').textContent = product.description || '';
            document.getElementById('quickAddStock').textContent = (product.stock_quantity > 0) ? `In Stock (${product.stock_quantity} available)` : 'Out of Stock';
            
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
                if (data.success) {
                    document.getElementById('cartCountBadge').textContent = data.cart_count;
                    closeQuickAddModal();
                    showToastNotification(data.message);
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
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
