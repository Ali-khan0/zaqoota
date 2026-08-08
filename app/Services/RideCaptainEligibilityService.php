<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\RideRequest;
use App\Models\RideVehicle;
use Illuminate\Support\Collection;

class RideCaptainEligibilityService
{
    public function eligibleCaptains(int $zoneId, int $categoryId, int $limit = 100): Collection
    {
        return DeliveryMan::query()->withoutGlobalScopes()
            ->where('application_status', 'approved')
            ->where('work_mode', 'ride')
            ->where('active', 1)
            ->where('zone_id', $zoneId)
            ->whereHas('rideVehicles', fn ($query) => $query
                ->where('ride_category_id', $categoryId)
                ->where('status', 'approved')
                ->where('is_active', true))
            ->limit(max(1, min($limit, 100)))
            ->get()
            ->filter(fn (DeliveryMan $captain) => $this->vehicleFor($captain, $categoryId, $zoneId) !== null)
            ->values();
    }

    public function captainByToken(string $token): ?DeliveryMan
    {
        return DeliveryMan::query()->withoutGlobalScopes()->where('auth_token', $token)->first();
    }

    public function vehicleFor(DeliveryMan $captain, int $categoryId, int $zoneId): ?RideVehicle
    {
        if ($captain->application_status !== 'approved'
            || $captain->work_mode !== 'ride'
            || (int) $captain->active !== 1
            || (int) $captain->zone_id !== $zoneId
            || $this->hasConflictingOrder($captain)
            || $this->hasActivePassengerRide($captain)) {
            return null;
        }

        return RideVehicle::query()
            ->where('delivery_man_id', $captain->id)
            ->where('ride_category_id', $categoryId)
            ->where('status', 'approved')
            ->where('is_active', true)
            ->first();
    }

    private function hasConflictingOrder(DeliveryMan $captain): bool
    {
        return Order::query()
            ->where('delivery_man_id', $captain->id)
            ->where(function ($query) {
                $query->whereNull('order_type')->orWhere('order_type', '!=', 'parcel');
            })
            ->whereIn('order_status', ['accepted', 'confirmed', 'pending', 'processing', 'picked_up', 'handover'])
            ->exists();
    }

    private function hasActivePassengerRide(DeliveryMan $captain): bool
    {
        return RideRequest::query()
            ->where('delivery_man_id', $captain->id)
            ->whereIn('status', [
                RideRequest::STATUS_RIDER_SELECTED,
                RideRequest::STATUS_CAPTAIN_ARRIVING,
                RideRequest::STATUS_ARRIVED,
                RideRequest::STATUS_IN_PROGRESS,
            ])
            ->exists();
    }
}
