<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Jobs\ExpireRideOffer;
use App\Models\RideOffer;
use App\Models\RideRequest;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideNotificationService;
use App\Services\RidePaymentService;
use App\Services\RideRealtimeService;
use App\Services\RideTripService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CaptainRideController extends Controller
{
    public function __construct(
        private readonly RideCaptainEligibilityService $eligibilityService,
        private readonly RideTripService $tripService,
        private readonly RideNotificationService $notificationService,
        private readonly RidePaymentService $paymentService,
        private readonly RideRealtimeService $realtimeService,
    ) {}

    public function availableRequests(Request $request)
    {
        $captain = $this->eligibilityService->captainByToken($request->token);
        $vehicle = $captain?->activeRideVehicle()->first();
        if (! $captain || ! $vehicle || ! $this->eligibilityService->vehicleFor($captain, $vehicle->ride_category_id, $captain->zone_id)) {
            return $this->error('captain', 'Captain is not currently eligible to receive passenger rides.');
        }

        $location = $captain->last_location()->first();
        if (! $location || ! is_numeric($location->latitude) || ! is_numeric($location->longitude)) {
            return $this->error('location', 'Update your current location before searching for passenger rides.');
        }
        $latitude = (float) $location->latitude;
        $longitude = (float) $location->longitude;
        $earthRadius = 6371000;
        $distanceSql = "$earthRadius * 2 * ASIN(SQRT(POWER(SIN(RADIANS(pickup_latitude - ?) / 2), 2) + COS(RADIANS(?)) * COS(RADIANS(pickup_latitude)) * POWER(SIN(RADIANS(pickup_longitude - ?) / 2), 2)))";
        $distanceBindings = [$latitude, $latitude, $longitude];

        $rides = RideRequest::query()
            ->select('ride_requests.*')->selectRaw("$distanceSql AS pickup_distance_meters", $distanceBindings)
            ->with('category')
            ->where('zone_id', $captain->zone_id)
            ->where('ride_category_id', $vehicle->ride_category_id)
            ->whereIn('status', [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING])
            ->whereDoesntHave('offers', fn ($query) => $query
                ->where('delivery_man_id', $captain->id)
                ->where(fn ($offer) => $offer
                    ->where('rejected_by', 'customer')
                    ->orWhere(fn ($active) => $active
                        ->whereIn('status', [RideOffer::STATUS_PENDING, RideOffer::STATUS_ACCEPTED])
                        ->where('expires_at', '>', now()))))
            ->whereRaw("$distanceSql <= ?", [...$distanceBindings, $this->eligibilityService->maximumPickupRadiusMeters()])
            ->orderBy('pickup_distance_meters')->oldest('created_at')->paginate(max(1, min($request->integer('limit', 20), 50)));
        $rides->getCollection()->transform(fn ($ride) => $this->requestData($ride));

        return response()->json($rides);
    }

    public function storeOffer(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), ['amount' => 'required|numeric|min:0']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $captain = $this->eligibilityService->captainByToken($request->token);
        if (! $captain) {
            return $this->error('captain', 'Captain account was not found.');
        }

        $result = DB::transaction(function () use ($captain, $rideId, $request) {
            $ride = RideRequest::query()->lockForUpdate()->findOrFail($rideId);
            if (! in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)) {
                return ['error' => 'This ride request is no longer accepting offers.'];
            }
            $vehicle = $this->eligibilityService->vehicleFor($captain, $ride->ride_category_id, $ride->zone_id);
            $pickupMetrics = $this->eligibilityService->pickupMetrics($captain, $ride);
            if (! $vehicle || ! $pickupMetrics || $pickupMetrics['distance_meters'] > $this->eligibilityService->maximumPickupRadiusMeters()) {
                return ['error' => 'Captain is not eligible for this ride request.'];
            }
            $amount = round((float) $request->amount, 2);
            if ($amount < $ride->minimum_negotiated_fare || $amount > $ride->maximum_negotiated_fare) {
                return ['error' => 'The offer must be inside the allowed negotiation range.'];
            }
            $existing = RideOffer::query()->where('ride_request_id', $ride->id)->where('delivery_man_id', $captain->id)->lockForUpdate()->first();
            if ($existing && $existing->status === RideOffer::STATUS_ACCEPTED) {
                return ['error' => 'This offer has already been accepted.'];
            }
            if ($existing && $existing->status === RideOffer::STATUS_REJECTED && $existing->rejected_by === 'customer') {
                return ['error' => 'The passenger rejected your offer for this Ride. You cannot submit another offer.'];
            }
            $offer = RideOffer::query()->updateOrCreate(
                ['ride_request_id' => $ride->id, 'delivery_man_id' => $captain->id],
                ['ride_vehicle_id' => $vehicle->id, 'amount' => $amount,
                    'pickup_distance_meters' => $pickupMetrics['distance_meters'], 'pickup_eta_seconds' => $pickupMetrics['eta_seconds'],
                    'status' => RideOffer::STATUS_PENDING, 'expires_at' => now()->addSeconds($ride->offer_expiry_seconds)]
            );
            if ($ride->status === RideRequest::STATUS_SEARCHING) {
                $ride->update(['status' => RideRequest::STATUS_NEGOTIATING]);
            }

            return ['offer' => $offer];
        });

        if (isset($result['error'])) {
            return $this->error('offer', $result['error']);
        }

        $this->realtimeService->offer($result['offer']->load('rideRequest'));
        if (config('queue.default') !== 'sync') {
            ExpireRideOffer::dispatch($result['offer']->id)->delay($result['offer']->expires_at);
        }

        return response()->json(['message' => 'Offer submitted.', 'offer' => $this->offerData($result['offer'])], 201);
    }

    public function offers(Request $request)
    {
        $captain = $this->eligibilityService->captainByToken($request->token);
        RideOffer::query()->where('delivery_man_id', $captain->id)->where('status', RideOffer::STATUS_PENDING)->where('expires_at', '<=', now())->update(['status' => RideOffer::STATUS_EXPIRED]);
        $offers = RideOffer::query()->where('delivery_man_id', $captain->id)->with('rideRequest.category')->latest()->paginate(max(1, min($request->integer('limit', 20), 50)));
        $offers->getCollection()->transform(fn ($offer) => [
            ...$this->offerData($offer),
            'ride' => $offer->rideRequest ? $this->requestData($offer->rideRequest) : null,
        ]);

        return response()->json($offers);
    }

    public function currentRide(Request $request)
    {
        $captain = $this->eligibilityService->captainByToken($request->token);
        $ride = RideRequest::query()->where('delivery_man_id', $captain->id)
            ->whereIn('status', [
                RideRequest::STATUS_RIDER_SELECTED,
                RideRequest::STATUS_CAPTAIN_ARRIVING,
                RideRequest::STATUS_ARRIVED,
                RideRequest::STATUS_IN_PROGRESS,
            ])->with(['category', 'user', 'rideVehicle'])->latest('selected_at')->first();

        return response()->json(['ride' => $ride ? $this->tripData($ride) : null]);
    }

    public function showRide(Request $request, int $rideId)
    {
        $captain = $this->eligibilityService->captainByToken($request->token);
        $ride = RideRequest::query()->where('delivery_man_id', $captain->id)->with(['category', 'user', 'rideVehicle'])->findOrFail($rideId);

        return response()->json(['ride' => $this->tripData($ride)]);
    }

    public function transition(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:start_pickup,arrived,start_trip,complete',
            'trip_pin' => 'required_if:action,start_trip|nullable|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $captain = $this->eligibilityService->captainByToken($request->token);
        $result = $this->tripService->transition($captain, $rideId, $request->action, $request->trip_pin);
        if (isset($result['error'])) {
            return $this->error('ride', $result['error']);
        }

        $messages = [
            RideRequest::STATUS_CAPTAIN_ARRIVING => ['Captain is on the way', 'captain_arriving'],
            RideRequest::STATUS_ARRIVED => ['Captain has arrived', 'captain_arrived'],
            RideRequest::STATUS_IN_PROGRESS => ['Ride started', 'ride_started'],
            RideRequest::STATUS_COMPLETED => ['Ride completed', 'ride_completed'],
        ];
        [$title, $event] = $messages[$result['ride']->status];
        $this->notificationService->event($result['ride'], $event);
        $this->realtimeService->status($result['ride']);

        return response()->json(['message' => $title.'.', 'ride' => $this->tripData($result['ride'])]);
    }

    public function updateLocation(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $captain = $this->eligibilityService->captainByToken($request->token);
        $ride = $this->tripService->updateLocation($captain, $rideId, (float) $request->latitude, (float) $request->longitude);
        if (! $ride) {
            return $this->error('ride', 'Location can only be updated for an active assigned ride.');
        }
        $this->realtimeService->location($ride);

        return response()->json(['message' => 'Ride location updated.', 'location_updated_at' => $ride->location_updated_at?->toIso8601String()]);
    }

    public function cancelRide(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), ['reason' => 'required|string|max:500']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $captain = $this->eligibilityService->captainByToken($request->token);
        $ride = DB::transaction(function () use ($captain, $rideId, $request) {
            $ride = RideRequest::query()->where('delivery_man_id', $captain->id)->lockForUpdate()->findOrFail($rideId);
            if (! $this->tripService->canCancel($ride->status)) {
                return null;
            }

            return $this->tripService->cancel($ride, 'captain', $captain->id, $request->reason);
        });
        if (! $ride) {
            return $this->error('ride', 'An in-progress or completed ride cannot be cancelled.');
        }

        $this->notificationService->event($ride, 'captain_cancelled');
        $this->realtimeService->status($ride);

        return response()->json(['message' => 'Ride cancelled.', 'ride' => $this->tripData($ride)]);
    }

    public function confirmCashPayment(Request $request, int $rideId)
    {
        $captain = $this->eligibilityService->captainByToken($request->token);
        $ride = RideRequest::query()->where('delivery_man_id', $captain->id)->with(['user', 'deliveryMan', 'rideVehicle', 'category'])->findOrFail($rideId);
        $payment = $ride->payments()->where('payment_method', 'cash')->where('status', \App\Models\RidePayment::STATUS_PENDING)->latest()->first();
        if (! $payment) {
            return $this->error('payment', 'No pending cash payment exists for this ride.');
        }

        try {
            $ride = $this->paymentService->settle($payment->id);
        } catch (\RuntimeException $exception) {
            return $this->error('payment', $exception->getMessage());
        }

        return response()->json(['message' => 'Cash payment confirmed.', 'ride' => $this->tripData($ride)]);
    }

    private function requestData(RideRequest $ride): array
    {
        $pickupDistance = is_numeric($ride->getAttribute('pickup_distance_meters')) ? (int) round($ride->getAttribute('pickup_distance_meters')) : null;
        $pickupEta = $pickupDistance === null ? null : (int) ceil($pickupDistance / ($this->eligibilityService->pickupEtaSpeedKmh() * 1000 / 3600));

        return [
            'id' => (int) $ride->id, 'request_number' => $ride->request_number, 'status' => $ride->status,
            'category' => $ride->category ? ['id' => (int) $ride->category->id, 'name' => $ride->category->name] : null,
            'pickup' => ['address' => $ride->pickup_address, 'latitude' => (float) $ride->pickup_latitude, 'longitude' => (float) $ride->pickup_longitude],
            'destination' => ['address' => $ride->destination_address, 'latitude' => (float) $ride->destination_latitude, 'longitude' => (float) $ride->destination_longitude],
            'distance_meters' => (int) $ride->distance_meters, 'duration_seconds' => (int) $ride->duration_seconds,
            'suggested_fare' => (float) $ride->suggested_fare, 'customer_offer' => (float) $ride->customer_offer,
            'minimum_negotiated_fare' => (float) $ride->minimum_negotiated_fare, 'maximum_negotiated_fare' => (float) $ride->maximum_negotiated_fare,
            'offer_expiry_seconds' => (int) $ride->offer_expiry_seconds,
            'pickup_distance_meters' => $pickupDistance,
            'pickup_eta_seconds' => $pickupEta,
        ];
    }

    private function tripData(RideRequest $ride): array
    {
        return [
            ...$this->requestData($ride),
            'final_accepted_fare' => (float) $ride->final_accepted_fare,
            'coupon_discount_amount' => (float) $ride->coupon_discount_amount,
            'free_waiting_minutes' => (int) $ride->free_waiting_minutes,
            'charged_waiting_minutes' => (int) $ride->charged_waiting_minutes,
            'waiting_charge_amount' => (float) $ride->waiting_charge_amount,
            'cancellation_charge_amount' => (float) $ride->cancellation_charge_amount,
            'previous_cancellation_due_amount' => (float) $ride->carried_cancellation_due_amount,
            'cancelled_by' => $ride->cancelled_by,
            'cancellation_reason' => $ride->cancellation_reason,
            'payment_status' => $ride->payment_status,
            'payment_method' => $ride->payment_method,
            'final_payable_amount' => $ride->final_payable_amount,
            'wallet_paid_amount' => (float) $ride->wallet_paid_amount,
            'remaining_payment_amount' => $ride->payment_status === 'paid' ? 0.0 : round(max(0, (float) $ride->final_payable_amount - (float) $ride->wallet_paid_amount), 2),
            'captain_total_earning_amount' => $ride->captain_total_earning_amount,
            'receipt_number' => $ride->receipt_number,
            'next_action' => app(\App\Services\RideTripStateMachine::class)->actionFor($ride->status),
            'customer' => $ride->user ? ['id' => (int) $ride->user->id, 'name' => trim($ride->user->f_name.' '.$ride->user->l_name), 'phone' => $ride->user->phone] : null,
            'vehicle' => $ride->rideVehicle ? ['id' => (int) $ride->rideVehicle->id, 'make' => $ride->rideVehicle->make, 'model' => $ride->rideVehicle->model, 'color' => $ride->rideVehicle->color, 'registration_number' => $ride->rideVehicle->registration_number] : null,
            'captain_arriving_at' => $ride->captain_arriving_at?->toIso8601String(),
            'arrived_at' => $ride->arrived_at?->toIso8601String(),
            'trip_started_at' => $ride->trip_started_at?->toIso8601String(),
            'completed_at' => $ride->completed_at?->toIso8601String(),
            'cancelled_at' => $ride->cancelled_at?->toIso8601String(),
        ];
    }

    private function offerData(RideOffer $offer): array
    {
        return ['id' => (int) $offer->id, 'ride_request_id' => (int) $offer->ride_request_id, 'amount' => (float) $offer->amount,
            'pickup_distance_meters' => $offer->pickup_distance_meters, 'pickup_eta_seconds' => $offer->pickup_eta_seconds,
            'status' => $offer->status, 'expires_at' => $offer->expires_at->toIso8601String(),
            'rejected_by' => $offer->rejected_by, 'rejected_at' => $offer->rejected_at?->toIso8601String()];
    }

    private function error(string $code, string $message)
    {
        return response()->json(['errors' => [['code' => $code, 'message' => $message]]], 403);
    }
}
