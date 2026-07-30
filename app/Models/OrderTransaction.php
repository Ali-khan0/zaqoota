<?php

namespace App\Models;

use App\Scopes\ZoneScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderTransaction extends Model
{
    use HasFactory;

    protected $fillable = array('delivery_man_id');

    protected $casts = [
        'fleet_manager_commission' => 'float',
    ];

    public const NET_ADMIN_COMMISSION_SQL =
        'admin_commission - COALESCE(fleet_manager_commission, 0)';

    public const NET_NON_DELIVERY_COMMISSION_SQL =
        'admin_commission + admin_expense - delivery_fee_comission'
        . ' - CASE WHEN delivery_fee_comission <= 0'
        . ' THEN COALESCE(fleet_manager_commission, 0) ELSE 0 END';

    public const NET_DELIVERY_COMMISSION_SQL =
        'delivery_fee_comission - CASE WHEN delivery_fee_comission > 0'
        . ' THEN COALESCE(fleet_manager_commission, 0) ELSE 0 END';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function delivery_man()
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    public function scopeModule($query, $module_id)
    {
        return $query->where('module_id', $module_id);
    }

    public function scopeNotRefunded($query)
    {
        return $query->where(function($query){
            $query->whereNotIn('status', ['refunded_with_delivery_charge', 'refunded_without_delivery_charge'])->orWhereNull('status');
        });
    }
    public function scopeRefunded($query)
    {
        return $query->where(function($query){
            $query->whereIn('status', ['refunded_with_delivery_charge', 'refunded_without_delivery_charge']);
        });
    }

    public function getNetAdminCommissionAttribute(): float
    {
        return (float) $this->admin_commission - (float) $this->fleet_manager_commission;
    }

    public function getNetNonDeliveryCommissionAttribute(): float
    {
        $fleetShare = (float) $this->delivery_fee_comission <= 0
            ? (float) $this->fleet_manager_commission
            : 0;

        return (float) $this->admin_commission
            + (float) $this->admin_expense
            - (float) $this->delivery_fee_comission
            - $fleetShare;
    }

    public function getNetDeliveryCommissionAttribute(): float
    {
        $fleetShare = (float) $this->delivery_fee_comission > 0
            ? (float) $this->fleet_manager_commission
            : 0;

        return (float) $this->delivery_fee_comission - $fleetShare;
    }

    protected static function booted()
    {
        static::addGlobalScope(new ZoneScope);
    }
}
