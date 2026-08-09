<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RideVehicleType extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'image_storage', 'status', 'sort_order'];

    protected $appends = ['image_url'];

    protected $casts = ['status' => 'boolean', 'sort_order' => 'integer'];

    public function getImageUrlAttribute(): string
    {
        return $this->image ? Helpers::get_full_url('ride-category', $this->image, $this->image_storage ?: 'public') : '';
    }

    public function categories(): HasMany
    {
        return $this->hasMany(RideCategory::class);
    }
}
