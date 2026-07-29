<?php

namespace App\Services;

use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use App\Models\DeliveryManRegistrationFee;
use App\Models\DeliveryManWallet;
use App\Models\DeliveryManWalletLedger;
use Illuminate\Support\Facades\DB;

class DeliveryManRegistrationFeeService
{
    public function getSettings(): array
    {
        $enabled = (int) ($this->setting('dm_reg_fee_enabled', 1));
        $total = (float) $this->setting('dm_reg_total_fee', 5000);
        $manualPart = (float) $this->setting('dm_reg_manual_first_part', 1500);
        $percent = (float) $this->setting('dm_reg_wallet_deduction_percent', 30);
        $frequency = $this->setting('dm_reg_deduction_frequency', 'weekly');
        $requireInitialOnApprove = (int) $this->setting('dm_reg_require_initial_on_approve', 0);

        return [
            'enabled' => $enabled === 1,
            'total_fee' => $total,
            'manual_first_part' => $manualPart,
            'deduction_percent' => max(0, min(100, $percent)),
            'deduction_frequency' => in_array($frequency, ['weekly', 'monthly'], true) ? $frequency : 'weekly',
            'require_initial_on_approve' => $requireInitialOnApprove === 1,
        ];
    }

    private function setting(string $key, mixed $default): mixed
    {
        $row = BusinessSetting::where('key', $key)->first();

        return $row !== null ? $row->value : $default;
    }

    public function ensureRecordForDeliveryMan(int $deliveryManId): ?DeliveryManRegistrationFee
    {
        $cfg = $this->getSettings();
        if (! $cfg['enabled']) {
            return null;
        }

        $fee = DeliveryManRegistrationFee::firstOrCreate(
            ['delivery_man_id' => $deliveryManId],
            [
                'total_fee' => $cfg['total_fee'],
                'manual_paid_amount' => 0,
                'manual_confirmed' => false,
                'wallet_remaining_due' => $cfg['total_fee'],
                'deduction_percent' => $cfg['deduction_percent'],
                'deduction_frequency' => $cfg['deduction_frequency'],
            ]
        );

        return $fee;
    }

    public function confirmManualPayment(int $deliveryManId, float $amount): bool
    {
        $fee = DeliveryManRegistrationFee::where('delivery_man_id', $deliveryManId)->first();
        if (! $fee || $fee->completed_at || $fee->manual_confirmed) {
            return false;
        }

        $cfg = $this->getSettings();
        $manualCap = $cfg['manual_first_part'];
        $paid = min($manualCap, max(0, $amount));

        return DB::transaction(function () use ($fee, $paid, $cfg) {
            $fee->manual_paid_amount = $paid;
            $fee->manual_confirmed = true;
            $fee->manual_confirmed_at = now();
            $fee->wallet_remaining_due = max(0, $fee->total_fee - $paid);
            if ($fee->wallet_remaining_due <= 0) {
                $fee->completed_at = now();
            }
            $fee->save();

            DeliveryManWalletLedger::create([
                'delivery_man_id' => $fee->delivery_man_id,
                'transaction_type' => DeliveryManWalletLedger::TYPE_REGISTRATION_FEE_MANUAL,
                'reference' => null,
                'amount' => $paid,
                'direction' => DeliveryManWalletLedger::DIR_CREDIT,
                'meta' => [
                    'note' => 'Manual signup fee recorded (outside wallet)',
                    'label_key' => 'messages.dm_reg_fee_manual_initial_label',
                ],
            ]);

            return true;
        });
    }

    public function availableWalletBalance(DeliveryMan $dm): float
    {
        $w = $dm->wallet;
        if (! $w) {
            return 0.0;
        }

        return (float) max(0, round(
            $w->total_earning - ($w->total_withdrawn + $w->pending_withdraw + $w->collected_cash),
            8
        ));
    }

    public function runScheduledDeductions(): int
    {
        $cfg = $this->getSettings();
        if (! $cfg['enabled']) {
            return 0;
        }

        $count = 0;
        $fees = DeliveryManRegistrationFee::query()
            ->whereNull('completed_at')
            ->where('manual_confirmed', true)
            ->where('wallet_remaining_due', '>', 0)
            ->with('deliveryMan.wallet')
            ->get();

        foreach ($fees as $fee) {
            if (! $this->shouldRunNow($fee)) {
                continue;
            }

            $dm = $fee->deliveryMan;
            if (! $dm) {
                continue;
            }

            $balance = $this->availableWalletBalance($dm);
            if ($balance <= 0) {
                continue;
            }

            $percent = (float) $fee->deduction_percent;
            $raw = $balance * ($percent / 100.0);
            $deduct = min($fee->wallet_remaining_due, $raw);
            $deduct = round($deduct, 2);
            if ($deduct <= 0) {
                continue;
            }

            DB::transaction(function () use ($fee, $dm, $deduct, &$count) {
                $wallet = DeliveryManWallet::firstOrNew(['delivery_man_id' => $dm->id]);
                $wallet->total_earning = max(0, ($wallet->total_earning ?? 0) - $deduct);
                $wallet->save();

                $fee->wallet_remaining_due = max(0, $fee->wallet_remaining_due - $deduct);
                $fee->last_wallet_deduction_at = now();
                if ($fee->wallet_remaining_due <= 0) {
                    $fee->completed_at = now();
                }
                $fee->save();

                DeliveryManWalletLedger::create([
                    'delivery_man_id' => $dm->id,
                    'transaction_type' => DeliveryManWalletLedger::TYPE_REGISTRATION_FEE_DEDUCTION,
                    'reference' => 'scheduled',
                    'amount' => $deduct,
                    'direction' => DeliveryManWalletLedger::DIR_DEBIT,
                    'meta' => [
                        'remaining_after' => $fee->wallet_remaining_due,
                        'deduction_for' => 'delivery_bag',
                        'label_key' => 'messages.dm_reg_fee_wallet_deduction_label',
                    ],
                ]);
                $count++;
            });
        }

        return $count;
    }

    private function shouldRunNow(DeliveryManRegistrationFee $fee): bool
    {
        $freq = $fee->deduction_frequency;
        $last = $fee->last_wallet_deduction_at;

        if ($last === null) {
            return true;
        }

        if ($freq === 'monthly') {
            return $last->copy()->addMonth()->isPast();
        }

        return $last->copy()->addWeek()->isPast();
    }
}
