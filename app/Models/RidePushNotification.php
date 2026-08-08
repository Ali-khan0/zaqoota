<?php

namespace App\Models;

use App\CentralLogics\Helpers;
use Illuminate\Database\Eloquent\Model;

class RidePushNotification extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['image_full_url'];

    protected $casts = ['status' => 'boolean', 'sent_at' => 'datetime'];

    public function getImageFullUrlAttribute(): string
    {
        return $this->image ? Helpers::get_full_url('ride-promotion', $this->image, $this->image_storage) : '';
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class);
    }
}
