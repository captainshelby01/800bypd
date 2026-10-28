@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-6 sm:space-y-8">
    <!-- Admin Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-amber-200/60 pb-5">
        <div>
            <div class="flex flex-wrap items-center gap-2 mb-1">
                <span class="bg-[#FBBF24] text-[#2D1B4E] font-black px-2.5 py-0.5 rounded-full text-[10px] uppercase">Admin Management Panel</span>
                <span class="text-xs text-slate-500 font-mono">/admin/categories</span>
            </div>
            <h1 class="font-whimsical font-bold text-2xl sm:text-3xl text-slate-900">Manage Store Categories</h1>
            <p class="text-xs text-slate-500">Create, edit, and organize product categories and classifications for the 800byPD store.</p>
        </div>

        <div class="flex flex-wrap sm:flex-nowrap items-center gap-2.5 w-full sm:w-auto">
            <a href="{{ route('admin.products.index') }}" class="bg-[#2D1B4E] hover:bg-purple-900 text-[#FBBF24] font-extrabold px-4 py-2.5 rounded-2xl text-xs flex items-center justify-center gap-2 shadow-md transition w-full sm:w-auto">
                <i class="bi bi-journal-bookmark-fill text-sm"></i> Product Catalog
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
            <i class="bi bi-receipt"></i> Orders & Payment Receipts
        </a>
        <a href="{{ route('admin.products.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-journal-bookmark-fill"></i> Product Catalog Management
        </a>
        <a href="{{ route('admin.categories.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-[#7C3AED] text-[#312E81] font-black flex items-center gap-2 bg-purple-50/50 rounded-t-2xl flex-shrink-0">
            <i class="bi bi-tags-fill text-[#7C3AED]"></i> Category Management
        </a>
        <a href="{{ route('admin.bundles.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-box2-heart-fill"></i> Product Bundles
        </a>
        <a href="{{ route('admin.settings.checkout') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
            <i class="bi bi-sliders"></i> Checkout Settings
        </a>
        @if(Auth::user()->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" class="px-4 sm:px-5 py-3 border-b-2 border-transparent text-slate-500 hover:text-slate-900 flex items-center gap-2 flex-shrink-0">
                <i class="bi bi-shield-lock-fill"></i> Admin & Staff Logins
            </a>
        @endif
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl text-xs flex items-center gap-2">
            <i class="bi bi-check-circle-fill text-emerald-600 text-base"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs flex items-center gap-2">
            <i class="bi bi-exclamation-triangle-fill text-rose-600 text-base"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-800 p-4 rounded-2xl text-xs space-y-1">
            @foreach ($errors->all() as $error)
                <p class="flex items-center gap-1.5"><i class="bi bi-exclamation-circle-fill text-rose-500"></i> {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8 items-start">
        <!-- Create Category Form Card (Left Column) -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-purple-200/80 shadow-sm space-y-4">
            <div class="border-b border-purple-100 pb-3">
                <span class="text-[10px] font-extrabold uppercase tracking-wider text-[#7C3AED] bg-purple-100 px-2 py-0.5 rounded-md inline-block">New Category</span>
                <h3 class="font-whimsical font-bold text-[#312E81] text-lg">Add New Category</h3>
                <p class="text-[11px] text-slate-500">Create a classification for storybooks, puzzles, flashcards, or study aids.</p>
            </div>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4 text-xs font-semibold">
                @csrf
                <div>
                    <label class="block text-slate-700 font-bold mb-1">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Activity Books" class="w-full border border-slate-300 px-3.5 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">URL Slug (Optional)</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" placeholder="e.g. activity-books (auto-generated if empty)" class="w-full border border-slate-300 px-3.5 py-2.5 rounded-xl font-mono text-[11px] focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Parent Category (Optional)</label>
                    <select name="parent_id" class="w-full border border-slate-300 px-3.5 py-2.5 rounded-xl bg-white focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">
                        <option value="">None (Top-Level Category)</option>
                        @foreach($parentCategories as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-slate-700 font-bold mb-1">Description (Optional)</label>
                    <textarea name="description" rows="3" placeholder="Brief summary of what this category offers..." class="w-full border border-slate-300 px-3.5 py-2.5 rounded-xl focus:ring-2 focus:ring-[#7C3AED] focus:outline-none">{{ old('description') }}</textarea>
                </div>

                <button type="submit" class="w-full bg-[#312E81] hover:bg-indigo-950 text-[#FACC15] font-extrabold py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center gap-2">
                    <i class="bi bi-plus-circle-fill text-sm"></i> Save Category
                </button>
            </form>
        </div>

        <!-- Categories Table (Right Column, 2 cols on lg) -->
        <div class="lg:col-span-2 bg-white border border-slate-200 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-whimsical font-bold text-slate-900 text-lg">Existing Categories</h3>
                    <p class="text-[11px] text-slate-500">Total of {{ $categories->total() }} categories configured.</p>
                </div>
            </div>

            <div class="overflow-x-auto -mx-5 sm:mx-0">
                <table class="w-full text-left text-xs border-collapse min-w-[550px] sm:min-w-full">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 uppercase font-bold text-[11px]">
                            <th class="p-3.5 whitespace-nowrap">Category Name</th>
                            <th class="p-3.5 whitespace-nowrap">Slug</th>
                            <th class="p-3.5 whitespace-nowrap">Parent</th>
                            <th class="p-3.5 whitespace-nowrap text-center">Products</th>
                            <th class="p-3.5 text-right whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @forelse($categories as $category)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-3.5">
                                    <div class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                        <i class="bi bi-tag-fill text-[#7C3AED]"></i>
                                        <span>{{ $category->name }}</span>
                                    </div>
                                    @if($category->description)
                                        <p class="text-[11px] text-slate-400 line-clamp-1 mt-0.5">{{ $category->description }}</p>
                                    @endif
                                </td>
                                <td class="p-3.5 font-mono text-purple-900 font-semibold text-[11px]">
                                    {{ $category->slug }}
                                </td>
                                <td class="p-3.5 whitespace-nowrap">
                                    @if($category->parent)
                                        <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded-md text-[10px] font-semibold">
                                            {{ $category->parent->name }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[10px]">Top-Level</span>
                                    @endif
                                </td>
                                <td class="p-3.5 text-center whitespace-nowrap">
                                    <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="inline-flex items-center gap-1 bg-purple-50 hover:bg-purple-100 text-[#7C3AED] font-extrabold px-2.5 py-1 rounded-full text-[11px] transition" title="View products in this category">
                                        <span>{{ $category->products_count }}</span>
                                        <span class="text-[9px] text-purple-400">items</span>
                                    </a>
                                </td>
                                <td class="p-3.5 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="bg-purple-100 hover:bg-purple-200 text-purple-900 font-bold px-3 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1">
                                            <i class="bi bi-pencil-square"></i> Edit
                                        </a>
                                        @if($category->products_count == 0)
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete category \'{{ $category->name }}\'?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-100 hover:bg-rose-200 text-rose-800 font-bold px-3 py-1.5 rounded-xl text-[11px] transition inline-flex items-center gap-1">
                                                    <i class="bi bi-trash-fill"></i> Delete
                                                </button>
                                            </form>
                                        @else
                                            <button type="button" disabled class="bg-slate-100 text-slate-400 font-bold px-3 py-1.5 rounded-xl text-[11px] cursor-not-allowed inline-flex items-center gap-1" title="Cannot delete: category has {{ $category->products_count }} product(s)">
                                                <i class="bi bi-lock-fill"></i> In Use
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-500 font-medium">
                                    <i class="bi bi-tags text-4xl text-amber-400 mb-2 block"></i>
                                    No categories found. Use the form on the left to create your first category.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($categories->hasPages())
                <div class="mt-4 pt-3 border-t border-slate-100">
                    {{ $categories->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
