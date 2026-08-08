<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoiceDelivery extends Model
{
    protected $fillable = ['recipient_email', 'delivery_type', 'status', 'error_message', 'sent_by', 'sent_at'];
    protected $casts = ['sent_at' => 'datetime'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }
}
