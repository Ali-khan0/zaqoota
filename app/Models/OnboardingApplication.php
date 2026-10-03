<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class OnboardingApplication extends Model
{
    use SoftDeletes;

    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_INVOICE_SENT = 'invoice_sent';
    public const STATUS_PAYMENT_PENDING = 'payment_pending';
    public const STATUS_DATA_PENDING = 'data_pending';
    public const STATUS_DATA_ENTRY = 'data_entry';
    public const STATUS_REVIEW_PENDING = 'review_pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';
    public const STATUS_CANCELLED = 'cancelled';
    public const STATUS_PAYMENT_FAILED = 'payment_failed';
    public const STATUS_REFUNDED = 'refunded';

    public const STATUSES = [
        self::STATUS_DRAFT,
        self::STATUS_SUBMITTED,
        self::STATUS_INVOICE_SENT,
        self::STATUS_PAYMENT_PENDING,
        self::STATUS_DATA_PENDING,
        self::STATUS_DATA_ENTRY,
        self::STATUS_REVIEW_PENDING,
        self::STATUS_APPROVED,
        self::STATUS_REJECTED,
        self::STATUS_CANCELLED,
        self::STATUS_PAYMENT_FAILED,
        self::STATUS_REFUNDED,
    ];

    protected $fillable = [
        'reference',
        'onboarding_manager_id',
        'vendor_id',
        'store_id',
        'module_id',
        'zone_id',
        'idempotency_key_hash',
        'status',
        'draft_revision',
        'draft_payload',
        'manager_name_snapshot',
        'manager_email_snapshot',
        'commission_rate_snapshot',
        'commission_base_snapshot',
        'commission_amount_snapshot',
        'currency',
        'owner_first_name',
        'owner_last_name',
        'owner_email',
        'owner_phone',
        'owner_tin',
        'owner_tin_expire_date',
        'owner_tin_certificate_path',
        'store_name',
        'store_phone',
        'store_email',
        'module_name_snapshot',
        'zone_name_snapshot',
        'formatted_address',
        'latitude',
        'longitude',
        'place_id',
        'delivery_time_min',
        'delivery_time_max',
        'delivery_time_unit',
        'submitted_at',
        'last_draft_synced_at',
        'completed_at',
    ];

    protected $hidden = [
        'data_entry_admin_id',
        'data_entry_assigned_at',
        'data_entry_completed_at',
        'idempotency_key_hash',
        'draft_payload',
        'owner_tin_certificate_path',
    ];

    protected $casts = [
        'data_entry_assigned_at' => 'datetime',
        'data_entry_completed_at' => 'datetime',
        'draft_payload' => 'encrypted:array',
        'draft_revision' => 'integer',
        'commission_rate_snapshot' => 'decimal:2',
        'commission_base_snapshot' => 'decimal:2',
        'commission_amount_snapshot' => 'decimal:2',
        'owner_tin_expire_date' => 'date',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'delivery_time_min' => 'integer',
        'delivery_time_max' => 'integer',
        'submitted_at' => 'datetime',
        'last_draft_synced_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'onboarding_manager_id');
    }

    public function dataEntryStaff(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'data_entry_admin_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }

    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(OnboardingInvoice::class)->latestOfMany();
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(OnboardingInvoice::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OnboardingApplicationStatusHistory::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(OnboardingApplicationMedia::class);
    }

    public function reminderRequests(): HasMany
    {
        return $this->hasMany(OpsOnboardingReminderRequest::class);
    }

    public function financeLedger(): HasMany
    {
        return $this->hasMany(OpsManagerFinanceLedger::class);
    }

    public function passwordSetupTokens(): HasMany
    {
        return $this->hasMany(OnboardingVendorPasswordSetup::class);
    }

    protected static function booted(): void
    {
        static::updating(function (self $application): void {
            if ($application->getOriginal('status') !== self::STATUS_DRAFT
                && ($application->status === self::STATUS_DRAFT
                    || $application->isDirty('submitted_at')
                    || $application->isDirty([
                        'onboarding_manager_id',
                        'manager_name_snapshot',
                        'manager_email_snapshot',
                        'commission_rate_snapshot',
                        'commission_base_snapshot',
                        'commission_amount_snapshot',
                        'currency',
                    ]))) {
                throw new \LogicException('Submitted onboarding attribution and commission snapshots are immutable.');
            }
        });
    }
}
