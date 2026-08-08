<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideCouponUsage extends Model
{
    public const STATUS_RESERVED = 'reserved';

    public const STATUS_REDEEMED = 'redeemed';

    public const STATUS_RELEASED = 'released';

    protected $guarded = ['id'];

    protected $casts = [
        'discount_amount' => 'float',
        'reserved_at' => 'datetime',
        'redeemed_at' => 'datetime',
        'released_at' => 'datetime',
    ];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(RideCoupon::class, 'ride_coupon_id');
    }

    public function ride(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class, 'ride_request_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
