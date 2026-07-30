<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FleetManagerWithdrawalMethod extends Model
{
    protected $fillable = [
        'fleet_manager_id',
        'withdrawal_method_id',
        'method_name',
        'method_fields',
        'is_default',
    ];

    protected $casts = [
        'method_fields' => 'array',
        'is_default' => 'boolean',
    ];

    public function fleetManager(): BelongsTo
    {
        return $this->belongsTo(FleetManager::class);
    }

    public function withdrawalMethod(): BelongsTo
    {
        return $this->belongsTo(WithdrawalMethod::class);
    }

    public function withdrawalRequests(): HasMany
    {
        return $this->hasMany(FleetManagerWithdrawalRequest::class);
    }
}
