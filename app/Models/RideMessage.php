<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideMessage extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'sender_id' => 'integer',
        'seen_by_id' => 'integer',
        'seen_at' => 'datetime',
    ];

    public function rideRequest(): BelongsTo
    {
        return $this->belongsTo(RideRequest::class);
    }
}
