<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoice extends Model
{
    public const TYPE_ONBOARDING = 'onboarding';
    public const TYPE_OTHER = 'other';
    public const PAYMENT_PAID = 'paid';
    public const PAYMENT_UNPAID = 'unpaid';
    public const SEND_SENT = 'sent';
    public const SEND_NOT_SENT = 'not_sent';
    public const SEND_FAILED = 'failed';

    protected $fillable = [
        'module_id', 'store_id', 'invoice_number', 'invoice_type', 'invoice_date',
        'due_date', 'amount', 'module_name', 'store_name', 'store_email', 'recipient_emails',
        'store_address', 'payment_status', 'send_status', 'sent_at', 'paid_at',
        'last_send_error', 'created_by',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'recipient_emails' => 'array',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
