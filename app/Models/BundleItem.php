<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BundleItem extends Model
{
    protected $fillable = [
        'bundle_id',
        'product_id',
        'product_variant_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    public function bundle()
    {
        return $this->belongsTo(Bundle::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get human-readable description of this bundle item.
     * E.g. "Safari Animals Puzzle (Easy — 6 pieces)" or "Everyday Words Flashcards"
     */
    public function getDisplayNameAttribute(): string
    {
        $baseName = $this->product?->name ?? 'Product';
        if ($this->variant?->name) {
            return "{$baseName} ({$this->variant->name})";
        }
        return $baseName;
    }
}
