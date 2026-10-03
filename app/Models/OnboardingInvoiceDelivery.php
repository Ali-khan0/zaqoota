<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoiceDelivery extends Model
{
    protected $fillable = [
        'recipient_email',
        'delivery_type',
        'idempotency_key_hash',
        'status',
        'attempt_count',
        'error_message',
        'sent_by',
        'sent_by_name',
        'sent_at',
        'last_attempt_at',
    ];

    protected $hidden = ['idempotency_key_hash'];

    protected $casts = [
        'attempt_count' => 'integer',
        'sent_at' => 'datetime',
        'last_attempt_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }
}
