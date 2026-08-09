<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RideCategory extends Model
{
    protected $fillable = ['ride_vehicle_type_id', 'name', 'slug', 'image', 'image_storage', 'fuel_type', 'passenger_capacity', 'status', 'sort_order'];

    protected $appends = ['image_url'];

    protected $casts = ['status' => 'boolean', 'passenger_capacity' => 'integer', 'sort_order' => 'integer'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Helpers::get_full_url('ride-category', $this->image, $this->image_storage ?: 'public') : '';
    }

    public function vehicleType(): BelongsTo
    {
        return $this->belongsTo(RideVehicleType::class, 'ride_vehicle_type_id');
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(RideVehicle::class);
    }

    public function fares(): HasMany
    {
        return $this->hasMany(RideFare::class);
    }
}
