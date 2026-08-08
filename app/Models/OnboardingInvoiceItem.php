<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingInvoiceItem extends Model
{
    protected $fillable = ['description', 'quantity', 'unit_price', 'line_total'];
    protected $casts = ['quantity' => 'decimal:2', 'unit_price' => 'decimal:2', 'line_total' => 'decimal:2'];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(OnboardingInvoice::class, 'onboarding_invoice_id');
    }
}
