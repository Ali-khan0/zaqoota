<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnboardingVendorPasswordSetup extends Model
{
    protected $fillable = [
        'onboarding_application_id', 'vendor_id', 'token_hash', 'token_secret',
        'expires_at', 'used_at', 'revoked_at', 'created_by', 'used_ip',
    ];

    protected $hidden = ['token_hash', 'token_secret', 'used_ip'];

    protected $casts = [
        'token_secret' => 'encrypted',
        'expires_at' => 'datetime',
        'used_at' => 'datetime',
        'revoked_at' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(OnboardingApplication::class, 'onboarding_application_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by');
    }
}
