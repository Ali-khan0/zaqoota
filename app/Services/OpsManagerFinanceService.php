<?php

namespace App\Services;

use App\Jobs\SendOpsManagerNotification;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\OpsManagerFinanceLedger;
use App\Models\OpsManagerPayoutMethod;
use App\Models\OpsManagerWithdrawal;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsManagerFinanceService
{
    public function __construct(private readonly OpsManagerAuditService $auditService) {}

    public function recordSubmission(OnboardingApplication $application, OnboardingInvoice $invoice): void
    {
        $common = [
            'manager_id' => $application->onboarding_manager_id,
            'onboarding_application_id' => $application->id,
            'onboarding_invoice_id' => $invoice->id,
            'currency' => $application->currency,
        ];
        $this->entry($common + [
            'entry_type' => 'invoice_collection_created',
            'bucket' => OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION,
            'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
            'amount' => $invoice->amount,
            'reference' => "ops-application:{$application->id}:collection-created",
            'description' => 'Onboarding invoice awaiting collection.',
        ]);

        if ((float) $application->commission_amount_snapshot > 0) {
            $this->entry($common + [
                'entry_type' => 'commission_calculated',
                'bucket' => OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION,
                'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
                'amount' => $application->commission_amount_snapshot,
                'reference' => "ops-application:{$application->id}:commission-calculated",
                'description' => 'Onboarding commission calculated and pending payment.',
                'metadata' => [
                    'commission_rate' => $application->commission_rate_snapshot,
                    'commission_base' => $application->commission_base_snapshot,
                ],
            ]);
        }
    }

    public function markInvoiceCollected(OnboardingApplication $application, ?Admin $actor = null): void
    {
        DB::transaction(function () use ($application, $actor): void {
            $application = $this->lockedApplication($application);
            $invoice = $application->invoice;
            if (! $invoice || $invoice->payment_status !== OnboardingInvoice::PAYMENT_PAID) {
                throw ValidationException::withMessages(['invoice' => ['The invoice must be paid before commission can be earned.']]);
            }
            $common = $this->applicationEntryData($application, $invoice, $actor);
            $collection = $this->applicationBucketBalance(
                $application->id,
                OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION,
            );
            if ($collection > 0) {
                $this->entry($common + [
                    'entry_type' => 'invoice_collection_cleared',
                    'bucket' => OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION,
                    'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                    'amount' => $collection,
                    'reference' => "ops-application:{$application->id}:collection-cleared",
                    'description' => 'Onboarding invoice collection cleared.',
                ]);
            }
            $commission = $this->applicationBucketBalance(
                $application->id,
                OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION,
            );
            if ($commission <= 0) {
                return;
            }
            $this->entry($common + [
                'entry_type' => 'commission_payment_cleared',
                'bucket' => OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION,
                'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                'amount' => $commission,
                'reference' => "ops-application:{$application->id}:commission-pending-cleared",
                'description' => 'Pending commission cleared after invoice payment.',
            ]);
            $this->entry($common + [
                'entry_type' => 'commission_pending_release',
                'bucket' => OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE,
                'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
                'amount' => $commission,
                'reference' => "ops-application:{$application->id}:commission-pending-release",
                'description' => 'Paid onboarding commission awaiting admin release.',
            ]);
        }, 3);
    }

    public function releaseCommission(OnboardingApplication $application, Admin $actor): void
    {
        DB::transaction(function () use ($application, $actor): void {
            $application = $this->lockedApplication($application);
            if ((config('ops.finance.release_policy', 'approved') === 'approved' && $application->status !== OnboardingApplication::STATUS_APPROVED)
                || in_array($application->status, ['rejected', 'cancelled', 'refunded', 'draft'], true)
                || $application->invoice?->payment_status !== OnboardingInvoice::PAYMENT_PAID
                || $application->invoice?->voided_at) {
                throw ValidationException::withMessages(['commission' => 'This application does not meet the configured commission release policy or paid invoice requirements.']);
            }
            if ((int) $actor->id === (int) $application->onboarding_manager_id
                || (int) $actor->id === (int) $application->invoice->paid_by) {
                throw ValidationException::withMessages(['commission' => 'A different staff member must release this commission.']);
            }
            $amount = $this->applicationBucketBalance($application->id, OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE);
            if ($amount <= 0) {
                throw ValidationException::withMessages(['commission' => ['This application has no commission pending release.']]);
            }
            $common = $this->applicationEntryData($application, $application->invoice, $actor);
            $this->entry($common + [
                'entry_type' => 'commission_released',
                'bucket' => OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE,
                'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                'amount' => $amount,
                'reference' => "ops-application:{$application->id}:commission-release-debit",
                'description' => 'Commission removed from pending release.',
            ]);
            $this->entry($common + [
                'entry_type' => 'commission_released',
                'bucket' => OpsManagerFinanceLedger::BUCKET_AVAILABLE,
                'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
                'amount' => $amount,
                'reference' => "ops-application:{$application->id}:commission-release-credit",
                'description' => 'Commission released for withdrawal.',
            ]);
        }, 3);
        SendOpsManagerNotification::dispatch(
            $application->onboarding_manager_id,
            "commission-released:{$application->id}",
            'commission_released',
            'Commission released',
            'Your onboarding commission is now available for withdrawal.',
            $application->id,
        );
        $this->auditService->record('ops_commission_released', $application->manager, [
            'onboarding_application_id' => $application->id,
        ], actor: $actor);
    }

    public function reverseCommission(OnboardingApplication $application, Admin $actor, ?string $reason = null): void
    {
        $reversed = false;
        DB::transaction(function () use ($application, $actor, $reason, &$reversed): void {
            $application = $this->lockedApplication($application);
            foreach ([
                OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION,
                OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE,
                OpsManagerFinanceLedger::BUCKET_AVAILABLE,
            ] as $bucket) {
                $amount = $this->applicationBucketBalance($application->id, $bucket);
                if ($amount <= 0) {
                    continue;
                }
                if ($bucket === OpsManagerFinanceLedger::BUCKET_AVAILABLE
                    && $amount > $this->balance($application->onboarding_manager_id, OpsManagerFinanceLedger::BUCKET_AVAILABLE)) {
                    throw ValidationException::withMessages([
                        'commission' => ['Reject or complete the manager’s reserved withdrawals before reversing this commission.'],
                    ]);
                }
                $reversed = true;
                $this->entry($this->applicationEntryData($application, $application->invoice, $actor) + [
                    'entry_type' => 'commission_reversed',
                    'bucket' => $bucket,
                    'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                    'amount' => $amount,
                    'reference' => "ops-application:{$application->id}:commission-reversed:{$bucket}",
                    'description' => 'Onboarding commission reversed.',
                    'metadata' => ['reason' => $reason],
                ]);
            }
        }, 3);
        if (! $reversed) {
            return;
        }
        SendOpsManagerNotification::dispatch(
            $application->onboarding_manager_id,
            "commission-reversed:{$application->id}",
            'commission_reversed',
            'Commission updated',
            'A commission adjustment was applied. Open Finance for details.',
            $application->id,
        );
        $this->auditService->record('ops_commission_reversed', $application->manager, [
            'onboarding_application_id' => $application->id,
            'reason' => $reason,
        ], actor: $actor);
    }

    public function reverseUnpaidApplication(OnboardingApplication $application, Admin $actor, string $reason): void
    {
        $commissionReversed = false;
        DB::transaction(function () use ($application, $actor, $reason, &$commissionReversed): void {
            $application = $this->lockedApplication($application);
            $invoice = $application->invoice;
            $common = $this->applicationEntryData($application, $invoice, $actor);
            $collection = $this->applicationBucketBalance(
                $application->id,
                OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION,
            );
            if ($collection > 0) {
                $this->entry($common + [
                    'entry_type' => 'invoice_collection_voided',
                    'bucket' => OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION,
                    'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                    'amount' => $collection,
                    'reference' => "ops-application:{$application->id}:collection-voided",
                    'description' => 'Awaiting collection removed after invoice cancellation.',
                    'metadata' => ['reason' => $reason],
                ]);
            }
            foreach ([
                OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION,
                OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE,
                OpsManagerFinanceLedger::BUCKET_AVAILABLE,
            ] as $bucket) {
                $amount = $this->applicationBucketBalance($application->id, $bucket);
                if ($amount <= 0) {
                    continue;
                }
                if ($bucket === OpsManagerFinanceLedger::BUCKET_AVAILABLE
                    && $amount > $this->balance($application->onboarding_manager_id, OpsManagerFinanceLedger::BUCKET_AVAILABLE)) {
                    throw ValidationException::withMessages([
                        'commission' => ['Reject or complete the manager’s reserved withdrawals before cancelling this application.'],
                    ]);
                }
                $commissionReversed = true;
                $this->entry($common + [
                    'entry_type' => 'commission_reversed',
                    'bucket' => $bucket,
                    'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                    'amount' => $amount,
                    'reference' => "ops-application:{$application->id}:commission-reversed:{$bucket}",
                    'description' => 'Onboarding commission reversed.',
                    'metadata' => ['reason' => $reason],
                ]);
            }
        }, 3);
        if ($commissionReversed) {
            SendOpsManagerNotification::dispatch(
                $application->onboarding_manager_id,
                "commission-reversed:{$application->id}",
                'commission_reversed',
                'Commission updated',
                'Commission was reversed after the onboarding invoice was cancelled.',
                $application->id,
            );
        }
        $this->auditService->record('ops_application_finance_reversed', $application->manager, [
            'onboarding_application_id' => $application->id,
            'reason' => $reason,
        ], actor: $actor);
    }

    public function savePayoutMethod(Admin $manager, array $data): OpsManagerPayoutMethod
    {
        return DB::transaction(function () use ($manager, $data): OpsManagerPayoutMethod {
            $this->lockManager($manager->id);
            $account = strtoupper(preg_replace('/\s+/', '', $data['account_number']));

            return OpsManagerPayoutMethod::query()->updateOrCreate(
                ['manager_id' => $manager->id],
                [
                    'type' => $data['type'],
                    'account_title' => trim($data['account_title']),
                    'provider_name' => trim($data['provider_name']),
                    'account_number' => $account,
                    'account_last_four' => substr($account, -4),
                    'is_active' => true,
                ],
            );
        }, 3);
    }

    public function requestWithdrawal(Admin $manager, float $amount, string $idempotencyKey): OpsManagerWithdrawal
    {
        $hash = hash('sha256', $idempotencyKey);

        return DB::transaction(function () use ($manager, $amount, $hash): OpsManagerWithdrawal {
            $this->lockManager($manager->id);
            $existing = OpsManagerWithdrawal::query()
                ->where('manager_id', $manager->id)
                ->where('idempotency_key_hash', $hash)
                ->first();
            if ($existing) {
                return $existing;
            }
            $method = OpsManagerPayoutMethod::query()
                ->where('manager_id', $manager->id)
                ->where('is_active', true)
                ->lockForUpdate()
                ->first();
            if (! $method) {
                throw ValidationException::withMessages(['payout_method' => ['Add your payment details before requesting a withdrawal.']]);
            }
            $minimum = max(0.01, (float) config('ops.finance.minimum_withdrawal_amount', 1));
            $maximum = max(0, (float) config('ops.finance.maximum_withdrawal_amount', 0));
            if ($amount < $minimum) {
                throw ValidationException::withMessages(['amount' => ["The minimum withdrawal amount is PKR {$minimum}."]]);
            }
            if ($maximum > 0 && $amount > $maximum) {
                throw ValidationException::withMessages(['amount' => ["The maximum withdrawal amount is PKR {$maximum}."]]);
            }
            if ($amount > $this->balance($manager->id, OpsManagerFinanceLedger::BUCKET_AVAILABLE)) {
                throw ValidationException::withMessages(['amount' => ['The withdrawal amount exceeds your available balance.']]);
            }
            $masked = $this->maskedAccount($method->account_last_four);
            $withdrawal = OpsManagerWithdrawal::create([
                'manager_id' => $manager->id,
                'payout_method_id' => $method->id,
                'idempotency_key_hash' => $hash,
                'reference' => 'OPSW-'.Str::upper((string) Str::ulid()),
                'amount' => $amount,
                'currency' => 'PKR',
                'destination_snapshot' => [
                    'type' => $method->type,
                    'account_title' => $method->account_title,
                    'provider_name' => $method->provider_name,
                    'account_number' => $method->account_number,
                ],
                'masked_destination' => $method->provider_name.' · '.$masked,
                'status' => OpsManagerWithdrawal::STATUS_PENDING,
            ]);
            $this->entry([
                'manager_id' => $manager->id,
                'withdrawal_id' => $withdrawal->id,
                'entry_type' => 'withdrawal_reserved',
                'bucket' => OpsManagerFinanceLedger::BUCKET_AVAILABLE,
                'direction' => OpsManagerFinanceLedger::DIRECTION_DEBIT,
                'amount' => $amount,
                'currency' => 'PKR',
                'reference' => "ops-withdrawal:{$withdrawal->id}:reserved",
                'description' => 'Available commission reserved for withdrawal.',
            ]);

            return $withdrawal;
        }, 3);
    }

    public function reviewWithdrawal(OpsManagerWithdrawal $withdrawal, string $status, Admin $actor, ?string $note = null): OpsManagerWithdrawal
    {
        $withdrawal = DB::transaction(function () use ($withdrawal, $status, $actor, $note): OpsManagerWithdrawal {
            $this->lockManager($withdrawal->manager_id);
            $withdrawal = OpsManagerWithdrawal::query()->lockForUpdate()->findOrFail($withdrawal->id);
            if ($withdrawal->status !== OpsManagerWithdrawal::STATUS_PENDING) {
                throw ValidationException::withMessages(['status' => ['This withdrawal has already been reviewed.']]);
            }
            if ((int) $actor->id === (int) $withdrawal->manager_id) {
                throw ValidationException::withMessages(['status' => 'You cannot review your own withdrawal.']);
            }
            if (! in_array($status, [OpsManagerWithdrawal::STATUS_APPROVED, OpsManagerWithdrawal::STATUS_REJECTED], true)) {
                throw ValidationException::withMessages(['status' => ['The withdrawal decision is invalid.']]);
            }
            $withdrawal->update([
                'status' => $status,
                'admin_note' => $note,
                'reviewed_by' => $actor->id,
                'reviewed_at' => now(),
            ]);
            if ($status === OpsManagerWithdrawal::STATUS_REJECTED) {
                $this->restoreWithdrawal($withdrawal, $actor, 'withdrawal_rejected');
            }

            return $withdrawal->refresh();
        }, 3);
        SendOpsManagerNotification::dispatch(
            $withdrawal->manager_id,
            "withdrawal-{$status}:{$withdrawal->id}",
            "withdrawal_{$status}",
            $status === OpsManagerWithdrawal::STATUS_APPROVED ? 'Withdrawal approved' : 'Withdrawal rejected',
            $status === OpsManagerWithdrawal::STATUS_APPROVED
                ? 'Your withdrawal was approved and is being prepared for payment.'
                : 'Your withdrawal was rejected. The reserved amount is available again.',
            withdrawalId: $withdrawal->id,
        );
        $this->auditService->record("ops_withdrawal_{$status}", $withdrawal->manager, [
            'withdrawal_id' => $withdrawal->id,
            'reference' => $withdrawal->reference,
            'amount' => $withdrawal->amount,
        ], actor: $actor);

        return $withdrawal;
    }

    public function markWithdrawalPaid(OpsManagerWithdrawal $withdrawal, Admin $actor, string $paymentReference): OpsManagerWithdrawal
    {
        $changed = false;
        $withdrawal = DB::transaction(function () use ($withdrawal, $actor, $paymentReference, &$changed): OpsManagerWithdrawal {
            $this->lockManager($withdrawal->manager_id);
            $withdrawal = OpsManagerWithdrawal::query()->lockForUpdate()->findOrFail($withdrawal->id);
            if ($withdrawal->status === OpsManagerWithdrawal::STATUS_PAID) {
                return $withdrawal;
            }
            if (! in_array($withdrawal->status, [OpsManagerWithdrawal::STATUS_APPROVED, OpsManagerWithdrawal::STATUS_PROCESSING], true)) {
                throw ValidationException::withMessages(['status' => ['Only an approved withdrawal can be marked paid.']]);
            }
            if (! $withdrawal->reviewed_by || (int) $actor->id === (int) $withdrawal->reviewed_by
                || (int) $actor->id === (int) $withdrawal->manager_id) {
                throw ValidationException::withMessages(['status' => 'Payment must be confirmed by a different staff member from the approver and recipient.']);
            }
            $changed = true;
            $withdrawal->update([
                'status' => OpsManagerWithdrawal::STATUS_PAID,
                'payment_reference' => $paymentReference,
                'paid_by' => $actor->id,
                'paid_at' => now(),
            ]);
            $this->entry([
                'manager_id' => $withdrawal->manager_id,
                'withdrawal_id' => $withdrawal->id,
                'entry_type' => 'withdrawal_paid',
                'bucket' => OpsManagerFinanceLedger::BUCKET_WITHDRAWN,
                'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
                'amount' => $withdrawal->amount,
                'currency' => $withdrawal->currency,
                'reference' => "ops-withdrawal:{$withdrawal->id}:paid",
                'description' => 'Withdrawal paid to onboarding manager.',
                'actor_admin_id' => $actor->id,
            ]);

            return $withdrawal->refresh();
        }, 3);
        if ($changed) {
            SendOpsManagerNotification::dispatch(
                $withdrawal->manager_id,
                "withdrawal-paid:{$withdrawal->id}",
                'withdrawal_paid',
                'Withdrawal paid',
                'Your withdrawal has been paid. Open Finance to view the receipt.',
                withdrawalId: $withdrawal->id,
            );
            $this->auditService->record('ops_withdrawal_paid', $withdrawal->manager, [
                'withdrawal_id' => $withdrawal->id,
                'reference' => $withdrawal->reference,
                'amount' => $withdrawal->amount,
                'payment_reference' => $paymentReference,
            ], actor: $actor);
        }

        return $withdrawal;
    }

    public function balances(int $managerId): array
    {
        $balances = OpsManagerFinanceLedger::query()
            ->where('manager_id', $managerId)
            ->selectRaw("bucket, SUM(CASE WHEN direction = 'credit' THEN amount ELSE -amount END) AS balance")
            ->groupBy('bucket')
            ->pluck('balance', 'bucket');

        return [
            'available_balance' => max(0, round((float) ($balances[OpsManagerFinanceLedger::BUCKET_AVAILABLE] ?? 0), 2)),
            'pending_commission' => max(0, round((float) ($balances[OpsManagerFinanceLedger::BUCKET_PENDING_COMMISSION] ?? 0), 2)),
            'pending_release' => max(0, round((float) ($balances[OpsManagerFinanceLedger::BUCKET_PENDING_RELEASE] ?? 0), 2)),
            'awaiting_collection' => max(0, round((float) ($balances[OpsManagerFinanceLedger::BUCKET_AWAITING_COLLECTION] ?? 0), 2)),
            'total_withdrawn' => max(0, round((float) ($balances[OpsManagerFinanceLedger::BUCKET_WITHDRAWN] ?? 0), 2)),
        ];
    }

    public function maskedAccount(string $lastFour): string
    {
        return '•••• '.$lastFour;
    }

    private function restoreWithdrawal(OpsManagerWithdrawal $withdrawal, Admin $actor, string $entryType): void
    {
        $this->entry([
            'manager_id' => $withdrawal->manager_id,
            'withdrawal_id' => $withdrawal->id,
            'entry_type' => $entryType,
            'bucket' => OpsManagerFinanceLedger::BUCKET_AVAILABLE,
            'direction' => OpsManagerFinanceLedger::DIRECTION_CREDIT,
            'amount' => $withdrawal->amount,
            'currency' => $withdrawal->currency,
            'reference' => "ops-withdrawal:{$withdrawal->id}:restored",
            'description' => 'Reserved withdrawal amount returned to available commission.',
            'actor_admin_id' => $actor->id,
        ]);
    }

    private function lockedApplication(OnboardingApplication $application): OnboardingApplication
    {
        $this->lockManager((int) $application->onboarding_manager_id);

        return OnboardingApplication::query()->with('invoice')->lockForUpdate()->findOrFail($application->id);
    }

    private function lockManager(int $managerId): Admin
    {
        return Admin::query()->lockForUpdate()->findOrFail($managerId);
    }

    private function applicationEntryData(OnboardingApplication $application, ?OnboardingInvoice $invoice, ?Admin $actor): array
    {
        return [
            'manager_id' => $application->onboarding_manager_id,
            'onboarding_application_id' => $application->id,
            'onboarding_invoice_id' => $invoice?->id,
            'currency' => $application->currency,
            'actor_admin_id' => $actor?->id,
        ];
    }

    private function applicationBucketBalance(int $applicationId, string $bucket): float
    {
        return (float) OpsManagerFinanceLedger::query()
            ->where('onboarding_application_id', $applicationId)
            ->where('bucket', $bucket)
            ->selectRaw("COALESCE(SUM(CASE WHEN direction = 'credit' THEN amount ELSE -amount END), 0) AS balance")
            ->value('balance');
    }

    private function balance(int $managerId, string $bucket): float
    {
        return (float) OpsManagerFinanceLedger::query()
            ->where('manager_id', $managerId)
            ->where('bucket', $bucket)
            ->selectRaw("COALESCE(SUM(CASE WHEN direction = 'credit' THEN amount ELSE -amount END), 0) AS balance")
            ->value('balance');
    }

    private function entry(array $data): OpsManagerFinanceLedger
    {
        return OpsManagerFinanceLedger::query()->firstOrCreate(
            ['reference' => $data['reference']],
            $data,
        );
    }
}
