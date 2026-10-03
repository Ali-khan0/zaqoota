<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoicePaymentAttempt extends Model
{
    public const STATUS_PENDING = 'pending';

    public const STATUS_PAID = 'paid';

    public const STATUS_FAILED = 'failed';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_REVIEW_REQUIRED = 'review_required';

    public const STATUS_REFUND_PENDING = 'refund_pending';

    public const STATUS_REFUNDED = 'refunded';

    protected $fillable = [
        'onboarding_invoice_id', 'checkout_token_id', 'payment_request_id',
        'gateway', 'amount', 'currency', 'status', 'transaction_reference',
        'failure_reason', 'refund_reference', 'refund_reason', 'refunded_by',
        'expires_at', 'paid_at', 'refunded_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'expires_at' => 'datetime',
        'paid_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }

    public function checkoutToken(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoiceCheckoutToken::class, 'checkout_token_id');
    }

    public function paymentRequest(): BelongsTo
    {
        return $this->belongsTo(PaymentRequest::class, 'payment_request_id');
    }

    public function refundedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'refunded_by');
    }
}
