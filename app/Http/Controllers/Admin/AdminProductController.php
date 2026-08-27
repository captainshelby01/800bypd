<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage'])->latest();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->get('category'));
        }

        $products = $query->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'sku' => 'nullable|string|unique:products,sku',
            'is_featured' => 'nullable|boolean',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $slug = Str::slug($validated['name']) . '-' . Str::random(4);
        $sku = $validated['sku'] ?? '800-' . strtoupper(Str::random(6));

        $product = Product::create([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $sku,
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'description' => $validated['description'],
            'is_featured' => $request->has('is_featured'),
            'is_active' => true,
        ]);

        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' added successfully!");
    }

    public function edit($id)
    {
        $product = Product::with('primaryImage')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'stock_quantity' => 'required|integer|min:0',
            'description' => 'required|string',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'sku' => $validated['sku'],
            'price' => $validated['price'],
            'sale_price' => $validated['sale_price'] ?? null,
            'stock_quantity' => $validated['stock_quantity'],
            'description' => $validated['description'],
            'is_featured' => $request->has('is_featured'),
            'is_active' => $request->has('is_active'),
        ]);

        if ($request->hasFile('primary_image')) {
            $path = $request->file('primary_image')->store('products', 'public');
            
            // Delete old primary image if exists
            $oldImage = ProductImage::where('product_id', $product->id)->where('is_primary', true)->first();
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
                $oldImage->update(['image_path' => $path]);
            } else {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                    'is_primary' => true,
                    'sort_order' => 0,
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully!");
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            $img->delete();
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted successfully!");
    }
}
