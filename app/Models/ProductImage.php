<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image_path', 'is_primary', 'sort_order'];

    protected $casts = [
        'is_primary' => 'boolean',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function getUrlAttribute(): string
    {
        if (empty($this->image_path)) {
            return asset('images/products/placeholder.svg');
        }

        // Remote URL (e.g. S3 / CDN / External)
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }

        $cleanPath = ltrim($this->image_path, '/');
        if (str_starts_with($cleanPath, 'storage/')) {
            $cleanPath = substr($cleanPath, 8);
        } elseif (str_starts_with($cleanPath, 'public/')) {
            $cleanPath = substr($cleanPath, 7);
        }

        // Check if file physically exists in public/storage or storage/app/public
        if (file_exists(public_path('storage/' . $cleanPath)) || file_exists(storage_path('app/public/' . $cleanPath))) {
            return asset('storage/' . $cleanPath);
        }

        // Check if file exists in public/images/products (for initial seeded assets)
        $basename = basename($cleanPath);
        if (file_exists(public_path('images/products/' . $basename))) {
            return asset('images/products/' . $basename);
        }

        // Default to public storage URL
        return asset('storage/' . $cleanPath);
    }
}
