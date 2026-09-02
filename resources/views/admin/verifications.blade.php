@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/verifications</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">800bypd Store Admin Panel</h1>
            <p class="text-xs text-slate-500">Manage customer orders, inspect Bank Transfer payment receipts, and track order fulfillment.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('admin.products.create') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-4 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition w-full sm:w-auto">
                <i class="bi bi-plus-circle-fill text-sm"></i> Add New Product
            </a>
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-shop text-sm"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Navigation Tabs (Mobile Scrollable Bar) -->
    <div class="flex overflow-x-auto border-b border-slate-200 gap-2 text-xs font-bold whitespace-nowrap pb-0.5 scrollbar-none">
        <a href="{{ route('admin.verifications') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-receipt text-[#7C3AED]"></i> Orders & Payment Receipts
        </a>
        <a href="{{ route('admin.products.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-journal-bookmark-fill"></i> Product Catalog Management
        </a>
        @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
                <i class="bi bi-shield-lock-fill"></i> Admin & Staff Logins
            </a>
        @endif
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center text-xl font-bold flex-shrink-0">
                <i class="bi bi-clock-fill"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Receipts</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $pendingTransfers->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-2xl flex items-center justify-center text-xl font-bold flex-shrink-0">
                <i class="bi bi-archive-fill"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $allOrders->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center text-xl font-bold flex-shrink-0">
                <i class="bi bi-shield-check"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gateways</span>
                <h3 class="text-sm font-bold text-slate-900">Paystack & Bank Transfer</h3>
            </div>
        </div>
    </div>

    <!-- Section 1: Pending Bank Transfer Verification Queue -->
    <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4">
        <h3 class="font-whimsical font-bold text-slate-900 text-lg sm:text-xl flex items-center gap-2">
            <span class="w-3 h-3 bg-amber-400 rounded-full inline-block animate-ping"></span> Bank Transfer Receipt Verification Queue
        </h3>

        <div class="overflow-x-auto -mx-5 sm:mx-0">
            <table class="w-full text-left text-xs border-collapse min-w-[650px] sm:min-w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                        <th class="p-3.5 whitespace-nowrap">Order #</th>
                        <th class="p-3.5 whitespace-nowrap">Customer Contact</th>
                        <th class="p-3.5 whitespace-nowrap">Delivery & Special Notes</th>
                        <th class="p-3.5 whitespace-nowrap">Amount</th>
                        <th class="p-3.5 whitespace-nowrap">Payment Proof</th>
                        <th class="p-3.5 text-right whitespace-nowrap">Approval Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingTransfers as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3.5 font-bold font-mono text-purple-900 whitespace-nowrap">{{ $order->order_number }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                <span class="font-bold block text-slate-900">{{ $order->customer_name }}</span>
                                <span class="text-[10px] text-slate-500 block"><i class="bi bi-telephone-fill mr-1"></i>{{ $order->customer_phone }}</span>
                                <span class="text-[10px] text-slate-500 block"><i class="bi bi-envelope-fill mr-1"></i>{{ $order->customer_email }}</span>
                            </td>
                            <td class="p-3.5 max-w-xs">
                                <span class="block text-slate-700 font-medium line-clamp-1">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->state }}</span>
                                @if($order->special_instructions)
                                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block mt-1">
                                        <i class="bi bi-sticky-fill mr-1"></i>{{ $order->special_instructions }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 font-black text-purple-950 text-sm price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                @if($order->bank_transfer_receipt)
                                    <a href="{{ asset('storage/' . $order->bank_transfer_receipt) }}" target="_blank" class="bg-emerald-50 text-emerald-700 border border-emerald-300 px-3 py-1.5 rounded-xl font-bold text-[10px] hover:bg-emerald-100 inline-flex items-center gap-1.5 shadow-sm">
                                        <i class="bi bi-file-earmark-image-fill text-emerald-600"></i> View Receipt Proof
                                    </a>
                                @else
                                    <span class="text-slate-400 font-semibold">No File</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-2">
                                    <form action="{{ route('admin.verifications.approve', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-xl text-xs shadow transition flex items-center gap-1">
                                            <i class="bi bi-check-lg"></i> Approve
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.verifications.reject', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-3 py-1.5 rounded-xl text-xs shadow transition flex items-center gap-1">
                                            <i class="bi bi-x-lg"></i> Reject
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-500 font-medium">No pending bank transfer verification requests at the moment.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: All Store Customer Orders & Delivery Status Management -->
    <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4">
        <h3 class="font-whimsical font-bold text-slate-900 text-lg sm:text-xl flex items-center gap-2">
            <i class="bi bi-card-checklist text-purple-700"></i> All Store Customer Orders
        </h3>

        <div class="overflow-x-auto -mx-5 sm:mx-0">
            <table class="w-full text-left text-xs border-collapse min-w-[650px] sm:min-w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                        <th class="p-3.5 whitespace-nowrap">Order #</th>
                        <th class="p-3.5 whitespace-nowrap">Customer Name</th>
                        <th class="p-3.5 whitespace-nowrap">Payment Method</th>
                        <th class="p-3.5 whitespace-nowrap">Payment Status</th>
                        <th class="p-3.5 whitespace-nowrap">Order Delivery Status</th>
                        <th class="p-3.5 text-right whitespace-nowrap">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3.5 font-bold font-mono text-purple-900 whitespace-nowrap">{{ $order->order_number }}</td>
                            <td class="p-3.5 font-bold text-slate-800 whitespace-nowrap">{{ $order->customer_name }}</td>
                            <td class="p-3.5 font-bold uppercase text-[10px] text-slate-600 whitespace-nowrap">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                <span class="font-bold px-2.5 py-0.5 rounded-full text-[10px] {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                                    {{ strtoupper($order->payment_status) }}
                                </span>
                            </td>
                            <td class="p-3.5 whitespace-nowrap">
                                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="inline-flex items-center gap-2">
                                    @csrf
                                    <select name="order_status" onchange="this.form.submit()" class="border border-slate-300 rounded-xl px-2.5 py-1 text-xs font-bold text-slate-800 bg-white focus:ring-2 focus:ring-amber-400 focus:outline-none">
                                        <option value="pending" {{ $order->order_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $order->order_status === 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="dispatched" {{ $order->order_status === 'dispatched' ? 'selected' : '' }}>Dispatched</option>
                                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td class="p-3.5 text-right font-black text-purple-950 text-sm price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">No orders registered yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
