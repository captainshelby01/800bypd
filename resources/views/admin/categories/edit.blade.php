@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <a href="{{ route('admin.categories.index') }}" class="text-xs text-purple-700 font-bold hover:underline mb-1 inline-flex items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to Category Management
            </a>
            <h1 class="font-whimsical text-2xl sm:text-3xl font-bold text-[#2D1B4E]">Edit Category: {{ $category->name }}</h1>
            <p class="text-xs text-slate-500">Update category title, URL slug, description, or hierarchy.</p>
        </div>

        <span class="bg-purple-100 text-[#7C3AED] font-extrabold text-xs px-3 py-1 rounded-full flex items-center gap-1">
            <i class="bi bi-box-seam"></i> {{ $category->products_count }} Products Linked
        </span>
    </div>

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-circle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white p-5 sm:p-8 rounded-3xl border border-purple-200/80 shadow-sm space-y-5 text-xs font-semibold">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-slate-700 font-bold mb-1">Category Title *</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none text-sm font-semibold">
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-1">URL Slug *</label>
            <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required class="w-full border border-slate-300 px-3.5 py-3 rounded-xl font-mono text-xs focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
            <p class="text-[10px] text-slate-400 mt-1">Used in website URLs (e.g. <code>/catalog?category={{ $category->slug }}</code>)</p>
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-1">Parent Category</label>
            <select name="parent_id" class="w-full border border-slate-300 px-3.5 py-3 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                <option value="">None (Top-Level Category)</option>
                @foreach($parentCategories as $parent)
                    <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-slate-700 font-bold mb-1">Description</label>
            <textarea name="description" rows="4" placeholder="Brief summary of products in this category..." class="w-full border border-slate-300 px-3.5 py-3 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none leading-relaxed">{{ old('description', $category->description) }}</textarea>
        </div>

        <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100">
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition font-bold">
                Cancel
            </a>
            <button type="submit" class="bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold px-6 py-2.5 rounded-xl shadow-md transition flex items-center gap-1.5">
                <i class="bi bi-check-circle-fill"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection
