<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FleetManagerWallet extends Model
{
    protected $fillable = [
        'fleet_manager_id',
        'total_earning',
        'total_withdrawn',
        'pending_withdraw',
    ];

    protected $casts = [
        'total_earning' => 'float',
        'total_withdrawn' => 'float',
        'pending_withdraw' => 'float',
    ];

    public function getAvailableBalanceAttribute(): float
    {
        return max(0, round(
            (float) $this->total_earning - ((float) $this->total_withdrawn + (float) $this->pending_withdraw),
            2
        ));
    }

    public function fleetManager(): BelongsTo
    {
        return $this->belongsTo(FleetManager::class);
    }
}
