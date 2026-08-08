<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideStatusHistory extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'actor_id' => 'integer',
        'metadata' => 'array',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }
}
