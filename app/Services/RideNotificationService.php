<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Jobs\SendRideRequestPush;
use App\Models\BusinessSetting;
use App\Models\RideNotificationDelivery;
use App\Models\RideOffer;
use App\Models\RideRequest;
use App\Models\UserNotification;
use Illuminate\Support\Collection;

class RideNotificationService
{
    public const SETTING_KEY = 'ride_hailing_notification_templates';

    public const DEFINITIONS = [
        'ride_request_available' => ['label' => 'New Ride Request - Captain', 'audience' => 'eligible_captains', 'title' => 'New Ride request nearby', 'body' => 'A new Ride {rideNumber} is available near {pickupAddress}. Open the app to send your offer.'],
        'customer_offer_updated' => ['label' => 'Passenger Updated Price - Eligible Captains', 'audience' => 'eligible_captains', 'title' => 'Ride price updated', 'body' => 'The passenger updated the opening price for Ride {rideNumber} to {customerOffer}. Open the app to review it.'],
        'offer_rejected' => ['label' => 'Passenger Rejected Offer - Captain', 'audience' => 'captain', 'title' => 'Ride offer not selected', 'body' => 'The passenger rejected your offer for Ride {rideNumber}.'],
        'offer_accepted' => ['label' => 'Passenger Accepted Offer', 'audience' => 'captain', 'title' => 'Ride offer accepted', 'body' => '{passengerName} selected your offer for Ride {rideNumber}. Start travelling to {pickupAddress}.'],
        'admin_assigned_customer' => ['label' => 'Admin Assigned Captain - Passenger', 'audience' => 'customer', 'title' => 'Captain assigned', 'body' => '{captainName} has been assigned to your Ride {rideNumber}.'],
        'admin_assigned_captain' => ['label' => 'Admin Assigned Ride - Captain', 'audience' => 'captain', 'title' => 'New Ride assigned', 'body' => 'Zaqoota assigned Ride {rideNumber} to you. Start travelling to {pickupAddress}.'],
        'captain_arriving' => ['label' => 'Captain Coming', 'audience' => 'customer', 'title' => 'Captain is on the way', 'body' => '{captainName} is travelling to your pickup point.'],
        'captain_arrived' => ['label' => 'Captain Arrived', 'audience' => 'customer', 'title' => 'Captain has arrived', 'body' => '{captainName} has arrived. Open the Ride screen for your pickup details.'],
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

    public function newRequest(RideRequest $ride, Collection $captains): void
    {
        $this->captainsEvent($ride, 'ride_request_available', $captains, 'ride_request');
    }

    public function captainsEvent(RideRequest $ride, string $event, Collection $captains, string $type, ?string $deliveryEvent = null): void
    {
        $definition = self::DEFINITIONS[$event];
        $configuration = $this->configuration()[$event] ?? [];
        $title = $this->render($configuration['title'] ?? $definition['title'], $ride);
        $body = $this->render($configuration['body'] ?? $definition['body'], $ride);
        $push = (bool) ($configuration['push_enabled'] ?? true);
        $inApp = (bool) ($configuration['in_app_enabled'] ?? true);
        $data = [
            ...$this->payload($ride, $title, $body),
            'type' => $type,
        ];

        foreach ($captains->unique('id') as $captain) {
            $delivery = RideNotificationDelivery::query()->firstOrCreate([
                'ride_request_id' => $ride->id,
                'delivery_man_id' => $captain->id,
                'event' => $deliveryEvent ?? $event,
            ]);

            try {
                if ($inApp && ! $delivery->in_app_stored) {
                    UserNotification::query()->create([
                        'delivery_man_id' => $captain->id,
                        'data' => json_encode($data),
                    ]);
                    $delivery->in_app_stored = true;
                }

                if (! $push) {
                    $delivery->push_status = 'disabled';
                } elseif (! $captain->fcm_token) {
                    $delivery->push_status = 'no_token';
                } elseif ($delivery->push_status !== 'accepted'
                    && ($delivery->push_status !== 'queued' || $delivery->updated_at?->lt(now()->subMinutes(5)))) {
                    $delivery->push_status = 'queued';
                    $delivery->last_error = null;
                    $delivery->save();
                    SendRideRequestPush::dispatch($delivery->id, $data);

                    continue;
                }
                $delivery->save();
            } catch (\Throwable $exception) {
                $delivery->forceFill([
                    'push_status' => 'failed',
                    'last_error' => (string) str($exception->getMessage())->limit(1000),
                    'last_attempted_at' => now(),
                ])->save();
                report($exception);
            }
        }
    }

    public function offerRejected(RideRequest $ride, RideOffer $offer): void
    {
        $definition = self::DEFINITIONS['offer_rejected'];
        $configuration = $this->configuration()['offer_rejected'] ?? [];
        $title = $this->render($configuration['title'] ?? $definition['title'], $ride);
        $body = $this->render($configuration['body'] ?? $definition['body'], $ride);
        $data = [...$this->payload($ride, $title, $body), 'type' => 'ride_offer_rejected', 'offer_id' => (string) $offer->id];
        try {
            if ((bool) ($configuration['in_app_enabled'] ?? true)) {
                UserNotification::query()->create(['delivery_man_id' => $offer->delivery_man_id, 'data' => json_encode($data)]);
            }
            if ((bool) ($configuration['push_enabled'] ?? true) && $offer->deliveryMan?->fcm_token) {
                Helpers::send_push_notif_to_device($offer->deliveryMan->fcm_token, $data);
            }
        } catch (\Throwable $exception) {
            report($exception);
        }
    }

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
        $type = $event === 'offer_accepted' ? 'ride_offer_accepted' : 'ride_status';
        $extra = $event === 'offer_accepted' ? ['offer_id' => (string) $ride->accepted_offer_id] : [];
        $this->deliver($ride, $definition['audience'], $title, $body, (bool) ($configuration['push_enabled'] ?? true), (bool) ($configuration['in_app_enabled'] ?? true), $type, $extra);
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

    private function deliver(RideRequest $ride, string $audience, string $title, string $description, bool $push, bool $inApp, string $type = 'ride_status', array $extra = []): void
    {
        $data = [...$this->payload($ride, $title, $description), 'type' => $type, ...$extra];
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
            '{customerOffer}' => Helpers::format_currency((float) $ride->customer_offer),
        ]);
    }

    private function payload(RideRequest $ride, string $title, string $description): array
    {
        return ['title' => $title, 'description' => $description, 'image' => '', 'type' => 'ride_status', 'ride_id' => (string) $ride->id, 'trip_id' => (string) $ride->id, 'status' => $ride->status];
    }
}
