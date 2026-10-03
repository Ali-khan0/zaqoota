<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OpsDataEntryService
{
    public function handle(OnboardingApplication $application, Admin $actor, string $action, string $note, string $expectedStatus, ?int $assignee): void
    {
        DB::transaction(function () use ($application, $actor, $action, $note, $expectedStatus, $assignee): void {
            Admin::query()->whereKey($application->onboarding_manager_id)->lockForUpdate()->firstOrFail();
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            abort_if($actor->zone_id && (int) $actor->zone_id !== (int) $application->zone_id, 403);
            $invoice = $application->invoices()->latest('id')->lockForUpdate()->firstOrFail();
            if ($application->status !== $expectedStatus || ! in_array($application->status, ['data_pending', 'data_entry'], true)
                || $invoice->payment_status !== 'paid' || $invoice->voided_at) {
                throw ValidationException::withMessages(['action' => 'This application changed or is not eligible for paid data entry. Refresh the page.']);
            }
            $from = $application->status;
            $previousAssignee = $application->data_entry_admin_id;
            if ($action === 'assign') {
                $staff = Admin::query()->with('role')->findOrFail($assignee);
                $modules = json_decode($staff->role?->modules ?? '[]', true) ?: [];
                if ($staff->isOnboardingManager() || ! $staff->role?->status
                    || ((int) $staff->role_id !== 1 && ! in_array('store', $modules, true))
                    || ($staff->zone_id && (int) $staff->zone_id !== (int) $application->zone_id)) {
                    throw ValidationException::withMessages(['assignee' => 'Choose active admin staff with store permission and matching territory.']);
                }
                // Ordinary store staff may claim unassigned work; reassignment requires employee permission.
                if ((int) $staff->id !== (int) $actor->id || ($previousAssignee && (int) $previousAssignee !== (int) $actor->id)) {
                    abort_unless(\App\CentralLogics\Helpers::module_permission_check('employee'), 403);
                }
                $application->forceFill(['data_entry_admin_id' => $staff->id, 'data_entry_assigned_at' => now(),
                    'data_entry_completed_at' => null, 'status' => 'data_entry'])->save();
            } else {
                abort_unless((int) $application->data_entry_admin_id === (int) $actor->id && $from === 'data_entry', 403);
                $store = Store::withoutGlobalScopes()->lockForUpdate()->findOrFail($application->store_id);
                $vendor = Vendor::query()->findOrFail($application->vendor_id);
                if ((int) $vendor->status === 1 || (int) $store->status === 1) {
                    throw ValidationException::withMessages(['store' => 'The partner must remain pending until final approval.']);
                }
                if (! $store->name || ! $store->address || ! $store->logo || ! $store->cover_photo
                    || ! $store->phone || ! \App\Models\Item::withoutGlobalScopes()->where('store_id', $store->id)->exists()) {
                    throw ValidationException::withMessages(['store' => 'Complete the store name, address, phone, logo, cover photo and at least one catalog item before review.']);
                }
                $application->forceFill(['status' => 'review_pending', 'data_entry_completed_at' => now()])->save();
            }
            $application->statusHistory()->create([
                'from_status' => $from, 'to_status' => $application->status, 'actor_type' => 'admin',
                'actor_id' => $actor->id, 'actor_name' => trim($actor->f_name.' '.$actor->l_name),
                'note' => ($action === 'assign' ? 'Data entry assigned. ' : 'Data entry completed; awaiting final review. ').$note,
                'metadata' => ['previous_assignee' => $previousAssignee, 'assignee' => $application->data_entry_admin_id],
            ]);
            app(OpsManagerAuditService::class)->record('ops_data_entry_'.$action, $application->manager, [
                'application_id' => $application->id, 'assignee' => $application->data_entry_admin_id, 'reason' => $note,
            ], actor: $actor);
        }, 3);
    }
}
