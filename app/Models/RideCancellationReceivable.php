<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideCancellationReceivable extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_CLEARED = 'cleared';

    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'user_id' => 'integer',
        'delivery_man_id' => 'integer',
        'collection_ride_id' => 'integer',
        'amount' => 'float',
        'cleared_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }

    public function collectionRide(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class, 'collection_ride_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }
}
