@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header & Actions -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/bundles</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Manage Product Bundles</h1>
            <p class="text-xs text-slate-500">Create pre-defined packages (5-item, 10-item bundles) to encourage higher cart sizes and fill customer boxes.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('admin.bundles.create') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-5 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition w-full sm:w-auto">
                <i class="bi bi-plus-circle-fill text-sm"></i> Create New Bundle
            </a>
            <a href="{{ route('home') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2.5 rounded-2xl text-xs transition flex items-center justify-center gap-1.5 w-full sm:w-auto">
                <i class="bi bi-shop text-sm"></i> Public Storefront
            </a>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="flex overflow-x-auto border-b border-slate-200 gap-2 text-xs font-bold whitespace-nowrap pb-0.5 scrollbar-none">
        <a href="{{ route('admin.dashboard') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-speedometer2"></i> Dashboard Overview
        </a>
        <a href="{{ route('admin.verifications') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-receipt"></i> Orders & Receipts
        </a>
        <a href="{{ route('admin.products.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-journal-bookmark-fill"></i> Products
        </a>
        <a href="{{ route('admin.bundles.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-box2-heart-fill text-[#7C3AED]"></i> Product Bundles
        </a>
        <a href="{{ route('admin.settings.checkout') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-sliders"></i> Checkout Settings
        </a>
        @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
                <i class="bi bi-shield-lock-fill"></i> Staff Logins
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Bundles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($bundles as $bundle)
            <div class="bg-white rounded-3xl border border-purple-200/80 shadow-sm p-5 sm:p-6 flex flex-col justify-between hover:shadow-md transition">
                <div>
                    <!-- Badge & Status -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="bg-[#FACC15] text-[#312E81] text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">
                            {{ $bundle->badge ?? $bundle->total_items_count . '-Item Bundle' }}
                        </span>
                        
                        <form action="{{ route('admin.bundles.toggleActive', $bundle->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[10px] font-extrabold px-2.5 py-1 rounded-full transition flex items-center gap-1 {{ $bundle->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200' }}" title="Click to toggle active status">
                                <span class="w-1.5 h-1.5 rounded-full {{ $bundle->is_active ? 'bg-emerald-600' : 'bg-slate-400' }}"></span>
                                {{ $bundle->is_active ? 'Active on Store' : 'Inactive' }}
                            </button>
                        </form>
                    </div>

                    <h3 class="font-whimsical font-bold text-slate-900 text-xl mb-1">{{ $bundle->name }}</h3>
                    <p class="text-xs text-slate-500 line-clamp-2 mb-4">{{ $bundle->description }}</p>

                    <!-- Items Breakdown List -->
                    <div class="bg-purple-50/50 rounded-2xl p-3.5 border border-purple-100 mb-4 text-xs space-y-1.5">
                        <div class="font-bold text-[#312E81] flex items-center justify-between text-[11px] mb-2 border-b border-purple-100 pb-1.5">
                            <span>Included Products</span>
                            <span class="bg-purple-200/60 text-[#7C3AED] px-2 py-0.5 rounded-md font-extrabold">{{ $bundle->total_items_count }} items total</span>
                        </div>
                        @foreach($bundle->items as $item)
                            <div class="flex items-center justify-between text-slate-700 text-[11px]">
                                <span class="truncate max-w-[200px] flex items-center gap-1.5">
                                    <i class="bi bi-check2 text-[#7C3AED] font-bold"></i> {{ $item->display_name }}
                                </span>
                                <span class="font-extrabold text-[#312E81] flex-shrink-0">x{{ $item->quantity }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing Info -->
                    <div class="flex items-baseline gap-2 mb-4">
                        <span class="font-whimsical font-bold text-2xl text-[#312E81]">{{ $bundle->formatted_price }}</span>
                        @if($bundle->original_price)
                            <span class="text-xs text-slate-400 line-through">{{ $bundle->formatted_original_price }}</span>
                            @if($bundle->savings_percentage)
                                <span class="bg-rose-100 text-rose-700 font-extrabold text-[10px] px-2 py-0.5 rounded-full">{{ $bundle->savings_percentage }}% OFF</span>
                            @endif
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2 border-t border-slate-100 pt-4">
                    <a href="{{ route('admin.bundles.edit', $bundle->id) }}" class="flex-1 bg-purple-50 hover:bg-purple-100 text-[#7C3AED] font-bold py-2 rounded-xl text-center text-xs transition">
                        <i class="bi bi-pencil-square mr-1"></i> Edit Bundle
                    </a>
                    
                    <form action="{{ route('admin.bundles.destroy', $bundle->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete bundle \'{{ $bundle->name }}\'?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold p-2 rounded-xl text-xs transition" title="Delete bundle">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-3xl border border-slate-200 p-12 text-center text-slate-500">
                <i class="bi bi-box2-heart text-5xl text-amber-400 mb-3 block"></i>
                <p class="font-bold text-slate-700 text-base mb-2">No bundles created yet.</p>
                <p class="text-xs text-slate-500 mb-5">Create your first bundle to encourage customers to buy multi-item packages that fill their box.</p>
                <a href="{{ route('admin.bundles.create') }}" class="bg-[#2D1B4E] text-[#FBBF24] font-extrabold px-6 py-3 rounded-full text-xs shadow-md inline-block">Create First Bundle</a>
            </div>
        @endforelse
    </div>

    @if($bundles->hasPages())
        <div class="pt-4">
            {{ $bundles->links() }}
        </div>
    @endif
</div>
@endsection
