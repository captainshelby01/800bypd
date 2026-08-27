@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <a href="{{ route('admin.products.index') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Product Catalog
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Add New Product</h1>
            <p class="text-xs text-slate-500">Create a new book, puzzle, or activity book for the 800bypd storefront</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-triangle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-5 sm:p-8 rounded-3xl border border-amber-200/80 shadow-sm space-y-6 text-xs font-semibold">
        @csrf

        <!-- Product Name & Category -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Product Title *</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Adventures of the Little Explorer" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-[#2D1B4E] font-bold mb-1">Category *</label>
                <select name="category_id" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl bg-white focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    <option value="">Select Category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Pricing & Stock -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">Price (NGN ₦) *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price') }}" required placeholder="5000.00" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Sale Price (Optional ₦)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="4500.00" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Stock Quantity *</label>
                <input type="number" name="stock_quantity" value="{{ old('stock_quantity', 10) }}" required min="0" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
        </div>

        <!-- SKU Code & Cover Image -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-slate-700 font-bold mb-1">SKU Code (Optional)</label>
                <input type="text" name="sku" value="{{ old('sku') }}" placeholder="e.g. 800-BOOK-001" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl font-mono focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>

            <div>
                <label class="block text-slate-700 font-bold mb-1">Primary Cover Image *</label>
                <input type="file" name="primary_image" required accept="image/*" class="w-full border border-slate-300 p-2 rounded-xl bg-slate-50 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                <span class="text-[10px] text-slate-400 mt-1 block">Supported formats: JPG, PNG, WEBP (Max size 4MB)</span>
            </div>
        </div>

        <!-- Description -->
        <div>
            <label class="block text-slate-700 font-bold mb-1">Product Overview & Description *</label>
            <textarea name="description" rows="4" required placeholder="Write a detailed description highlighting the story line, age group, material, or learning benefits..." class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-amber-400 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <!-- Flags -->
        <div class="p-4 bg-amber-50/50 rounded-2xl border border-amber-200/60">
            <label class="flex items-center gap-2 cursor-pointer text-slate-800">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="rounded border-slate-300 text-purple-700 focus:ring-amber-400">
                <span class="font-bold">Feature on Homepage (Bestseller Banner)</span>
            </label>
        </div>

        <!-- Submit Buttons -->
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('admin.products.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-3 rounded-2xl transition text-center">Cancel</a>
            <button type="submit" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-6 py-3 rounded-2xl shadow-md transition flex items-center justify-center gap-2 text-sm">
                <i class="bi bi-plus-circle-fill"></i> Save & Publish Product
            </button>
        </div>
    </form>
</div>
@endsection
