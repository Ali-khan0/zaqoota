<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RideVehicle extends Model
{
    public const MAX_PER_RIDER = 2;
    public const STATUSES = ['pending', 'approved', 'rejected'];
    public const FUEL_TYPES = ['petrol', 'electric', 'hybrid', 'diesel'];

    protected $fillable = [
        'delivery_man_id', 'ride_vehicle_type_id', 'ride_category_id', 'fuel_type', 'make', 'model',
        'model_year', 'color', 'registration_number', 'front_image', 'front_image_storage',
        'back_image', 'back_image_storage', 'status', 'is_active', 'admin_note',
    ];

    protected $casts = ['model_year' => 'integer', 'is_active' => 'boolean'];
    protected $appends = ['front_image_full_url', 'back_image_full_url'];

    public function getFrontImageFullUrlAttribute(): ?string
    {
        return $this->front_image
            ? Helpers::get_full_url('ride-vehicle', $this->front_image, $this->front_image_storage ?: 'public')
            : null;
    }

    public function getBackImageFullUrlAttribute(): ?string
    {
        return $this->back_image
            ? Helpers::get_full_url('ride-vehicle', $this->back_image, $this->back_image_storage ?: 'public')
            : null;
    }

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class);
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(RideVehicleType::class, 'ride_vehicle_type_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RideCategory::class, 'ride_category_id');
    }
}
