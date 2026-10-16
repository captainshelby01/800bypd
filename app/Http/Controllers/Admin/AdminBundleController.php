<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bundle;
use App\Models\BundleItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminBundleController extends Controller
{
    public function index()
    {
        $bundles = Bundle::with(['items.product', 'items.variant'])
            ->orderBy('sort_order', 'asc')
            ->latest()
            ->paginate(12);

        return view('admin.bundles.index', compact('bundles'));
    }

    public function create()
    {
        $products = Product::with('variants')->where('is_active', true)->orderBy('name')->get();
        return view('admin.bundles.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1|max:50',
        ], [
            'items.required' => 'You must include at least one product in the bundle.',
            'items.min' => 'You must include at least one product in the bundle.',
        ]);

        $slug = Str::slug($validated['name']) . '-' . Str::random(4);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('bundles', 'public');
        }

        $bundle = Bundle::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => Bundle::count() + 1,
        ]);

        foreach ($validated['items'] as $itemData) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'product_id' => $itemData['product_id'],
                'product_variant_id' => !empty($itemData['product_variant_id']) ? $itemData['product_variant_id'] : null,
                'quantity' => (int) $itemData['quantity'],
            ]);
        }

        return redirect()->route('admin.bundles.index')
            ->with('success', "Bundle '{$bundle->name}' created successfully with {$bundle->total_items_count} items!");
    }

    public function edit($id)
    {
        $bundle = Bundle::with(['items.product', 'items.variant'])->findOrFail($id);
        $products = Product::with('variants')->where('is_active', true)->orderBy('name')->get();

        return view('admin.bundles.edit', compact('bundle', 'products'));
    }

    public function update(Request $request, $id)
    {
        $bundle = Bundle::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'badge' => 'nullable|string|max:100',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.product_variant_id' => 'nullable|exists:product_variants,id',
            'items.*.quantity' => 'required|integer|min:1|max:50',
        ], [
            'items.required' => 'You must include at least one product in the bundle.',
            'items.min' => 'You must include at least one product in the bundle.',
        ]);

        if ($request->hasFile('image')) {
            if ($bundle->image) {
                Storage::disk('public')->delete($bundle->image);
            }
            $bundle->image = $request->file('image')->store('bundles', 'public');
        }

        $bundle->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'original_price' => $validated['original_price'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'image' => $bundle->image,
            'is_active' => $request->has('is_active'),
        ]);

        // Sync items: replace with new items
        $bundle->items()->delete();
        foreach ($validated['items'] as $itemData) {
            BundleItem::create([
                'bundle_id' => $bundle->id,
                'product_id' => $itemData['product_id'],
                'product_variant_id' => !empty($itemData['product_variant_id']) ? $itemData['product_variant_id'] : null,
                'quantity' => (int) $itemData['quantity'],
            ]);
        }

        return redirect()->route('admin.bundles.index')
            ->with('success', "Bundle '{$bundle->name}' updated successfully!");
    }

    public function toggleActive($id)
    {
        $bundle = Bundle::findOrFail($id);
        $bundle->is_active = !$bundle->is_active;
        $bundle->save();

        $statusText = $bundle->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Bundle '{$bundle->name}' has been {$statusText}.");
    }

    public function destroy($id)
    {
        $bundle = Bundle::findOrFail($id);
        if ($bundle->image) {
            Storage::disk('public')->delete($bundle->image);
        }
        $name = $bundle->name;
        $bundle->delete();

        return redirect()->route('admin.bundles.index')
            ->with('success', "Bundle '{$name}' deleted successfully.");
    }
}
