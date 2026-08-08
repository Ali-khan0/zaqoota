<?php

namespace App\Services;

use App\Models\RideRequest;

class RideTripStateMachine
{
    private const CAPTAIN_TRANSITIONS = [
        RideRequest::STATUS_RIDER_SELECTED => RideRequest::STATUS_CAPTAIN_ARRIVING,
        RideRequest::STATUS_CAPTAIN_ARRIVING => RideRequest::STATUS_ARRIVED,
        RideRequest::STATUS_ARRIVED => RideRequest::STATUS_IN_PROGRESS,
        RideRequest::STATUS_IN_PROGRESS => RideRequest::STATUS_COMPLETED,
    ];

    public function nextCaptainStatus(string $currentStatus): ?string
    {
        return self::CAPTAIN_TRANSITIONS[$currentStatus] ?? null;
    }

    public function actionFor(string $currentStatus): ?string
    {
        return match ($currentStatus) {
            RideRequest::STATUS_RIDER_SELECTED => 'start_pickup',
            RideRequest::STATUS_CAPTAIN_ARRIVING => 'arrived',
            RideRequest::STATUS_ARRIVED => 'start_trip',
            RideRequest::STATUS_IN_PROGRESS => 'complete',
            default => null,
        };
    }

    public function canCancel(string $status): bool
    {
        return in_array($status, [
            RideRequest::STATUS_SEARCHING,
            RideRequest::STATUS_NEGOTIATING,
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
        ], true);
    }
}
