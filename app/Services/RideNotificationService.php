<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\RideRequest;
use App\Models\UserNotification;

class RideNotificationService
{
    public function customer(RideRequest $ride, string $title, string $description): void
    {
        $data = $this->payload($ride, $title, $description);

        try {
            UserNotification::query()->create(['user_id' => $ride->user_id, 'data' => json_encode($data)]);
            if ($ride->user?->cm_firebase_token) {
                Helpers::send_push_notif_to_device($ride->user->cm_firebase_token, $data);
            }
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    public function captain(RideRequest $ride, string $title, string $description): void
    {
        try {
            if ($ride->deliveryMan?->fcm_token) {
                Helpers::send_push_notif_to_device($ride->deliveryMan->fcm_token, $this->payload($ride, $title, $description));
            }
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    private function payload(RideRequest $ride, string $title, string $description): array
    {
        return [
            'title' => $title,
            'description' => $description,
            'image' => '',
            'type' => 'ride_status',
            'trip_id' => (string) $ride->id,
            'status' => $ride->status,
        ];
    }
}
