<?php

namespace App\Services;

use App\Models\FleetManager;
use App\Models\FleetManagerEarningTransaction;
use App\Models\FleetManagerWallet;
use App\Models\FleetManagerWithdrawalMethod;
use App\Models\FleetManagerWithdrawalRequest;
use App\Models\OrderTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class FleetManagerFinanceService
{
    public function creditOrderCommission(
        object $order,
        float $deliveryAmount,
        float $adminCommissionAmount
    ): float {
        $fleetManager = $order->delivery_man?->fleetManager;
        $percentage = max(0, (float) ($fleetManager?->commission_percentage ?? 0));
        $deliveryAmount = max(0, $deliveryAmount);
        $adminCommissionAmount = max(0, $adminCommissionAmount);

        if (! $fleetManager || $percentage <= 0 || $deliveryAmount <= 0 || $adminCommissionAmount <= 0) {
            return 0;
        }

        if (FleetManagerEarningTransaction::query()->where('order_id', $order->id)->exists()) {
            return 0;
        }

        $amount = round(min(($deliveryAmount * $percentage) / 100, $adminCommissionAmount), 2);
        if ($amount <= 0) {
            return 0;
        }

        $orderTransactionId = OrderTransaction::query()
            ->where('order_id', $order->id)
            ->value('id');

        FleetManagerEarningTransaction::create([
            'fleet_manager_id' => $fleetManager->id,
            'delivery_man_id' => $order->delivery_man_id,
            'order_id' => $order->id,
            'order_transaction_id' => $orderTransactionId,
            'delivery_amount' => $deliveryAmount,
            'admin_commission_amount' => $adminCommissionAmount,
            'fleet_commission_percentage' => $percentage,
            'amount' => $amount,
            'status' => FleetManagerEarningTransaction::STATUS_EARNED,
        ]);

        OrderTransaction::query()
            ->where('order_id', $order->id)
            ->update(['fleet_manager_commission' => $amount]);

        $wallet = FleetManagerWallet::query()->firstOrCreate([
            'fleet_manager_id' => $fleetManager->id,
        ]);
        $wallet->increment('total_earning', $amount);

        return $amount;
    }

    public function reverseOrderCommission(int $orderId): float
    {
        $earning = FleetManagerEarningTransaction::query()
            ->where('order_id', $orderId)
            ->lockForUpdate()
            ->first();

        if (! $earning || $earning->status !== FleetManagerEarningTransaction::STATUS_EARNED) {
            return 0;
        }

        $wallet = FleetManagerWallet::query()
            ->where('fleet_manager_id', $earning->fleet_manager_id)
            ->lockForUpdate()
            ->firstOrFail();

        $wallet->total_earning = max(0, (float) $wallet->total_earning - (float) $earning->amount);
        $wallet->save();

        $earning->update([
            'status' => FleetManagerEarningTransaction::STATUS_REVERSED,
            'reversed_at' => now(),
        ]);

        return (float) $earning->amount;
    }

    public function requestWithdrawal(
        FleetManager $fleetManager,
        FleetManagerWithdrawalMethod $method,
        float $amount,
        ?string $note
    ): FleetManagerWithdrawalRequest {
        return DB::transaction(function () use ($fleetManager, $method, $amount, $note) {
            $method = FleetManagerWithdrawalMethod::query()
                ->where('fleet_manager_id', $fleetManager->id)
                ->with('withdrawalMethod')
                ->findOrFail($method->id);

            if (! $method->withdrawalMethod?->is_active) {
                throw ValidationException::withMessages([
                    'withdrawal_method_id' => __('fleet_management.error_withdraw_method_inactive'),
                ]);
            }

            $wallet = FleetManagerWallet::query()
                ->where('fleet_manager_id', $fleetManager->id)
                ->lockForUpdate()
                ->firstOrCreate(['fleet_manager_id' => $fleetManager->id]);

            if ($amount <= 0 || $amount > $wallet->available_balance) {
                throw ValidationException::withMessages([
                    'amount' => __('fleet_management.error_insufficient_withdraw_balance'),
                ]);
            }

            $request = FleetManagerWithdrawalRequest::create([
                'fleet_manager_id' => $fleetManager->id,
                'fleet_manager_withdrawal_method_id' => $method->id,
                'withdrawal_method_id' => $method->withdrawal_method_id,
                'amount' => $amount,
                'method_name' => $method->method_name,
                'method_fields' => $method->method_fields,
                'manager_note' => $note,
                'status' => FleetManagerWithdrawalRequest::STATUS_PENDING,
            ]);

            $wallet->increment('pending_withdraw', $amount);

            return $request;
        });
    }

    public function reviewWithdrawal(
        FleetManagerWithdrawalRequest $withdrawal,
        string $status,
        int $reviewedBy,
        ?string $note
    ): FleetManagerWithdrawalRequest {
        return DB::transaction(function () use ($withdrawal, $status, $reviewedBy, $note) {
            $withdrawal = FleetManagerWithdrawalRequest::query()
                ->lockForUpdate()
                ->findOrFail($withdrawal->id);

            if ($withdrawal->status !== FleetManagerWithdrawalRequest::STATUS_PENDING) {
                throw ValidationException::withMessages([
                    'status' => __('fleet_management.error_withdrawal_already_reviewed'),
                ]);
            }

            if (! in_array($status, [
                FleetManagerWithdrawalRequest::STATUS_APPROVED,
                FleetManagerWithdrawalRequest::STATUS_REJECTED,
            ], true)) {
                throw ValidationException::withMessages([
                    'status' => __('fleet_management.error_invalid_withdrawal_status'),
                ]);
            }

            $wallet = FleetManagerWallet::query()
                ->where('fleet_manager_id', $withdrawal->fleet_manager_id)
                ->lockForUpdate()
                ->firstOrFail();

            if ((float) $wallet->pending_withdraw < (float) $withdrawal->amount) {
                throw ValidationException::withMessages([
                    'amount' => __('fleet_management.error_withdraw_balance_mismatch'),
                ]);
            }

            $wallet->pending_withdraw = max(
                0,
                (float) $wallet->pending_withdraw - (float) $withdrawal->amount
            );
            if ($status === FleetManagerWithdrawalRequest::STATUS_APPROVED) {
                $wallet->total_withdrawn = (float) $wallet->total_withdrawn + (float) $withdrawal->amount;
            }
            $wallet->save();

            $withdrawal->update([
                'status' => $status,
                'admin_note' => $note,
                'reviewed_by' => $reviewedBy,
                'reviewed_at' => now(),
            ]);

            return $withdrawal->refresh();
        });
    }
}
