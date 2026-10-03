<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnboardingInvoiceCheckoutToken extends Model
{
    protected $fillable = [
        'onboarding_invoice_id', 'token_hash', 'token_secret', 'expires_at',
        'last_accessed_at', 'revoked_at', 'created_by',
    ];

    protected $hidden = ['token_hash', 'token_secret'];

    protected $casts = [
        'token_secret' => 'encrypted',
        'expires_at' => 'datetime',
        'last_accessed_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }

    public function attempts(): HasMany
    {
        return $this->hasMany(OnboardingInvoicePaymentAttempt::class, 'checkout_token_id');
    }
}
