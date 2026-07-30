<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\DeliveryMan;
use App\Models\FleetManager;
use App\Models\FleetPaymentCollection;
use App\Services\FleetManagementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class FleetManagerController extends Controller
{
    public function __construct(private readonly FleetManagementService $fleetManagementService)
    {
    }

    public function profile(Request $request)
    {
        $manager = $this->manager($request)->load(['primaryZone', 'zones']);

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

        return response()->json([
            'assigned_riders' => (clone $riders)->count(),
            'active_riders' => (clone $riders)->where('active', 1)->count(),
            'offline_riders' => (clone $riders)->where('active', 0)->count(),
            'riders_with_due' => (clone $riders)->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0))->count(),
            'total_due' => (float) $manager->riders()
                ->join('delivery_man_wallets', 'delivery_men.id', '=', 'delivery_man_wallets.delivery_man_id')
                ->sum('delivery_man_wallets.collected_cash'),
            'pending_collections' => $manager->paymentCollections()
                ->where('status', FleetPaymentCollection::STATUS_PENDING)
                ->count(),
        ]);
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
            ->when($request->due_only, fn ($query) => $query->whereHas('wallet', fn ($wallet) => $wallet->where('collected_cash', '>', 0)))
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
            ->with('deliveryMan:id,f_name,l_name,phone')
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
            'collection' => $this->formatCollection($collection->load('deliveryMan:id,f_name,l_name,phone')),
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
}
