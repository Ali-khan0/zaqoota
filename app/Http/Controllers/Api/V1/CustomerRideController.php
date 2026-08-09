<?php

namespace App\Http\Controllers\Api\V1;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\RideCategory;
use App\Models\RideFare;
use App\Models\RideOffer;
use App\Models\RideRequest as PassengerRide;
use App\Models\User;
use App\Models\Zone;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideCouponService;
use App\Services\RideFareCalculator;
use App\Services\RideNotificationService;
use App\Services\RidePaymentService;
use App\Services\RideRealtimeService;
use App\Services\RideRouteService;
use App\Services\RideTripService;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use MatanYadaev\EloquentSpatial\Objects\Point;

class CustomerRideController extends Controller
{
    public function __construct(
        private readonly RideRouteService $routeService,
        private readonly RideFareCalculator $fareCalculator,
        private readonly RideCaptainEligibilityService $eligibilityService,
        private readonly RideTripService $tripService,
        private readonly RideNotificationService $notificationService,
        private readonly RidePaymentService $paymentService,
        private readonly RideRealtimeService $realtimeService,
        private readonly RideCouponService $couponService,
    ) {}

    public function validateCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string|max:100',
            'zone_id' => 'required|integer|exists:zones,id',
            'ride_category_id' => 'required|integer|exists:ride_categories,id',
            'fare' => 'required|numeric|min:0',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        try {
            $result = $this->couponService->validateCode($request->coupon_code, $request->user()->id, $request->integer('zone_id'), $request->integer('ride_category_id'), (float) $request->fare);
        } catch (\RuntimeException $exception) {
            return $this->error('coupon_code', $exception->getMessage());
        }

