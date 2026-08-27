@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <a href="{{ route('account.dashboard') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Order History</h1>
            <p class="text-xs text-slate-500">Track and review all purchases placed under {{ $user->email }}</p>
        </div>

        <a href="{{ route('catalog.index') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-5 py-2.5 rounded-full text-xs shadow-md transition flex items-center gap-2">
            <i class="bi bi-bag-fill"></i> Continue Shopping
        </a>
    </div>

    <div class="bg-white rounded-3xl border border-amber-200/80 p-6 md:p-8 shadow-sm space-y-6">
        @if($orders->isEmpty())
            <div class="text-center py-16">
                <i class="bi bi-box-seam text-5xl text-amber-400 mb-3 block"></i>
                <h2 class="font-whimsical text-xl font-bold text-slate-700">No past orders found</h2>
                <p class="text-xs text-slate-500 mb-6">You haven't placed any orders with this account yet.</p>
                <a href="{{ route('catalog.index') }}" class="bg-[#2D1B4E] text-[#FBBF24] font-extrabold px-6 py-3 rounded-2xl text-xs">
                    Start Shopping
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-slate-200 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-4 whitespace-nowrap">Order #</th>
                            <th class="py-3 px-4 whitespace-nowrap">Date Placed</th>
                            <th class="py-3 px-4 whitespace-nowrap">Items Count</th>
                            <th class="py-3 px-4 whitespace-nowrap">Total Price</th>
                            <th class="py-3 px-4 whitespace-nowrap">Payment Method</th>
                            <th class="py-3 px-4 whitespace-nowrap">Payment Status</th>
                            <th class="py-3 px-4 whitespace-nowrap">Delivery Status</th>
                            <th class="py-3 px-4 text-right whitespace-nowrap">Details</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($orders as $order)
                            <tr class="hover:bg-amber-50/30 transition">
                                <td class="py-4 px-4 font-bold text-[#2D1B4E] whitespace-nowrap">{{ $order->order_number }}</td>
                                <td class="py-4 px-4 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                <td class="py-4 px-4 text-slate-700 font-bold whitespace-nowrap">{{ $order->items->sum('quantity') }} items</td>
                                <td class="py-4 px-4 font-bold text-slate-900 price-convertible whitespace-nowrap" data-price-ngn="{{ $order->total_amount }}">{{ $order->formatted_total }}</td>
                                <td class="py-4 px-4 text-slate-600 uppercase text-[11px] font-bold whitespace-nowrap">
                                    {{ str_replace('_', ' ', $order->payment_method) }}
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    @if($order->payment_status === 'paid')
                                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase flex items-center gap-1 w-fit">
                                            <i class="bi bi-check-circle-fill"></i> Paid
                                        </span>
                                    @elseif($order->payment_status === 'pending_verification')
                                        <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase flex items-center gap-1 w-fit">
                                            <i class="bi bi-clock-fill"></i> Pending Verification
                                        </span>
                                    @else
                                        <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">Unpaid</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 whitespace-nowrap">
                                    <span class="bg-purple-100 text-purple-900 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        {{ ucfirst($order->order_status) }}
                                    </span>
                                </td>
                                <td class="py-4 px-4 text-right whitespace-nowrap">
                                    <a href="{{ route('account.orders.show', $order->order_number) }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-3.5 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1 shadow-sm">
                                        View Receipt <i class="bi bi-receipt text-[11px]"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
