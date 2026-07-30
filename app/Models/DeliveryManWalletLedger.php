<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryManWalletLedger extends Model
{
    public const TYPE_REGISTRATION_FEE_DEDUCTION = 'registration_fee_wallet_deduction';

    public const TYPE_REGISTRATION_FEE_MANUAL = 'registration_fee_manual_confirmed';

    public const TYPE_MILESTONE_BONUS_DAILY = 'milestone_bonus_daily';

    public const TYPE_MILESTONE_BONUS_WEEKLY = 'milestone_bonus_weekly';

    public const TYPE_FLEET_PAYMENT_RECOVERY = 'fleet_payment_recovery';

    public const DIR_DEBIT = 'debit';

    public const DIR_CREDIT = 'credit';

    protected $fillable = [
        'delivery_man_id',
        'transaction_type',
        'reference',
        'amount',
        'direction',
        'meta',
    ];

    protected $casts = [
        'amount' => 'float',
        'meta' => 'array',
    ];

    public function deliveryMan(): BelongsTo
    {
        return $this->belongsTo(DeliveryMan::class, 'delivery_man_id');
    }

    /**
     * Human-readable line for registration-fee ledger rows (app / API).
     */
    public static function registrationFeeLedgerDescription(?string $transactionType, ?array $meta): string
    {
        $key = $meta['label_key'] ?? null;
        if (is_string($key) && $key !== '') {
            return translate($key);
        }

        return match ($transactionType) {
            self::TYPE_REGISTRATION_FEE_DEDUCTION => translate('messages.dm_reg_fee_wallet_deduction_label'),
            self::TYPE_REGISTRATION_FEE_MANUAL => translate('messages.dm_reg_fee_manual_initial_label'),
            default => '',
        };
    }
}
