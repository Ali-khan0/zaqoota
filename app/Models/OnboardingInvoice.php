<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'due_date', 'amount', 'public_note', 'private_note', 'module_name', 'store_name', 'store_owner_name', 'store_email', 'recipient_emails',
        'store_address', 'payment_status', 'send_status', 'sent_at', 'paid_at',
        'last_send_error', 'last_reminder_at', 'payment_method', 'payment_reference', 'paid_by',
        'voided_at', 'void_reason', 'voided_by', 'created_by', 'generated_by_name',
    ];

    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'recipient_emails' => 'array',
        'sent_at' => 'datetime',
        'paid_at' => 'datetime',
        'voided_at' => 'datetime',
        'last_reminder_at' => 'datetime',
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

    public function items(): HasMany
    {
        return $this->hasMany(OnboardingInvoiceItem::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(OnboardingInvoiceDelivery::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(OnboardingInvoiceEvent::class);
    }

    public function getDisplayStatusAttribute(): string
    {
        if ($this->voided_at) {
            return 'void';
        }
        if ($this->payment_status === self::PAYMENT_PAID) {
            return 'paid';
        }
        if ($this->due_date->isPast()) {
            return 'overdue';
        }
        if ($this->due_date->between(today(), today()->addDays(7))) {
            return 'due_soon';
        }

        return 'unpaid';
    }
}
