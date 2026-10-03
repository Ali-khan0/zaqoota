<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpsManagerPayoutMethod extends Model
{
    protected $fillable = [
        'manager_id',
        'type',
        'account_title',
        'provider_name',
        'account_number',
        'account_last_four',
        'is_active',
    ];

    protected $hidden = ['account_number'];

    protected $casts = [
        'account_number' => 'encrypted',
        'is_active' => 'boolean',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'manager_id');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(OpsManagerWithdrawal::class, 'payout_method_id');
    }
}
