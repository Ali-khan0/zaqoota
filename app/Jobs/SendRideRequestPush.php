<?php

namespace App\Jobs;

use App\CentralLogics\Helpers;
use App\Models\RideNotificationDelivery;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Throwable;

class SendRideRequestPush implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public readonly int $deliveryId,
        public readonly array $payload,
    ) {
        $this->afterCommit();
    }

    public function handle(): void
    {
        $delivery = RideNotificationDelivery::query()->with('deliveryMan')->find($this->deliveryId);
        if (! $delivery || $delivery->push_status === 'accepted') {
            return;
        }

        $token = $delivery->deliveryMan?->fcm_token;
        if (! $token) {
            $delivery->update([
                'push_status' => 'no_token',
                'last_error' => 'Captain has no Firebase device token.',
                'last_attempted_at' => now(),
            ]);

            return;
        }

        $delivery->increment('push_attempts');
        $accepted = Helpers::send_push_notif_to_device($token, $this->payload);
        $delivery->update([
            'push_status' => $accepted ? 'accepted' : 'failed',
            'accepted_at' => $accepted ? now() : null,
            'last_error' => $accepted ? null : 'Firebase did not accept the message.',
            'last_attempted_at' => now(),
        ]);

        if (! $accepted) {
            throw new \RuntimeException('Firebase did not accept the Ride request notification.');
        }
    }

    public function failed(?Throwable $exception): void
    {
        RideNotificationDelivery::query()->whereKey($this->deliveryId)->update([
            'push_status' => 'failed',
            'last_error' => (string) str($exception?->getMessage() ?: 'Push job failed.')->limit(1000),
            'last_attempted_at' => now(),
        ]);
    }
}
