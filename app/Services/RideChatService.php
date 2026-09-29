<?php

namespace App\Services;

use App\CentralLogics\Helpers;
use App\Models\RideChatPresence;
use App\Models\RideMessage;
use App\Models\RideRequest;
use App\Models\UserNotification;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RideChatService
{
    public const SENDABLE_STATUSES = [
        RideRequest::STATUS_RIDER_SELECTED,
        RideRequest::STATUS_CAPTAIN_ARRIVING,
        RideRequest::STATUS_ARRIVED,
        RideRequest::STATUS_IN_PROGRESS,
    ];

    public function __construct(private readonly RideRealtimeService $realtime) {}

    public function messages(RideRequest $ride, int $limit): LengthAwarePaginator
    {
        return RideMessage::query()->where('ride_request_id', $ride->id)
            ->latest('id')->paginate(max(1, min($limit, 50)));
    }

    public function canSend(RideRequest $ride): bool
    {
        return in_array($ride->status, self::SENDABLE_STATUSES, true);
    }

    public function send(RideRequest $ride, string $type, int $participantId, string $clientId, string $body): array
    {
        if (! $this->canSend($ride)) {
            throw ValidationException::withMessages(['ride' => 'Messages can only be sent during an assigned active Ride.']);
        }

        [$message, $created] = DB::transaction(function () use ($ride, $type, $participantId, $clientId, $body) {
            $identity = [
                'ride_request_id' => $ride->id,
                'sender_type' => $type,
                'sender_id' => $participantId,
                'client_id' => $clientId,
            ];
            $created = RideMessage::query()->insertOrIgnore([
                ...$identity,
                'message' => trim($body),
                'created_at' => now(),
                'updated_at' => now(),
            ]) === 1;
            $message = RideMessage::query()->where($identity)->firstOrFail();

            return [$message, $created];
        }, 3);

        if ($created) {
            $data = $this->data($message);
            $this->realtime->messageCreated($ride, $data);
            $this->notifyRecipientUnlessPresent($ride, $type, $body);
        }

        return [$message, $created];
    }

    public function markSeen(RideRequest $ride, string $type, int $participantId): int
    {
        $ids = RideMessage::query()->where('ride_request_id', $ride->id)
            ->where('sender_type', '!=', $type)->whereNull('seen_at')->pluck('id');
        if ($ids->isEmpty()) {
            return 0;
        }
        $seenAt = now();
        RideMessage::query()->whereIn('id', $ids)->update([
            'seen_at' => $seenAt,
            'seen_by_type' => $type,
            'seen_by_id' => $participantId,
            'updated_at' => $seenAt,
        ]);
        $this->realtime->messagesSeen($ride, $ids->map(fn ($id) => (int) $id)->all(), $type, $seenAt->toIso8601String());

        return $ids->count();
    }

    public function presence(RideRequest $ride, string $type, int $participantId, bool $active): bool
    {
        $active = $active && $this->canSend($ride);
        RideChatPresence::query()->updateOrCreate([
            'ride_request_id' => $ride->id,
            'participant_type' => $type,
            'participant_id' => $participantId,
        ], ['expires_at' => $active ? now()->addSeconds(75) : now()]);

        return $active;
    }

    public function data(RideMessage $message): array
    {
        return [
            'id' => (int) $message->id,
            'ride_id' => (int) $message->ride_request_id,
            'sender_type' => $message->sender_type,
            'client_id' => $message->client_id,
            'message' => $message->message,
            'sent_at' => $message->created_at?->toIso8601String(),
            'seen_at' => $message->seen_at?->toIso8601String(),
        ];
    }

    private function notifyRecipientUnlessPresent(RideRequest $ride, string $senderType, string $body): void
    {
        $recipientType = $senderType === 'customer' ? 'captain' : 'customer';
        $recipientId = $recipientType === 'customer' ? (int) $ride->user_id : (int) $ride->delivery_man_id;
        if (! $recipientId) {
            return;
        }
        $present = RideChatPresence::query()->where([
            'ride_request_id' => $ride->id,
            'participant_type' => $recipientType,
            'participant_id' => $recipientId,
        ])->where('expires_at', '>', now())->exists();

        $title = $senderType === 'customer' ? 'New passenger message' : 'New Captain message';
        $data = [
            'title' => $title,
            'description' => (string) str($body)->limit(120),
            'image' => '',
            'type' => 'ride_message',
            'ride_id' => (string) $ride->id,
            'trip_id' => (string) $ride->id,
            'status' => $ride->status,
        ];
        if ($recipientType === 'customer') {
            UserNotification::query()->create(['user_id' => $recipientId, 'data' => json_encode($data)]);
            if (! $present && $ride->user?->cm_firebase_token) {
                Helpers::send_push_notif_to_device($ride->user->cm_firebase_token, $data);
            }
        } else {
            UserNotification::query()->create(['delivery_man_id' => $recipientId, 'data' => json_encode($data)]);
            if (! $present && $ride->deliveryMan?->fcm_token) {
                Helpers::send_push_notif_to_device($ride->deliveryMan->fcm_token, $data);
            }
        }
    }
}
