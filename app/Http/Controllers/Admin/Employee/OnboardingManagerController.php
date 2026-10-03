<?php

namespace App\Http\Controllers\Admin\Employee;

use App\Http\Controllers\BaseController;
use App\Models\Admin;
use App\Models\OnboardingApplication;
use App\Models\OnboardingInvoice;
use App\Models\OpsManagerAudit;
use App\Models\OpsManagerFinanceLedger;
use App\Models\OpsManagerWithdrawal;
use App\Services\OpsManagerAuditService;
use App\Services\OpsManagerFinanceService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class OnboardingManagerController extends BaseController
{
    public function __construct(
        private readonly OpsManagerFinanceService $financeService,
        private readonly OpsManagerAuditService $auditService,
    ) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search'));
        $status = $request->query('status', 'all');

        $managers = $this->managerQuery()
            ->with(['role', 'zones'])
            ->withCount([
                'onboardingApplications',
                'onboardingApplications as approved_applications_count' => fn (Builder $query) => $query
                    ->where('status', OnboardingApplication::STATUS_APPROVED),
            ])
            ->when($search !== '', function (Builder $query) use ($search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($status === 'active', fn (Builder $query) => $query
                ->where('ops_status', true)
                ->whereHas('role', fn (Builder $roleQuery) => $roleQuery->where('status', true)))
            ->when($status === 'banned', fn (Builder $query) => $query->where('ops_status', false))
            ->latest()
            ->paginate(config('default_pagination'))
            ->withQueryString();

        $visibleManagerIds = $this->managerQuery()->pluck('id');
        $summary = [
            'total' => $visibleManagerIds->count(),
            'active' => $this->managerQuery()
                ->where('ops_status', true)
                ->whereHas('role', fn (Builder $query) => $query->where('status', true))
                ->count(),
            'applications' => OnboardingApplication::query()
                ->whereIn('onboarding_manager_id', $visibleManagerIds)
                ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
                ->count(),
            'approved' => OnboardingApplication::query()
                ->whereIn('onboarding_manager_id', $visibleManagerIds)
                ->where('status', OnboardingApplication::STATUS_APPROVED)
                ->count(),
        ];

        return view('admin-views.employee.onboarding-manager-index', compact('managers', 'summary'));
    }

    public function show(Admin $manager): View
    {
        $manager = $this->resolveManager($manager);
        $balances = $this->financeService->balances($manager->id);
        $applicationCounts = OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->selectRaw('status, COUNT(*) AS aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $invoiceTotals = OnboardingInvoice::query()
            ->whereHas('onboardingApplication', fn (Builder $query) => $query
                ->where('onboarding_manager_id', $manager->id))
            ->whereNull('voided_at')
            ->selectRaw(
                'COUNT(*) AS invoice_count, COALESCE(SUM(amount), 0) AS invoiced_amount, COALESCE(SUM(CASE WHEN payment_status = ? THEN amount ELSE 0 END), 0) AS paid_amount',
                [OnboardingInvoice::PAYMENT_PAID],
            )
            ->first();

        $applications = OnboardingApplication::query()
            ->where('onboarding_manager_id', $manager->id)
            ->where('status', '!=', OnboardingApplication::STATUS_DRAFT)
            ->with(['invoice:id,onboarding_application_id,invoice_number,amount,payment_status', 'zone:id,name'])
            ->latest()
            ->paginate(10, ['*'], 'applications_page')
            ->withQueryString();

        $ledger = OpsManagerFinanceLedger::query()
            ->where('manager_id', $manager->id)
            ->latest('id')
            ->paginate(10, ['*'], 'ledger_page')
            ->withQueryString();

        $withdrawals = OpsManagerWithdrawal::query()
            ->where('manager_id', $manager->id)
            ->latest()
            ->paginate(10, ['*'], 'withdrawals_page')
            ->withQueryString();

        $audits = OpsManagerAudit::query()
            ->where('manager_id', $manager->id)
            ->with('actor:id,f_name,l_name')
            ->latest()
            ->paginate(10, ['*'], 'audits_page')
            ->withQueryString();

        $manager->load(['role', 'zones', 'opsPayoutMethod']);

        return view('admin-views.employee.onboarding-manager-show', compact(
            'manager',
            'balances',
            'applicationCounts',
            'invoiceTotals',
            'applications',
            'ledger',
            'withdrawals',
            'audits',
        ));
    }

    public function updateStatus(Request $request, Admin $manager): RedirectResponse
    {
        $manager = $this->resolveManager($manager);
        $validated = $request->validate([
            'ops_status' => ['required', 'boolean'],
            'reason' => ['nullable', 'string', 'max:500'],
        ]);
        $enabled = (bool) $validated['ops_status'];

        DB::transaction(function () use ($manager, $enabled, $validated, $request): void {
            $locked = Admin::query()->whereKey($manager->id)->lockForUpdate()->firstOrFail();
            if ((bool) $locked->ops_status === $enabled) {
                return;
            }

            $locked->forceFill([
                'ops_status' => $enabled,
                'ops_fcm_token' => $enabled ? $locked->ops_fcm_token : null,
                'ops_fcm_platform' => $enabled ? $locked->ops_fcm_platform : null,
                'is_logged_in' => $enabled ? $locked->is_logged_in : false,
                'remember_token' => $enabled ? $locked->remember_token : null,
                'login_remember_token' => $enabled ? $locked->login_remember_token : null,
            ])->save();

            if (! $enabled) {
                $locked->tokens()->update(['revoked' => true]);
            }

            $this->auditService->record($enabled ? 'ops_manager_unbanned' : 'ops_manager_banned', $locked, [
                'reason' => $validated['reason'] ?? null,
                'tokens_revoked' => ! $enabled,
            ], $request);
        });

        Toastr::success($enabled
            ? 'Onboarding manager access enabled.'
            : 'Onboarding manager access disabled and mobile sessions revoked.');

        return back();
    }

    private function managerQuery(): Builder
    {
        return Admin::query()
            ->where('staff_type', Admin::STAFF_TYPE_ONBOARDING_MANAGER)
            ->when(auth('admin')->user()?->zone_id, fn (Builder $query, $zoneId) => $query
                ->where('zone_id', $zoneId));
    }

    private function resolveManager(Admin $manager): Admin
    {
        abort_unless($manager->isOnboardingManager(), 404);
        $adminZoneId = auth('admin')->user()?->zone_id;
        abort_if($adminZoneId && (int) $manager->zone_id !== (int) $adminZoneId, 403);

        return $manager;
    }
}
