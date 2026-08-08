<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RideVehicleType extends Model
{
    protected $fillable = ['name', 'slug', 'status', 'sort_order'];

    protected $casts = ['status' => 'boolean', 'sort_order' => 'integer'];

    public function categories(): HasMany
    {
        return $this->hasMany(RideCategory::class);
    }
}
