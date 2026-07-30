<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\FleetManager;
use App\Models\FleetManagerEarningTransaction;
use App\Models\FleetManagerWithdrawalMethod;
use App\Models\FleetManagerWithdrawalRequest;
use App\Models\FleetPaymentCollection;
use App\Models\WithdrawalMethod;
use App\Services\FleetManagerFinanceService;
use App\Services\FleetManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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

    public function profile(Request $request)
    {
        $manager = $this->manager($request)->load(['primaryZone', 'zones', 'wallet']);

        return response()->json([
            'id' => $manager->id,
            'account_type' => 'fleet_manager',
            'employee_id' => $manager->employee_id,
            'name' => $manager->full_name,
            'f_name' => $manager->f_name,
            'l_name' => $manager->l_name,
            'phone' => $manager->phone,
            'email' => $manager->email,
            'image' => $manager->image,
            'status' => $manager->status,
            'on_leave' => $manager->on_leave,
            'rider_capacity' => $manager->rider_capacity,
            'assigned_riders_count' => $manager->riders()->count(),
            'shift_start' => $manager->shift_start,
            'shift_end' => $manager->shift_end,
            'joining_date' => optional($manager->joining_date)->format('Y-m-d'),
            'contract_type' => $manager->contract_type,
            'commission_percentage' => (float) $manager->commission_percentage,
            'wallet' => $this->formatWallet($manager),
            'primary_zone' => $manager->primaryZone ? [
                'id' => $manager->primaryZone->id,
                'name' => $manager->primaryZone->name,
                'display_name' => $manager->primaryZone->display_name,
            ] : null,
            'zones' => $manager->zones->map(fn ($zone) => [
                'id' => $zone->id,
                'name' => $zone->name,
                'display_name' => $zone->display_name,
            ])->values(),
        ]);
    }

    public function dashboard(Request $request)
    {
        $manager = $this->manager($request);
        $riders = $manager->riders()->with('wallet');
        $riderIds = $manager->riders()->select('delivery_men.id');
        $totalDue = (float) $manager->riders()
            ->join('delivery_man_wallets', 'delivery_men.id', '=', 'delivery_man_wallets.delivery_man_id')
            ->sum('delivery_man_wallets.collected_cash');
        $pendingCollectionAmount = (float) FleetPaymentCollection::query()
            ->whereIn('delivery_man_id', $riderIds)
            ->where('status', FleetPaymentCollection::STATUS_PENDING)
            ->sum('amount');

        return response()->json([
            'assigned_riders' => (clone $riders)->count(),
            'active_riders' => (clone $riders)->where('active', 1)->count(),
            'offline_riders' => (clone $riders)->where('active', 0)->count(),
            'riders_with_due' => (clone $riders)->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0))->count(),
            'total_due' => $totalDue,
            'total_pending_collection_amount' => $pendingCollectionAmount,
            'total_collectable_balance' => max(0, $totalDue - $pendingCollectionAmount),
            'pending_collections' => $manager->paymentCollections()
                ->where('status', FleetPaymentCollection::STATUS_PENDING)
                ->count(),
            'commission_percentage' => (float) $manager->commission_percentage,
            'wallet' => $this->formatWallet($manager->loadMissing('wallet')),
        ]);
    }

    public function updateProfile(Request $request)
    {
        $manager = $this->manager($request);
        $validator = Validator::make($request->all(), [
            'f_name' => ['required', 'string', 'max:100'],
            'l_name' => ['nullable', 'string', 'max:100'],
            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('fleet_managers')->ignore($manager->id),
                Rule::unique('delivery_men', 'phone'),
            ],
            'email' => [
                'nullable',
                'email',
                'max:191',
                Rule::unique('fleet_managers')->ignore($manager->id),
                Rule::unique('delivery_men', 'email'),
            ],
            'password' => [
                'nullable',
                Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised(),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $data = $validator->validated();
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $manager->update($data);

        return response()->json(['message' => __('fleet_management.profile_updated')]);
    }

    public function earnings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'status' => ['nullable', Rule::in([
                FleetManagerEarningTransaction::STATUS_EARNED,
                FleetManagerEarningTransaction::STATUS_REVERSED,
            ])],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $manager = $this->manager($request);
        $query = $manager->earningTransactions()
            ->with('deliveryMan:id,f_name,l_name,phone')
            ->when($request->from, fn ($builder, $from) => $builder->whereDate('created_at', '>=', $from))
            ->when($request->to, fn ($builder, $to) => $builder->whereDate('created_at', '<=', $to))
            ->when($request->status, fn ($builder, $status) => $builder->where('status', $status));

        $summary = [
            'earned' => (float) (clone $query)->where('status', FleetManagerEarningTransaction::STATUS_EARNED)->sum('amount'),
            'reversed' => (float) (clone $query)->where('status', FleetManagerEarningTransaction::STATUS_REVERSED)->sum('amount'),
            'orders' => (clone $query)->where('status', FleetManagerEarningTransaction::STATUS_EARNED)->count(),
            'wallet' => $this->formatWallet($manager->loadMissing('wallet')),
        ];
        $earnings = $query->latest()->paginate(config('default_pagination'));
        $earnings->getCollection()->transform(fn ($earning) => [
            'id' => $earning->id,
            'order_id' => $earning->order_id,
            'rider' => $earning->deliveryMan ? [
                'id' => $earning->deliveryMan->id,
                'name' => $earning->deliveryMan->full_name,
                'phone' => $earning->deliveryMan->phone,
            ] : null,
            'delivery_amount' => (float) $earning->delivery_amount,
            'admin_commission_amount' => (float) $earning->admin_commission_amount,
            'commission_percentage' => (float) $earning->fleet_commission_percentage,
            'amount' => (float) $earning->amount,
            'status' => $earning->status,
            'created_at' => $earning->created_at?->toIso8601String(),
            'reversed_at' => $earning->reversed_at?->toIso8601String(),
        ]);

        return response()->json([
            'summary' => $summary,
            'earnings' => $earnings,
        ]);
    }

    public function withdrawalMethodTemplates()
    {
        return response()->json(
            WithdrawalMethod::query()
                ->where('is_active', 1)
                ->orderByDesc('is_default')
                ->get(['id', 'method_name', 'method_fields', 'is_default'])
        );
    }

    public function withdrawalMethods(Request $request)
    {
        return response()->json(
            $this->manager($request)->withdrawalMethods()
                ->whereHas('withdrawalMethod', fn ($method) => $method->where('is_active', 1))
                ->latest()
                ->get()
                ->map(fn ($method) => $this->formatWithdrawalMethod($method))
                ->values()
        );
    }

    public function storeWithdrawalMethod(Request $request, ?int $id = null)
    {
        $manager = $this->manager($request);
        $validator = Validator::make($request->all(), [
            'withdrawal_method_id' => ['required', 'integer', 'exists:withdrawal_methods,id'],
            'fields' => ['required', 'array'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $template = WithdrawalMethod::query()
            ->where('is_active', 1)
            ->findOrFail($request->withdrawal_method_id);
        $fieldValidation = $this->validateWithdrawalFields($template, $request->input('fields', []));
        if ($fieldValidation->fails()) {
            return response()->json(['errors' => Helpers::error_processor($fieldValidation)], 422);
        }

        $method = $id
            ? $manager->withdrawalMethods()->findOrFail($id)
            : new FleetManagerWithdrawalMethod(['fleet_manager_id' => $manager->id]);
        $method->fill([
            'withdrawal_method_id' => $template->id,
            'method_name' => $template->method_name,
            'method_fields' => $fieldValidation->validated(),
            'is_default' => $request->boolean('is_default'),
        ]);
        $method->save();

        if ($method->is_default || $manager->withdrawalMethods()->count() === 1) {
            $method->update(['is_default' => true]);
            $manager->withdrawalMethods()->where('id', '!=', $method->id)->update(['is_default' => false]);
        } elseif (! $manager->withdrawalMethods()->where('is_default', true)->exists()) {
            $method->update(['is_default' => true]);
        }

        return response()->json([
            'message' => __('fleet_management.withdrawal_method_saved'),
            'method' => $this->formatWithdrawalMethod($method),
        ], $id ? 200 : 201);
    }

    public function makeDefaultWithdrawalMethod(Request $request, int $id)
    {
        $manager = $this->manager($request);
        $method = $manager->withdrawalMethods()
            ->whereHas('withdrawalMethod', fn ($template) => $template->where('is_active', 1))
            ->findOrFail($id);

        $manager->withdrawalMethods()->update(['is_default' => false]);
        $method->update(['is_default' => true]);

        return response()->json(['message' => __('fleet_management.default_withdrawal_method_updated')]);
    }

    public function deleteWithdrawalMethod(Request $request, int $id)
    {
        $manager = $this->manager($request);
        $method = $manager->withdrawalMethods()->findOrFail($id);
        $wasDefault = $method->is_default;
        $method->delete();

        if ($wasDefault) {
            $manager->withdrawalMethods()->latest()->first()?->update(['is_default' => true]);
        }

        return response()->json(['message' => __('fleet_management.withdrawal_method_deleted')]);
    }

    public function withdrawals(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['nullable', Rule::in([
                FleetManagerWithdrawalRequest::STATUS_PENDING,
                FleetManagerWithdrawalRequest::STATUS_APPROVED,
                FleetManagerWithdrawalRequest::STATUS_REJECTED,
            ])],
            'page' => ['nullable', 'integer', 'min:1'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $manager = $this->manager($request);
        $withdrawals = $manager->withdrawalRequests()
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest()
            ->paginate(config('default_pagination'));
        $withdrawals->getCollection()->transform(fn ($withdrawal) => $this->formatWithdrawal($withdrawal));

        return response()->json([
            'wallet' => $this->formatWallet($manager->loadMissing('wallet')),
            'withdrawals' => $withdrawals,
        ]);
    }

    public function requestWithdrawal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'withdrawal_method_id' => ['required', 'integer'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'note' => ['nullable', 'string', 'max:1000'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $manager = $this->manager($request);
        $method = $manager->withdrawalMethods()->findOrFail($request->withdrawal_method_id);

        try {
            $withdrawal = $this->fleetManagerFinanceService->requestWithdrawal(
                $manager,
                $method,
                (float) $request->amount,
                $request->note
            );
        } catch (ValidationException $exception) {
            return $this->validationExceptionResponse($exception);
        }

        return response()->json([
            'message' => __('fleet_management.withdrawal_requested'),
            'wallet' => $this->formatWallet($manager->load('wallet')),
            'withdrawal' => $this->formatWithdrawal($withdrawal),
        ], 201);
    }

    public function riders(Request $request)
    {
        $manager = $this->manager($request);
        $riders = $manager->riders()
            ->with(['zone', 'wallet', 'rating'])
            ->withSum([
                'fleetPaymentCollections as pending_collection_amount' => fn ($query) => $query
                    ->where('status', FleetPaymentCollection::STATUS_PENDING),
            ], 'amount')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('f_name', 'like', "%{$search}%")
                        ->orWhere('l_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($request->boolean('due_only'), fn ($query) => $query->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0)))
            ->paginate(config('default_pagination'));

        $riders->getCollection()->transform(function (DeliveryMan $rider) {
            return [
                'id' => $rider->id,
                'name' => $rider->full_name,
                'phone' => $rider->phone,
                'image_full_url' => $rider->image_full_url,
                'zone' => $rider->zone?->name,
                'active' => (bool) $rider->active,
                'status' => (bool) $rider->status,
                'current_orders' => (int) $rider->current_orders,
                'rating' => (float) ($rider->rating->first()?->average ?? 0),
                'payable_balance' => (float) ($rider->wallet?->collected_cash ?? 0),
                'pending_collection_amount' => (float) ($rider->pending_collection_amount ?? 0),
                'collectable_balance' => max(
                    0,
                    (float) ($rider->wallet?->collected_cash ?? 0) - (float) ($rider->pending_collection_amount ?? 0)
                ),
            ];
        });

        return response()->json($riders);
    }

    public function rider(Request $request, int $id)
    {
        $rider = $this->manager($request)->riders()
            ->with(['zone', 'wallet', 'rating', 'vehicle'])
            ->withSum([
                'fleetPaymentCollections as pending_collection_amount' => fn ($query) => $query
                    ->where('status', FleetPaymentCollection::STATUS_PENDING),
            ], 'amount')
            ->withCount(['orders', 'total_delivered_orders', 'total_canceled_orders'])
            ->findOrFail($id);

        $payableBalance = (float) ($rider->wallet?->collected_cash ?? 0);
        $pendingAmount = (float) ($rider->pending_collection_amount ?? 0);

        return response()->json([
            'id' => $rider->id,
            'name' => $rider->full_name,
            'f_name' => $rider->f_name,
            'l_name' => $rider->l_name,
            'phone' => $rider->phone,
            'email' => $rider->email,
            'image_full_url' => $rider->image_full_url,
            'zone' => $rider->zone ? [
                'id' => $rider->zone->id,
                'name' => $rider->zone->name,
            ] : null,
            'vehicle' => $rider->vehicle ? [
                'id' => $rider->vehicle->id,
                'type' => $rider->vehicle->type ?? null,
            ] : null,
            'active' => (bool) $rider->active,
            'status' => (bool) $rider->status,
            'available' => (bool) $rider->available,
            'current_orders' => (int) $rider->current_orders,
            'rating' => (float) ($rider->rating->first()?->average ?? 0),
            'rating_count' => (int) ($rider->rating->first()?->rating_count ?? 0),
            'orders_count' => (int) $rider->orders_count,
            'delivered_orders_count' => (int) $rider->total_delivered_orders_count,
            'canceled_orders_count' => (int) $rider->total_canceled_orders_count,
            'member_since' => optional($rider->created_at)->format('Y-m-d'),
            'payable_balance' => $payableBalance,
            'pending_collection_amount' => $pendingAmount,
            'collectable_balance' => max(0, $payableBalance - $pendingAmount),
        ]);
    }

    public function collections(Request $request)
    {
        $collections = $this->manager($request)
            ->paymentCollections()
            ->with([
                'deliveryMan' => fn ($query) => $query
                    ->select('id', 'f_name', 'l_name', 'phone')
                    ->with('wallet')
                    ->withSum([
                        'fleetPaymentCollections as pending_collection_amount' => fn ($collections) => $collections
                            ->where('status', FleetPaymentCollection::STATUS_PENDING),
                    ], 'amount'),
            ])
            ->when($request->status, fn ($query, $status) => $query->where('status', $status))
            ->latest('submitted_at')
            ->paginate(config('default_pagination'));

        $collections->getCollection()->transform(fn ($collection) => $this->formatCollection($collection));

        return response()->json($collections);
    }

    public function updateFcmToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fcm_token' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $this->manager($request)->update(['fcm_token' => $request->fcm_token]);

        return response()->json(['message' => __('fleet_management.fcm_token_updated')]);
    }

    public function submitCollection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'delivery_man_id' => ['required', 'integer', 'exists:delivery_men,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:cash,bank_transfer,mobile_wallet,other'],
            'reference' => ['nullable', 'string', 'max:191'],
            'note' => ['nullable', 'string', 'max:1000'],
            'proof_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 422);
        }

        $manager = $this->manager($request);
        $rider = $manager->riders()->with('wallet')->findOrFail($request->delivery_man_id);
        $data = $validator->validated();
        $proofFile = $request->file('proof_file');
        unset($data['proof_file']);

        try {
            $collection = $this->fleetManagementService->submitCollection($manager, $rider, $data);
        } catch (ValidationException $exception) {
            $errors = [];
            foreach ($exception->errors() as $field => $messages) {
                foreach ($messages as $message) {
                    $errors[] = ['code' => $field, 'message' => $message];
                }
            }

            return response()->json(['errors' => $errors], 422);
        }

        if ($proofFile) {
            $fileName = now()->format('Y-m-d').'-'.Str::uuid().'.'.$proofFile->getClientOriginalExtension();
            Storage::disk('local')->putFileAs('fleet-manager/payment-proofs', $proofFile, $fileName);
            $collection->update([
                'proof_file' => $fileName,
                'proof_disk' => 'local',
            ]);
        }

        return response()->json([
            'message' => __('fleet_management.collection_submitted'),
            'collection' => $this->formatCollection($collection->load([
                'deliveryMan' => fn ($query) => $query
                    ->select('id', 'f_name', 'l_name', 'phone')
                    ->with('wallet')
                    ->withSum([
                        'fleetPaymentCollections as pending_collection_amount' => fn ($collections) => $collections
                            ->where('status', FleetPaymentCollection::STATUS_PENDING),
                    ], 'amount'),
            ])),
        ], 201);
    }

    private function manager(Request $request): FleetManager
    {
        return FleetManager::query()
            ->where('auth_token', $request->token)
            ->where('status', true)
            ->where('on_leave', false)
            ->firstOrFail();
    }

    private function formatCollection(FleetPaymentCollection $collection): array
    {
        $payableBalance = max(0, (float) ($collection->deliveryMan?->wallet?->collected_cash ?? 0));
        $pendingCollectionAmount = max(
            0,
            (float) ($collection->deliveryMan?->pending_collection_amount ?? 0)
        );

        return [
            'id' => $collection->id,
            'rider' => $collection->deliveryMan ? [
                'id' => $collection->deliveryMan->id,
                'name' => $collection->deliveryMan->full_name,
                'phone' => $collection->deliveryMan->phone,
            ] : null,
            'amount' => (float) $collection->amount,
            'due_before' => (float) $collection->due_before,
            'due_after' => $collection->due_after === null ? null : (float) $collection->due_after,
            'payable_balance' => $payableBalance,
            'pending_collection_amount' => $pendingCollectionAmount,
            'collectable_balance' => max(0, $payableBalance - $pendingCollectionAmount),
            'payment_method' => $collection->payment_method,
            'reference' => $collection->reference,
            'note' => $collection->note,
            'proof_uploaded' => (bool) $collection->proof_file,
            'status' => $collection->status,
            'submitted_at' => $collection->submitted_at?->toIso8601String(),
            'reviewed_at' => $collection->reviewed_at?->toIso8601String(),
            'rejection_reason' => $collection->rejection_reason,
        ];
    }

    private function formatWallet(FleetManager $manager): array
    {
        return [
            'total_earning' => (float) ($manager->wallet?->total_earning ?? 0),
            'total_withdrawn' => (float) ($manager->wallet?->total_withdrawn ?? 0),
            'pending_withdraw' => (float) ($manager->wallet?->pending_withdraw ?? 0),
            'available_balance' => (float) ($manager->wallet?->available_balance ?? 0),
        ];
    }

    private function validateWithdrawalFields(WithdrawalMethod $template, array $fields)
    {
        $rules = [];
        foreach ($template->method_fields ?? [] as $field) {
            $name = $field['input_name'];
            $rule = ($field['is_required'] ?? false) ? ['required'] : ['nullable'];
            $typeRules = match ($field['input_type'] ?? 'string') {
                'number' => ['numeric'],
                'email' => ['email', 'max:191'],
                'date' => ['date'],
                default => ['string', 'max:191'],
            };
            $rule = array_merge($rule, $typeRules);
            $rules[$name] = $rule;
        }

        return Validator::make($fields, $rules);
    }

    private function formatWithdrawalMethod(FleetManagerWithdrawalMethod $method): array
    {
        return [
            'id' => $method->id,
            'withdrawal_method_id' => $method->withdrawal_method_id,
            'method_name' => $method->method_name,
            'fields' => $method->method_fields,
            'is_default' => (bool) $method->is_default,
        ];
    }

    private function formatWithdrawal(FleetManagerWithdrawalRequest $withdrawal): array
    {
        return [
            'id' => $withdrawal->id,
            'amount' => (float) $withdrawal->amount,
            'method_name' => $withdrawal->method_name,
            'method_fields' => $withdrawal->method_fields,
            'manager_note' => $withdrawal->manager_note,
            'status' => $withdrawal->status,
            'admin_note' => $withdrawal->admin_note,
            'requested_at' => $withdrawal->created_at?->toIso8601String(),
            'reviewed_at' => $withdrawal->reviewed_at?->toIso8601String(),
        ];
    }

    private function validationExceptionResponse(ValidationException $exception)
    {
        $errors = [];
        foreach ($exception->errors() as $field => $messages) {
            foreach ($messages as $message) {
                $errors[] = ['code' => $field, 'message' => $message];
            }
        }

        return response()->json(['errors' => $errors], 422);
    }
}
