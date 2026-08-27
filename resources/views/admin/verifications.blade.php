@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin</span>
            </div>
            <h1 class="font-whimsical font-bold text-3xl text-slate-900">800bypd Store Admin Panel</h1>
            <p class="text-xs text-slate-500">Manage customer orders, inspect Bank Transfer payment receipts, and track order fulfillment.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-full text-xs transition">
                <i class="fa-solid fa-store mr-1"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-amber-100 text-amber-700 rounded-2xl flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-[#2D1B4E] fa-clock"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pending Receipts</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $pendingTransfers->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-purple-100 text-purple-700 rounded-2xl flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-box-archive"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Orders</span>
                <h3 class="text-2xl font-black text-slate-900">{{ $allOrders->count() }}</h3>
            </div>
        </div>

        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center text-xl font-bold">
                <i class="fa-solid fa-shield-check"></i>
            </div>
            <div>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Gateways</span>
                <h3 class="text-sm font-bold text-slate-900">Paystack & Bank Transfer</h3>
            </div>
        </div>
    </div>

    <!-- Section 1: Pending Bank Transfer Verification Queue -->
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm mb-10">
        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-4 flex items-center gap-2">
            <span class="w-3 h-3 bg-amber-400 rounded-full inline-block animate-ping"></span> Bank Transfer Receipt Verification Queue
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                        <th class="p-3.5">Order #</th>
                        <th class="p-3.5">Customer Contact</th>
                        <th class="p-3.5">Delivery & Special Notes</th>
                        <th class="p-3.5">Amount</th>
                        <th class="p-3.5">Payment Proof</th>
                        <th class="p-3.5 text-right">Approval Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pendingTransfers as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3.5 font-bold font-mono text-purple-900">{{ $order->order_number }}</td>
                            <td class="p-3.5">
                                <span class="font-bold block text-slate-900">{{ $order->customer_name }}</span>
                                <span class="text-[10px] text-slate-500 block"><i class="fa-solid fa-phone mr-1"></i>{{ $order->customer_phone }}</span>
                                <span class="text-[10px] text-slate-500 block"><i class="fa-solid fa-envelope mr-1"></i>{{ $order->customer_email }}</span>
                            </td>
                            <td class="p-3.5 max-w-xs">
                                <span class="block text-slate-700 font-medium line-clamp-1">{{ $order->shipping_address }}, {{ $order->city }}, {{ $order->state }}</span>
                                @if($order->special_instructions)
                                    <span class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded border border-amber-200 inline-block mt-1">
                                        <i class="fa-solid fa-note-sticky mr-1"></i>{{ $order->special_instructions }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 font-black text-purple-950 text-sm">{{ $order->formatted_total }}</td>
                            <td class="p-3.5">
                                @if($order->bank_transfer_receipt)
                                    <a href="{{ asset('storage/' . $order->bank_transfer_receipt) }}" target="_blank" class="bg-emerald-50 text-emerald-700 border border-emerald-300 px-3 py-1.5 rounded-xl font-bold text-[10px] hover:bg-emerald-100 inline-flex items-center gap-1.5 shadow-sm">
                                        <i class="fa-solid fa-file-image text-emerald-600"></i> View Receipt Proof
                                    </a>
                                @else
                                    <span class="text-slate-400 font-semibold">No File</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right space-x-2">
                                <form action="{{ route('admin.verifications.approve', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3.5 py-1.5 rounded-xl text-xs shadow transition">
                                        <i class="fa-solid fa-check mr-1"></i> Approve
                                    </button>
                                </form>
                                <form action="{{ route('admin.verifications.reject', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold px-3.5 py-1.5 rounded-xl text-xs shadow transition">
                                        <i class="fa-solid fa-xmark mr-1"></i> Reject
                                    </button>
                                </form>
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

    <!-- Section 2: All Store Orders Overview -->
    <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm">
        <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-4 flex items-center gap-2">
            <i class="fa-solid fa-list-check text-purple-700"></i> All Customer Orders
        </h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                        <th class="p-3.5">Order #</th>
                        <th class="p-3.5">Customer Name</th>
                        <th class="p-3.5">Payment Method</th>
                        <th class="p-3.5">Payment Status</th>
                        <th class="p-3.5">Order Status</th>
                        <th class="p-3.5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3.5 font-bold font-mono text-purple-900">{{ $order->order_number }}</td>
                            <td class="p-3.5 font-bold text-slate-800">{{ $order->customer_name }}</td>
                            <td class="p-3.5 font-bold uppercase text-[10px] text-slate-600">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                            <td class="p-3.5">
                                <span class="font-bold px-2.5 py-0.5 rounded-full text-[10px] {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                                    {{ strtoupper($order->payment_status) }}
                                </span>
                            </td>
                            <td class="p-3.5">
                                <span class="font-semibold text-slate-700 text-xs capitalize">{{ $order->order_status }}</span>
                            </td>
                            <td class="p-3.5 text-right font-black text-purple-950 text-sm">{{ $order->formatted_total }}</td>
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
