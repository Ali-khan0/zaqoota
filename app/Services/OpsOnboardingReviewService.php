<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\OnboardingApplication;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpsOnboardingReviewService
{
    public function __construct(private readonly OpsOnboardingPaymentService $payments, private readonly OpsManagerAuditService $audit) {}

    public function review(OnboardingApplication $application, Admin $actor, string $action, string $note, string $expectedStatus): void
    {
        DB::transaction(function () use ($application, $actor, $action, $note, $expectedStatus): void {
            Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            abort_if($actor->zone_id && (int) $actor->zone_id !== (int) $application->zone_id, 403);
            if ($application->status !== $expectedStatus || in_array($application->status, ['draft', 'approved', 'cancelled', 'refunded', 'rejected'], true)) {
                throw ValidationException::withMessages(['action' => 'This application has changed or is closed. Refresh before reviewing it.']);
            }
            $invoice = $application->invoices()->latest('id')->lockForUpdate()->firstOrFail();
            $from = $application->status;
            if ($action === 'reject') {
                if ($invoice->payment_status !== 'unpaid' || $invoice->voided_at) {
                    throw ValidationException::withMessages(['action' => 'Paid applications require the invoice refund workflow before closure.']);
                }
                $this->payments->voidUnpaid($invoice, $actor, $note);
                $application->refresh();
                $from = $application->status;
                $application->update(['status' => 'rejected']);
            } elseif ($action === 'correction' && in_array($from, ['review_pending', 'data_entry'], true)) {
                $application->forceFill(['status' => 'data_pending', 'data_entry_completed_at' => null])->save();
            }
            $application->statusHistory()->create([
                'from_status' => $from,
                'to_status' => $application->status,
                'actor_type' => 'admin',
                'actor_id' => $actor->id,
                'actor_name' => trim($actor->f_name.' '.$actor->l_name),
                'note' => ($action === 'reject' ? 'Rejected: ' : 'Correction requested: ').$note,
                'metadata' => ['review_action' => $action],
            ]);
            $this->audit->record('ops_application_'.$action, $application->manager, [
                'application_id' => $application->id, 'reason' => $note,
            ], actor: $actor);
        }, 3);
    }
}
