<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpsOnboardingReminderRequest extends Model
{
    public const STATUS_QUEUED = 'queued';

    public const STATUS_SENT = 'sent';

    public const STATUS_FAILED = 'failed';

    public const STATUS_CANCELLED = 'cancelled';

    public const UPDATED_AT = null;

    protected $fillable = [
        'onboarding_application_id',
        'onboarding_manager_id',
        'idempotency_key_hash',
        'status',
        'attempt_count',
        'last_error',
        'next_allowed_at',
        'sent_at',
    ];

    protected $hidden = ['idempotency_key_hash'];

    protected $casts = [
        'next_allowed_at' => 'datetime',
        'sent_at' => 'datetime',
        'attempt_count' => 'integer',
        'created_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(OnboardingApplication::class, 'onboarding_application_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'onboarding_manager_id');
    }
}
