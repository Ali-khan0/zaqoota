<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideNotificationDelivery extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'in_app_stored' => 'boolean',
        'push_attempts' => 'integer',
        'last_attempted_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }
}
