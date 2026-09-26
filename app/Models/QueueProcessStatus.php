<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QueueProcessStatus extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'enabled' => 'boolean',
        'processed_count' => 'integer',
        'failed_count' => 'integer',
        'skipped_count' => 'integer',
        'last_processed_at' => 'datetime',
        'last_failed_at' => 'datetime',
        'last_skipped_at' => 'datetime',
    ];
}
