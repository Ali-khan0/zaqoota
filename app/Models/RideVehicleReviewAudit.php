<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideVehicleReviewAudit extends Model
{
    protected $fillable = [
        'ride_vehicle_id',
        'admin_id',
        'from_status',
        'to_status',
        'admin_note',
        'reviewed_at',
    ];

    protected $casts = ['reviewed_at' => 'datetime'];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(RideVehicle::class, 'ride_vehicle_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
