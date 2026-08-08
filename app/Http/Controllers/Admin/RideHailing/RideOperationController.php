<?php

namespace App\Http\Controllers\Admin\RideHailing;

use App\Http\Controllers\Controller;
use App\Models\RideCategory;
use App\Models\RideOffer;
use App\Models\RideRequest;
use App\Models\Zone;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideFareCalculator;
use App\Services\RideNotificationService;
use App\Services\RideRealtimeService;
use App\Services\RideTripService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RideOperationController extends Controller
{
    public function __construct(
        private readonly RideCaptainEligibilityService $eligibilityService,
        private readonly RideFareCalculator $fareCalculator,
        private readonly RideTripService $tripService,
        private readonly RideNotificationService $notificationService,
        private readonly RideRealtimeService $realtimeService,
    ) {}

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));
        $status = (string) $request->input('status', 'all');
        $paymentStatus = (string) $request->input('payment_status', 'all');
        $adminZoneId = auth('admin')->user()?->zone_id;
        $zoneId = $adminZoneId ?: ($request->integer('zone_id') ?: null);
        $categoryId = $request->integer('category_id') ?: null;
        $from = $request->date('from');
        $to = $request->date('to');
        $unassignedStatuses = [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING];
        $activeStatuses = [RideRequest::STATUS_RIDER_SELECTED, RideRequest::STATUS_CAPTAIN_ARRIVING, RideRequest::STATUS_ARRIVED, RideRequest::STATUS_IN_PROGRESS];

        $rides = $this->scopedQuery()
            ->with(['user', 'deliveryMan', 'category', 'rideVehicle'])
            ->when($status === 'unassigned', fn ($query) => $query->whereIn('status', $unassignedStatuses))
            ->when($status === 'active', fn ($query) => $query->whereIn('status', $activeStatuses))
            ->when(! in_array($status, ['all', 'unassigned', 'active'], true), fn ($query) => $query->where('status', $status))
            ->when($paymentStatus === 'due', fn ($query) => $query->whereIn('payment_status', ['unpaid', 'pending']))
            ->when(! in_array($paymentStatus, ['all', 'due'], true), fn ($query) => $query->where('payment_status', $paymentStatus))
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
            ->when($categoryId, fn ($query) => $query->where('ride_category_id', $categoryId))
            ->when($from, fn ($query) => $query->whereDate('created_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('created_at', '<=', $to))
            ->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested
                ->where('request_number', 'like', "%{$search}%")
                ->orWhere('pickup_address', 'like', "%{$search}%")
                ->orWhere('destination_address', 'like', "%{$search}%")
                ->orWhereHas('user', fn ($user) => $user
                    ->where('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"))
                ->orWhereHas('deliveryMan', fn ($captain) => $captain
                    ->where('f_name', 'like', "%{$search}%")
                    ->orWhere('l_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%"))))
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        $countQuery = $this->scopedQuery()->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId));
        $statusCounts = (clone $countQuery)->selectRaw('status, COUNT(*) as total')->groupBy('status')->pluck('total', 'status');
        $counts = [
            'all' => (clone $countQuery)->count(),
            'unassigned' => (clone $countQuery)->whereIn('status', [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING])->count(),
            'active' => (clone $countQuery)->whereIn('status', [RideRequest::STATUS_RIDER_SELECTED, RideRequest::STATUS_CAPTAIN_ARRIVING, RideRequest::STATUS_ARRIVED, RideRequest::STATUS_IN_PROGRESS])->count(),
            'completed' => (int) ($statusCounts[RideRequest::STATUS_COMPLETED] ?? 0),
            'cancelled' => (int) ($statusCounts[RideRequest::STATUS_CANCELLED] ?? 0),
        ];

        $zones = Zone::query()->where('status', 1)->when($adminZoneId, fn ($query) => $query->whereKey($adminZoneId))->orderBy('name')->get(['id', 'name']);
        $categories = RideCategory::query()->where('status', true)->orderBy('sort_order')->get(['id', 'name']);

        return view('admin-views.ride-hailing.rides.index', compact(
            'rides', 'search', 'status', 'paymentStatus', 'zoneId', 'categoryId',
            'from', 'to', 'zones', 'categories', 'adminZoneId', 'counts'
        ));
    }

    public function show(RideRequest $ride): View
    {
        $ride = $this->scopedQuery()->with([
            'user', 'deliveryMan', 'category', 'zone', 'rideVehicle.vehicleType',
            'offers.deliveryMan', 'offers.rideVehicle', 'statusHistories', 'payments',
        ])->findOrFail($ride->id);
        $eligibleCaptains = in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)
            ? $this->eligibilityService->eligibleCaptains($ride->zone_id, $ride->ride_category_id)
                ->load('activeRideVehicle')
            : collect();

        return view('admin-views.ride-hailing.rides.show', compact('ride', 'eligibleCaptains'));
    }

    public function assign(Request $request, RideRequest $ride): RedirectResponse
    {
        $validated = $request->validate([
            'delivery_man_id' => ['required', 'integer', 'exists:delivery_men,id'],
            'final_fare' => ['required', 'numeric', 'min:0'],
        ]);

        $ride = DB::transaction(function () use ($ride, $validated) {
            $ride = $this->scopedQuery()->lockForUpdate()->findOrFail($ride->id);
            if (! in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)) {
                throw ValidationException::withMessages(['delivery_man_id' => translate('messages.This ride already has a Captain or is no longer assignable.')]);
            }
            $captain = \App\Models\DeliveryMan::query()->withoutGlobalScopes()->findOrFail($validated['delivery_man_id']);
            $vehicle = $this->eligibilityService->vehicleFor($captain, $ride->ride_category_id, $ride->zone_id);
            if (! $vehicle) {
                throw ValidationException::withMessages(['delivery_man_id' => translate('messages.The selected Captain is no longer eligible for this ride.')]);
            }
            $fare = round((float) $validated['final_fare'], 2);
            if ($fare < $ride->minimum_negotiated_fare || $fare > $ride->maximum_negotiated_fare) {
                throw ValidationException::withMessages(['final_fare' => translate('messages.The fare must remain inside the configured negotiation range.')]);
            }

            RideOffer::query()->where('ride_request_id', $ride->id)->where('status', RideOffer::STATUS_PENDING)->update(['status' => RideOffer::STATUS_REJECTED]);
            $offer = RideOffer::query()->updateOrCreate(
                ['ride_request_id' => $ride->id, 'delivery_man_id' => $captain->id],
                ['ride_vehicle_id' => $vehicle->id, 'amount' => $fare, 'status' => RideOffer::STATUS_ACCEPTED, 'expires_at' => now()]
            );
            $fromStatus = $ride->status;
            $ride->update([
                'accepted_offer_id' => $offer->id,
                'delivery_man_id' => $captain->id,
                'ride_vehicle_id' => $vehicle->id,
                'status' => RideRequest::STATUS_RIDER_SELECTED,
                'selected_at' => now(),
                'trip_pin' => (string) random_int(1000, 9999),
                ...$this->fareCalculator->settlement($fare, $ride->platform_commission_percent),
            ]);
            $this->tripService->history(
                $ride, $fromStatus, RideRequest::STATUS_RIDER_SELECTED,
                'admin', (int) auth('admin')->id(), 'Captain assigned manually',
                ['accepted_offer_id' => $offer->id]
            );

            return $ride->fresh(['user', 'deliveryMan', 'rideVehicle', 'category']);
        });

        $this->notificationService->customer($ride, 'Captain assigned', 'A Captain has been assigned to your ride.');
        $this->notificationService->captain($ride, 'New ride assigned', 'Zaqoota assigned a passenger ride to you. Start travelling to pickup.');
        $this->realtimeService->status($ride);

        return redirect()->route('admin.ride-hailing.rides.show', $ride)->with('success', translate('messages.Captain assigned successfully.'));
    }

    private function scopedQuery(): Builder
    {
        $query = RideRequest::query();
        $adminZoneId = auth('admin')->user()?->zone_id;

        return $query->when($adminZoneId, fn ($builder) => $builder->where('zone_id', $adminZoneId));
    }
}
