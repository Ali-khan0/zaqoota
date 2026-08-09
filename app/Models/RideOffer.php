<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideOffer extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_ACCEPTED = 'accepted';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_EXPIRED = 'expired';

    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'delivery_man_id' => 'integer',
        'ride_vehicle_id' => 'integer',
        'amount' => 'float',
        'pickup_distance_meters' => 'integer',
        'pickup_eta_seconds' => 'integer',
        'expires_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function rideVehicle(): BelongsTo
    {
        return $this->belongsTo(RideVehicle::class);
    }
}
