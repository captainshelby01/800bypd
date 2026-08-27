<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'value', 'min_spend', 'expires_at'];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
