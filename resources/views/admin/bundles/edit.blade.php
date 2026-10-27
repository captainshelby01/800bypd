@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <a href="{{ route('admin.bundles.index') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Product Bundles
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Edit Bundle: {{ $bundle->name }}</h1>
            <p class="text-xs text-slate-500">Update bundle items, pricing, badge, or image</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.bundles.update', $bundle->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-3xl border border-purple-200/80 shadow-sm space-y-6 text-xs font-semibold">
        @csrf
        @method('PUT')

        <!-- 1. Bundle Details -->
        <div>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md mb-2 inline-block">1. General Information</span>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Bundle Name *</label>
                    <input type="text" name="name" value="{{ old('name', $bundle->name) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Badge / Tag (Optional)</label>
                    <input type="text" name="badge" value="{{ old('badge', $bundle->badge) }}" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>
            </div>
        </div>

        <!-- 2. Pricing & Image -->
        <div>
            <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md mb-2 inline-block">2. Pricing & Media</span>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Bundle Price (₦) *</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $bundle->price) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Original Price (₦ Optional)</label>
                    <input type="number" step="0.01" name="original_price" value="{{ old('original_price', $bundle->original_price) }}" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Bundle Cover Image</label>
                    <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 p-2 rounded-xl bg-slate-50 focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    @if($bundle->image)
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-[10px] text-slate-400">Current:</span>
                            <img src="{{ $bundle->image_url }}" class="w-10 h-10 object-cover rounded-lg border" onerror="this.onerror=null; this.src='{{ asset('images/products/placeholder.svg') }}';">
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. Description -->
        <div>
            <label class="block text-slate-700 font-bold mb-1">Bundle Description</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">{{ old('description', $bundle->description) }}</textarea>
        </div>

        <!-- 4. Interactive Bundle Items Builder -->
        <div>
            <div class="flex items-center justify-between border-b border-purple-100 pb-2 mb-3">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-50 px-2.5 py-1 rounded-md inline-block">3. Included Products</span>
                    <h3 class="font-whimsical font-bold text-slate-900 text-base mt-1">Select Products In This Bundle</h3>
                </div>
                <div class="bg-purple-100 text-[#312E81] px-3 py-1 rounded-full text-xs font-black">
                    Total Items: <span id="totalItemsDisplay" class="text-[#7C3AED]">{{ $bundle->total_items_count }}</span>
                </div>
            </div>

            <p class="text-[11px] text-slate-500 mb-4">
                Each product added here contributes to the customer's <strong>"Fill Your Box"</strong> counter when they purchase this bundle.
            </p>

            <div id="bundleItemsContainer" class="space-y-3">
                @foreach($bundle->items as $index => $item)
                    <div class="bundle-item-row bg-purple-50/40 p-4 rounded-2xl border border-purple-200/60 flex flex-col sm:flex-row items-start sm:items-center gap-3">
                        <div class="flex-1 w-full sm:w-auto">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Product *</label>
                            <select name="items[{{ $index }}][product_id]" required onchange="handleProductChange(this, {{ $index }})" class="product-select w-full border border-slate-300 px-3 py-2.5 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs">
                                <option value="">-- Choose Product --</option>
                                @foreach($products as $p)
                                    <option value="{{ $p->id }}" data-variants="{{ json_encode($p->variants) }}" {{ $item->product_id == $p->id ? 'selected' : '' }}>
                                        {{ $p->name }} (₦{{ number_format($p->price, 2) }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="w-full sm:w-48 variant-container {{ $item->product && $item->product->variants->count() > 0 ? '' : 'hidden' }}">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Variation</label>
                            <select name="items[{{ $index }}][product_variant_id]" class="variant-select w-full border border-slate-300 px-3 py-2.5 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs">
                                <option value="">Default / Standard</option>
                                @if($item->product && $item->product->variants->count() > 0)
                                    @foreach($item->product->variants as $v)
                                        <option value="{{ $v->id }}" {{ $item->product_variant_id == $v->id ? 'selected' : '' }}>
                                            {{ $v->name ?? $v->sku }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="w-full sm:w-24">
                            <label class="block text-[11px] font-bold text-slate-600 mb-1">Quantity *</label>
                            <input type="number" name="items[{{ $index }}][quantity]" value="{{ $item->quantity }}" min="1" max="50" required oninput="calculateTotalItems()" class="item-qty w-full border border-slate-300 px-3 py-2.5 rounded-xl text-center font-extrabold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs bg-white">
                        </div>

                        <div class="sm:pt-5">
                            <button type="button" onclick="removeRow(this)" class="text-rose-500 hover:text-rose-700 p-2 rounded-xl hover:bg-rose-50 transition" title="Remove item">
                                <i class="bi bi-trash-fill text-base"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="button" onclick="addRow()" class="bg-purple-100 hover:bg-purple-200 text-[#7C3AED] font-extrabold px-4 py-2.5 rounded-xl transition flex items-center gap-1.5 text-xs">
                    <i class="bi bi-plus-circle-fill"></i> Add Another Product
                </button>
            </div>
        </div>

        <!-- 5. Active Status -->
        <div class="p-4 bg-purple-50/50 rounded-2xl border border-purple-200/60 flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $bundle->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-[#7C3AED] focus:ring-[#7C3AED]">
            <label for="is_active" class="text-xs font-bold text-slate-800 cursor-pointer">
                Publish on Website (display in "Buy Our Bundles" section)
            </label>
        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.bundles.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-3 rounded-2xl transition">Cancel</a>
            <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-3 rounded-2xl shadow-md transition flex items-center gap-2 text-xs">
                <i class="bi bi-pencil-square"></i> Save Changes
            </button>
        </div>
    </form>
</div>

<template id="rowTemplate">
    <div class="bundle-item-row bg-purple-50/40 p-4 rounded-2xl border border-purple-200/60 flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <div class="flex-1 w-full sm:w-auto">
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Product *</label>
            <select name="items[INDEX][product_id]" required onchange="handleProductChange(this, INDEX)" class="product-select w-full border border-slate-300 px-3 py-2.5 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs">
                <option value="">-- Choose Product --</option>
                @foreach($products as $p)
                    <option value="{{ $p->id }}" data-variants="{{ json_encode($p->variants) }}">
                        {{ $p->name }} (₦{{ number_format($p->price, 2) }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="w-full sm:w-48 variant-container hidden">
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Variation</label>
            <select name="items[INDEX][product_variant_id]" class="variant-select w-full border border-slate-300 px-3 py-2.5 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs">
                <option value="">Default / Standard</option>
            </select>
        </div>

        <div class="w-full sm:w-24">
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Quantity *</label>
            <input type="number" name="items[INDEX][quantity]" value="1" min="1" max="50" required oninput="calculateTotalItems()" class="item-qty w-full border border-slate-300 px-3 py-2.5 rounded-xl text-center font-extrabold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-xs bg-white">
        </div>

        <div class="sm:pt-5">
            <button type="button" onclick="removeRow(this)" class="text-rose-500 hover:text-rose-700 p-2 rounded-xl hover:bg-rose-50 transition" title="Remove item">
                <i class="bi bi-trash-fill text-base"></i>
            </button>
        </div>
    </div>
</template>

<script>
let rowIndex = {{ $bundle->items->count() + 10 }};

function addRow() {
    const container = document.getElementById('bundleItemsContainer');
    const template = document.getElementById('rowTemplate').innerHTML;
    const newHtml = template.replaceAll('INDEX', rowIndex);
    
    const div = document.createElement('div');
    div.innerHTML = newHtml;
    container.appendChild(div.firstElementChild);
    
    rowIndex++;
    calculateTotalItems();
}

function removeRow(btn) {
    const rows = document.querySelectorAll('.bundle-item-row');
    if (rows.length <= 1) {
        alert('A bundle must have at least one product.');
        return;
    }
    btn.closest('.bundle-item-row').remove();
    calculateTotalItems();
}

function handleProductChange(selectElem, index) {
    const selectedOption = selectElem.options[selectElem.selectedIndex];
    const row = selectElem.closest('.bundle-item-row');
    const variantContainer = row.querySelector('.variant-container');
    const variantSelect = row.querySelector('.variant-select');

    variantSelect.innerHTML = '<option value="">Default / Standard</option>';

    if (!selectedOption || !selectedOption.value) {
        variantContainer.classList.add('hidden');
        return;
    }

    const variantsData = selectedOption.getAttribute('data-variants');
    if (variantsData) {
        try {
            const variants = JSON.parse(variantsData);
            if (variants && variants.length > 0) {
                variants.forEach(v => {
                    const opt = document.createElement('option');
                    opt.value = v.id;
                    opt.textContent = v.name || v.sku;
                    variantSelect.appendChild(opt);
                });
                variantContainer.classList.remove('hidden');
            } else {
                variantContainer.classList.add('hidden');
            }
        } catch (e) {
            variantContainer.classList.add('hidden');
        }
    } else {
        variantContainer.classList.add('hidden');
    }
}

function calculateTotalItems() {
    let total = 0;
    document.querySelectorAll('.item-qty').forEach(input => {
        const val = parseInt(input.value) || 0;
        total += val;
    });
    document.getElementById('totalItemsDisplay').textContent = total;
}

// Initial calculation
calculateTotalItems();
</script>
@endsection
