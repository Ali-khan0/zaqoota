<?php

namespace App\Services;

use App\Models\DeliveryMan;
use App\Models\Zone;
use MatanYadaev\EloquentSpatial\Objects\Point;

class OperationalZoneService
{
    public function resolve(float $latitude, float $longitude): ?Zone
    {
        return Zone::query()
            ->active()
            ->whereContains('coordinates', new Point($latitude, $longitude, POINT_SRID))
            ->selectRaw('zones.*, ABS(ST_Area(coordinates)) as operational_area')
            ->orderBy('operational_area')
            ->orderBy('zones.id')
            ->first();
    }

    public function resolveLegacy(?int $zoneId): ?Zone
    {
        return $zoneId ? Zone::query()->active()->find($zoneId) : null;
    }

    public function synchronize(DeliveryMan $deliveryMan, float $latitude, float $longitude): array
    {
        $zone = $this->resolve($latitude, $longitude);
        $previousZoneId = (int) $deliveryMan->zone_id;

        $nextZoneId = $zone?->id;
        $changed = $previousZoneId !== (int) $nextZoneId;

        if ($changed) {
            $deliveryMan->forceFill(['zone_id' => $nextZoneId])->save();
            $deliveryMan->unsetRelation('zone');
        }

        return [
            'zone' => $zone,
            'changed' => $changed,
            'topics' => $zone ? $this->topics($deliveryMan->fresh()) : ['topic' => '', 'zone_topic' => ''],
        ];
    }

    public function topics(DeliveryMan $deliveryMan): array
    {
        $deliveryMan->loadMissing('zone');
        $zone = $deliveryMan->zone;
        if (! $zone) {
            return ['topic' => '', 'zone_topic' => ''];
        }

        $deliverymanTopic = (string) $zone->deliveryman_wise_topic;
        $topic = $deliveryMan->vehicle_id
            ? 'delivery_man_'.$zone->id.'_'.$deliveryMan->vehicle_id
            : ($deliveryMan->type === 'zone_wise'
                ? $deliverymanTopic
                : 'restaurant_dm_'.$deliveryMan->store_id);

        return [
            'topic' => $topic,
            'zone_topic' => $deliveryMan->type === 'zone_wise' && $deliverymanTopic !== ''
                ? $deliverymanTopic.'_push'
                : '',
        ];
    }
}
