@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header & Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Dashboard</h1>
            <p class="text-xs text-slate-500">Overview of store sales, monthly orders revenue, product performance, and latest customer orders.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('admin.products.create') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-4 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition w-full sm:w-auto">
                <i class="bi bi-plus-circle-fill text-sm"></i> Add New Product
            </a>
            <a href="{{ route('admin.verifications') }}" class="bg-amber-100 hover:bg-amber-200 text-amber-900 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-receipt text-sm"></i> Orders & Receipts
                @if($pendingVerifications > 0)
                    <span class="bg-rose-600 text-white font-black px-1.5 py-0.5 rounded-full text-[10px]">{{ $pendingVerifications }}</span>
                @endif
            </a>
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-shop text-sm"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex overflow-x-auto border-b border-slate-200 gap-2 text-xs font-bold whitespace-nowrap pb-0.5 scrollbar-none">
        <a href="{{ route('admin.dashboard') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-speedometer2 text-[#7C3AED]"></i> Dashboard Overview
        </a>
        <a href="{{ route('admin.verifications') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-receipt"></i> Orders & Payment Receipts
            @if($pendingVerifications > 0)
                <span class="bg-amber-500 text-white font-black px-1.5 py-0.2 rounded-full text-[9px]">{{ $pendingVerifications }}</span>
            @endif
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

    <!-- Overview Stat Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 sm:gap-6">
        <!-- Total Orders Card -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm transition hover:shadow-md">
            <div class="text-xs font-bold text-slate-500 mb-2">Total Orders</div>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2 font-whimsical tracking-tight">{{ number_format($totalOrders) }}</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>All orders currently listed</span>
            </div>
        </div>

        <!-- Total Goods Sold Card -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm transition hover:shadow-md">
            <div class="text-xs font-bold text-slate-500 mb-2">Total Goods Sold</div>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2 font-whimsical tracking-tight">₦{{ number_format($totalGoodsSold, 2) }}</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>Total value of goods sold</span>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-200 shadow-sm transition hover:shadow-md">
            <div class="text-xs font-bold text-slate-500 mb-2">Total Products</div>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 mb-2 font-whimsical tracking-tight">{{ number_format($totalProducts) }}</div>
            <div class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                <span>All products currently listed</span>
            </div>
        </div>
    </div>

    <!-- Monthly Charts Section: Revenue & Orders Per Month -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Monthly Sales Revenue Chart -->
        <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-900 text-base sm:text-lg">Monthly Sales Revenue</h3>
            </div>
            <div class="relative w-full h-64 sm:h-72">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
            <div class="flex items-center justify-center gap-2 mt-4 text-xs font-semibold text-slate-600">
                <span class="inline-block w-3.5 h-3.5 border-2 border-amber-500 bg-amber-100 rounded-sm"></span>
                <span>Sales Revenue</span>
            </div>
        </div>

        <!-- Orders Per Month Chart -->
        <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-slate-900 text-base sm:text-lg">Orders Per Month</h3>
            </div>
            <div class="relative w-full h-64 sm:h-72">
                <canvas id="ordersPerMonthChart"></canvas>
            </div>
            <div class="flex items-center justify-center gap-2 mt-4 text-xs font-semibold text-slate-600">
                <span class="inline-block w-3.5 h-3.5 border-2 border-amber-500 bg-amber-100 rounded-sm"></span>
                <span>Orders</span>
            </div>
        </div>
    </div>

    <!-- Sales by Product Bar Chart Section -->
    <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-slate-900 text-base sm:text-lg">Sales by Product</h3>
        </div>
        <div class="relative w-full h-72 sm:h-80">
            <canvas id="salesByProductChart"></canvas>
        </div>
    </div>

    <!-- Latest Orders Table Section -->
    <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h3 class="font-bold text-slate-900 text-lg sm:text-xl">Latest Orders</h3>
            
            <!-- Table Search Bar -->
            <form action="{{ route('admin.dashboard') }}" method="GET" class="w-full sm:w-auto">
                <div class="relative w-full sm:w-64">
                    <input type="text" name="search" id="orderSearchInput" value="{{ request('search') }}" placeholder="Search" 
                        class="w-full pl-9 pr-4 py-2 border border-slate-200 rounded-2xl text-xs font-semibold text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition shadow-sm">
                    <i class="bi bi-search absolute left-3.5 top-2.5 text-slate-400 text-xs"></i>
                    @if(request('search'))
                        <a href="{{ route('admin.dashboard') }}" class="absolute right-3 top-2 text-slate-400 hover:text-slate-600 text-xs font-bold">&times;</a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto -mx-5 sm:mx-0">
            <table class="w-full text-left text-xs border-collapse min-w-[700px] sm:min-w-full" id="latestOrdersTable">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-600 font-semibold text-xs">
                        <th class="p-3.5 whitespace-nowrap">Order # <i class="bi bi-chevron-down text-[10px] text-slate-400 ml-1"></i></th>
                        <th class="p-3.5 whitespace-nowrap">Customer <i class="bi bi-chevron-down text-[10px] text-slate-400 ml-1"></i></th>
                        <th class="p-3.5 whitespace-nowrap">Total <i class="bi bi-chevron-down text-[10px] text-slate-400 ml-1"></i></th>
                        <th class="p-3.5 whitespace-nowrap">Payment status</th>
                        <th class="p-3.5 whitespace-nowrap">Date <i class="bi bi-chevron-down text-[10px] text-slate-400 ml-1"></i></th>
                        <th class="p-3.5 text-right whitespace-nowrap">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                    @forelse($latestOrders as $order)
                        <tr class="hover:bg-slate-50/60 transition group">
                            <td class="p-3.5 font-bold font-mono text-slate-900 whitespace-nowrap">{{ $order->order_number }}</td>
                            <td class="p-3.5 font-semibold text-slate-800 whitespace-nowrap">{{ $order->customer_name }}</td>
                            <td class="p-3.5 font-bold text-slate-900 whitespace-nowrap">₦{{ number_format($order->total_amount, 2) }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                @php
                                    $status = strtolower($order->payment_status);
                                    $isPaid = in_array($status, ['paid', 'completed']);
                                    $isPending = in_array($status, ['pending', 'pending_verification', 'unpaid']);
                                @endphp
                                @if($isPaid)
                                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        paid
                                    </span>
                                @elseif($isPending)
                                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        {{ $status === 'pending_verification' ? 'pending verification' : 'pending' }}
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold bg-rose-50 text-rose-700 border border-rose-200">
                                        {{ $status }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 text-slate-600 whitespace-nowrap">{{ $order->created_at ? $order->created_at->format('d M Y H:i') : 'N/A' }}</td>
                            <td class="p-3.5 text-right whitespace-nowrap">
                                <a href="{{ route('admin.verifications') }}" class="text-purple-700 hover:text-purple-900 font-bold text-xs inline-flex items-center gap-1 group-hover:underline">
                                    Manage <i class="bi bi-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-8 text-center text-slate-400 font-medium">No orders found matching your search.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($latestOrders->hasPages())
            <div class="pt-4 border-t border-slate-100">
                {{ $latestOrders->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Chart.js Integration -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const monthlyLabels = {!! json_encode($monthlyLabels) !!};
    const monthlyRevenueData = {!! json_encode($monthlyRevenue) !!};
    const monthlyOrdersData = {!! json_encode($monthlyOrders) !!};
    const productLabels = {!! json_encode($productLabels) !!};
    const productSalesData = {!! json_encode($productSales) !!};

    const commonLineOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: '#1E1B4B',
                titleFont: { size: 12, weight: 'bold' },
                bodyFont: { size: 12 },
                padding: 10,
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    font: { size: 10 },
                    color: '#64748B',
                    maxRotation: 45,
                    minRotation: 45
                }
            },
            y: {
                beginAtZero: true,
                grid: {
                    color: '#F1F5F9',
                    borderDash: [2, 2]
                },
                ticks: {
                    font: { size: 11 },
                    color: '#64748B'
                }
            }
        }
    };

    // 1. Monthly Sales Revenue Chart
    const revenueCtx = document.getElementById('monthlyRevenueChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Sales Revenue',
                    data: monthlyRevenueData,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    borderWidth: 2,
                    pointBackgroundColor: '#F59E0B',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                ...commonLineOptions,
                plugins: {
                    ...commonLineOptions.plugins,
                    tooltip: {
                        ...commonLineOptions.plugins.tooltip,
                        callbacks: {
                            label: function(context) {
                                return 'Revenue: ₦' + Number(context.parsed.y).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
                            }
                        }
                    }
                },
                scales: {
                    ...commonLineOptions.scales,
                    y: {
                        ...commonLineOptions.scales.y,
                        ticks: {
                            ...commonLineOptions.scales.y.ticks,
                            callback: function(value) {
                                return '₦' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Orders Per Month Chart
    const ordersCtx = document.getElementById('ordersPerMonthChart');
    if (ordersCtx) {
        new Chart(ordersCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Orders',
                    data: monthlyOrdersData,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.08)',
                    borderWidth: 2,
                    pointBackgroundColor: '#F59E0B',
                    pointBorderColor: '#FFFFFF',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    tension: 0.35,
                    fill: true
                }]
            },
            options: {
                ...commonLineOptions,
                plugins: {
                    ...commonLineOptions.plugins,
                    tooltip: {
                        ...commonLineOptions.plugins.tooltip,
                        callbacks: {
                            label: function(context) {
                                return 'Orders: ' + context.parsed.y;
                            }
                        }
                    }
                },
                scales: {
                    ...commonLineOptions.scales,
                    y: {
                        ...commonLineOptions.scales.y,
                        ticks: {
                            ...commonLineOptions.scales.y.ticks,
                            stepSize: 1,
                            precision: 0
                        }
                    }
                }
            }
        });
    }

    // 3. Sales by Product Bar Chart
    const productCtx = document.getElementById('salesByProductChart');
    if (productCtx) {
        new Chart(productCtx, {
            type: 'bar',
            data: {
                labels: productLabels.map(l => l.length > 20 ? l.substring(0, 18) + '...' : l),
                datasets: [{
                    label: 'Units Sold',
                    data: productSalesData,
                    backgroundColor: 'rgba(254, 243, 199, 0.85)',
                    borderColor: '#F59E0B',
                    borderWidth: 1.5,
                    borderRadius: 4,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1E1B4B',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 12 },
                        padding: 10,
                        cornerRadius: 8,
                        callbacks: {
                            title: function(items) {
                                if (!items.length) return '';
                                const index = items[0].dataIndex;
                                return productLabels[index] || items[0].label;
                            },
                            label: function(context) {
                                return 'Sales: ' + context.parsed.y + ' units';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#475569'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#F1F5F9'
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#64748B',
                            stepSize: 5,
                            precision: 0
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection
