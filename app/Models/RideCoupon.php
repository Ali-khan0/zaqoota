<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RideCoupon extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'float',
        'max_discount' => 'float',
        'min_fare' => 'float',
        'zone_ids' => 'array',
        'ride_category_ids' => 'array',
        'payment_methods' => 'array',
        'first_ride_only' => 'boolean',
        'total_limit' => 'integer',
        'per_user_limit' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'status' => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(RideCouponUsage::class);
    }
}
