<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>800bypd - Children's Story Books, Puzzles & Activity Books by WrittenbyPD</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-whimsical { font-family: 'Fredoka', cursive, sans-serif; }
    </style>
</head>
<body class="bg-[#FFFDF9] text-slate-800 flex flex-col min-h-screen">

    <!-- Top Announcement Strip (MOT The Label & Scripture Haven Style) -->
    <div class="bg-[#2D1B4E] text-[#FDE68A] text-xs font-semibold py-2.5 px-4 border-b border-amber-500/20">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-2">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase tracking-wide">800bypd Store</span>
                <span>✨ Fast Delivery Across Lagos (1-3 Days) & All States in Nigeria!</span>
            </div>

            <div class="flex items-center gap-4 text-xs font-bold">
                <!-- Spotify Channel Modal Trigger -->
                <button onclick="openSpotifyModal()" class="hover:text-white transition flex items-center gap-1.5 text-emerald-400 font-bold">
                    <i class="fa-brands fa-spotify text-sm"></i> Spotify Audiobooks
                </button>

                <!-- Fluid Multi-Currency Switcher -->
                <div class="flex items-center gap-1 bg-[#1F1235] px-3 py-1 rounded-full border border-purple-800/50">
                    <i class="fa-solid fa-coins text-amber-400 text-[10px]"></i>
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-11 h-11 bg-[#FBBF24] text-[#2D1B4E] rounded-2xl flex items-center justify-center font-whimsical font-bold text-2xl shadow-md rotate-2 group-hover:rotate-0 transition duration-300">
                    8
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-whimsical text-2xl font-bold text-[#2D1B4E]">800by<span class="text-amber-500">pd</span></span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Children's Books & Games</span>
                </div>
            </a>

            <!-- Navigation Links (Public Storefront Only) -->
            <nav class="hidden md:flex items-center space-x-9 text-xs font-bold text-slate-700 uppercase tracking-wider">
                <a href="{{ route('home') }}" class="hover:text-purple-700 transition">Home</a>
                <a href="{{ route('catalog.index', ['category' => 'childrens-story-books']) }}" class="hover:text-purple-700 transition">Story Books</a>
                <a href="{{ route('catalog.index', ['category' => 'jigsaw-puzzles']) }}" class="hover:text-purple-700 transition">Jigsaw Puzzles</a>
                <a href="{{ route('catalog.index', ['category' => 'colouring-books']) }}" class="hover:text-purple-700 transition">Colouring Books</a>
            </nav>

            <!-- Search & Shopping Cart -->
            <div class="flex items-center gap-3">
                <form action="{{ route('catalog.index') }}" method="GET" class="relative hidden sm:block">
                    <input type="text" name="search" placeholder="Search storybooks, puzzles..." class="w-44 lg:w-56 pl-8 pr-4 py-2 border border-amber-200/80 bg-amber-50/20 rounded-full text-xs focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-amber-500 text-xs"></i>
                </form>

                <a href="{{ route('cart.index') }}" class="relative bg-[#2D1B4E] hover:bg-purple-900 text-white px-5 py-2.5 rounded-full font-bold text-xs flex items-center gap-2 shadow-md transition">
                    <i class="fa-solid fa-bag-shopping text-sm text-amber-400"></i>
                    <span>Cart</span>
                    @php $cartCount = count(session('cart', [])); @endphp
                    <span id="cartCountBadge" class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2 py-0.5 rounded-full text-[10px] ml-1">{{ $cartCount }}</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Spotify Storytime Banner -->
    <div class="bg-gradient-to-r from-emerald-700 via-teal-700 to-emerald-800 text-white text-xs font-semibold py-2.5 px-4 shadow-inner">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-2">
                <i class="fa-brands fa-spotify text-amber-300 text-base"></i>
                <span>🎧 <strong>Spotify Storytime Companion:</strong> Listen to 800bypd children's audiobooks & podcasts narrated by WrittenbyPD!</span>
            </div>
            <button onclick="openSpotifyModal()" class="bg-[#FBBF24] hover:bg-amber-300 text-[#2D1B4E] font-extrabold px-3.5 py-1 rounded-full text-[11px] transition shadow">
                Listen Now <i class="fa-solid fa-play ml-1"></i>
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <div class="max-w-7xl mx-auto px-4 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-300 text-emerald-900 px-4 py-3 rounded-2xl relative mb-4 text-xs font-semibold">
                <i class="fa-solid fa-circle-check mr-2 text-sm text-emerald-600"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-300 text-rose-900 px-4 py-3 rounded-2xl relative mb-4 text-xs font-semibold">
                <i class="fa-solid fa-circle-exclamation mr-2 text-sm text-rose-600"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-grow max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Support Button (+2348164254442) -->
    <a href="https://wa.me/2348164254442?text=Hello%20800bypd!%20I%20have%20a%20question%20about%20your%20children%27s%20books%20and%20puzzles." target="_blank" class="fixed bottom-6 right-6 z-50 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full p-4 shadow-2xl flex items-center justify-center gap-2 group transition transform hover:scale-105 border-2 border-white">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
        <span class="hidden group-hover:inline text-xs font-extrabold pr-2">Chat with 800bypd</span>
    </a>

    <!-- Spotify Channel Popup Modal -->
    <div id="spotifyModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 max-w-md w-full border border-emerald-200 shadow-2xl relative">
            <button onclick="closeSpotifyModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-700 text-lg">
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="text-center mb-5">
                <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-2xl mx-auto mb-2">
                    <i class="fa-brands fa-spotify"></i>
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
                    <div class="space-x-3 text-sm">
                        <i class="fa-solid fa-backward-step cursor-pointer hover:text-emerald-400"></i>
                        <i class="fa-solid fa-circle-play text-emerald-400 text-xl cursor-pointer hover:scale-110"></i>
                        <i class="fa-solid fa-forward-step cursor-pointer hover:text-emerald-400"></i>
                    </div>
                </div>
            </div>

            <a href="https://spotify.com" target="_blank" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-lg">
                Open Spotify App <i class="fa-solid fa-arrow-up-right-from-square"></i>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-[#2D1B4E] text-slate-300 mt-20 py-14 border-t-4 border-[#FBBF24]">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-9 text-xs">
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-9 h-9 bg-amber-400 text-purple-950 rounded-xl flex items-center justify-center font-whimsical font-bold text-xl">8</div>
                    <span class="font-whimsical text-2xl font-bold text-white">800by<span class="text-amber-400">pd</span></span>
                </div>
                <p class="text-slate-300 leading-relaxed mb-3">A children's bookstore and activity workshop created by <strong>WrittenbyPD</strong>. Inspiring early literacy through storybooks, jigsaw puzzles, and colouring books.</p>
                <p class="text-amber-300 font-bold"><i class="fa-solid fa-location-dot mr-1"></i> Based in Lagos, Nigeria</p>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Customer Support</h4>
                <ul class="space-y-2.5 text-slate-300">
                    <li><i class="fa-brands fa-whatsapp text-emerald-400 mr-2 text-sm"></i> WhatsApp: +234 816 425 4442</li>
                    <li><i class="fa-solid fa-envelope text-amber-400 mr-2 text-sm"></i> Email: 800bypd@gmail.com</li>
                    <li><i class="fa-solid fa-truck-fast text-purple-300 mr-2 text-sm"></i> Delivery: 1-3 Days Lagos & Nationwide</li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Payment Methods</h4>
                <div class="space-y-2.5 text-slate-300">
                    <p><i class="fa-solid fa-credit-card text-amber-400 mr-2"></i> Visa, Mastercard, Verve</p>
                    <p><i class="fa-solid fa-building-columns text-emerald-400 mr-2"></i> Direct Bank Transfer (GTBank)</p>
                    <p><i class="fa-solid fa-bolt text-blue-400 mr-2"></i> Paystack (USSD & Transfer)</p>
                </div>
            </div>

            <div>
                <h4 class="text-white font-whimsical text-base font-bold mb-4">Spotify Storytime</h4>
                <p class="text-slate-300 mb-4">Stream audiobooks and bedtime stories directly on Spotify.</p>
                <button onclick="openSpotifyModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-md">
                    <i class="fa-brands fa-spotify"></i> Listen on Spotify
                </button>
            </div>
        </div>

        <div class="text-center text-slate-400 border-t border-purple-900 mt-12 pt-6 text-xs">
            &copy; {{ date('Y') }} <strong>800bypd</strong> (WrittenbyPD). All rights reserved. Designed to International E-Commerce Standards.
        </div>
    </footer>

    <!-- Currency Conversion Script -->
    <script>
        const exchangeRates = { NGN: 1, USD: 0.00065, GBP: 0.00051, EUR: 0.00060 };
        const currencySymbols = { NGN: '₦', USD: '$', GBP: '£', EUR: '€' };

        function changeCurrency(curr) {
            sessionStorage.setItem('selected_currency', curr);
            document.querySelectorAll('.price-convertible').forEach(el => {
                const baseNaira = parseFloat(el.getAttribute('data-price-ngn'));
                if (!isNaN(baseNaira)) {
                    const converted = (baseNaira * exchangeRates[curr]).toFixed(2);
                    el.textContent = currencySymbols[curr] + Number(converted).toLocaleString();
                }
            });
        }

        function openSpotifyModal() {
            document.getElementById('spotifyModal').classList.remove('hidden');
        }

        function closeSpotifyModal() {
            document.getElementById('spotifyModal').classList.add('hidden');
        }

        window.addEventListener('DOMContentLoaded', () => {
            const saved = sessionStorage.getItem('selected_currency');
            if (saved) {
                document.getElementById('currencySelector').value = saved;
                changeCurrency(saved);
            }
        });
    </script>
</body>
</html>
