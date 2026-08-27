<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'price', 
        'sale_price', 'stock_quantity', 'description', 
        'specifications', 'is_featured', 'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage() {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function getFormattedPriceAttribute() {
        return '₦' . number_format($this->sale_price ?? $this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute() {
        return $this->sale_price ? '₦' . number_format($this->price, 2) : null;
    }
}
