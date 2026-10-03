<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpsManagerFinanceLedger extends Model
{
    public const UPDATED_AT = null;

    public const BUCKET_AWAITING_COLLECTION = 'awaiting_collection';

    public const BUCKET_PENDING_COMMISSION = 'pending_commission';

    public const BUCKET_PENDING_RELEASE = 'pending_release';

    public const BUCKET_AVAILABLE = 'available';

    public const BUCKET_WITHDRAWN = 'withdrawn';

    public const DIRECTION_CREDIT = 'credit';

    public const DIRECTION_DEBIT = 'debit';

    protected $fillable = [
        'manager_id',
        'onboarding_application_id',
        'onboarding_invoice_id',
        'withdrawal_id',
        'entry_type',
        'bucket',
        'direction',
        'amount',
        'currency',
        'reference',
        'description',
        'metadata',
        'actor_admin_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'manager_id');
    }

    public function application(): BelongsTo
    {
        return $this->belongsTo(OnboardingApplication::class, 'onboarding_application_id');
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }

    public function withdrawal(): BelongsTo
    {
        return $this->belongsTo(OpsManagerWithdrawal::class, 'withdrawal_id');
    }
}
