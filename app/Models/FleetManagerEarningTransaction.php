<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FleetManagerEarningTransaction extends Model
{
    public const STATUS_EARNED = 'earned';
    public const STATUS_REVERSED = 'reversed';

    protected $fillable = [
        'fleet_manager_id',
        'delivery_man_id',
        'order_id',
        'order_transaction_id',
        'delivery_amount',
        'admin_commission_amount',
        'fleet_commission_percentage',
        'amount',
        'status',
        'reversed_at',
    ];

    protected $casts = [
        'delivery_amount' => 'float',
        'admin_commission_amount' => 'float',
        'fleet_commission_percentage' => 'float',
        'amount' => 'float',
        'reversed_at' => 'datetime',
    ];

    public function fleetManager(): BelongsTo
    {
        return $this->belongsTo(FleetManager::class);
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderTransaction(): BelongsTo
    {
        return $this->belongsTo(OrderTransaction::class);
    }
}
