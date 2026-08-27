@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Product Catalog
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Edit Product: {{ $product->name }}</h1>
            <p class="text-xs text-slate-500">Update product details, pricing, stock levels, or cover image</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-3xl border border-amber-200/80 shadow-sm space-y-6 text-xs font-semibold">
        @csrf
        @method('PUT')

        <!-- Product Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Product Title *</label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-[#2D1B4E] font-bold mb-1">Category *</label>
                <select name="category_id" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl bg-white focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Price (NGN ₦) *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Sale Price (Optional ₦)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Stock Quantity *</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" required min="0" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
        </div>

        <!-- SKU Code & Cover Image -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">SKU Code *</label>
                <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl font-mono focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Update Primary Image (Optional)</label>
                <input type="file" name="primary_image" accept="image/*" class="w-full border border-slate-300 p-2 rounded-xl bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                
                @if($product->primaryImage)
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-[10px] text-slate-500">Current Image:</span>
                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" class="w-10 h-10 object-cover rounded-lg border">
                    </div>
                @endif
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-slate-700 font-bold mb-1">Product Overview & Description *</label>
            <textarea name="description" rows="4" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Flags -->
        <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-200/60 flex flex-col sm:flex-row gap-4">
            <label class="flex items-center gap-2 cursor-pointer text-slate-800">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="rounded border-slate-300 text-purple-700 focus:ring-amber-400">
                <span class="font-bold">Feature on Homepage (Bestseller Banner)</span>
            </label>

            <label class="flex items-center gap-2 cursor-pointer text-slate-800">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="rounded border-slate-300 text-emerald-700 focus:ring-amber-400">
                <span class="font-bold">Active in Catalog</span>
            </label>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-3 rounded-2xl transition text-center">Cancel</a>
            <button type="submit" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-6 py-3 rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                <i class="bi bi-pencil-square"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
