<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'primaryImage', 'variants'])->latest();

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

            // Ensure availability in public/storage even if symlink is detached
            if (!file_exists(public_path('storage/' . $path))) {
                @mkdir(dirname(public_path('storage/' . $path)), 0755, true);
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            }

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $path,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        // Handle Product Variations (e.g. Flashcard sizes, Puzzle difficulty levels)
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $v) {
                if (!empty($v['name'])) {
                    $variantSku = !empty($v['sku']) ? $v['sku'] : $product->sku . '-' . strtoupper(Str::random(4));
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $v['name'],
                        'sku' => $variantSku,
                        'price' => !empty($v['price']) ? (float)$v['price'] : $product->price,
                        'stock' => isset($v['stock']) ? (int)$v['stock'] : $product->stock_quantity,
                        'attributes' => !empty($v['attributes']) ? (is_array($v['attributes']) ? $v['attributes'] : json_decode($v['attributes'], true)) : ['variant' => $v['name']],
                    ]);
                }
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' added successfully!");
    }

    public function edit($id)
    {
        $product = Product::with(['primaryImage', 'variants'])->findOrFail($id);
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

            // Ensure availability in public/storage even if symlink is detached
            if (!file_exists(public_path('storage/' . $path))) {
                @mkdir(dirname(public_path('storage/' . $path)), 0755, true);
                @copy(storage_path('app/public/' . $path), public_path('storage/' . $path));
            }
            
            // Delete old primary image if exists
            $oldImage = ProductImage::where('product_id', $product->id)->where('is_primary', true)->first();
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image_path);
                if (file_exists(public_path('storage/' . $oldImage->image_path))) {
                    @unlink(public_path('storage/' . $oldImage->image_path));
                }
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

        // Sync Product Variations (e.g. Flashcard sizes, Puzzle difficulty levels)
        if ($request->has('variants') && is_array($request->variants)) {
            $keptVariantIds = [];
            foreach ($request->variants as $v) {
                if (!empty($v['name'])) {
                    $variantSku = !empty($v['sku']) ? $v['sku'] : $product->sku . '-' . strtoupper(Str::random(4));
                    $variantData = [
                        'product_id' => $product->id,
                        'name' => $v['name'],
                        'sku' => $variantSku,
                        'price' => !empty($v['price']) ? (float)$v['price'] : $product->price,
                        'stock' => isset($v['stock']) ? (int)$v['stock'] : 0,
                        'attributes' => !empty($v['attributes']) ? (is_array($v['attributes']) ? $v['attributes'] : json_decode($v['attributes'], true)) : ['variant' => $v['name']],
                    ];

                    if (!empty($v['id'])) {
                        $variant = ProductVariant::where('product_id', $product->id)->find($v['id']);
                        if ($variant) {
                            $variant->update($variantData);
                            $keptVariantIds[] = $variant->id;
                        }
                    } else {
                        $newVariant = ProductVariant::create($variantData);
                        $keptVariantIds[] = $newVariant->id;
                    }
                }
            }

            // Delete variants that were removed by the admin
            ProductVariant::where('product_id', $product->id)
                ->whereNotIn('id', $keptVariantIds)
                ->delete();
        } elseif ($request->has('has_no_variants')) {
            ProductVariant::where('product_id', $product->id)->delete();
        }

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$product->name}' updated successfully!");
    }

    public function destroy($id)
    {
        $product = Product::with('images')->findOrFail($id);
        
        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image_path);
            if (file_exists(public_path('storage/' . $img->image_path))) {
                @unlink(public_path('storage/' . $img->image_path));
            }
            $img->delete();
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "Product '{$name}' deleted successfully!");
    }

    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();

        $statusText = $product->is_active ? 'enabled and is now active on the store' : 'disabled and hidden from the storefront';

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $product->is_active,
                'message' => "Product '{$product->name}' has been {$statusText}.",
            ]);
        }

        return back()->with('success', "Product '{$product->name}' has been {$statusText}.");
    }
}
