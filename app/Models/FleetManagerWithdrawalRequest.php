<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FleetManagerWithdrawalRequest extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'fleet_manager_id',
        'fleet_manager_withdrawal_method_id',
        'withdrawal_method_id',
        'amount',
        'method_name',
        'method_fields',
        'manager_note',
        'status',
        'admin_note',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'method_fields' => 'array',
        'reviewed_at' => 'datetime',
    ];

    public function fleetManager(): BelongsTo
    {
        return $this->belongsTo(FleetManager::class);
    }

    public function savedMethod(): BelongsTo
    {
        return $this->belongsTo(FleetManagerWithdrawalMethod::class, 'fleet_manager_withdrawal_method_id');
    }

    public function withdrawalMethod(): BelongsTo
    {
        return $this->belongsTo(WithdrawalMethod::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }
}
