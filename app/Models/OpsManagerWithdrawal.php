<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OpsManagerWithdrawal extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_PROCESSING = 'processing';

    public const STATUS_PAID = 'paid';

    public const STATUS_REJECTED = 'rejected';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'manager_id',
        'payout_method_id',
        'idempotency_key_hash',
        'reference',
        'amount',
        'currency',
        'destination_snapshot',
        'masked_destination',
        'status',
        'admin_note',
        'payment_reference',
        'reviewed_by',
        'reviewed_at',
        'paid_by',
        'paid_at',
    ];

    protected $hidden = ['idempotency_key_hash', 'destination_snapshot', 'proof_disk', 'proof_path', 'proof_mime'];

    protected $casts = [
        'amount' => 'decimal:2',
        'destination_snapshot' => 'encrypted:array',
        'reviewed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'manager_id');
    }

    public function payoutMethod(): BelongsTo
    {
        return $this->belongsTo(OpsManagerPayoutMethod::class, 'payout_method_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'reviewed_by');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'paid_by');
    }
}
