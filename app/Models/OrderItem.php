<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'bundle_id',
        'product_name',
        'variation_name',
        'bundle_details',
        'price',
        'quantity',
    ];

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function bundle() {
        return $this->belongsTo(Bundle::class);
    }

    public function getFormattedPriceAttribute() {
        return '₦' . number_format($this->price, 2);
    }

    public function getFormattedTotalAttribute() {
        return '₦' . number_format($this->price * $this->quantity, 2);
    }
}
