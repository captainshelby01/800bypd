@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header & Navigation Tabs -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/products</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Manage Store Products</h1>
            <p class="text-xs text-slate-500">Add new story books or puzzles, update prices, manage stock quantities, and feature items.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('admin.products.create') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-5 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition w-full sm:w-auto">
                <i class="bi bi-plus-circle-fill text-sm"></i> Add New Product
            </a>
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-shop text-sm"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Navigation Tabs (Mobile Scrollable Bar) -->
    <div class="flex overflow-x-auto border-b border-slate-200 gap-2 text-xs font-bold whitespace-nowrap pb-0.5 scrollbar-none">
        <a href="{{ route('admin.verifications') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-receipt"></i> Orders & Payment Receipts
        </a>
        <a href="{{ route('admin.products.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-journal-bookmark-fill text-[#7C3AED]"></i> Product Catalog Management
        </a>
        <a href="{{ route('admin.users.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-shield-lock-fill"></i> Admin & Staff Logins
        </a>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search title or SKU..." class="pl-9 pr-4 py-2.5 border border-slate-200 rounded-xl text-xs font-semibold focus:ring-2 focus:ring-amber-400 focus:outline-none w-full sm:w-64">
                <i class="bi bi-search absolute left-3 top-3 text-slate-400 text-xs"></i>
            </div>

            <select name="category" onchange="this.form.submit()" class="border border-slate-200 px-3 py-2.5 text-xs rounded-xl bg-white font-semibold focus:ring-2 focus:ring-amber-400 focus:outline-none">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-slate-800 text-white font-bold px-4 py-2.5 rounded-xl text-xs hover:bg-slate-900">Filter</button>
            @if(request('search') || request('category'))
                <a href="{{ route('admin.products.index') }}" class="text-xs text-rose-600 font-bold self-center hover:underline">Clear</a>
            @endif
        </form>

        <span class="text-xs font-bold text-slate-500 text-left sm:text-right">Showing {{ $products->total() }} Product(s)</span>
    </div>

    <!-- Products Table -->
    <div class="bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm">
        <div class="overflow-x-auto -mx-5 sm:mx-0">
            <table class="w-full text-left text-xs border-collapse min-w-[700px] sm:min-w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                        <th class="p-3.5 whitespace-nowrap">Product</th>
                        <th class="p-3.5 whitespace-nowrap">SKU</th>
                        <th class="p-3.5 whitespace-nowrap">Category</th>
                        <th class="p-3.5 whitespace-nowrap">Price</th>
                        <th class="p-3.5 whitespace-nowrap">Stock Status</th>
                        <th class="p-3.5 whitespace-nowrap">Featured</th>
                        <th class="p-3.5 text-right whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($products as $product)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3.5 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-purple-50 rounded-xl overflow-hidden flex items-center justify-center border border-purple-100 flex-shrink-0">
                                        @if($product->primaryImage)
                                            <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-full h-full object-cover">
                                        @else
                                            <i class="bi bi-book-half text-xl text-amber-400"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-900 text-sm leading-tight">{{ $product->name }}</p>
                                        <span class="text-[10px] text-slate-400">{{ Str::limit($product->description, 35) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="p-3.5 font-mono text-purple-900 font-bold whitespace-nowrap">{{ $product->sku }}</td>
                            <td class="p-3.5 whitespace-nowrap">
                                <span class="bg-purple-50 text-purple-800 text-[10px] font-bold px-2.5 py-1 rounded-md uppercase">
                                    {{ $product->category->name ?? 'General' }}
                                </span>
                            </td>
                            <td class="p-3.5 font-bold whitespace-nowrap">
                                <span class="price-convertible text-slate-900" data-price-ngn="{{ $product->sale_price ?? $product->price }}">{{ $product->formatted_price }}</span>
                                @if($product->sale_price)
                                    <span class="block text-[10px] text-slate-400 line-through price-convertible" data-price-ngn="{{ $product->price }}">{{ $product->formatted_original_price }}</span>
                                @endif
                            </td>
                            <td class="p-3.5 whitespace-nowrap">
                                @if($product->stock_quantity > 5)
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        <i class="bi bi-check-circle-fill mr-1"></i> In Stock ({{ $product->stock_quantity }})
                                    </span>
                                @elseif($product->stock_quantity > 0)
                                    <span class="bg-amber-100 text-amber-900 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        <i class="bi bi-exclamation-triangle-fill mr-1"></i> Low Stock ({{ $product->stock_quantity }})
                                    </span>
                                @else
                                    <span class="bg-rose-100 text-rose-800 text-[10px] font-bold px-2.5 py-1 rounded-full uppercase">
                                        Out of Stock
                                    </span>
                                @endif
                            </td>
                            <td class="p-3.5 whitespace-nowrap">
                                @if($product->is_featured)
                                    <span class="bg-amber-400 text-[#2D1B4E] text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase">
                                        <i class="bi bi-star-fill mr-1"></i> Featured
                                    </span>
                                @else
                                    <span class="text-slate-400 text-[10px]">Standard</span>
                                @endif
                            </td>
                            <td class="p-3.5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-purple-100 hover:bg-purple-200 text-purple-900 font-bold px-3 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete {{ $product->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold px-3 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1">
                                            <i class="bi bi-trash-fill"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-500 font-medium">
                                <i class="bi bi-journal-bookmark text-4xl text-amber-400 mb-2 block"></i>
                                No products found. Click "Add New Product" to add story books or puzzles to your store!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
