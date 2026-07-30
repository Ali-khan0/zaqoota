<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FleetManagerRiderAssignment extends Model
{
    protected $fillable = [
        'fleet_manager_id',
        'delivery_man_id',
        'assigned_by',
        'ended_by',
        'started_at',
        'ended_at',
        'is_active',
        'reason',
        'end_reason',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function fleetManager(): BelongsTo
    {
        return $this->belongsTo(FleetManager::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_by');
    }

    public function endedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'ended_by');
    }
}
