<?php

namespace App\Jobs;

use App\Models\RideRequest;
use App\Queue\Middleware\EnsureQueueProcessEnabled;
use App\Services\RideDispatchService;
use App\Services\RideNotificationService;
use App\Services\RideRealtimeService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DispatchRideRequestWave implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public function __construct(
        public readonly int $rideId,
        public readonly int $wave,
    ) {
        $this->afterCommit();
    }

    public function middleware(): array
    {
        return [new EnsureQueueProcessEnabled('ride_dispatch_wave')];
    }

    public function handle(
        RideDispatchService $dispatch,
        RideRealtimeService $realtime,
        RideNotificationService $notifications,
    ): void {
        $ride = RideRequest::query()->with(['category', 'user'])->find($this->rideId);
        if (! $ride || ! in_array($ride->status, [RideRequest::STATUS_SEARCHING, RideRequest::STATUS_NEGOTIATING], true)) {
            return;
        }

        $releaseAt = $dispatch->dispatchStartedAt($ride)
            ->addSeconds($this->wave * $dispatch->waveIntervalSeconds());
        if ($releaseAt->isFuture()) {
            if (config('queue.default') !== 'sync') {
                $this->release(max(1, now()->diffInSeconds($releaseAt)));
            }

            return;
        }

        $captains = $dispatch->captainsForWave($ride, $this->wave);
        if ($captains->isEmpty()) {
            return;
        }

        $realtime->discovery($ride, $captains);
        $notifications->newRequest($ride, $captains);
    }
}
