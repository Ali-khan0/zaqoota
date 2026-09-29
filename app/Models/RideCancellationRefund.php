<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideCancellationRefund extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'user_id' => 'integer',
        'paid_amount' => 'float',
        'cancellation_allocated_amount' => 'float',
        'wallet_refund_amount' => 'float',
        'completed_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
