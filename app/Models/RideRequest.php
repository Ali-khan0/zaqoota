<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RideRequest extends Model
{
    public const STATUS_SEARCHING = 'searching';

    public const STATUS_NEGOTIATING = 'negotiating';

    public const STATUS_RIDER_SELECTED = 'rider_selected';

    public const STATUS_CAPTAIN_ARRIVING = 'captain_arriving';

    public const STATUS_ARRIVED = 'arrived';

    public const STATUS_IN_PROGRESS = 'in_progress';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const ACTIVE_CUSTOMER_STATUSES = [
        self::STATUS_SEARCHING,
        self::STATUS_NEGOTIATING,
        self::STATUS_RIDER_SELECTED,
        self::STATUS_CAPTAIN_ARRIVING,
        self::STATUS_ARRIVED,
        self::STATUS_IN_PROGRESS,
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'user_id' => 'integer',
        'zone_id' => 'integer',
        'ride_category_id' => 'integer',
        'ride_fare_id' => 'integer',
        'ride_coupon_id' => 'integer',
        'delivery_man_id' => 'integer',
        'ride_vehicle_id' => 'integer',
        'accepted_offer_id' => 'integer',
        'pickup_latitude' => 'float',
        'pickup_longitude' => 'float',
        'destination_latitude' => 'float',
        'destination_longitude' => 'float',
        'distance_meters' => 'integer',
        'duration_seconds' => 'integer',
        'base_fare' => 'float',
        'minimum_fare' => 'float',
        'per_km_charge' => 'float',
        'per_minute_charge' => 'float',
        'waiting_charge_per_minute' => 'float',
        'free_waiting_minutes' => 'integer',
        'cancellation_charge' => 'float',
        'platform_commission_percent' => 'float',
        'suggested_fare' => 'float',
        'minimum_negotiated_fare' => 'float',
        'maximum_negotiated_fare' => 'float',
        'customer_offer' => 'float',
        'coupon_discount_amount' => 'float',
        'admin_coupon_expense_amount' => 'float',
        'coupon_payment_methods' => 'array',
        'final_accepted_fare' => 'float',
        'platform_commission_amount' => 'float',
        'rider_earning_amount' => 'float',
        'offer_expiry_seconds' => 'integer',
        'trip_pin' => 'encrypted',
        'selected_at' => 'datetime',
        'captain_arriving_at' => 'datetime',
        'arrived_at' => 'datetime',
        'trip_started_at' => 'datetime',
        'completed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'cancellation_charge_amount' => 'float',
        'carried_cancellation_due_amount' => 'float',
        'cancellation_compensation_paid_at' => 'datetime',
        'cancellation_recovered_at' => 'datetime',
        'recovery_ride_id' => 'integer',
        'charged_waiting_minutes' => 'integer',
        'waiting_charge_amount' => 'float',
        'final_payable_amount' => 'float',
        'wallet_paid_amount' => 'float',
        'captain_total_earning_amount' => 'float',
        'current_latitude' => 'float',
        'current_longitude' => 'float',
        'location_updated_at' => 'datetime',
        'paid_at' => 'datetime',
        'settled_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RideCategory::class, 'ride_category_id');
    }

    public function fare(): BelongsTo
    {
        return $this->belongsTo(RideFare::class, 'ride_fare_id');
    }

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(RideCoupon::class, 'ride_coupon_id');
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function rideVehicle(): BelongsTo
    {
        return $this->belongsTo(RideVehicle::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(RideOffer::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(RideStatusHistory::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(RidePayment::class);
    }

    public function couponUsages(): HasMany
    {
        return $this->hasMany(RideCouponUsage::class);
    }
}
