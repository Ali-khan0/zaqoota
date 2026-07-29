<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DmBonusMilestone extends Model
{
    protected $fillable = [
        'period_type',
        'slot',
        'orders_required',
        'bonus_amount',
        'status',
    ];

    protected $casts = [
        'orders_required' => 'integer',
        'bonus_amount' => 'float',
        'status' => 'boolean',
    ];

    public function awards(): HasMany
    {
        return $this->hasMany(DmBonusAward::class, 'dm_bonus_milestone_id');
    }
}
