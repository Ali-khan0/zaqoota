<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingApplicationStatusHistory extends Model
{
    public const UPDATED_AT = null;

    protected $fillable = [
        'onboarding_application_id',
        'from_status',
        'to_status',
        'actor_type',
        'actor_id',
        'actor_name',
        'note',
        'metadata',
    ];

    protected $casts = [
        'actor_id' => 'integer',
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(OnboardingApplication::class, 'onboarding_application_id');
    }
}
