<?php

namespace App\Services;

use App\Models\RideCancellationRefund;
use App\Models\RidePayment;
use App\Models\RideRequest;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Support\Str;
use RuntimeException;

class RidePrepaymentCancellationService
{
    public function __construct(
        private readonly RideCancellationReceivableService $receivables,
    ) {}

    public function refund(RideRequest $ride, float $cancellationCharge): ?RideCancellationRefund
    {
        $paidAmount = round((float) RidePayment::query()
            ->where('ride_request_id', $ride->id)
            ->where('status', RidePayment::STATUS_PAID)
            ->sum('amount'), 2);
        if ($paidAmount <= 0) {
            return null;
        }

        $existing = RideCancellationRefund::query()
            ->where('ride_request_id', $ride->id)
            ->lockForUpdate()
            ->first();
        if ($existing) {
            return $existing;
        }
        if ($paidAmount + 0.001 < $cancellationCharge) {
            throw new RuntimeException('The Ride prepayment is lower than the cancellation charge. Manual reconciliation is required.');
        }

        $allocated = round(min($paidAmount, max(0, $cancellationCharge)), 2);
        $refundAmount = round($paidAmount - $allocated, 2);
        $transactionId = null;
        if ($refundAmount > 0) {
            $user = User::query()->withoutGlobalScopes()->whereKey($ride->user_id)->lockForUpdate()->firstOrFail();
            $transactionId = (string) Str::uuid();
            $user->wallet_balance = round((float) $user->wallet_balance + $refundAmount, 3);
            $user->save();

            $walletTransaction = new WalletTransaction;
            $walletTransaction->user_id = $user->id;
            $walletTransaction->transaction_id = $transactionId;
            $walletTransaction->reference = 'ride-cancellation-refund:'.$ride->id;
            $walletTransaction->transaction_type = 'ride_cancellation_refund';
            $walletTransaction->credit = $refundAmount;
            $walletTransaction->debit = 0;
            $walletTransaction->admin_bonus = 0;
            $walletTransaction->balance = $user->wallet_balance;
            $walletTransaction->created_at = now();
            $walletTransaction->updated_at = now();
            $walletTransaction->save();
        }

        if ($allocated > 0) {
            $this->receivables->clear($ride, $ride, 'prepayment', 'digital');
        }

        $refund = RideCancellationRefund::query()->create([
            'ride_request_id' => $ride->id,
            'user_id' => $ride->user_id,
            'paid_amount' => $paidAmount,
            'cancellation_allocated_amount' => $allocated,
            'wallet_refund_amount' => $refundAmount,
            'wallet_transaction_id' => $transactionId,
            'status' => 'completed',
            'completed_at' => now(),
        ]);
        $ride->update([
            'payment_status' => $allocated > 0 ? 'recovered' : 'refunded',
            'payment_method' => 'digital_refund',
            'wallet_paid_amount' => 0,
            'paid_at' => now(),
            'settled_at' => now(),
        ]);

        return $refund;
    }
}
