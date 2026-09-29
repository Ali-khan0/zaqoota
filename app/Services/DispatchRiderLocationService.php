<?php

namespace App\Services;

use App\Events\DispatchRiderLocationUpdated;
use App\Models\BusinessSetting;
use App\Models\DeliveryMan;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Cache;

class DispatchRiderLocationService
{
    public function snapshot(?int $zoneId = null): array
    {
        $generatedAt = now();
        $freshnessSeconds = $this->freshnessSeconds();
        $cutoff = $generatedAt->copy()->subSeconds($freshnessSeconds);

        $riders = DeliveryMan::query()
            ->with(['last_location', 'storage'])
            ->where('type', 'zone_wise')
            ->where('status', 1)
            ->where('active', 1)
            ->where('application_status', 'approved')
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
            ->whereHas('last_location', fn ($query) => $query->where('time', '>=', $cutoff))
            ->get()
            ->map(fn (DeliveryMan $rider) => $this->marker($rider, $generatedAt, $freshnessSeconds))
            ->filter()
            ->values();

        return [
            'generated_at' => $generatedAt->toIso8601String(),
            'stale_after_seconds' => $freshnessSeconds,
            'riders' => $riders,
        ];
    }

    public function broadcast(int $deliveryManId, ?int $previousZoneId = null): void
    {
        $rider = DeliveryMan::query()
            ->with(['last_location', 'storage'])
            ->find($deliveryManId);
        if (! $rider) {
            return;
        }

        $generatedAt = now();
        $freshnessSeconds = $this->freshnessSeconds();
        $payload = $this->marker($rider, $generatedAt, $freshnessSeconds) ?? [
            'id' => (int) $rider->id,
            'zone_id' => $rider->zone_id ? (int) $rider->zone_id : null,
            'visible' => false,
            'updated_at' => $generatedAt->toIso8601String(),
            'stale_at' => $generatedAt->toIso8601String(),
        ];

        $channels = ['admin.dispatch.location.all'];
        if ($rider->zone_id) {
            $channels[] = 'admin.dispatch.location.zone.'.(int) $rider->zone_id;
        }
        if ($previousZoneId && (int) $previousZoneId !== (int) $rider->zone_id) {
            $channels[] = 'admin.dispatch.location.zone.'.(int) $previousZoneId;
        }

        broadcast(new DispatchRiderLocationUpdated($channels, $payload));
    }

    public function rider(int $deliveryManId, ?int $zoneId = null): ?array
    {
        $rider = DeliveryMan::query()
            ->with(['last_location', 'storage'])
            ->when($zoneId, fn ($query) => $query->where('zone_id', $zoneId))
            ->find($deliveryManId);

        return $rider
            ? $this->marker($rider, now(), $this->freshnessSeconds())
            : null;
    }

    public function freshnessSeconds(): int
    {
        return Cache::remember('dispatch_map_location_freshness_seconds', 60, function () {
            $settings = BusinessSetting::query()
                ->whereIn('key', [
                    'commerce_dispatch_location_freshness_seconds',
                    'ride_hailing_dispatch_location_freshness_seconds',
                ])
                ->pluck('value', 'key');

            return max(30, min(1800, max(
                (int) ($settings['commerce_dispatch_location_freshness_seconds'] ?? 180),
                (int) ($settings['ride_hailing_dispatch_location_freshness_seconds'] ?? 180),
            )));
        });
    }

    private function marker(DeliveryMan $rider, CarbonInterface $generatedAt, int $freshnessSeconds): ?array
    {
        $location = $rider->last_location;
        $visible = (bool) $rider->status
            && (int) $rider->active === 1
            && $rider->application_status === 'approved'
            && $rider->type === 'zone_wise'
            && $location?->time
            && $location->time->greaterThanOrEqualTo($generatedAt->copy()->subSeconds($freshnessSeconds));

        if (! $location || ! is_numeric($location->latitude) || ! is_numeric($location->longitude)) {
            return null;
        }

        return [
            'id' => (int) $rider->id,
            'name' => trim($rider->f_name.' '.$rider->l_name),
            'image_url' => $rider->image_full_url,
            'latitude' => (float) $location->latitude,
            'longitude' => (float) $location->longitude,
            'heading' => $location->heading !== null ? (float) $location->heading : null,
            'accuracy_meters' => $location->accuracy_meters !== null ? (float) $location->accuracy_meters : null,
            'location' => (string) $location->location,
            'zone_id' => $rider->zone_id ? (int) $rider->zone_id : null,
            'work_mode' => (string) ($rider->work_mode ?: 'delivery'),
            'assigned_order_count' => (int) $rider->assigned_order_count,
            'current_orders' => (int) $rider->current_orders,
            'visible' => $visible,
            'updated_at' => $location->time->toIso8601String(),
            'stale_at' => $location->time->copy()->addSeconds($freshnessSeconds)->toIso8601String(),
        ];
    }
}
