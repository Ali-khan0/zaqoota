<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DmBonusAward extends Model
{
    protected $fillable = [
        'delivery_man_id',
        'dm_bonus_milestone_id',
        'period_key',
        'delivered_count',
        'amount',
        'awarded_at',
    ];

    protected $casts = [
        'delivered_count' => 'integer',
        'amount' => 'float',
        'awarded_at' => 'datetime',
    ];

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(DmBonusMilestone::class, 'dm_bonus_milestone_id');
    }
}
