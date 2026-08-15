<?php

namespace App\Services;

use App\Events\RideRealtimeEvent;
use App\Models\RideOffer;
use App\Models\RideRequest;
use Illuminate\Support\Collection;

class RideRealtimeService
{
    public function __construct(private readonly RideCaptainEligibilityService $eligibilityService) {}

    public function discovery(RideRequest $ride, ?Collection $captains = null): void
    {
        $channels = ($captains ?? $this->eligibilityService->eligibleCaptainsForRide($ride))
            ->map(fn ($captain) => "ride.captain.{$captain->id}")
            ->all();
        if ($channels === []) {
            return;
        }

        $this->send(
            $channels,
            'ride.request.created',
            ['ride' => $this->rideSummary($ride)],
        );
    }

    public function requestUpdated(RideRequest $ride, Collection $captains): void
    {
        $captainChannels = $captains->map(fn ($captain) => "ride.captain.{$captain->id}")->all();
        if ($captainChannels !== []) {
            $this->send($captainChannels, 'ride.request.updated', ['ride' => $this->rideSummary($ride)]);
        }
        $this->send(["ride.customer.{$ride->user_id}"], 'ride.status.updated', [
            'ride_id' => (int) $ride->id,
            'status' => $ride->status,
            'customer_offer' => (float) $ride->customer_offer,
            'updated_at' => $ride->updated_at?->toIso8601String(),
        ]);
    }

    public function offerRejected(RideOffer $offer): void
    {
        $ride = $offer->rideRequest;
        $this->send(["ride.customer.{$ride->user_id}", "ride.captain.{$offer->delivery_man_id}"], 'ride.offer.updated', [
            'ride_id' => (int) $ride->id,
            'status' => $ride->status,
            'offer' => [
                'id' => (int) $offer->id,
                'status' => $offer->status,
                'rejected_by' => $offer->rejected_by,
                'rejected_at' => $offer->rejected_at?->toIso8601String(),
            ],
        ]);
    }

    public function offer(RideOffer $offer): void
    {
        $ride = $offer->rideRequest;
        $this->send(
            ["ride.customer.{$ride->user_id}", "ride.trip.{$ride->id}"],
            'ride.offer.updated',
            [
                'ride_id' => (int) $ride->id,
                'status' => $ride->status,
                'offer' => [
                    'id' => (int) $offer->id,
                    'amount' => (float) $offer->amount,
                    'pickup_distance_meters' => $offer->pickup_distance_meters,
                    'pickup_eta_seconds' => $offer->pickup_eta_seconds,
                    'status' => $offer->status,
                    'expires_at' => $offer->expires_at?->toIso8601String(),
                    'captain_id' => (int) $offer->delivery_man_id,
                    'vehicle_id' => (int) $offer->ride_vehicle_id,
                ],
            ],
        );
    }

    public function status(RideRequest $ride): void
    {
        $channels = ["ride.customer.{$ride->user_id}", "ride.trip.{$ride->id}"];
        if ($ride->delivery_man_id) {
            $channels[] = "ride.captain.{$ride->delivery_man_id}";
        }
        $this->send($channels, 'ride.status.updated', [
            'ride_id' => (int) $ride->id,
            'request_number' => $ride->request_number,
            'status' => $ride->status,
            'payment_status' => $ride->payment_status,
            'updated_at' => $ride->updated_at?->toIso8601String(),
        ]);
    }

    public function location(RideRequest $ride): void
    {
        $this->send(["ride.trip.{$ride->id}"], 'ride.location.updated', self::locationPayload($ride));
    }

    public static function locationPayload(RideRequest $ride): array
    {
        return [
            'ride_id' => (int) $ride->id,
            'latitude' => (float) $ride->current_latitude,
            'longitude' => (float) $ride->current_longitude,
            'heading' => $ride->current_heading,
            'speed_mps' => $ride->current_speed_mps,
            'accuracy_meters' => $ride->current_accuracy_meters,
            'updated_at' => $ride->location_updated_at?->toIso8601String(),
        ];
    }

    public function payment(RideRequest $ride): void
    {
        $channels = ["ride.customer.{$ride->user_id}", "ride.trip.{$ride->id}"];
        if ($ride->delivery_man_id) {
            $channels[] = "ride.captain.{$ride->delivery_man_id}";
        }
        $this->send($channels, 'ride.payment.updated', [
            'ride_id' => (int) $ride->id,
            'payment_status' => $ride->payment_status,
            'payment_method' => $ride->payment_method,
            'final_payable_amount' => (float) $ride->final_payable_amount,
            'receipt_number' => $ride->receipt_number,
            'paid_at' => $ride->paid_at?->toIso8601String(),
        ]);
    }

    private function rideSummary(RideRequest $ride): array
    {
        return [
            'id' => (int) $ride->id,
            'request_number' => $ride->request_number,
            'status' => $ride->status,
            'zone_id' => (int) $ride->zone_id,
            'ride_category_id' => (int) $ride->ride_category_id,
            'pickup' => ['address' => $ride->pickup_address, 'latitude' => (float) $ride->pickup_latitude, 'longitude' => (float) $ride->pickup_longitude],
            'destination' => ['address' => $ride->destination_address, 'latitude' => (float) $ride->destination_latitude, 'longitude' => (float) $ride->destination_longitude],
            'distance_meters' => (int) $ride->distance_meters,
            'duration_seconds' => (int) $ride->duration_seconds,
            'suggested_fare' => (float) $ride->suggested_fare,
            'customer_offer' => (float) $ride->customer_offer,
            'minimum_negotiated_fare' => (float) $ride->minimum_negotiated_fare,
            'maximum_negotiated_fare' => (float) $ride->maximum_negotiated_fare,
            'offer_expiry_seconds' => (int) $ride->offer_expiry_seconds,
        ];
    }

    private function send(array $channels, string $event, array $payload): void
    {
        try {
            broadcast(new RideRealtimeEvent($channels, $event, $payload));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