        return response()->json(['coupon' => [
            'code' => $result['coupon']->code,
            'title' => $result['coupon']->title,
            'discount_amount' => $result['discount_amount'],
            'fare_after_discount' => round(max(0, (float) $request->fare - $result['discount_amount']), 2),
        ]]);
    }

    public function estimate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ride_category_id' => 'required|integer|exists:ride_categories,id',
            'pickup_latitude' => 'required|numeric|between:-90,90',
            'pickup_longitude' => 'required|numeric|between:-180,180',
            'destination_latitude' => 'required|numeric|between:-90,90',
            'destination_longitude' => 'required|numeric|between:-180,180',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $category = RideCategory::query()->where('status', true)->find($request->integer('ride_category_id'));
        if (! $category) {
            return $this->error('ride_category_id', 'The selected ride category is unavailable.');
        }

        $rideModuleId = Module::query()->where('module_type', 'ride_hailing')->where('status', 1)->value('id');
        $zone = $rideModuleId ? Zone::query()
            ->where('status', 1)
            ->whereHas('modules', fn ($query) => $query->where('modules.id', $rideModuleId))
            ->whereContains('coordinates', new Point((float) $request->pickup_latitude, (float) $request->pickup_longitude, POINT_SRID))
            ->first() : null;
        if (! $zone) {
            return $this->error('pickup_location', 'Ride Hailing is not available at this pickup location.');
        }

        $fare = RideFare::query()
            ->where('zone_id', $zone->id)
            ->where('ride_category_id', $category->id)
            ->where('status', true)
            ->first();
        if (! $fare) {
            return $this->error('ride_category_id', 'Fare setup is unavailable for this zone and category.');
        }

        try {
            $route = $this->routeService->calculate(
                (float) $request->pickup_latitude,
                (float) $request->pickup_longitude,
                (float) $request->destination_latitude,
                (float) $request->destination_longitude,
            );
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json(['errors' => [['code' => 'route', 'message' => 'A driving route could not be calculated. Please try again.']]], 503);
        }

        $calculation = $this->fareCalculator->calculate($fare, $route['distance_meters'], $route['duration_seconds']);
        $previousCancellationDue = round((float) PassengerRide::query()
            ->where('user_id', $request->user()->id)->where('status', PassengerRide::STATUS_CANCELLED)
            ->whereNotNull('cancellation_compensation_paid_at')->whereNull('cancellation_recovered_at')
            ->sum('cancellation_charge_amount'), 2);
        $quote = [
            'user_id' => (int) $request->user()->id,
            'expires_at' => now()->addMinutes(5)->timestamp,
            'zone_id' => (int) $zone->id,
            'ride_category_id' => (int) $category->id,
            'ride_fare_id' => (int) $fare->id,
            'pickup_latitude' => (float) $request->pickup_latitude,
            'pickup_longitude' => (float) $request->pickup_longitude,
            'destination_latitude' => (float) $request->destination_latitude,
            'destination_longitude' => (float) $request->destination_longitude,
            ...$route,
            ...$calculation,
            'previous_cancellation_due_amount' => $previousCancellationDue,
            'estimated_total_with_previous_due' => round((float) $calculation['suggested_fare'] + $previousCancellationDue, 2),
            'minimum_fare' => (float) $fare->minimum_fare,
            'per_km_charge' => (float) $fare->per_km_charge,
            'per_minute_charge' => (float) $fare->per_minute_charge,
            'waiting_charge_per_minute' => (float) $fare->waiting_charge_per_minute,
            'free_waiting_minutes' => (int) $fare->free_waiting_minutes,
            'cancellation_charge' => (float) $fare->cancellation_charge,
            'platform_commission_percent' => (float) $fare->platform_commission_percent,
            'offer_expiry_seconds' => (int) $fare->offer_expiry_seconds,
        ];

        return response()->json([
            'quote_token' => Crypt::encryptString(json_encode($quote, JSON_THROW_ON_ERROR)),
            'quote_expires_at' => now()->addMinutes(5)->toIso8601String(),
            'zone' => ['id' => (int) $zone->id, 'name' => $zone->name],
            'category' => ['id' => (int) $category->id, 'name' => $category->name],
            'distance_meters' => $route['distance_meters'],
            'duration_seconds' => $route['duration_seconds'],
            'route_polyline' => $route['route_polyline'],
            ...$calculation,
            'free_waiting_minutes' => (int) $fare->free_waiting_minutes,
            'waiting_charge_per_minute' => (float) $fare->waiting_charge_per_minute,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'quote_token' => 'required|string',
            'pickup_address' => 'required|string|max:500',
            'destination_address' => 'required|string|max:500',
            'customer_offer' => 'required|numeric|min:0',
            'coupon_code' => 'nullable|string|max:100',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        try {
            $quote = json_decode(Crypt::decryptString($request->quote_token), true, 512, JSON_THROW_ON_ERROR);
        } catch (DecryptException|\JsonException) {
            return $this->error('quote_token', 'The fare quote is invalid. Please estimate again.');
        }
        if ((int) data_get($quote, 'user_id') !== (int) $request->user()->id || (int) data_get($quote, 'expires_at') < now()->timestamp) {
            return $this->error('quote_token', 'The fare quote has expired. Please estimate again.');
        }

        $customerOffer = round((float) $request->customer_offer, 2);
        if ($customerOffer < (float) $quote['minimum_negotiated_fare'] || $customerOffer > (float) $quote['maximum_negotiated_fare']) {
            return $this->error('customer_offer', 'The customer offer must be inside the allowed negotiation range.');
        }

        $coupon = null;
        if ($request->filled('coupon_code')) {
            try {
                $coupon = $this->couponService->validateCode($request->coupon_code, $request->user()->id, (int) $quote['zone_id'], (int) $quote['ride_category_id'], $customerOffer)['coupon'];
            } catch (\RuntimeException $exception) {
                return $this->error('coupon_code', $exception->getMessage());
            }
        }

        $ride = DB::transaction(function () use ($request, $quote, $customerOffer, $coupon) {
            User::query()->whereKey($request->user()->id)->lockForUpdate()->firstOrFail();
            $outstandingCancellations = PassengerRide::query()
                ->where('user_id', $request->user()->id)
                ->where('status', PassengerRide::STATUS_CANCELLED)
                ->where('cancellation_charge_amount', '>', 0)
                ->whereNotNull('cancellation_compensation_paid_at')
                ->whereNull('cancellation_recovered_at')
                ->whereNull('recovery_ride_id')
                ->lockForUpdate()
                ->oldest('id')
                ->get();
            $chargeableCancellationCount = PassengerRide::query()->where('user_id', $request->user()->id)
                ->where('status', PassengerRide::STATUS_CANCELLED)->where('cancellation_charge_amount', '>', 0)->count();
            if ($chargeableCancellationCount >= 2 && $outstandingCancellations->isNotEmpty()) {
                return ['cancellation_limit' => $outstandingCancellations];
            }
            if (PassengerRide::query()->where('user_id', $request->user()->id)->whereIn('status', PassengerRide::ACTIVE_CUSTOMER_STATUSES)->exists()) {
                return null;
            }
            $ride = PassengerRide::query()->create([
                'user_id' => $request->user()->id,
                'zone_id' => $quote['zone_id'],
                'ride_category_id' => $quote['ride_category_id'],
                'ride_fare_id' => $quote['ride_fare_id'],
                'ride_coupon_id' => $coupon?->id,
                'coupon_code' => $coupon?->code,
                'status' => PassengerRide::STATUS_SEARCHING,
                'pickup_address' => $request->pickup_address,
                'pickup_latitude' => $quote['pickup_latitude'],
                'pickup_longitude' => $quote['pickup_longitude'],
                'destination_address' => $request->destination_address,
                'destination_latitude' => $quote['destination_latitude'],
                'destination_longitude' => $quote['destination_longitude'],
                'distance_meters' => $quote['distance_meters'],
                'duration_seconds' => $quote['duration_seconds'],
                'route_polyline' => $quote['route_polyline'],
                'base_fare' => $quote['base_fare'],
                'minimum_fare' => $quote['minimum_fare'],
                'per_km_charge' => $quote['per_km_charge'],
                'per_minute_charge' => $quote['per_minute_charge'],
                'waiting_charge_per_minute' => $quote['waiting_charge_per_minute'],
                'free_waiting_minutes' => $quote['free_waiting_minutes'],
                'cancellation_charge' => $quote['cancellation_charge'],
                'platform_commission_percent' => $quote['platform_commission_percent'],
                'suggested_fare' => $quote['suggested_fare'],
                'minimum_negotiated_fare' => $quote['minimum_negotiated_fare'],
                'maximum_negotiated_fare' => $quote['maximum_negotiated_fare'],
                'customer_offer' => $customerOffer,
                'offer_expiry_seconds' => $quote['offer_expiry_seconds'],
                'carried_cancellation_due_amount' => round((float) $outstandingCancellations->sum('cancellation_charge_amount'), 2),
            ]);
            if ($outstandingCancellations->isNotEmpty()) {
                PassengerRide::query()->whereKey($outstandingCancellations->pluck('id'))->update(['recovery_ride_id' => $ride->id]);
            }
            $ride->update(['request_number' => 'ZQR-'.str_pad((string) $ride->id, 7, '0', STR_PAD_LEFT)]);
            $this->tripService->history($ride, null, PassengerRide::STATUS_SEARCHING, 'customer', $request->user()->id);

            return $ride->fresh(['category']);
        });

        if (is_array($ride) && isset($ride['cancellation_limit'])) {
            $dues = $ride['cancellation_limit'];

            return response()->json([
                'errors' => [['code' => 'ride_cancellation_limit', 'message' => 'You have reached the cancellation limit. Pay all cancellation dues online before requesting another Ride.']],
                'booking_blocked' => true,
                'online_payment_required' => true,
                'total_due' => round((float) $dues->sum('cancellation_charge_amount'), 2),
                'rides' => $dues->map(fn ($due) => ['id' => (int) $due->id, 'request_number' => $due->request_number, 'amount_due' => (float) $due->cancellation_charge_amount])->values(),
            ], 403);
        }

        if (! $ride) {
            return $this->error('ride', 'Complete or cancel your active ride request before creating another one.');
        }

        $this->realtimeService->discovery($ride);

        return response()->json(['message' => 'Ride request created.', 'ride' => $this->rideData($ride)], 201);
    }

    public function index(Request $request)
    {
        $rides = PassengerRide::query()->where('user_id', $request->user()->id)->with('category')->latest()->paginate(max(1, min($request->integer('limit', 20), 50)));
        $rides->getCollection()->transform(fn ($ride) => $this->rideData($ride));

        return response()->json($rides);
    }

    public function show(Request $request, int $rideId)
    {
        $ride = PassengerRide::query()->where('user_id', $request->user()->id)->with(['category', 'deliveryMan', 'rideVehicle', 'user'])->findOrFail($rideId);

        return response()->json(['ride' => $this->rideData($ride)]);
    }

    public function offers(Request $request, int $rideId)
    {
        $ride = PassengerRide::query()->where('user_id', $request->user()->id)->findOrFail($rideId);
        RideOffer::query()->where('ride_request_id', $ride->id)->where('status', RideOffer::STATUS_PENDING)->where('expires_at', '<=', now())->update(['status' => RideOffer::STATUS_EXPIRED]);
        $offers = $ride->offers()->where('status', RideOffer::STATUS_PENDING)->where('expires_at', '>', now())
            ->with(['deliveryMan.rating', 'rideVehicle.category'])
            ->orderByRaw('pickup_distance_meters IS NULL')->orderBy('pickup_distance_meters')->oldest('created_at')->get()->map(fn ($offer) => $this->offerData($offer));

        return response()->json(['offers' => $offers]);
    }

    public function updateCoupon(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), ['coupon_code' => 'nullable|string|max:100']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        try {
            $ride = DB::transaction(function () use ($request, $rideId) {
                $ride = PassengerRide::query()->where('user_id', $request->user()->id)->lockForUpdate()->findOrFail($rideId);
                if (! in_array($ride->status, [PassengerRide::STATUS_SEARCHING, PassengerRide::STATUS_NEGOTIATING], true)) {
                    throw new \RuntimeException('A Ride coupon can only be changed before a Captain is selected.');
                }
                if (! $request->filled('coupon_code')) {
                    $ride->update(['ride_coupon_id' => null, 'coupon_code' => null]);

                    return $ride->fresh(['category']);
                }
                $coupon = $this->couponService->validateCode(
                    $request->coupon_code,
                    $request->user()->id,
                    $ride->zone_id,
                    $ride->ride_category_id,
                    (float) $ride->customer_offer,
                    $ride->id,
                )['coupon'];
                $ride->update(['ride_coupon_id' => $coupon->id, 'coupon_code' => $coupon->code]);

                return $ride->fresh(['category']);
            });
        } catch (\RuntimeException $exception) {
            return $this->error('coupon_code', $exception->getMessage());
        }

        return response()->json(['message' => $ride->coupon_code ? 'Ride coupon updated.' : 'Ride coupon removed.', 'ride' => $this->rideData($ride)]);
    }

    public function acceptOffer(Request $request, int $rideId, int $offerId)
    {
        $result = DB::transaction(function () use ($request, $rideId, $offerId) {
            $ride = PassengerRide::query()->where('user_id', $request->user()->id)->lockForUpdate()->findOrFail($rideId);
            if (! in_array($ride->status, [PassengerRide::STATUS_SEARCHING, PassengerRide::STATUS_NEGOTIATING], true)) {
                return ['error' => 'This ride request is no longer accepting offers.'];
            }
            $offer = RideOffer::query()->where('ride_request_id', $ride->id)->lockForUpdate()->findOrFail($offerId);
            if ($offer->status !== RideOffer::STATUS_PENDING || $offer->expires_at->isPast()) {
                $offer->update(['status' => RideOffer::STATUS_EXPIRED]);

                return ['error' => 'This Captain offer has expired.'];
            }
            $captain = $offer->deliveryMan()->withoutGlobalScopes()->first();
            $vehicle = $captain ? $this->eligibilityService->vehicleFor($captain, $ride->ride_category_id, $ride->zone_id) : null;
            if (! $vehicle || $vehicle->id !== $offer->ride_vehicle_id) {
                return ['error' => 'This Captain is no longer available for the ride.'];
            }
            $settlement = $this->fareCalculator->settlement($offer->amount, $ride->platform_commission_percent);
            try {
                $coupon = $this->couponService->reserve($ride, (float) $offer->amount);
            } catch (\RuntimeException $exception) {
                return ['error' => $exception->getMessage(), 'error_code' => 'coupon_code'];
            }
            $fromStatus = $ride->status;
            $offer->update(['status' => RideOffer::STATUS_ACCEPTED]);
            RideOffer::query()->where('ride_request_id', $ride->id)->whereKeyNot($offer->id)->where('status', RideOffer::STATUS_PENDING)->update(['status' => RideOffer::STATUS_REJECTED]);
            $ride->update([
                'accepted_offer_id' => $offer->id,
                'delivery_man_id' => $captain->id,
                'ride_vehicle_id' => $vehicle->id,
                'status' => PassengerRide::STATUS_RIDER_SELECTED,
                'selected_at' => now(),
                'trip_pin' => (string) random_int(1000, 9999),
                ...$settlement,
                ...$coupon,
            ]);
            $this->tripService->history($ride, $fromStatus, PassengerRide::STATUS_RIDER_SELECTED, 'customer', $request->user()->id, null, ['accepted_offer_id' => $offer->id]);

            return ['ride' => $ride->fresh(['category', 'deliveryMan', 'rideVehicle'])];
        });

        if (isset($result['error'])) {
            return $this->error($result['error_code'] ?? 'offer', $result['error']);
        }

        $this->notificationService->event($result['ride'], 'offer_accepted');
        $this->realtimeService->status($result['ride']);

        return response()->json(['message' => 'Captain selected successfully.', 'ride' => $this->rideData($result['ride'])]);
    }

    public function cancel(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), ['reason' => 'nullable|string|max:500']);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $result = DB::transaction(function () use ($request, $rideId) {
            $ride = PassengerRide::query()->where('user_id', $request->user()->id)->lockForUpdate()->findOrFail($rideId);
            if (! $this->tripService->canCancel($ride->status)) {
                return null;
            }

            return $this->tripService->cancel($ride, 'customer', (int) $request->user()->id, $request->reason);
        });

        if (! $result) {
            return $this->error('ride', 'This ride can no longer be cancelled.');
        }

        if ($result->delivery_man_id) {
            $this->notificationService->event($result, $result->cancellation_charge_amount > 0 ? 'passenger_cancelled_with_charge' : 'passenger_cancelled_no_charge');
        }
        $this->realtimeService->status($result);

        return response()->json(['message' => 'Ride request cancelled.', 'ride' => $this->rideData($result)]);
    }

    public function paymentSummary(Request $request, int $rideId)
    {
        $ride = PassengerRide::query()->where('user_id', $request->user()->id)->with(['category', 'deliveryMan', 'rideVehicle', 'user'])->findOrFail($rideId);

        return response()->json(['payment' => $this->paymentSummaryData($ride)]);
    }

    public function paymentDue(Request $request)
    {
        $rides = PassengerRide::query()
            ->where('user_id', $request->user()->id)
            ->where('status', PassengerRide::STATUS_CANCELLED)
            ->where('cancellation_charge_amount', '>', 0)
            ->whereNotNull('cancellation_compensation_paid_at')
            ->whereNull('cancellation_recovered_at')
            ->oldest('id')
            ->get();
        $chargeableCancellationCount = PassengerRide::query()->where('user_id', $request->user()->id)
            ->where('status', PassengerRide::STATUS_CANCELLED)->where('cancellation_charge_amount', '>', 0)->count();
        $bookingBlocked = $chargeableCancellationCount >= 2 && $rides->isNotEmpty();

        return response()->json([
            'total_due' => round((float) $rides->sum(fn ($ride) => max(0, (float) $ride->final_payable_amount - (float) $ride->wallet_paid_amount)), 2),
            'chargeable_cancellation_count' => $chargeableCancellationCount,
            'booking_blocked' => $bookingBlocked,
            'online_payment_required' => $bookingBlocked,
            'rides' => $rides->map(fn ($ride) => [
                'id' => (int) $ride->id,
                'request_number' => $ride->request_number,
                'cancellation_charge' => (float) $ride->cancellation_charge_amount,
                'wallet_paid_amount' => (float) $ride->wallet_paid_amount,
                'amount_due' => round(max(0, (float) $ride->final_payable_amount - (float) $ride->wallet_paid_amount), 2),
                'recovery_ride_id' => $ride->recovery_ride_id,
                'recovery_method' => $bookingBlocked ? 'online_payment' : 'next_ride',
                'payment_status' => $ride->payment_status,
                'cancelled_at' => $ride->cancelled_at?->toIso8601String(),
            ])->values(),
        ]);
    }

    public function createPayment(Request $request, int $rideId)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|in:cash,digital,wallet',
            'use_wallet' => 'sometimes|boolean',
            'payment_gateway' => 'required_if:payment_method,digital|nullable|string|max:80',
            'callback_url' => 'required_if:payment_method,digital|nullable|url|max:1000',
            'payment_platform' => 'required_if:payment_method,digital|nullable|in:app,web',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $ride = PassengerRide::query()->where('user_id', $request->user()->id)->with('user')->findOrFail($rideId);
        try {
            if ($ride->status === PassengerRide::STATUS_CANCELLED) {
                if (! $ride->cancellation_compensation_paid_at || $ride->cancellation_recovered_at) {
                    return $this->error('payment', 'This cancellation charge is not payable.');
                }
                if ($request->payment_method !== 'digital' || $request->boolean('use_wallet')) {
                    return $this->error('payment_method', 'Cancellation-limit dues must be paid using an online payment gateway.');
                }
                $result = $this->paymentService->createDigitalAttempt($ride, $request->payment_gateway, $request->callback_url, $request->payment_platform, false);

                return response()->json(['message' => 'Cancellation due payment link created.', 'redirect_link' => $result['redirect_link'], 'payment' => $this->paymentData($result['payment'])], 201);
            }
            $this->couponService->assertPaymentMethod($ride, $request->payment_method, $request->boolean('use_wallet'));
            if ($request->payment_method === 'wallet') {
                $payment = $this->paymentService->createWalletAttempt($ride);

                return response()->json([
                    'message' => 'Ride payment completed from the customer wallet.',
                    'payment' => $this->paymentData($payment),
                    'payment_summary' => $this->paymentSummaryData($ride->fresh('user')),
                ], 201);
            }

            if ($request->payment_method === 'cash') {
                $result = $this->paymentService->createCashAttempt($ride, $request->boolean('use_wallet'));

                return response()->json([
                    'message' => $result['remaining_amount'] > 0
                        ? 'Cash payment selected. The Captain must confirm collection.'
                        : 'Ride payment completed from the customer wallet.',
                    'wallet_amount' => $result['wallet_amount'],
                    'remaining_amount' => $result['remaining_amount'],
                    'payment' => $this->paymentData($result['payment']->fresh()),
                ], 201);
            }

            $result = $this->paymentService->createDigitalAttempt($ride, $request->payment_gateway, $request->callback_url, $request->payment_platform, $request->boolean('use_wallet'));

            return response()->json([
                'message' => $result['redirect_link'] ? 'Payment link created.' : 'Ride payment completed from the customer wallet.',
                'redirect_link' => $result['redirect_link'],
                'wallet_amount' => $result['wallet_amount'],
                'remaining_amount' => $result['remaining_amount'],
                'payment' => $this->paymentData($result['payment']),
            ], 201);
        } catch (\RuntimeException $exception) {
            return $this->error('payment', $exception->getMessage());
        }
    }

    public function payments(Request $request, int $rideId)
    {
        $ride = PassengerRide::query()->where('user_id', $request->user()->id)->findOrFail($rideId);
        $payments = $ride->payments()->latest()->paginate(max(1, min($request->integer('limit', 20), 50)));
        $payments->getCollection()->transform(fn ($payment) => $this->paymentData($payment));

        return response()->json($payments);
    }

    public function receipt(Request $request, int $rideId)
    {
        $ride = PassengerRide::query()->where('user_id', $request->user()->id)
            ->with(['category', 'deliveryMan', 'rideVehicle'])->findOrFail($rideId);
        if (! in_array($ride->payment_status, ['paid', 'recovered'], true)) {
            return $this->error('payment', 'A receipt is available only after payment.');
        }

        return response()->json(['receipt' => [
            'receipt_number' => $ride->receipt_number,
            'ride_request_number' => $ride->request_number,
            'paid_at' => $ride->paid_at?->toIso8601String(),
            'payment_method' => $ride->payment_method,
            'payment_gateway' => $ride->payment_gateway,
            'transaction_reference' => $ride->payment_transaction_reference,
            'accepted_fare' => (float) $ride->final_accepted_fare,
            'waiting_charge' => (float) $ride->waiting_charge_amount,
            'cancellation_charge' => (float) $ride->cancellation_charge_amount,
            'previous_cancellation_due' => (float) $ride->carried_cancellation_due_amount,
            'coupon_discount' => (float) $ride->coupon_discount_amount,
            'wallet_paid_amount' => (float) $ride->wallet_paid_amount,
            'total_paid' => (float) $ride->final_payable_amount,
            'category' => $ride->category?->name,
            'pickup_address' => $ride->pickup_address,
            'destination_address' => $ride->destination_address,
            'captain_name' => $ride->deliveryMan?->full_name,
            'vehicle' => $ride->rideVehicle ? trim("{$ride->rideVehicle->make} {$ride->rideVehicle->model} {$ride->rideVehicle->registration_number}") : null,
        ]]);
    }

    private function rideData(PassengerRide $ride): array
    {
        return [
            'id' => (int) $ride->id, 'request_number' => $ride->request_number, 'status' => $ride->status,
            'category' => $ride->category ? ['id' => (int) $ride->category->id, 'name' => $ride->category->name] : null,
            'pickup' => ['address' => $ride->pickup_address, 'latitude' => (float) $ride->pickup_latitude, 'longitude' => (float) $ride->pickup_longitude],
            'destination' => ['address' => $ride->destination_address, 'latitude' => (float) $ride->destination_latitude, 'longitude' => (float) $ride->destination_longitude],
            'distance_meters' => (int) $ride->distance_meters, 'duration_seconds' => (int) $ride->duration_seconds,
            'suggested_fare' => (float) $ride->suggested_fare, 'customer_offer' => (float) $ride->customer_offer,
            'minimum_negotiated_fare' => (float) $ride->minimum_negotiated_fare, 'maximum_negotiated_fare' => (float) $ride->maximum_negotiated_fare,
            'final_accepted_fare' => $ride->final_accepted_fare,
            'coupon' => $ride->ride_coupon_id ? ['code' => $ride->coupon_code, 'discount_amount' => (float) $ride->coupon_discount_amount] : null,
            'trip_pin' => in_array($ride->status, [PassengerRide::STATUS_RIDER_SELECTED, PassengerRide::STATUS_CAPTAIN_ARRIVING, PassengerRide::STATUS_ARRIVED], true) ? $ride->trip_pin : null,
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
            'receipt_number' => $ride->receipt_number,
            'captain_location' => $ride->location_updated_at ? ['latitude' => (float) $ride->current_latitude, 'longitude' => (float) $ride->current_longitude, 'updated_at' => $ride->location_updated_at->toIso8601String()] : null,
            'captain' => $ride->deliveryMan ? ['id' => (int) $ride->deliveryMan->id, 'name' => $ride->deliveryMan->full_name, 'phone' => $ride->deliveryMan->phone] : null,
            'vehicle' => $ride->rideVehicle ? ['id' => (int) $ride->rideVehicle->id, 'make' => $ride->rideVehicle->make, 'model' => $ride->rideVehicle->model, 'color' => $ride->rideVehicle->color, 'registration_number' => $ride->rideVehicle->registration_number] : null,
            'created_at' => $ride->created_at?->toIso8601String(),
            'captain_arriving_at' => $ride->captain_arriving_at?->toIso8601String(),
            'arrived_at' => $ride->arrived_at?->toIso8601String(),
            'trip_started_at' => $ride->trip_started_at?->toIso8601String(),
            'completed_at' => $ride->completed_at?->toIso8601String(),
            'cancelled_at' => $ride->cancelled_at?->toIso8601String(),
        ];
    }

    private function offerData(RideOffer $offer): array
    {
        $rating = $offer->deliveryMan?->rating?->first();

        return [
            'id' => (int) $offer->id, 'amount' => (float) $offer->amount, 'expires_at' => $offer->expires_at->toIso8601String(),
            'pickup_distance_meters' => $offer->pickup_distance_meters,
            'pickup_eta_seconds' => $offer->pickup_eta_seconds,
            'captain' => ['id' => (int) $offer->delivery_man_id, 'name' => $offer->deliveryMan?->full_name, 'rating' => (float) ($rating?->average ?? 0), 'rating_count' => (int) ($rating?->rating_count ?? 0)],
            'vehicle' => ['id' => (int) $offer->ride_vehicle_id, 'make' => $offer->rideVehicle?->make, 'model' => $offer->rideVehicle?->model, 'color' => $offer->rideVehicle?->color, 'registration_number' => $offer->rideVehicle?->registration_number],
        ];
    }

    private function paymentSummaryData(PassengerRide $ride): array
    {
        return [
            'status' => $ride->payment_status,
            'method' => $ride->payment_method,
            'gateway' => $ride->payment_gateway,
            'accepted_fare' => (float) $ride->final_accepted_fare,
            'waiting_charge' => (float) $ride->waiting_charge_amount,
            'cancellation_charge' => (float) $ride->cancellation_charge_amount,
            'previous_cancellation_due' => (float) $ride->carried_cancellation_due_amount,
            'coupon_discount' => (float) $ride->coupon_discount_amount,
            'final_payable_amount' => (float) $ride->final_payable_amount,
            'wallet_paid_amount' => (float) $ride->wallet_paid_amount,
            'remaining_amount' => $ride->payment_status === 'paid' ? 0.0 : round(max(0, (float) $ride->final_payable_amount - (float) $ride->wallet_paid_amount), 2),
            'customer_wallet_balance' => (float) $ride->user?->wallet_balance,
            'wallet_enabled' => (int) \App\Models\BusinessSetting::query()->where('key', 'wallet_status')->value('value') === 1,
            'partial_payment_enabled' => (int) \App\Models\BusinessSetting::query()->where('key', 'partial_payment_status')->value('value') === 1,
            'partial_payment_method' => (string) \App\Models\BusinessSetting::query()->where('key', 'partial_payment_method')->value('value'),
            'paid_at' => $ride->paid_at?->toIso8601String(),
            'receipt_number' => $ride->receipt_number,
        ];
    }

    private function paymentData(\App\Models\RidePayment $payment): array
    {
        return [
            'id' => (int) $payment->id,
            'amount' => (float) $payment->amount,
            'payment_method' => $payment->payment_method,
            'payment_gateway' => $payment->payment_gateway,
            'status' => $payment->status,
            'transaction_reference' => $payment->transaction_reference,
            'created_at' => $payment->created_at?->toIso8601String(),
            'paid_at' => $payment->paid_at?->toIso8601String(),
        ];
    }

    private function error(string $code, string $message)
    {
        return response()->json(['errors' => [['code' => $code, 'message' => $message]]], 403);
    }
}
