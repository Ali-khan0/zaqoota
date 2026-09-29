<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RideChatPresence extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'ride_request_id' => 'integer',
        'participant_id' => 'integer',
        'expires_at' => 'datetime',
    ];
}
