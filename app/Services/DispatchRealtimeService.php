<?php

namespace App\Services;

use App\Events\DispatchOrderCreated;
use App\Models\Order;
use App\Models\RideRequest;
use Illuminate\Support\Facades\DB;

class DispatchRealtimeService
{
    public function commerceOrderCreated(Order $order): void
    {
        if (! in_array($order->order_type, ['delivery', 'parcel'], true)) {
            return;
        }

        $order->loadMissing('module:id,module_type');
        $moduleKey = $order->order_type === 'parcel'
            ? 'parcel'
            : (string) ($order->module?->module_type ?: 'food');

        $this->send((int) $order->zone_id, $moduleKey, [
            'source' => 'commerce',
            'id' => (int) $order->id,
            'number' => (string) $order->id,
            'module_key' => $moduleKey,
            'module_id' => $order->module_id ? (int) $order->module_id : null,
            'zone_id' => (int) $order->zone_id,
            'status' => (string) $order->order_status,
            'created_at' => $order->created_at?->toIso8601String(),
        ]);
    }

    public function rideCreated(RideRequest $ride): void
    {
        $this->send((int) $ride->zone_id, 'ride_hailing', [
            'source' => 'ride',
            'id' => (int) $ride->id,
            'number' => $ride->request_number,
            'module_key' => 'ride_hailing',
            'module_id' => null,
            'zone_id' => (int) $ride->zone_id,
            'status' => (string) $ride->status,
            'created_at' => $ride->created_at?->toIso8601String(),
        ]);
    }

    private function send(int $zoneId, string $moduleKey, array $payload): void
    {
        DB::afterCommit(function () use ($zoneId, $moduleKey, $payload) {
            try {
                broadcast(new DispatchOrderCreated([
                    "admin.dispatch.module.{$moduleKey}",
                    "admin.dispatch.zone.{$zoneId}.module.{$moduleKey}",
                ], $payload));
            } catch (\Throwable $exception) {
                report($exception);
            }
        });
    }
}
