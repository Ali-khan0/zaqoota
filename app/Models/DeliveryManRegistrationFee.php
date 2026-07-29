<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryManRegistrationFee extends Model
{
    protected $fillable = [
        'delivery_man_id',
        'total_fee',
        'manual_paid_amount',
        'manual_confirmed',
        'manual_confirmed_at',
        'wallet_remaining_due',
        'deduction_percent',
        'deduction_frequency',
        'last_wallet_deduction_at',
        'completed_at',
    ];

    protected $casts = [
        'total_fee' => 'float',
        'manual_paid_amount' => 'float',
        'manual_confirmed' => 'boolean',
        'manual_confirmed_at' => 'datetime',
        'wallet_remaining_due' => 'float',
        'deduction_percent' => 'float',
        'last_wallet_deduction_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }
}
