<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideFare extends Model
{
    protected $fillable = [
        'zone_id', 'ride_category_id', 'base_fare', 'minimum_fare', 'per_km_charge',
        'per_minute_charge', 'pickup_distance_charge', 'waiting_charge_per_minute',
        'free_waiting_minutes', 'cancellation_charge', 'platform_commission_percent',
        'negotiation_min_percent', 'negotiation_max_percent', 'offer_expiry_seconds', 'status',
    ];

    protected $casts = [
        'base_fare' => 'float', 'minimum_fare' => 'float', 'per_km_charge' => 'float',
        'per_minute_charge' => 'float', 'pickup_distance_charge' => 'float',
        'waiting_charge_per_minute' => 'float', 'cancellation_charge' => 'float',
        'free_waiting_minutes' => 'integer', 'offer_expiry_seconds' => 'integer',
        'platform_commission_percent' => 'float', 'negotiation_min_percent' => 'float',
        'negotiation_max_percent' => 'float', 'status' => 'boolean',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RideCategory::class, 'ride_category_id');
    }
}
