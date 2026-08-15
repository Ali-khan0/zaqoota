<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideRating extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'user_id' => 'integer',
        'delivery_man_id' => 'integer',
        'rating' => 'integer',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
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
