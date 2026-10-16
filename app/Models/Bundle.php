<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bundle extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'original_price',
        'image',
        'badge',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(BundleItem::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_items')
                    ->withPivot('product_variant_id', 'quantity')
                    ->withTimestamps();
    }

    /**
     * Total number of individual items in this bundle.
     * E.g. 2 puzzles + 1 book + 1 flashcard + 1 coloring book = 5 items.
     * This directly contributes to the "Fill Your Box" item counter.
     */
    public function getTotalItemsCountAttribute(): int
    {
        return (int) $this->items->sum('quantity');
    }

    public function getFormattedPriceAttribute(): string
    {
        return '₦' . number_format($this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute(): ?string
    {
        return $this->original_price ? '₦' . number_format($this->original_price, 2) : null;
    }

    public function getSavingsPercentageAttribute(): ?int
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return (int) round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return null;
    }
}
