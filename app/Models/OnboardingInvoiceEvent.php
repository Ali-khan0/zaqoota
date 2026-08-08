<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoiceEvent extends Model
{
    protected $fillable = ['event_type', 'description', 'metadata', 'admin_id', 'admin_name'];
    protected $casts = ['metadata' => 'array'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }
}
