@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6 sm:space-y-8">
    <!-- Header banner -->
    <div class="bg-gradient-to-r from-[#312E81] via-[#7C3AED] to-purple-900 text-white rounded-3xl p-6 md:p-8 shadow-xl relative overflow-hidden flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-4 border-[#FACC15]">
        <div class="space-y-2">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-[#FACC15] text-[#312E81] rounded-2xl flex items-center justify-center font-whimsical font-bold text-xl sm:text-2xl shadow-md flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="font-whimsical text-xl sm:text-3xl font-bold text-white">Hello, {{ $user->name }}! 👋</h1>
                    <p class="text-xs text-purple-200">Welcome to your 800byPD customer portal</p>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <a href="{{ route('account.orders') }}" class="bg-[#FACC15] hover:bg-yellow-300 text-[#312E81] font-extrabold px-5 py-2.5 rounded-2xl text-xs flex items-center gap-2 shadow-md transition w-full sm:w-auto justify-center">
                <i class="bi bi-archive-fill"></i> View Order History ({{ $ordersCount }})
            </a>
            <form action="{{ route('account.logout') }}" method="POST" class="inline w-full sm:w-auto">
                @csrf
                <button type="submit" class="bg-purple-950/60 hover:bg-purple-950 text-purple-200 hover:text-white px-4 py-2.5 rounded-2xl text-xs font-bold transition border border-purple-700/50 w-full sm:w-auto flex items-center justify-center gap-1">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>
    </div>

    <!-- Account Details & Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-xs">
        <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Account Profile</span>
                <i class="bi bi-person-vcard-fill text-[#7C3AED] text-xl"></i>
            </div>
            <div>
                <p class="text-slate-500">Full Name</p>
                <p class="font-bold text-slate-800 text-sm">{{ $user->name }}</p>
            </div>
            <div>
                <p class="text-slate-500">Email Address</p>
                <p class="font-bold text-slate-800">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-slate-500">Phone Number</p>
                <p class="font-bold text-slate-800">{{ $user->phone ?? 'Not provided' }}</p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm space-y-3">
            <div class="flex items-center justify-between">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Total Orders Placed</span>
                <i class="bi bi-bag-fill text-[#7C3AED] text-xl"></i>
            </div>
            <p class="font-whimsical text-4xl font-bold text-[#312E81]">{{ $ordersCount }}</p>
            <p class="text-slate-500 text-[11px]">Track progress, delivery statuses & payment receipts.</p>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm flex flex-col justify-between">
            <div class="space-y-2">
                <span class="text-slate-400 font-bold uppercase tracking-wider text-[10px]">Need Help?</span>
                <h3 class="font-whimsical text-lg font-bold text-slate-800">Support & Delivery Info</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Have questions about an existing order or delivery timeline?</p>
            </div>
            <a href="https://wa.me/2348164254442?text=Hello%20800bypd!%20I%20am%20logged%20in%20as%20{{ urlencode($user->email) }}%20and%20need%20help%20with%20my%20orders." target="_blank" class="mt-4 bg-[#7C3AED] hover:bg-purple-800 text-white font-extrabold py-2.5 px-4 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-sm transition border border-[#FACC15]">
                <i class="bi bi-whatsapp text-base text-[#FACC15]"></i> Chat on WhatsApp
            </a>
        </div>
    </div>

    <!-- Recent Orders Section -->
    <div class="bg-white rounded-3xl border border-purple-200/80 p-6 md:p-8 shadow-sm space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-whimsical text-2xl font-bold text-[#312E81]">Recent Orders</h2>
                <p class="text-xs text-slate-500">Your latest purchases with 800byPD</p>
            </div>
            <a href="{{ route('account.orders') }}" class="text-[#7C3AED] hover:underline font-bold text-xs flex items-center gap-1">
                View All Orders <i class="bi bi-arrow-right text-[10px]"></i>
            </a>
        </div>

        @if($recentOrders->isEmpty())
            <div class="text-center py-12 bg-purple-50/40 rounded-2xl border border-dashed border-purple-200">
                <i class="bi bi-box-seam text-4xl text-[#FACC15] mb-3 block"></i>
                <h3 class="font-whimsical text-lg font-bold text-slate-700">No orders yet</h3>
                <p class="text-xs text-slate-500 mb-4">Explore our collection of storybooks, jigsaw puzzles, and colouring books!</p>
                <a href="{{ route('catalog.index') }}" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-2.5 rounded-full text-xs shadow-md transition inline-flex items-center gap-2">
                    <i class="bi bi-book-half"></i> Browse Book Storefront
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-4 whitespace-nowrap">Order Number</th>
                            <th class="py-3 px-4 whitespace-nowrap">Date</th>
                            <th class="py-3 px-4 whitespace-nowrap">Total Amount</th>
                            <th class="py-3 px-4 whitespace-nowrap">Payment</th>
                            <th class="py-3 px-4 whitespace-nowrap">Status</th>
                            <th class="py-3 px-4 text-right whitespace-nowrap">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($recentOrders as $order)
                            <tr class="hover:bg-purple-50/50 transition">
                                <td class="py-4 px-4 font-bold text-[#312E81] whitespace-nowrap">{{ $order->order_number }}</td>
                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y') }}</td>
                                <td class="py-4 px-4 font-bold text-slate-800 price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($order->payment_status === 'paid')
                                        <span class="bg-purple-100 text-[#7C3AED] text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Paid</span>
                                    @elseif($order->payment_status === 'pending_verification')
                                        <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Receipt Pending</span>
                                    @else
                                        <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Unpaid</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="bg-purple-100 text-[#312E81] text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="bg-purple-100 hover:bg-purple-200 text-[#312E81] font-extrabold px-3 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1">
                                        Details <i class="bi bi-chevron-right text-[9px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
