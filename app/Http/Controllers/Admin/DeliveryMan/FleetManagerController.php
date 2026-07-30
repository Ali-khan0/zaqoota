<?php

namespace App\Http\Controllers\Admin\DeliveryMan;

use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\DeliveryManWallet;
use App\Models\FleetManager;
use App\Models\FleetManagerRiderAssignment;
use App\Models\FleetManagerWithdrawalRequest;
use App\Models\FleetPaymentCollection;
use App\Models\Zone;
use App\Services\FleetManagerFinanceService;
use App\Services\FleetManagementService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class FleetManagerController extends Controller
{
    public function __construct(
        private readonly FleetManagementService $fleetManagementService,
        private readonly FleetManagerFinanceService $fleetManagerFinanceService
    ) {
    }

    public function index(Request $request)
    {
        $fleetManagers = $this->managerQuery()
            ->with(['primaryZone', 'zones', 'wallet'])
            ->withCount('riders')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('employee_id', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(config('default_pagination'));

        return view('admin-views.delivery-man.fleet-manager.index', compact('fleetManagers'));
    }

    public function create()
    {
        $zones = Zone::query()->where('status', 1)->orderBy('name')->get();

        return view('admin-views.delivery-man.fleet-manager.form', [
            'fleetManager' => new FleetManager(),
            'zones' => $zones,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateManager($request);
        $zoneIds = $data['zone_ids'];
        unset($data['zone_ids']);
        $data['password'] = Hash::make($data['password']);
        $data['primary_zone_id'] = $data['primary_zone_id'] ?: $zoneIds[0];

        $fleetManager = FleetManager::create($data);
        $fleetManager->zones()->sync($zoneIds);

        Toastr::success(__('fleet_management.manager_created'));

        return redirect()->route('admin.users.delivery-man.fleet-manager.index');
    }

    public function edit(int $id)
    {
        $fleetManager = $this->findEditableManager($id);
        $zones = Zone::query()->where('status', 1)->orderBy('name')->get();

        return view('admin-views.delivery-man.fleet-manager.form', compact('fleetManager', 'zones'));
    }

    public function update(Request $request, int $id)
    {
        $fleetManager = $this->findEditableManager($id);
        $data = $this->validateManager($request, $fleetManager);
        $zoneIds = $data['zone_ids'];
        unset($data['zone_ids']);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['primary_zone_id'] = $data['primary_zone_id'] ?: $zoneIds[0];
        $fleetManager->update($data);
        $fleetManager->zones()->sync($zoneIds);
        if (! $fleetManager->status || $fleetManager->on_leave) {
            $fleetManager->update(['auth_token' => null]);
        }

        Toastr::success(__('fleet_management.manager_updated'));

        return redirect()->route('admin.users.delivery-man.fleet-manager.index');
    }

    public function status(int $id)
    {
        $fleetManager = $this->findEditableManager($id);
        $fleetManager->update(['status' => ! $fleetManager->status]);
        if (! $fleetManager->status) {
            $fleetManager->update(['auth_token' => null]);
        }

        Toastr::success(__('fleet_management.manager_status_updated'));

        return back();
    }

    public function assignments(Request $request)
    {
        $fleetManagers = $this->managerQuery()
            ->available()
            ->withCount('riders')
            ->orderBy('f_name')
            ->get();

        $riders = $this->riderQuery()
            ->with(['zone', 'fleetManager', 'wallet'])
            ->when($request->zone_id, fn ($query, $zoneId) => $query->where('zone_id', $zoneId))
            ->when($request->assignment === 'unassigned', fn ($query) => $query->whereNull('fleet_manager_id'))
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->where('application_status', 'approved')
            ->paginate(config('default_pagination'));

        $history = FleetManagerRiderAssignment::query()
            ->with(['fleetManager', 'deliveryMan', 'assignedBy', 'endedBy'])
            ->when(Auth::guard('admin')->user()?->zone_id, function ($query, $zoneId) {
                $query->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $zoneId));
            })
            ->latest('started_at')
            ->limit(20)
            ->get();

        $zones = Zone::query()->where('status', 1)->orderBy('name')->get();

        return view('admin-views.delivery-man.fleet-manager.assignments', compact(
            'fleetManagers',
            'riders',
            'history',
            'zones'
        ));
    }

    public function assign(Request $request)
    {
        $data = $request->validate([
            'fleet_manager_id' => ['required', 'integer', 'exists:fleet_managers,id'],
            'rider_ids' => ['required', 'array', 'min:1'],
            'rider_ids.*' => ['integer', 'exists:delivery_men,id'],
            'reason' => ['nullable', 'string', 'max:191'],
        ]);

        $fleetManager = $this->findVisibleManager($data['fleet_manager_id']);
        DB::transaction(function () use ($data, $fleetManager) {
            foreach (array_unique($data['rider_ids']) as $riderId) {
                $this->fleetManagementService->assignRider(
                    $fleetManager,
                    $this->findVisibleRider($riderId),
                    Auth::guard('admin')->id(),
                    $data['reason'] ?? null
                );
            }
        });

        Toastr::success(__('fleet_management.riders_assigned'));

        return back();
    }

    public function unassign(Request $request, int $riderId)
    {
        $data = $request->validate([
            'reason' => ['nullable', 'string', 'max:191'],
        ]);

        $this->fleetManagementService->unassignRider(
            $this->findVisibleRider($riderId),
            Auth::guard('admin')->id(),
            $data['reason'] ?? null
        );

        Toastr::success(__('fleet_management.rider_unassigned'));

        return back();
    }

    public function collections(Request $request)
    {
        $collections = FleetPaymentCollection::query()
            ->with([
                'fleetManager',
                'deliveryMan' => fn ($query) => $query
                    ->with('wallet')
                    ->withSum([
                        'fleetPaymentCollections as pending_collection_amount' => fn ($collections) => $collections
                            ->where('status', FleetPaymentCollection::STATUS_PENDING),
                    ], 'amount'),
                'reviewer',
            ])
            ->when(Auth::guard('admin')->user()?->zone_id, function ($query, $zoneId) {
                $query->whereHas('deliveryMan', fn ($rider) => $rider->where('zone_id', $zoneId));
            })
            ->when($request->fleet_manager_id, fn ($query, $managerId) => $query->where('fleet_manager_id', $managerId))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest('submitted_at')
            ->paginate(config('default_pagination'));

        $recoveryManagers = $this->managerQuery()
            ->with('zones')
            ->withCount([
                'riders',
                'riders as riders_with_due_count' => fn ($query) => $query
                    ->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0)),
            ])
            ->addSelect([
                'rider_payable_balance' => DeliveryManWallet::query()
                    ->selectRaw('COALESCE(SUM(delivery_man_wallets.collected_cash), 0)')
                    ->join('delivery_men', 'delivery_men.id', '=', 'delivery_man_wallets.delivery_man_id')
                    ->whereColumn('delivery_men.fleet_manager_id', 'fleet_managers.id'),
            ])
            ->orderByDesc('rider_payable_balance')
            ->get();

        return view('admin-views.delivery-man.fleet-manager.collections', compact(
            'collections',
            'recoveryManagers'
        ));
    }

    public function report(Request $request, int $id)
    {
        $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['earned', 'reversed'])],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $fleetManager = $this->findVisibleManager($id)->load(['wallet', 'zones']);
        $earningsQuery = $fleetManager->earningTransactions()
            ->with('deliveryMan:id,f_name,l_name,phone')
            ->when($request->from, fn ($query, $from) => $query->whereDate('created_at', '>=', $from))
            ->when($request->to, fn ($query, $to) => $query->whereDate('created_at', '<=', $to))
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->search, function ($query, $search) {
                $query->where(function ($earning) use ($search) {
                    $earning->where('order_id', 'like', "%{$search}%")
                        ->orWhereHas('deliveryMan', function ($rider) use ($search) {
                            $rider->where('f_name', 'like', "%{$search}%")
                                ->orWhere('l_name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            });

        $summary = [
            'total_earned' => (float) (clone $earningsQuery)->where('status', 'earned')->sum('amount'),
            'reversed' => (float) (clone $earningsQuery)->where('status', 'reversed')->sum('amount'),
            'orders' => (clone $earningsQuery)->where('status', 'earned')->count(),
            'riders' => $fleetManager->riders()->count(),
            'riders_with_due' => $fleetManager->riders()
                ->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0))
                ->count(),
            'rider_payable_balance' => (float) $fleetManager->riders()
                ->join('delivery_man_wallets', 'delivery_men.id', '=', 'delivery_man_wallets.delivery_man_id')
                ->sum('delivery_man_wallets.collected_cash'),
            'approved_recoveries' => (float) $fleetManager->paymentCollections()
                ->where('status', FleetPaymentCollection::STATUS_APPROVED)
                ->sum('amount'),
        ];

        $earnings = $earningsQuery->latest()->paginate(config('default_pagination'));

        return view('admin-views.delivery-man.fleet-manager.report', compact(
            'fleetManager',
            'earnings',
            'summary'
        ));
    }

    public function withdrawals(Request $request)
    {
        $withdrawals = FleetManagerWithdrawalRequest::query()
            ->with(['fleetManager.zones', 'reviewer'])
            ->when(Auth::guard('admin')->user()?->zone_id, function ($query, $zoneId) {
                $query->whereHas('fleetManager.zones', fn ($zone) => $zone->where('zones.id', $zoneId));
            })
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->when($request->fleet_manager_id, fn ($query, $managerId) => $query->where('fleet_manager_id', $managerId))
            ->when($request->search, function ($query, $search) {
                $query->whereHas('fleetManager', function ($manager) use ($search) {
                    $manager->where('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(config('default_pagination'));

        $fleetManagers = $this->managerQuery()->orderBy('f_name')->get(['id', 'f_name', 'l_name']);

        return view('admin-views.delivery-man.fleet-manager.withdrawals', compact(
            'withdrawals',
            'fleetManagers'
        ));
    }

    public function reviewWithdrawal(Request $request, int $id)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in([
                FleetManagerWithdrawalRequest::STATUS_APPROVED,
                FleetManagerWithdrawalRequest::STATUS_REJECTED,
            ])],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        $withdrawal = FleetManagerWithdrawalRequest::query()->findOrFail($id);
        $this->findVisibleManager($withdrawal->fleet_manager_id);
        $this->fleetManagerFinanceService->reviewWithdrawal(
            $withdrawal,
            $data['status'],
            Auth::guard('admin')->id(),
            $data['admin_note'] ?? null
        );

        Toastr::success(
            $data['status'] === FleetManagerWithdrawalRequest::STATUS_APPROVED
                ? __('fleet_management.withdrawal_approved')
                : __('fleet_management.withdrawal_rejected')
        );

        return back();
    }

    public function approveCollection(int $id)
    {
        $collection = FleetPaymentCollection::findOrFail($id);
        $this->findVisibleRider($collection->delivery_man_id);
        $this->fleetManagementService->approveCollection($collection, Auth::guard('admin')->id());
        Toastr::success(__('fleet_management.collection_approved'));

        return back();
    }

    public function rejectCollection(Request $request, int $id)
    {
        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $collection = FleetPaymentCollection::findOrFail($id);
        $this->findVisibleRider($collection->delivery_man_id);
        $this->fleetManagementService->rejectCollection(
            $collection,
            Auth::guard('admin')->id(),
            $data['rejection_reason']
        );
        Toastr::success(__('fleet_management.collection_rejected'));

        return back();
    }

    public function collectionProof(int $id)
    {
        $collection = FleetPaymentCollection::findOrFail($id);
        $this->findVisibleRider($collection->delivery_man_id);
        abort_unless($collection->proof_file, 404);

        $path = 'fleet-manager/payment-proofs/'.$collection->proof_file;
        abort_unless(Storage::disk($collection->proof_disk ?: 'local')->exists($path), 404);

        return Storage::disk($collection->proof_disk ?: 'local')->download($path);
    }

    private function validateManager(Request $request, ?FleetManager $fleetManager = null): array
    {
        $data = $request->validate([
            'employee_id' => ['nullable', 'string', 'max:100', Rule::unique('fleet_managers')->ignore($fleetManager?->id)],
            'f_name' => ['required', 'string', 'max:100'],
            'l_name' => ['nullable', 'string', 'max:100'],
            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('fleet_managers')->ignore($fleetManager?->id),
                Rule::unique('delivery_men', 'phone'),
            ],
            'email' => [
                'nullable',
                'email',
                'max:191',
                Rule::unique('fleet_managers')->ignore($fleetManager?->id),
                Rule::unique('delivery_men', 'email'),
            ],
            'password' => [
                $fleetManager ? 'nullable' : 'required',
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
            ],
            'zone_ids' => ['required', 'array', 'min:1'],
            'zone_ids.*' => ['integer', 'exists:zones,id'],
            'primary_zone_id' => ['nullable', 'integer', 'exists:zones,id'],
            'rider_capacity' => ['required', 'integer', 'min:1', 'max:10000'],
            'shift_start' => ['nullable', 'date_format:H:i'],
            'shift_end' => ['nullable', 'date_format:H:i'],
            'joining_date' => ['nullable', 'date'],
            'contract_type' => ['required', Rule::in(['employee', 'contractor', 'external_fleet'])],
            'commission_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['nullable', 'boolean'],
            'on_leave' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $zoneIds = array_map('intval', $data['zone_ids']);
        if (! empty($data['primary_zone_id']) && ! in_array((int) $data['primary_zone_id'], $zoneIds, true)) {
            throw ValidationException::withMessages([
                'primary_zone_id' => __('fleet_management.error_primary_area_invalid'),
            ]);
        }

        $adminZoneId = Auth::guard('admin')->user()?->zone_id;
        if ($adminZoneId && ($zoneIds !== [(int) $adminZoneId])) {
            throw ValidationException::withMessages([
                'zone_ids' => __('fleet_management.error_area_admin_scope'),
            ]);
        }

        return $data;
    }

    private function managerQuery()
    {
        return FleetManager::query()
            ->when(Auth::guard('admin')->user()?->zone_id, function ($query, $zoneId) {
                $query->whereHas('zones', fn ($zone) => $zone->where('zones.id', $zoneId));
            });
    }

    private function riderQuery()
    {
        return DeliveryMan::withoutGlobalScopes()
            ->when(Auth::guard('admin')->user()?->zone_id, fn ($query, $zoneId) => $query->where('zone_id', $zoneId));
    }

    private function findVisibleManager(int $id): FleetManager
    {
        return $this->managerQuery()->findOrFail($id);
    }

    private function findEditableManager(int $id): FleetManager
    {
        $fleetManager = $this->findVisibleManager($id);
        $adminZoneId = Auth::guard('admin')->user()?->zone_id;

        if ($adminZoneId && $fleetManager->zones()->where('zones.id', '!=', $adminZoneId)->exists()) {
            abort(403, __('fleet_management.error_multi_area_super_admin'));
        }

        return $fleetManager;
    }

    private function findVisibleRider(int $id): DeliveryMan
    {
        return $this->riderQuery()->findOrFail($id);
    }
}
