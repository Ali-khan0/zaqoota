<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RidePayment extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'user_id' => 'integer',
        'delivery_man_id' => 'integer',
        'amount' => 'float',
        'paid_at' => 'datetime',
        'failed_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }
}
