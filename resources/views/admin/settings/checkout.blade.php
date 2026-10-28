@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/settings/checkout</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Checkout Settings</h1>
            <p class="text-xs text-slate-500">Configure minimum order requirements and the "Fill Your Box" shopping experience.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
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
        <a href="{{ route('admin.categories.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-tags-fill"></i> Category Management
        </a>
        <a href="{{ route('admin.bundles.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-box2-heart-fill"></i> Product Bundles
        </a>
        <a href="{{ route('admin.settings.checkout') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-sliders text-[#7C3AED]"></i> Checkout Settings
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

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Settings Form -->
        <div class="lg:col-span-7">
            <form action="{{ route('admin.settings.checkout.update') }}" method="POST" class="bg-white p-6 sm:p-8 rounded-3xl border border-purple-200/80 shadow-sm space-y-6">
                @csrf

                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md mb-2 inline-block">Order Rules</span>
                    <h3 class="font-whimsical text-xl font-bold text-[#312E81] mb-1">Minimum Order Quantity ("Fill Your Box")</h3>
                    <p class="text-xs text-slate-500 leading-relaxed">
                        Control how many items a customer must have in their cart before checkout becomes available. Customers cannot checkout until their box reaches this count.
                    </p>
                </div>

                <div class="p-5 bg-purple-50/50 rounded-2xl border border-purple-100 space-y-4">
                    <div>
                        <label class="block text-slate-800 text-xs font-bold mb-2">
                            Minimum Required Items per Order:
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="number" 
                                id="minOrderInput"
                                name="checkout_min_order_quantity" 
                                value="{{ old('checkout_min_order_quantity', $minOrderQty) }}" 
                                min="1" 
                                max="100" 
                                required
                                oninput="updateLivePreview(this.value)"
                                class="w-32 border border-slate-300 px-4 py-3 rounded-xl font-extrabold text-base text-center text-[#312E81] focus:ring-2 focus:ring-[#7C3AED] focus:outline-none bg-white shadow-sm"
                            >
                            <span class="text-xs text-slate-600 font-semibold">items minimum</span>
                        </div>
                        @error('checkout_min_order_quantity')
                            <p class="text-rose-600 text-[11px] mt-1.5 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="text-[11px] text-slate-500 space-y-1">
                        <p class="flex items-center gap-1.5 font-medium"><i class="bi bi-info-circle text-[#7C3AED]"></i> Applies to the <strong>total number of eligible items</strong> in the cart, not the total monetary value.</p>
                        <p class="flex items-center gap-1.5 font-medium"><i class="bi bi-check-all text-emerald-600"></i> Individual products inside a bundle automatically count toward this minimum (e.g., a 5-item bundle counts as 5 items).</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end pt-2">
                    <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-7 py-3.5 rounded-2xl shadow-md transition flex items-center gap-2 text-xs">
                        <i class="bi bi-check-circle-fill"></i> Save Settings
                    </button>
                </div>
            </form>
        </div>

        <!-- Live Customer Experience Preview -->
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white p-6 rounded-3xl border border-purple-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h4 class="font-whimsical font-bold text-[#312E81] text-sm flex items-center gap-2">
                        <i class="bi bi-eye-fill text-[#7C3AED]"></i> Live Customer Preview
                    </h4>
                    <span class="text-[10px] text-slate-400 font-mono">Interactive</span>
                </div>

                <p class="text-[11px] text-slate-500">
                    Here is how the <strong>"Fill Your Box"</strong> experience looks to shoppers when the minimum is set to <span id="previewMinText" class="font-bold text-[#7C3AED]">{{ $minOrderQty }}</span>:
                </p>

                <!-- State A: Incomplete Box -->
                <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200/80 space-y-2.5">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-extrabold text-amber-900 flex items-center gap-1.5">
                            <i class="bi bi-box-seam text-amber-600"></i> Fill Your Box
                        </span>
                        <span class="font-bold text-amber-800 bg-amber-100 px-2 py-0.5 rounded-full text-[10px]">
                            <span id="previewPartialCount">2</span> / <span class="previewMinVar">{{ $minOrderQty }}</span> items added
                        </span>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-amber-200/60 rounded-full h-2.5 overflow-hidden">
                        <div id="previewProgressBar" class="bg-amber-500 h-2.5 rounded-full transition-all duration-300" style="width: {{ min(100, round((2 / max(1, $minOrderQty)) * 100)) }}%"></div>
                    </div>

                    <p id="previewPromptMessage" class="text-[11px] text-amber-800 font-medium">
                        Add <span id="previewRemaining" class="font-bold">{{ max(1, $minOrderQty - 2) }}</span> more item to complete your box.
                    </p>
                    <span class="inline-block bg-slate-200 text-slate-500 text-[10px] font-bold px-3 py-1 rounded-xl cursor-not-allowed">
                        <i class="bi bi-lock-fill mr-1"></i> Checkout Disabled
                    </span>
                </div>

                <!-- State B: Full Box -->
                <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/80 space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-extrabold text-emerald-900 flex items-center gap-1.5">
                            <i class="bi bi-check-circle-fill text-emerald-600"></i> Your box is full!
                        </span>
                        <span class="font-bold text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded-full text-[10px]">
                            <span class="previewMinVar">{{ $minOrderQty }}</span> / <span class="previewMinVar">{{ $minOrderQty }}</span> items
                        </span>
                    </div>

                    <div class="w-full bg-emerald-200/60 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-emerald-500 h-2.5 rounded-full w-full"></div>
                    </div>

                    <p class="text-[11px] text-emerald-800 font-medium">
                        Your box is full! You can checkout now or add more items.
                    </p>
                    <span class="inline-block bg-[#312E81] text-[#FACC15] text-[10px] font-bold px-3 py-1.5 rounded-xl shadow-sm">
                        Proceed to Checkout <i class="bi bi-arrow-right"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateLivePreview(minVal) {
    const min = parseInt(minVal) || 1;
    document.getElementById('previewMinText').textContent = min;
    
    document.querySelectorAll('.previewMinVar').forEach(el => {
        el.textContent = min;
    });

    const current = Math.max(1, min - 1);
    document.getElementById('previewPartialCount').textContent = current;
    
    const remaining = Math.max(1, min - current);
    document.getElementById('previewRemaining').textContent = remaining;

    const percent = Math.min(100, Math.round((current / min) * 100));
    document.getElementById('previewProgressBar').style.width = percent + '%';
    document.getElementById('previewPromptMessage').innerHTML = `Add <strong>${remaining}</strong> more item${remaining > 1 ? 's' : ''} to complete your box.`;
}
</script>
@endsection
