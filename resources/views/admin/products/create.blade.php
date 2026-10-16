@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Product Catalog
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Add New Product</h1>
            <p class="text-xs text-slate-500">Create a new puzzle, coloring book, flashcard, or storybook for the 800byPD store</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-3xl border border-purple-200/80 shadow-sm space-y-6 text-xs font-semibold">
        @csrf

        <!-- 1. Product Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Product Title *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Safari Animal Kingdom Jigsaw Puzzle" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-[#2D1B4E] font-bold mb-1">Category *</label>
                <select name="category_id" id="categorySelect" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- 2. Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Base Price (NGN ₦) *</label>
                <input type="number" step="0.01" name="price" id="basePrice" value="{{ old('price') }}" required placeholder="4000.00" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Sale Price (Optional ₦)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="3500.00" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Total Stock Quantity *</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 20) }}" required min="0" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>
        </div>

        <!-- 3. SKU Code & Cover Image -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">SKU Code (Optional)</label>
                <input type="text" name="sku" id="baseSku" value="{{ old('sku') }}" placeholder="e.g. PD-PUZ-001" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl font-mono focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Primary Cover Image *</label>
                <input type="file" name="primary_image" required accept="image/*" class="w-full border border-slate-300 p-2 rounded-xl bg-slate-50 focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            </div>
        </div>

        <!-- 4. Description -->
        <div>
            <label class="block text-slate-700 font-bold mb-1">Product Overview & Description *</label>
            <textarea name="description" rows="4" required placeholder="Write a clear description containing all relevant info a customer needs before purchasing (learning benefits, recommended ages, piece counts)..." class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <!-- 5. Product Variations Manager -->
        <div class="bg-purple-50/40 p-5 sm:p-6 rounded-3xl border border-purple-200/80 space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-purple-200/60 pb-3">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-100 px-2 py-0.5 rounded-md inline-block">Product Options</span>
                    <h3 class="font-whimsical font-bold text-[#312E81] text-base">Product Variations</h3>
                    <p class="text-[11px] text-slate-500">Add variations like Flashcard sizes (Pocket / Big) or Jigsaw Puzzle difficulty (Easy 6-pc / Intermediate 12-pc).</p>
                </div>

                <!-- Quick Preset Buttons -->
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" onclick="applyFlashcardPresets()" class="bg-white hover:bg-purple-100 text-[#7C3AED] border border-purple-200 px-3 py-1.5 rounded-xl text-[11px] font-extrabold transition">
                        ⚡ Flashcard Sizes
                    </button>
                    <button type="button" onclick="applyPuzzlePresets()" class="bg-white hover:bg-purple-100 text-[#7C3AED] border border-purple-200 px-3 py-1.5 rounded-xl text-[11px] font-extrabold transition">
                        ⚡ Puzzle Difficulties
                    </button>
                    <button type="button" onclick="addCustomVariant()" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] px-3 py-1.5 rounded-xl text-[11px] font-extrabold transition">
                        ➕ Add Variation
                    </button>
                </div>
            </div>

            <div id="variantsList" class="space-y-3">
                <!-- Dynamic Variant Rows -->
            </div>
            
            <p id="noVariantsNotice" class="text-xs text-slate-400 italic py-2">
                No variations configured. This product will be listed as a single standard item. Click a preset button above to add variations.
            </p>
        </div>

        <!-- 6. Flags -->
        <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-200/60">
            <label class="flex items-center gap-2 cursor-pointer text-slate-800">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300 text-[#7C3AED] focus:ring-[#7C3AED]">
                <span class="font-bold">Feature on Homepage (Bestseller Banner)</span>
            </label>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-3 rounded-2xl transition text-center">Cancel</a>
            <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-3 rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                <i class="bi bi-plus-circle-fill"></i> Save & Publish Product
            </button>
        </div>
    </form>
</div>

<template id="variantRowTemplate">
    <div class="variant-row bg-white p-4 rounded-2xl border border-purple-200 shadow-sm flex flex-col sm:flex-row items-start sm:items-center gap-3">
        <div class="flex-1 w-full sm:w-auto">
            <label class="block text-[10px] font-bold text-slate-500 mb-1">Variation Name *</label>
            <input type="text" name="variants[INDEX][name]" placeholder="e.g. Pocket Size" required class="variant-name w-full border border-slate-300 px-3 py-2 rounded-xl text-xs font-bold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
        </div>

        <div class="w-full sm:w-36">
            <label class="block text-[10px] font-bold text-slate-500 mb-1">Variant SKU</label>
            <input type="text" name="variants[INDEX][sku]" placeholder="SKU-VAR" class="variant-sku w-full border border-slate-300 px-3 py-2 rounded-xl text-xs font-mono focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
        </div>

        <div class="w-full sm:w-28">
            <label class="block text-[10px] font-bold text-slate-500 mb-1">Price (₦) *</label>
            <input type="number" step="0.01" name="variants[INDEX][price]" placeholder="4000" required class="variant-price w-full border border-slate-300 px-3 py-2 rounded-xl text-xs font-bold focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
        </div>

        <div class="w-full sm:w-20">
            <label class="block text-[10px] font-bold text-slate-500 mb-1">Stock *</label>
            <input type="number" name="variants[INDEX][stock]" value="25" min="0" required class="variant-stock w-full border border-slate-300 px-3 py-2 rounded-xl text-xs font-bold text-center focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
        </div>

        <div class="sm:pt-4">
            <button type="button" onclick="removeVariantRow(this)" class="text-rose-500 hover:text-rose-700 p-2 rounded-xl hover:bg-rose-50 transition" title="Delete variant">
                <i class="bi bi-trash-fill text-base"></i>
            </button>
        </div>
    </div>
</template>

<script>
let variantIndex = 0;

function addVariantRow(name = '', sku = '', price = '', stock = 20) {
    const container = document.getElementById('variantsList');
    const template = document.getElementById('variantRowTemplate').innerHTML;
    const newHtml = template.replaceAll('INDEX', variantIndex);
    
    const div = document.createElement('div');
    div.innerHTML = newHtml;
    const row = div.firstElementChild;

    if (name) row.querySelector('.variant-name').value = name;
    if (sku) row.querySelector('.variant-sku').value = sku;
    if (price) row.querySelector('.variant-price').value = price;
    if (stock) row.querySelector('.variant-stock').value = stock;

    container.appendChild(row);
    variantIndex++;

    document.getElementById('noVariantsNotice').classList.add('hidden');
}

function removeVariantRow(btn) {
    btn.closest('.variant-row').remove();
    if (document.querySelectorAll('.variant-row').length === 0) {
        document.getElementById('noVariantsNotice').classList.remove('hidden');
    }
}

function applyFlashcardPresets() {
    const basePrice = document.getElementById('basePrice').value || 3500;
    const baseSku = document.getElementById('baseSku').value || 'PD-FC';
    addVariantRow('Pocket Size', baseSku + '-PKT', basePrice, 30);
    addVariantRow('Big Size', baseSku + '-BIG', parseFloat(basePrice) + 2000, 30);
}

function applyPuzzlePresets() {
    const basePrice = document.getElementById('basePrice').value || 4000;
    const baseSku = document.getElementById('baseSku').value || 'PD-PUZ';
    addVariantRow('Easy — 6 pieces', baseSku + '-E6', basePrice, 25);
    addVariantRow('Intermediate — 12 pieces', baseSku + '-I12', parseFloat(basePrice) + 1500, 25);
}

function addCustomVariant() {
    const basePrice = document.getElementById('basePrice').value || '';
    addVariantRow('', '', basePrice, 20);
}
</script>
@endsection
