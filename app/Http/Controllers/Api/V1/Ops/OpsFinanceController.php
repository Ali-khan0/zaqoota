<?php

namespace App\Http\Controllers\Api\V1\Ops;

use App\Http\Controllers\Controller;
use App\Jobs\SendOpsManagerNotification;
use App\Models\Admin;
use App\Models\OpsManagerFinanceLedger;
use App\Models\OpsManagerPayoutMethod;
use App\Models\OpsManagerWithdrawal;
use App\Services\OpsManagerAuditService;
use App\Services\OpsManagerFinanceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class OpsFinanceController extends Controller
{
    public function __construct(
        private readonly OpsManagerFinanceService $financeService,
        private readonly OpsManagerAuditService $auditService,
    ) {}

    public function summary(Request $request): JsonResponse
    {
        $manager = $this->manager($request);
        $method = OpsManagerPayoutMethod::query()
            ->where('manager_id', $manager->id)
            ->where('is_active', true)
            ->first();
        $withdrawals = OpsManagerWithdrawal::query()
            ->where('manager_id', $manager->id)
            ->whereIn('status', [
                OpsManagerWithdrawal::STATUS_PENDING,
                OpsManagerWithdrawal::STATUS_APPROVED,
                OpsManagerWithdrawal::STATUS_PROCESSING,
            ])
            ->latest()
            ->get();

        return response()->json(['data' => [
            'balances' => $this->financeService->balances($manager->id),
            'payout_method' => $method ? $this->payoutMethodData($method) : null,
            'pending_withdrawals' => $withdrawals->map(fn ($withdrawal) => $this->withdrawalData($withdrawal))->values(),
        ]]);
    }

    public function ledger(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'type' => ['nullable', Rule::in(['commission', 'collection', 'withdrawal'])],
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
        ]);
        $manager = $this->manager($request);
        $ledger = OpsManagerFinanceLedger::query()
            ->where('manager_id', $manager->id)
            ->where('entry_type', '!=', 'commission_payment_cleared')
            ->where(function ($query) {
                $query->where('entry_type', '!=', 'commission_released')
                    ->orWhere('bucket', OpsManagerFinanceLedger::BUCKET_AVAILABLE);
            })
            ->when(($validated['type'] ?? null) === 'collection', fn ($query) => $query->where('entry_type', 'like', 'invoice_collection_%'))
            ->when(($validated['type'] ?? null) === 'withdrawal', fn ($query) => $query->where('entry_type', 'like', 'withdrawal_%'))
            ->when(($validated['type'] ?? null) === 'commission', fn ($query) => $query->where('entry_type', 'like', 'commission_%'))
            ->latest('id')
            ->paginate((int) ($validated['per_page'] ?? 20));

        return response()->json([
            'data' => $ledger->getCollection()->map(fn ($entry) => $this->ledgerData($entry))->values(),
            'meta' => [
                'current_page' => $ledger->currentPage(),
                'last_page' => $ledger->lastPage(),
                'per_page' => $ledger->perPage(),
                'total' => $ledger->total(),
            ],
        ]);
    }

    public function savePayoutMethod(Request $request): JsonResponse
    {
        $request->merge(['account_number' => strtoupper(preg_replace('/\s+/', '', (string) $request->input('account_number')))]);
        $validator = Validator::make($request->all(), [
            'type' => ['required', Rule::in(['bank_account', 'iban'])],
            'account_title' => ['required', 'string', 'min:2', 'max:191'],
            'provider_name' => ['required', 'string', 'min:2', 'max:191'],
            'account_number' => [
                'required',
                'string',
                'max:24',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if (! preg_match('/^PK\d{2}[A-Z]{4}[A-Z0-9]{16}$/', $value)
                        && ! preg_match('/^\d{8,24}$/', $value)) {
                        $fail('Enter a valid Pakistan IBAN or an 8–24 digit bank account number.');
                    }
                },
            ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'code' => 'validation_error',
                'message' => 'Please correct the highlighted payment details.',
                'errors' => $validator->errors(),
            ], 422);
        }
        $manager = $this->manager($request);
        $method = $this->financeService->savePayoutMethod($manager, $validator->validated());
        $this->auditService->record('ops_payout_method_saved', $manager, [
            'payout_method_id' => $method->id,
            'type' => $method->type,
            'provider_name' => $method->provider_name,
            'account_last_four' => $method->account_last_four,
        ], $request);

        return response()->json([
            'message' => 'Payment details saved successfully.',
            'data' => $this->payoutMethodData($method),
        ]);
    }

    public function requestWithdrawal(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'],
            'idempotency_key' => ['required', 'string', 'min:16', 'max:150'],
        ]);
        $headerKey = (string) $request->header('Idempotency-Key');
        if ($headerKey === '' || ! hash_equals($validated['idempotency_key'], $headerKey)) {
            return response()->json([
                'code' => 'idempotency_key_mismatch',
                'message' => 'The Idempotency-Key header and request value must match.',
            ], 422);
        }
        $manager = $this->manager($request);
        $withdrawal = $this->financeService->requestWithdrawal(
            $manager,
            round((float) $validated['amount'], 2),
            $validated['idempotency_key'],
        );
        $alreadyProcessed = ! $withdrawal->wasRecentlyCreated;
        if (! $alreadyProcessed) {
            $this->auditService->record('ops_withdrawal_requested', $manager, [
                'withdrawal_id' => $withdrawal->id,
                'reference' => $withdrawal->reference,
                'amount' => $withdrawal->amount,
            ], $request);
            SendOpsManagerNotification::dispatch(
                $manager->id,
                "withdrawal-pending:{$withdrawal->id}",
                'withdrawal_pending',
                'Withdrawal submitted',
                'Your withdrawal request is pending admin review.',
                withdrawalId: $withdrawal->id,
            );
        }

        return response()->json([
            'message' => $alreadyProcessed
                ? 'Withdrawal request already processed.'
                : 'Withdrawal request submitted successfully.',
            'already_processed' => $alreadyProcessed,
            'data' => $this->withdrawalData($withdrawal),
        ], $alreadyProcessed ? 200 : 201);
    }

    public function withdrawalByIdempotency(Request $request, string $idempotencyKey): JsonResponse
    {
        $manager = $this->manager($request);
        $withdrawal = OpsManagerWithdrawal::query()
            ->where('manager_id', $manager->id)
            ->where('idempotency_key_hash', hash('sha256', $idempotencyKey))
            ->firstOrFail();

        return response()->json([
            'already_processed' => true,
            'data' => $this->withdrawalData($withdrawal),
        ]);
    }

    public function withdrawal(Request $request, int $withdrawal): JsonResponse
    {
        $record = OpsManagerWithdrawal::query()
            ->where('manager_id', $this->manager($request)->id)
            ->findOrFail($withdrawal);

        return response()->json(['data' => $this->withdrawalData($record)]);
    }

    private function manager(Request $request): Admin
    {
        return $request->attributes->get('ops_manager');
    }

    private function payoutMethodData(OpsManagerPayoutMethod $method): array
    {
        return [
            'id' => $method->id,
            'type' => $method->type,
            'account_title' => $method->account_title,
            'provider_name' => $method->provider_name,
            'account_number' => '',
            'masked_account' => $this->financeService->maskedAccount($method->account_last_four),
        ];
    }

    private function withdrawalData(OpsManagerWithdrawal $withdrawal): array
    {
        return [
            'id' => $withdrawal->id,
            'reference' => $withdrawal->reference,
            'amount' => (float) $withdrawal->amount,
            'currency' => $withdrawal->currency,
            'status' => $withdrawal->status,
            'destination' => $withdrawal->masked_destination,
            'admin_note' => $withdrawal->admin_note,
            'submitted_at' => $withdrawal->created_at?->toIso8601String(),
            'processed_at' => ($withdrawal->paid_at ?? $withdrawal->reviewed_at)?->toIso8601String(),
        ];
    }

    private function ledgerData(OpsManagerFinanceLedger $entry): array
    {
        $type = str_starts_with($entry->entry_type, 'withdrawal_')
            ? 'withdrawal'
            : (str_starts_with($entry->entry_type, 'invoice_collection_') ? 'collection' : 'commission');

        return [
            'id' => (string) $entry->id,
            'type' => $type,
            'entry_type' => $entry->entry_type,
            'title' => $this->ledgerTitle($entry->entry_type),
            'description' => $entry->description,
            'amount' => (float) $entry->amount,
            'direction' => $entry->direction,
            'is_credit' => $entry->direction === OpsManagerFinanceLedger::DIRECTION_CREDIT,
            'withdrawal_id' => $entry->withdrawal_id,
            'occurred_at' => $entry->created_at?->toIso8601String(),
        ];
    }

    private function ledgerTitle(string $entryType): string
    {
        return match ($entryType) {
            'invoice_collection_created' => 'Awaiting partner payment',
            'invoice_collection_cleared' => 'Partner payment received',
            'commission_calculated' => 'Commission calculated',
            'commission_payment_cleared' => 'Commission payment verified',
            'commission_pending_release' => 'Commission pending release',
            'commission_released' => 'Commission released',
            'commission_reversed' => 'Commission reversed',
            'withdrawal_reserved' => 'Withdrawal requested',
            'withdrawal_rejected' => 'Withdrawal returned',
            'withdrawal_paid' => 'Withdrawal paid',
            default => 'Finance update',
        };
    }
}
