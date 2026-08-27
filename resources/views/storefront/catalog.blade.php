@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-black text-gray-900">Product Catalog</h1>
    <p class="text-xs text-gray-500">Explore all available products in Naira ₦</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
    <!-- Sidebar Filters -->
    <div class="bg-white p-6 rounded-2xl border shadow-sm h-fit">
        <h3 class="font-bold text-gray-900 text-base mb-4 flex items-center justify-between">
            <span>Filters</span>
            <a href="{{ route('catalog.index') }}" class="text-xs text-indigo-600 font-semibold hover:underline">Reset</a>
        </h3>

        <form action="{{ route('catalog.index') }}" method="GET" class="space-y-6">
            <!-- Search -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Search Keywords</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Keyword..." class="w-full border px-3 py-2 text-xs rounded-lg focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Categories -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-2">Category</label>
                <div class="space-y-1 max-h-48 overflow-y-auto text-xs">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-2 text-gray-600 cursor-pointer">
                            <input type="radio" name="category" value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'checked' : '' }} onchange="this.form.submit()">
                            <span>{{ $category->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Sort By -->
            <div>
                <label class="block text-xs font-semibold text-gray-700 mb-1">Sort By</label>
                <select name="sort" onchange="this.form.submit()" class="w-full border px-3 py-2 text-xs rounded-lg bg-white">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="bestsellers" {{ request('sort') == 'bestsellers' ? 'selected' : '' }}>Bestsellers</option>
                </select>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-semibold text-xs py-2.5 rounded-xl hover:bg-indigo-700">Apply Filters</button>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="lg:col-span-3">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition group flex flex-col justify-between">
                    <div>
                        <div class="h-48 bg-gray-100 relative overflow-hidden flex items-center justify-center">
                            @if($product->primaryImage)
                                <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <i class="fa-solid fa-image text-4xl text-gray-300"></i>
                            @endif
                        </div>
                        <div class="p-4">
                            <span class="text-[11px] font-semibold text-indigo-600 uppercase tracking-wide">{{ $product->category->name ?? 'General' }}</span>
                            <h3 class="font-bold text-gray-900 text-base mb-1 line-clamp-1">
                                <a href="{{ route('catalog.show', $product->slug) }}" class="hover:text-indigo-600">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-gray-500 line-clamp-2 mb-3">{{ $product->description }}</p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 border-t border-gray-50 flex items-center justify-between mt-auto">
                        <span class="text-lg font-black text-indigo-900">{{ $product->formatted_price }}</span>
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold px-3 py-2 rounded-xl flex items-center gap-1">
                                <i class="fa-solid fa-plus"></i> Add
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-white border rounded-2xl">
                    <p>No products matching your search criteria.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
