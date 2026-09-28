<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommerceOrderNotificationDelivery extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'dispatch_wave' => 'integer',
        'pickup_distance_meters' => 'integer',
        'in_app_stored' => 'boolean',
        'push_attempts' => 'integer',
        'last_attempted_at' => 'datetime',
        'accepted_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function canQueuePush(): bool
    {
        if (in_array($this->push_status, ['accepted', 'disabled', 'superseded'], true)) {
            return false;
        }

        if ($this->push_status === 'failed' && $this->push_attempts > 0) {
            return false;
        }

        return $this->push_status !== 'queued'
            || $this->updated_at?->lt(now()->subMinutes(5)) === true;
    }
}
