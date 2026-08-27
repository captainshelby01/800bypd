<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'customer_name', 'customer_email',
        'customer_phone', 'shipping_address', 'city', 'state',
        'shipping_method', 'special_instructions',
        'subtotal', 'discount_amount', 'shipping_fee', 'total_amount',
        'payment_method', 'payment_status', 'payment_reference',
        'bank_transfer_receipt', 'order_status'
    ];

    public function items() {
        return $this->hasMany(OrderItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getFormattedTotalAttribute() {
        return '₦' . number_format($this->total_amount, 2);
    }

    public function getFormattedSubtotalAttribute() {
        return '₦' . number_format($this->subtotal, 2);
    }
}
