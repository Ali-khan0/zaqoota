<?php

namespace App\Jobs;

use App\Models\CommerceOrderNotificationDelivery;
use App\Models\Order;
use App\Models\UserNotification;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\CommerceOrderDispatchService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class DispatchCommerceOrderWave implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public readonly int $orderId,
        public readonly int $wave,
        public readonly array $payload,
    ) {
        $this->afterCommit();
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('commerce_dispatch_wave')];
    }

    public function handle(CommerceOrderDispatchService $dispatch): void
    {
        $order = Order::query()->withoutGlobalScopes()->with('store')->find($this->orderId);
        if (! $order || $order->delivery_man_id !== null) {
            return;
        }

        $releaseAt = $dispatch->dispatchStartedAt($order)
            ->addSeconds($this->wave * $dispatch->waveIntervalSeconds());
        if ($releaseAt->isFuture()) {
            if (config('queue.default') !== 'sync') {
                $this->release(max(1, now()->diffInSeconds($releaseAt)));
            }

            return;
        }

        foreach ($dispatch->captainsVisibleThroughWave($order, $this->wave) as $captain) {
            try {
                $deliveryId = DB::transaction(function () use ($captain) {
                    $delivery = CommerceOrderNotificationDelivery::query()->firstOrCreate([
                        'order_id' => $this->orderId,
                        'delivery_man_id' => $captain->id,
                        'event' => 'order_request',
                    ], [
                        'dispatch_wave' => $this->wave + 1,
                        'pickup_distance_meters' => (int) $captain->getAttribute('pickup_distance_meters'),
                    ]);
                    $delivery = CommerceOrderNotificationDelivery::query()->whereKey($delivery->id)->lockForUpdate()->first();

                    if ($delivery->dispatch_wave === null || $delivery->pickup_distance_meters === null) {
                        $delivery->dispatch_wave ??= $this->wave + 1;
                        $delivery->pickup_distance_meters ??= (int) $captain->getAttribute('pickup_distance_meters');
                    }

                    if (! $delivery->in_app_stored) {
                        UserNotification::query()->create([
                            'delivery_man_id' => $captain->id,
                            'data' => json_encode($this->payload),
                        ]);
                        $delivery->in_app_stored = true;
                    }
                    if (! $captain->fcm_token) {
                        $delivery->push_status = 'no_token';
                        $delivery->save();

                        return null;
                    }
                    if (! $delivery->canQueuePush()) {
                        $delivery->save();

                        return null;
                    }
                    $delivery->push_status = 'queued';
                    $delivery->last_error = null;
                    $delivery->save();

                    return $delivery->id;
                }, 3);

                if ($deliveryId) {
                    SendCommerceOrderRequestPush::dispatch($deliveryId, $this->payload);
                }
            } catch (\Throwable $exception) {
                CommerceOrderNotificationDelivery::query()->where([
                    'order_id' => $this->orderId,
                    'delivery_man_id' => $captain->id,
                    'event' => 'order_request',
                ])->update([
                    'push_status' => 'failed',
                    'last_error' => (string) str($exception->getMessage())->limit(1000),
                    'last_attempted_at' => now(),
                ]);
                report($exception);
            }
        }
    }
}
