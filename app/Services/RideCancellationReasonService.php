<?php

namespace App\Services;

use App\Models\RideCancellationReason;
use Illuminate\Support\Collection;

class RideCancellationReasonService
{
    public function available(string $actorType, string $rideStatus): Collection
    {
        $actorType = RideCancellationReason::canonicalActor($actorType);

        return RideCancellationReason::query()
            ->where('status', true)
            ->where('user_type', $actorType)
            ->whereJsonContains('ride_statuses', $rideStatus)
            ->orderBy('display_order')
            ->orderBy('id')
            ->get();
    }

    public function resolve(int $reasonId, string $actorType, string $rideStatus): ?RideCancellationReason
    {
        $reason = RideCancellationReason::query()->find($reasonId);

        return $reason?->appliesTo($actorType, $rideStatus) ? $reason : null;
    }

    public function data(RideCancellationReason $reason, bool $includeActor = false): array
    {
        return array_filter([
            'id' => (int) $reason->id,
            'code' => $reason->code,
            'title' => $reason->title,
            'user_type' => $includeActor ? $reason->user_type : null,
        ], fn ($value) => $value !== null);
    }
}
