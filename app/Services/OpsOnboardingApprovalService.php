<?php

namespace App\Services;

use App\Jobs\SendOpsVendorApprovalEmail;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\OnboardingVendorPasswordSetup;
use App\Models\Store;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OpsOnboardingApprovalService
{
    public function __construct(private readonly OpsManagerAuditService $auditService) {}

    public function applicationForStore(Store $store): ?OnboardingApplication
    {
        return OnboardingApplication::query()
            ->where('store_id', $store->id)
            ->where('vendor_id', $store->vendor_id)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->latest('id')
            ->first();
    }

    public function approve(OnboardingApplication $application, Admin $actor): array
    {
        $permissions = json_decode($actor->role?->modules ?? '[]', true) ?: [];
        abort_unless((int) $actor->role_id === 1 || (in_array('store', $permissions, true) && in_array('report', $permissions, true)), 403);
        $changed = false;
        $setup = null;
        $result = DB::transaction(function () use ($application, $actor, &$changed, &$setup): OnboardingApplication {
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            $vendor = Vendor::query()->lockForUpdate()->findOrFail($application->vendor_id);
            $store = Store::withoutGlobalScopes()->lockForUpdate()->findOrFail($application->store_id);
            $invoice = OnboardingInvoice::query()
                ->where('onboarding_application_id', $application->id)
                ->latest('id')
                ->lockForUpdate()
                ->firstOrFail();

            if ($application->status === OnboardingApplication::STATUS_APPROVED) {
                return $application;
            }
            if ($application->status !== OnboardingApplication::STATUS_REVIEW_PENDING) {
                throw ValidationException::withMessages([
                    'status' => ['This Ops application must complete data entry and review before final approval.'],
                ]);
            }
            abort_if($actor->zone_id && (int) $actor->zone_id !== (int) $application->zone_id, 403);
            if (! $application->data_entry_completed_at || ! $application->data_entry_admin_id) {
                throw ValidationException::withMessages(['status' => 'Recorded data-entry completion is required before approval.']);
            }
            if ($invoice->payment_status !== OnboardingInvoice::PAYMENT_PAID || $invoice->voided_at) {
                throw ValidationException::withMessages([
                    'payment' => ['A verified, non-void onboarding payment is required before final approval.'],
                ]);
            }

            $vendor->forceFill(['status' => 1, 'rejection_note' => null])->save();
            $store->forceFill(['status' => 1])->save();
            DB::table('password_resets')->where('email', $vendor->email)->delete();
            $fromStatus = $application->status;
            $application->update([
                'status' => OnboardingApplication::STATUS_APPROVED,
                'completed_at' => now(),
            ]);
            $application->statusHistory()->create([
                'from_status' => $fromStatus,
                'to_status' => OnboardingApplication::STATUS_APPROVED,
                'actor_type' => 'admin',
                'actor_id' => $actor->id,
                'actor_name' => $this->actorName($actor),
                'note' => 'Final approval activated the vendor and store; one-time password setup issued.',
            ]);
            $setup = $this->issueToken($application, $vendor, $actor);
            $invoice->events()->create([
                'event_type' => 'application_approved',
                'description' => 'Onboarding application approved and vendor password setup issued.',
                'metadata' => ['password_setup_expires_at' => $setup->expires_at->toIso8601String()],
                'admin_id' => $actor->id,
                'admin_name' => $this->actorName($actor),
            ]);
            $changed = true;

            return $application->refresh();
        }, 3);

        if ($changed && $setup) {
            SendOpsVendorApprovalEmail::dispatch($setup->id);
            $this->auditService->record('ops_application_approved', $result->manager, [
                'onboarding_application_id' => $result->id,
                'vendor_id' => $result->vendor_id,
                'store_id' => $result->store_id,
                'password_setup_id' => $setup->id,
            ], actor: $actor);
        }

        return ['application' => $result, 'password_setup' => $setup, 'already_processed' => ! $changed];
    }

    public function reissue(OnboardingApplication $application, Admin $actor): OnboardingVendorPasswordSetup
    {
        $setup = DB::transaction(function () use ($application, $actor): OnboardingVendorPasswordSetup {
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($application->id);
            $vendor = Vendor::query()->lockForUpdate()->findOrFail($application->vendor_id);
            $store = Store::withoutGlobalScopes()->lockForUpdate()->findOrFail($application->store_id);
            if ($application->status !== OnboardingApplication::STATUS_APPROVED
                || (int) $vendor->status !== 1
                || (int) $store->status !== 1) {
                throw ValidationException::withMessages([
                    'status' => ['Password setup can be reissued only for an active approved Ops partner.'],
                ]);
            }

            return $this->issueToken($application, $vendor, $actor);
        }, 3);

        SendOpsVendorApprovalEmail::dispatch($setup->id);
        $this->auditService->record('ops_vendor_password_setup_reissued', $application->manager, [
            'onboarding_application_id' => $application->id,
            'password_setup_id' => $setup->id,
        ], actor: $actor);

        return $setup;
    }

    public function resolve(string $secret): OnboardingVendorPasswordSetup
    {
        $setup = OnboardingVendorPasswordSetup::query()
            ->with(['application.store', 'vendor'])
            ->where('token_hash', hash('sha256', $secret))
            ->firstOrFail();
        $this->assertUsable($setup);

        return $setup;
    }

    public function signedUrl(OnboardingVendorPasswordSetup $setup): string
    {
        return URL::temporarySignedRoute(
            'onboarding-vendor.password-setup',
            $setup->expires_at,
            ['token' => $setup->token_secret],
        );
    }

    public function complete(OnboardingVendorPasswordSetup $setup, string $password, ?string $ip): Vendor
    {
        $application = null;
        $vendor = DB::transaction(function () use ($setup, $password, $ip, &$application): Vendor {
            $application = OnboardingApplication::query()->lockForUpdate()->findOrFail($setup->onboarding_application_id);
            $vendor = Vendor::query()->lockForUpdate()->findOrFail($setup->vendor_id);
            $store = Store::withoutGlobalScopes()->lockForUpdate()->findOrFail($application->store_id);
            $setup = OnboardingVendorPasswordSetup::query()->lockForUpdate()->findOrFail($setup->id);
            $setup->setRelation('application', $application->setRelation('store', $store));
            $setup->setRelation('vendor', $vendor);
            $this->assertUsable($setup);

            $vendor->forceFill([
                'password' => Hash::make($password),
                'login_remember_token' => Str::random(60),
                'auth_token' => null,
            ])->save();
            DB::table('password_resets')->where('email', $vendor->email)->delete();
            $setup->update(['used_at' => now(), 'used_ip' => $ip]);
            OnboardingVendorPasswordSetup::query()
                ->where('onboarding_application_id', $application->id)
                ->whereKeyNot($setup->id)
                ->whereNull('revoked_at')
                ->update(['revoked_at' => now()]);
            $application->invoice?->events()->create([
                'event_type' => 'vendor_password_setup_completed',
                'description' => 'Vendor completed the one-time password setup.',
            ]);

            return $vendor->refresh();
        }, 3);

        $this->auditService->record('ops_vendor_password_setup_completed', $application?->manager, [
            'onboarding_application_id' => $application?->id,
            'vendor_id' => $vendor->id,
        ]);

        return $vendor;
    }

    private function issueToken(
        OnboardingApplication $application,
        Vendor $vendor,
        Admin $actor,
    ): OnboardingVendorPasswordSetup {
        OnboardingVendorPasswordSetup::query()
            ->where('onboarding_application_id', $application->id)
            ->whereNull('used_at')
            ->whereNull('revoked_at')
            ->update(['revoked_at' => now()]);
        $secret = Str::random(64);

        return OnboardingVendorPasswordSetup::query()->create([
            'onboarding_application_id' => $application->id,
            'vendor_id' => $vendor->id,
            'token_hash' => hash('sha256', $secret),
            'token_secret' => $secret,
            'expires_at' => now()->addMinutes(max(15, (int) config('ops.approval.password_setup_lifetime_minutes', 1440))),
            'created_by' => $actor->id,
        ]);
    }

    private function assertUsable(OnboardingVendorPasswordSetup $setup): void
    {
        if ($setup->used_at || $setup->revoked_at || $setup->expires_at->isPast()) {
            abort(410, 'This password setup link has expired or was already used.');
        }
        if ($setup->application?->status !== OnboardingApplication::STATUS_APPROVED
            || (int) $setup->vendor?->status !== 1
            || (int) $setup->application?->store?->status !== 1) {
            abort(403, 'This partner account is not active.');
        }
    }

    private function actorName(Admin $actor): string
    {
        return trim($actor->f_name.' '.$actor->l_name) ?: $actor->email;
    }
}
