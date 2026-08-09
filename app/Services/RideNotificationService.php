<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\BusinessSetting;
use App\Models\RideRequest;
use App\Models\UserNotification;

class RideNotificationService
{
    public const SETTING_KEY = 'ride_hailing_notification_templates';

    public const DEFINITIONS = [
        'offer_accepted' => ['label' => 'Passenger Accepted Offer', 'audience' => 'captain', 'title' => 'Ride offer accepted', 'body' => '{passengerName} selected your offer for Ride {rideNumber}. Start travelling to {pickupAddress}.'],
        'admin_assigned_customer' => ['label' => 'Admin Assigned Captain - Passenger', 'audience' => 'customer', 'title' => 'Captain assigned', 'body' => '{captainName} has been assigned to your Ride {rideNumber}.'],
        'admin_assigned_captain' => ['label' => 'Admin Assigned Ride - Captain', 'audience' => 'captain', 'title' => 'New Ride assigned', 'body' => 'Zaqoota assigned Ride {rideNumber} to you. Start travelling to {pickupAddress}.'],
        'captain_arriving' => ['label' => 'Captain Coming', 'audience' => 'customer', 'title' => 'Captain is on the way', 'body' => '{captainName} is travelling to your pickup point.'],
        'captain_arrived' => ['label' => 'Captain Arrived', 'audience' => 'customer', 'title' => 'Captain has arrived', 'body' => '{captainName} has arrived. Please meet at the pickup point.'],
        'ride_started' => ['label' => 'Ride Started', 'audience' => 'customer', 'title' => 'Ride started', 'body' => 'Your Trip PIN was verified and Ride {rideNumber} has started.'],
        'ride_completed' => ['label' => 'Ride Completed', 'audience' => 'customer', 'title' => 'Ride completed', 'body' => 'Ride {rideNumber} is complete. Your final payable amount is {finalFare}.'],
        'passenger_cancelled_no_charge' => ['label' => 'Passenger Cancelled - No Charge', 'audience' => 'captain', 'title' => 'Ride cancelled by passenger', 'body' => '{passengerName} cancelled Ride {rideNumber}. Reason: {reason}. No cancellation compensation applies.'],
        'passenger_cancelled_with_charge' => ['label' => 'Passenger Cancelled - Compensation Due', 'audience' => 'captain', 'title' => 'Ride cancelled by passenger', 'body' => '{passengerName} cancelled Ride {rideNumber}. Reason: {reason}. Zaqoota has credited compensation of {cancellationCharge} to your wallet.'],
        'captain_cancelled' => ['label' => 'Captain Cancelled', 'audience' => 'customer', 'title' => 'Ride cancelled by Captain', 'body' => '{captainName} cancelled Ride {rideNumber}. Reason: {reason}. You were not charged and can request another Ride.'],
        'admin_cancelled_customer' => ['label' => 'Admin Cancelled - Passenger', 'audience' => 'customer', 'title' => 'Ride cancelled by Zaqoota', 'body' => 'Zaqoota cancelled Ride {rideNumber}. Reason: {reason}. You were not charged.'],
        'admin_cancelled_captain' => ['label' => 'Admin Cancelled - Captain', 'audience' => 'captain', 'title' => 'Ride cancelled by Zaqoota', 'body' => 'Zaqoota cancelled Ride {rideNumber}. Reason: {reason}.'],
        'payment_received' => ['label' => 'Payment Received', 'audience' => 'customer', 'title' => 'Ride payment received', 'body' => 'Your payment of {finalFare} for Ride {rideNumber} was confirmed and the receipt is ready.'],
        'earning_posted' => ['label' => 'Captain Earning Posted', 'audience' => 'captain', 'title' => 'Ride earning posted', 'body' => 'Your earning of {captainEarning} for Ride {rideNumber} has been added to your wallet.'],
    ];

    private ?array $configured = null;

    public function event(RideRequest $ride, string $event): void
    {
        $definition = self::DEFINITIONS[$event] ?? null;
        if (! $definition) {
            return;
        }
        $configuration = $this->configuration()[$event] ?? [];
        $title = $this->render($configuration['title'] ?? $definition['title'], $ride);
        $body = $this->render($configuration['body'] ?? $definition['body'], $ride);
        $this->deliver($ride, $definition['audience'], $title, $body, (bool) ($configuration['push_enabled'] ?? true), (bool) ($configuration['in_app_enabled'] ?? true));
    }

    public static function templates(): array
    {
        $stored = json_decode((string) BusinessSetting::query()->where('key', self::SETTING_KEY)->value('value'), true);

        return collect(self::DEFINITIONS)->mapWithKeys(fn ($definition, $key) => [$key => [
            ...$definition,
            'title' => $stored[$key]['title'] ?? $definition['title'],
            'body' => $stored[$key]['body'] ?? $definition['body'],
            'push_enabled' => (bool) ($stored[$key]['push_enabled'] ?? true),
            'in_app_enabled' => (bool) ($stored[$key]['in_app_enabled'] ?? true),
        ]])->all();
    }

    private function deliver(RideRequest $ride, string $audience, string $title, string $description, bool $push, bool $inApp): void
    {
        $data = $this->payload($ride, $title, $description);
        try {
            if ($audience === 'customer') {
                if ($inApp) {
                    UserNotification::query()->create(['user_id' => $ride->user_id, 'data' => json_encode($data)]);
                }
                if ($push && $ride->user?->cm_firebase_token) {
                    Helpers::send_push_notif_to_device($ride->user->cm_firebase_token, $data);
                }
            } elseif ($ride->delivery_man_id) {
                if ($inApp) {
                    UserNotification::query()->create(['delivery_man_id' => $ride->delivery_man_id, 'data' => json_encode($data)]);
                }
                if ($push && $ride->deliveryMan?->fcm_token) {
                    Helpers::send_push_notif_to_device($ride->deliveryMan->fcm_token, $data);
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

    private function configuration(): array
    {
        return $this->configured ??= (json_decode((string) BusinessSetting::query()->where('key', self::SETTING_KEY)->value('value'), true) ?: []);
    }

    private function render(string $template, RideRequest $ride): string
    {
        return strtr($template, [
            '{rideNumber}' => (string) $ride->request_number,
            '{passengerName}' => trim(($ride->user?->f_name ?? '').' '.($ride->user?->l_name ?? '')) ?: 'Passenger',
            '{captainName}' => $ride->deliveryMan?->full_name ?: 'Captain',
            '{reason}' => $ride->cancellation_reason ?: 'Not provided',
            '{cancellationCharge}' => Helpers::format_currency((float) $ride->cancellation_charge_amount),
            '{pickupAddress}' => (string) $ride->pickup_address,
            '{finalFare}' => Helpers::format_currency((float) $ride->final_payable_amount),
            '{captainEarning}' => Helpers::format_currency((float) $ride->captain_total_earning_amount),
        ]);
    }

    private function payload(RideRequest $ride, string $title, string $description): array
    {
        return ['title' => $title, 'description' => $description, 'image' => '', 'type' => 'ride_status', 'trip_id' => (string) $ride->id, 'status' => $ride->status];
    }
}
