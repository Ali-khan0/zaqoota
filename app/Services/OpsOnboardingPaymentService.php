<?php

namespace App\Services;

use App\Jobs\SendOpsManagerNotification;
use App\Jobs\SendOpsOnboardingPaymentConfirmation;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\OnboardingInvoiceCheckoutToken;
use App\Models\OnboardingInvoicePaymentAttempt;
use App\Models\PaymentRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsOnboardingPaymentService
{
    public function __construct(
        private readonly OpsManagerFinanceService $financeService,
        private readonly OpsManagerAuditService $auditService,
    ) {}

    public function settleManual(
        OnboardingInvoice $invoice,
        Admin $actor,
        string $method,
        string $reference,
        UploadedFile $proof,
    ): array {
        $storedProof = $this->storeProof($invoice, $proof);
        $changed = false;
        try {
            $result = DB::transaction(function () use ($invoice, $actor, $method, $reference, $storedProof, &$changed): array {
                $applicationId = $invoice->onboarding_application_id;
                $application = OnboardingApplication::query()->findOrFail($applicationId);
                Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
                $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($applicationId);
                $invoice = OnboardingInvoice::query()->lockForUpdate()->findOrFail($invoice->id);
                if ($invoice->voided_at) {
                    throw ValidationException::withMessages(['payment_status' => ['A void invoice cannot be paid.']]);
                }
                if ($invoice->payment_status === OnboardingInvoice::PAYMENT_PAID
                    && $application->status === OnboardingApplication::STATUS_DATA_PENDING) {
                    return ['invoice' => $invoice, 'application' => $application, 'already_processed' => true];
                }
                if (! in_array($application->status, [
                    OnboardingApplication::STATUS_SUBMITTED,
                    OnboardingApplication::STATUS_INVOICE_SENT,
                    OnboardingApplication::STATUS_PAYMENT_PENDING,
                    OnboardingApplication::STATUS_PAYMENT_FAILED,
                    OnboardingApplication::STATUS_DATA_PENDING,
                ], true)) {
                    throw ValidationException::withMessages([
                        'payment_status' => ['This onboarding stage cannot accept payment verification.'],
                    ]);
                }

                $fromStatus = $application->status;
                $invoice->update([
                    'payment_status' => OnboardingInvoice::PAYMENT_PAID,
                    'paid_at' => $invoice->paid_at ?? now(),
                    'payment_method' => trim($method),
                    'payment_reference' => trim($reference),
                    'payment_proof_disk' => $storedProof['disk'],
                    'payment_proof_path' => $storedProof['path'],
                    'payment_proof_name' => $storedProof['name'],
                    'payment_proof_mime' => $storedProof['mime'],
                    'payment_proof_size' => $storedProof['size'],
                    'paid_by' => $actor->id,
                ]);
                if ($fromStatus !== OnboardingApplication::STATUS_DATA_PENDING) {
                    $application->update(['status' => OnboardingApplication::STATUS_DATA_PENDING]);
                    $application->statusHistory()->create([
                        'from_status' => $fromStatus,
                        'to_status' => OnboardingApplication::STATUS_DATA_PENDING,
                        'actor_type' => 'admin',
                        'actor_id' => $actor->id,
                        'actor_name' => $this->actorName($actor),
                        'note' => 'Onboarding payment verified; application moved to data entry pending.',
                        'metadata' => [
                            'invoice_id' => $invoice->id,
                            'payment_method' => trim($method),
                            'payment_reference' => trim($reference),
                        ],
                    ]);
                }
                $invoice->events()->create([
                    'event_type' => 'payment_verified',
                    'description' => 'Onboarding payment verified and moved to data entry pending.',
                    'metadata' => [
                        'payment_method' => trim($method),
                        'payment_reference' => trim($reference),
                        'proof_name' => $storedProof['name'],
                    ],
                    'admin_id' => $actor->id,
                    'admin_name' => $this->actorName($actor),
                ]);
                $this->financeService->markInvoiceCollected($application, $actor);
                OnboardingInvoiceCheckoutToken::query()
                    ->where('onboarding_invoice_id', $invoice->id)
                    ->whereNull('revoked_at')
                    ->update(['revoked_at' => now()]);
                $changed = true;

                return ['invoice' => $invoice->refresh(), 'application' => $application->refresh(), 'already_processed' => false];
            }, 3);
        } catch (\Throwable $exception) {
            Storage::disk($storedProof['disk'])->delete($storedProof['path']);
            throw $exception;
        }

        if (! $changed) {
            Storage::disk($storedProof['disk'])->delete($storedProof['path']);

            return $result;
        }
        $application = $result['application'];
        $invoice = $result['invoice'];
        SendOpsOnboardingPaymentConfirmation::dispatch($invoice->id);
        SendOpsManagerNotification::dispatch(
            $application->onboarding_manager_id,
            "payment-verified:{$invoice->id}",
            'payment_verified',
            'Payment verified',
            'Partner payment was verified and the restaurant moved to data entry.',
            $application->id,
        );
        $this->auditService->record('ops_payment_verified', $application->manager, [
            'onboarding_application_id' => $application->id,
            'invoice_id' => $invoice->id,
            'payment_method' => trim($method),
            'payment_reference' => trim($reference),
            'proof_name' => $storedProof['name'],
        ], actor: $actor);

        return $result;
    }

    public function voidUnpaid(OnboardingInvoice $invoice, Admin $actor, string $reason): void
    {
        DB::transaction(function () use ($invoice, $actor, $reason): void {
            $application = OnboardingApplication::query()->findOrFail($invoice->onboarding_application_id);
            Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            $invoice = OnboardingInvoice::query()->lockForUpdate()->findOrFail($invoice->id);
            if ($invoice->voided_at) {
                return;
            }
            if ($invoice->payment_status !== OnboardingInvoice::PAYMENT_UNPAID) {
                throw ValidationException::withMessages([
                    'void_reason' => ['Only an unpaid Ops invoice can be voided directly. Paid invoices require the refund workflow.'],
                ]);
            }
            $fromStatus = $application->status;
            $invoice->update([
                'voided_at' => now(),
                'void_reason' => $reason,
                'voided_by' => $actor->id,
            ]);
            if ($fromStatus !== OnboardingApplication::STATUS_CANCELLED) {
                $application->update(['status' => OnboardingApplication::STATUS_CANCELLED]);
                $application->statusHistory()->create([
                    'from_status' => $fromStatus,
                    'to_status' => OnboardingApplication::STATUS_CANCELLED,
                    'actor_type' => 'admin',
                    'actor_id' => $actor->id,
                    'actor_name' => $this->actorName($actor),
                    'note' => 'Onboarding invoice voided and application cancelled.',
                    'metadata' => ['invoice_id' => $invoice->id, 'reason' => $reason],
                ]);
            }
            $invoice->events()->create([
                'event_type' => 'voided',
                'description' => 'Invoice voided and onboarding application cancelled.',
                'metadata' => ['reason' => $reason],
                'admin_id' => $actor->id,
                'admin_name' => $this->actorName($actor),
            ]);
            $this->financeService->reverseUnpaidApplication($application, $actor, $reason);
            OnboardingInvoiceCheckoutToken::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);
        }, 3);

        $application = $invoice->onboardingApplication;
        $this->auditService->record('ops_invoice_voided', $application?->manager, [
            'onboarding_application_id' => $application?->id,
            'invoice_id' => $invoice->id,
            'reason' => $reason,
        ], actor: $actor);
    }

    public function settleGateway(PaymentRequest $paymentRequest): bool
    {
        $changed = false;
        $application = null;
        $invoice = null;
        $settled = DB::transaction(function () use ($paymentRequest, &$changed, &$application, &$invoice): bool {
            $paymentRequest = PaymentRequest::query()->lockForUpdate()->findOrFail($paymentRequest->id);
            $attempt = OnboardingInvoicePaymentAttempt::query()
                ->where('payment_request_id', $paymentRequest->id)
                ->lockForUpdate()
                ->first();
            if (! $attempt) {
                return false;
            }
            if (in_array($attempt->status, [
                OnboardingInvoicePaymentAttempt::STATUS_PAID,
                OnboardingInvoicePaymentAttempt::STATUS_REFUND_PENDING,
                OnboardingInvoicePaymentAttempt::STATUS_REFUNDED,
            ], true)) {
                return true;
            }

            $invoice = OnboardingInvoice::query()->findOrFail($attempt->onboarding_invoice_id);
            $application = OnboardingApplication::query()->findOrFail($invoice->onboarding_application_id);
            Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            $invoice = OnboardingInvoice::query()->lockForUpdate()->findOrFail($invoice->id);
            $reference = trim((string) $paymentRequest->transaction_id);
            $invalidReason = $this->gatewayMismatchReason($paymentRequest, $attempt, $invoice, $reference);
            if ($invalidReason !== null) {
                $referenceAlreadyUsed = $reference !== '' && OnboardingInvoicePaymentAttempt::query()
                    ->whereKeyNot($attempt->id)
                    ->where('gateway', $attempt->gateway)
                    ->where('transaction_reference', $reference)
                    ->exists();
                $attempt->update([
                    'status' => OnboardingInvoicePaymentAttempt::STATUS_REVIEW_REQUIRED,
                    'failure_reason' => $invalidReason,
                    'transaction_reference' => $reference !== '' && ! $referenceAlreadyUsed ? $reference : null,
                ]);
                $invoice->events()->create([
                    'event_type' => 'gateway_payment_review_required',
                    'description' => 'Gateway payment requires manual review and did not settle the invoice.',
                    'metadata' => [
                        'attempt_id' => $attempt->id,
                        'reason' => $invalidReason,
                        'reported_transaction_reference' => $reference !== '' ? $reference : null,
                    ],
                ]);

                return false;
            }

            if ($invoice->voided_at || $invoice->payment_status === OnboardingInvoice::PAYMENT_REFUNDED) {
                $attempt->update([
                    'status' => OnboardingInvoicePaymentAttempt::STATUS_REFUND_PENDING,
                    'transaction_reference' => $reference,
                    'paid_at' => now(),
                    'failure_reason' => 'Payment completed after the invoice became unavailable.',
                ]);
                $invoice->events()->create([
                    'event_type' => 'duplicate_payment_refund_required',
                    'description' => 'A gateway payment completed after the invoice became unavailable and requires refund.',
                    'metadata' => ['attempt_id' => $attempt->id, 'transaction_reference' => $reference],
                ]);

                return false;
            }
            if ($invoice->payment_status === OnboardingInvoice::PAYMENT_PAID) {
                if ($invoice->payment_method === $attempt->gateway && $invoice->payment_reference === $reference) {
                    $attempt->update([
                        'status' => OnboardingInvoicePaymentAttempt::STATUS_PAID,
                        'transaction_reference' => $reference,
                        'paid_at' => $invoice->paid_at ?? now(),
                    ]);

                    return true;
                }
                $attempt->update([
                    'status' => OnboardingInvoicePaymentAttempt::STATUS_REFUND_PENDING,
                    'transaction_reference' => $reference,
                    'paid_at' => now(),
                    'failure_reason' => 'Invoice was already paid by another transaction.',
                ]);
                $invoice->events()->create([
                    'event_type' => 'duplicate_payment_refund_required',
                    'description' => 'A duplicate gateway payment requires refund.',
                    'metadata' => ['attempt_id' => $attempt->id, 'transaction_reference' => $reference],
                ]);

                return false;
            }
            if (! in_array($application->status, [
                OnboardingApplication::STATUS_SUBMITTED,
                OnboardingApplication::STATUS_INVOICE_SENT,
                OnboardingApplication::STATUS_PAYMENT_PENDING,
                OnboardingApplication::STATUS_PAYMENT_FAILED,
                OnboardingApplication::STATUS_DATA_PENDING,
            ], true)) {
                $attempt->update([
                    'status' => OnboardingInvoicePaymentAttempt::STATUS_REFUND_PENDING,
                    'transaction_reference' => $reference,
                    'paid_at' => now(),
                    'failure_reason' => 'Application stage cannot accept payment.',
                ]);

                return false;
            }

            $fromStatus = $application->status;
            $invoice->update([
                'payment_status' => OnboardingInvoice::PAYMENT_PAID,
                'paid_at' => now(),
                'payment_method' => $attempt->gateway,
                'payment_reference' => $reference,
                'paid_by' => null,
                'refunded_at' => null,
                'refund_reference' => null,
                'refund_reason' => null,
                'refunded_by' => null,
            ]);
            if ($fromStatus !== OnboardingApplication::STATUS_DATA_PENDING) {
                $application->update(['status' => OnboardingApplication::STATUS_DATA_PENDING]);
                $application->statusHistory()->create([
                    'from_status' => $fromStatus,
                    'to_status' => OnboardingApplication::STATUS_DATA_PENDING,
                    'actor_type' => 'gateway',
                    'actor_name' => $attempt->gateway,
                    'note' => 'Hosted checkout payment verified; application moved to data entry pending.',
                    'metadata' => [
                        'invoice_id' => $invoice->id,
                        'payment_attempt_id' => $attempt->id,
                        'payment_reference' => $reference,
                    ],
                ]);
            }
            $attempt->update([
                'status' => OnboardingInvoicePaymentAttempt::STATUS_PAID,
                'transaction_reference' => $reference,
                'failure_reason' => null,
                'paid_at' => now(),
            ]);
            $invoice->events()->create([
                'event_type' => 'gateway_payment_verified',
                'description' => 'Hosted checkout payment verified and moved to data entry pending.',
                'metadata' => [
                    'gateway' => $attempt->gateway,
                    'attempt_id' => $attempt->id,
                    'payment_reference' => $reference,
                ],
            ]);
            OnboardingInvoiceCheckoutToken::query()
                ->where('onboarding_invoice_id', $invoice->id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);
            $this->financeService->markInvoiceCollected($application);
            $changed = true;

            return true;
        }, 3);

        if ($changed && $application && $invoice) {
            SendOpsOnboardingPaymentConfirmation::dispatch($invoice->id);
            SendOpsManagerNotification::dispatch(
                $application->onboarding_manager_id,
                "payment-verified:{$invoice->id}",
                'payment_verified',
                'Payment verified',
                'Partner payment was verified and the restaurant moved to data entry.',
                $application->id,
            );
            $this->auditService->record('ops_gateway_payment_verified', $application->manager, [
                'onboarding_application_id' => $application->id,
                'invoice_id' => $invoice->id,
                'payment_method' => $invoice->payment_method,
                'payment_reference' => $invoice->payment_reference,
            ]);
        }

        return $settled;
    }

    public function failGatewayAttempt(PaymentRequest $paymentRequest): void
    {
        DB::transaction(function () use ($paymentRequest): void {
            $attempt = OnboardingInvoicePaymentAttempt::query()
                ->where('payment_request_id', $paymentRequest->id)
                ->lockForUpdate()
                ->first();
            if (! $attempt || $attempt->status !== OnboardingInvoicePaymentAttempt::STATUS_PENDING) {
                return;
            }
            $attempt->update([
                'status' => OnboardingInvoicePaymentAttempt::STATUS_FAILED,
                'failure_reason' => 'The payment gateway reported failure or cancellation.',
            ]);
            $attempt->invoice?->events()->create([
                'event_type' => 'gateway_payment_failed',
                'description' => 'Hosted checkout payment failed or was cancelled.',
                'metadata' => ['attempt_id' => $attempt->id, 'gateway' => $attempt->gateway],
            ]);
        }, 3);
    }

    public function recordGatewayRefund(
        OnboardingInvoicePaymentAttempt $attempt,
        Admin $actor,
        string $reference,
        string $reason,
    ): void {
        $application = null;
        $reversedInvoice = false;
        DB::transaction(function () use ($attempt, $actor, $reference, $reason, &$application, &$reversedInvoice): void {
            $attempt = OnboardingInvoicePaymentAttempt::query()->lockForUpdate()->findOrFail($attempt->id);
            if ($attempt->status === OnboardingInvoicePaymentAttempt::STATUS_REFUNDED) {
                return;
            }
            if (! in_array($attempt->status, [
                OnboardingInvoicePaymentAttempt::STATUS_PAID,
                OnboardingInvoicePaymentAttempt::STATUS_REFUND_PENDING,
            ], true)) {
                throw ValidationException::withMessages(['refund' => ['Only a captured gateway payment can be recorded as refunded.']]);
            }
            $invoice = OnboardingInvoice::query()->lockForUpdate()->findOrFail($attempt->onboarding_invoice_id);
            $application = OnboardingApplication::query()->findOrFail($invoice->onboarding_application_id);
            Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            $isCurrentPayment = $invoice->payment_status === OnboardingInvoice::PAYMENT_PAID
                && $invoice->payment_method === $attempt->gateway
                && $invoice->payment_reference === $attempt->transaction_reference;
            if ($isCurrentPayment) {
                $fromStatus = $application->status;
                $this->financeService->reverseCommission($application, $actor, $reason);
                $invoice->update([
                    'payment_status' => OnboardingInvoice::PAYMENT_REFUNDED,
                    'refunded_at' => now(),
                    'refund_reference' => trim($reference),
                    'refund_reason' => trim($reason),
                    'refunded_by' => $actor->id,
                ]);
                if ($fromStatus !== OnboardingApplication::STATUS_REFUNDED) {
                    $application->update(['status' => OnboardingApplication::STATUS_REFUNDED]);
                    $application->statusHistory()->create([
                        'from_status' => $fromStatus,
                        'to_status' => OnboardingApplication::STATUS_REFUNDED,
                        'actor_type' => 'admin',
                        'actor_id' => $actor->id,
                        'actor_name' => $this->actorName($actor),
                        'note' => 'Gateway refund verified; onboarding payment and commission were reversed.',
                        'metadata' => ['attempt_id' => $attempt->id, 'refund_reference' => trim($reference)],
                    ]);
                }
                $reversedInvoice = true;
            }
            $attempt->update([
                'status' => OnboardingInvoicePaymentAttempt::STATUS_REFUNDED,
                'refund_reference' => trim($reference),
                'refund_reason' => trim($reason),
                'refunded_by' => $actor->id,
                'refunded_at' => now(),
            ]);
            $invoice->events()->create([
                'event_type' => 'gateway_payment_refunded',
                'description' => $isCurrentPayment
                    ? 'Hosted checkout payment refunded and onboarding commission reversed.'
                    : 'Duplicate hosted checkout payment refund recorded.',
                'metadata' => [
                    'attempt_id' => $attempt->id,
                    'refund_reference' => trim($reference),
                    'reason' => trim($reason),
                ],
                'admin_id' => $actor->id,
                'admin_name' => $this->actorName($actor),
            ]);
        }, 3);

        if ($application) {
            $this->auditService->record('ops_gateway_payment_refunded', $application->manager, [
                'onboarding_application_id' => $application->id,
                'payment_attempt_id' => $attempt->id,
                'refund_reference' => trim($reference),
                'invoice_reversed' => $reversedInvoice,
            ], actor: $actor);
        }
    }

    public function cleanupOrphanedProofs(int $hours): int
    {
        $disk = (string) config('ops.media.disk', 'local');
        $cutoff = now()->subHours(max(1, $hours))->getTimestamp();
        $deleted = 0;

        foreach (Storage::disk($disk)->allFiles('onboarding/payment-proofs') as $path) {
            try {
                if (Storage::disk($disk)->lastModified($path) >= $cutoff) {
                    continue;
                }
                $isReferenced = OnboardingInvoice::query()
                    ->where('payment_proof_disk', $disk)
                    ->where('payment_proof_path', $path)
                    ->exists();
                if (! $isReferenced && Storage::disk($disk)->delete($path)) {
                    $deleted++;
                }
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        return $deleted;
    }

    private function storeProof(OnboardingInvoice $invoice, UploadedFile $proof): array
    {
        $disk = (string) config('ops.media.disk', 'local');
        $mime = (string) $proof->getMimeType();
        $extension = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'application/pdf' => 'pdf',
            default => throw ValidationException::withMessages(['payment_proof' => ['Upload a valid JPG, PNG, or PDF payment proof.']]),
        };
        $path = 'onboarding/payment-proofs/'.$invoice->id.'/'.Str::uuid().'.'.$extension;
        $stream = fopen($proof->getRealPath(), 'rb');
        try {
            if (! is_resource($stream) || ! Storage::disk($disk)->put($path, $stream, ['visibility' => 'private'])) {
                throw ValidationException::withMessages(['payment_proof' => ['Payment proof could not be stored. Please retry.']]);
            }
        } finally {
            if (is_resource($stream)) {
                fclose($stream);
            }
        }

        return [
            'disk' => $disk,
            'path' => $path,
            'name' => Str::limit(
                preg_replace('/[^\pL\pN._ -]+/u', '-', basename($proof->getClientOriginalName())) ?: 'payment-proof.'.$extension,
                255,
                '',
            ),
            'mime' => $mime,
            'size' => (int) $proof->getSize(),
        ];
    }

    private function gatewayMismatchReason(
        PaymentRequest $paymentRequest,
        OnboardingInvoicePaymentAttempt $attempt,
        OnboardingInvoice $invoice,
        string $reference,
    ): ?string {
        if (! $paymentRequest->is_paid) {
            return 'Gateway request is not marked paid.';
        }
        if ($paymentRequest->attribute !== 'onboarding_invoice'
            || (int) $paymentRequest->attribute_id !== $invoice->id
            || (int) $paymentRequest->payer_id !== $invoice->id) {
            return 'Gateway request does not belong to this onboarding invoice.';
        }
        if ($paymentRequest->payment_method !== $attempt->gateway) {
            return 'Gateway identity does not match the checkout attempt.';
        }
        if ((int) round(((float) $paymentRequest->payment_amount) * 100) !== (int) round(((float) $attempt->amount) * 100)
            || (int) round(((float) $invoice->amount) * 100) !== (int) round(((float) $attempt->amount) * 100)) {
            return 'Paid amount does not match the immutable invoice amount.';
        }
        if (strtoupper((string) $paymentRequest->currency_code) !== strtoupper($attempt->currency)) {
            return 'Paid currency does not match the invoice currency.';
        }
        if ($reference === '') {
            return 'Gateway transaction reference is missing.';
        }
        if (OnboardingInvoicePaymentAttempt::query()
            ->whereKeyNot($attempt->id)
            ->where('gateway', $attempt->gateway)
            ->where('transaction_reference', $reference)
            ->exists()) {
            return 'Gateway transaction reference was already used.';
        }

        return null;
    }

    private function actorName(Admin $actor): string
    {
        return trim($actor->f_name.' '.$actor->l_name) ?: $actor->email;
    }
}
