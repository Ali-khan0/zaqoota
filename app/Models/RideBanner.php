<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Model;

class RideBanner extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['image_full_url'];

    protected $casts = ['status' => 'boolean', 'starts_at' => 'datetime', 'expires_at' => 'datetime', 'sort_order' => 'integer'];

    public function getImageFullUrlAttribute(): string
    {
        return Helpers::get_full_url('ride-promotion', $this->image, $this->image_storage);
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }

    public function category()
    {
        return $this->belongsTo(RideCategory::class, 'ride_category_id');
    }
}
