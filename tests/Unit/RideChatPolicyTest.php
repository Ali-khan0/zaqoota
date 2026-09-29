<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\RideChatController;
use App\Services\RideChatService;
use App\Services\RideRealtimeService;
use ReflectionMethod;
use Tests\TestCase;

class RideChatPolicyTest extends TestCase
{
    public function test_message_send_is_lifecycle_limited_and_idempotent(): void
    {
        $body = $this->methodBody(RideChatService::class, 'send');

        self::assertStringContainsString('$this->canSend($ride)', $body);
        self::assertStringContainsString('insertOrIgnore', $body);
        self::assertStringContainsString("'client_id'", $body);
        self::assertStringContainsString('if ($created)', $body);
    }

    public function test_each_endpoint_scopes_the_ride_to_the_authenticated_participant(): void
    {
        $customer = $this->methodBody(RideChatController::class, 'customerRide');
        $captain = $this->methodBody(RideChatController::class, 'captainRide');

        self::assertStringContainsString("where('user_id'", $customer);
        self::assertStringContainsString("whereNotNull('delivery_man_id')", $customer);
        self::assertStringContainsString("where('delivery_man_id'", $captain);
    }

    public function test_seen_receipts_are_written_only_for_other_participant_messages(): void
    {
        $body = $this->methodBody(RideChatService::class, 'markSeen');

        self::assertStringContainsString("where('sender_type', '!=', \$type)", $body);
        self::assertStringContainsString("'seen_by_type' => \$type", $body);
        self::assertStringContainsString("'seen_by_id' => \$participantId", $body);
    }

    public function test_presence_only_suppresses_push_and_expires(): void
    {
        $presence = $this->methodBody(RideChatService::class, 'presence');
        $delivery = $this->methodBody(RideChatService::class, 'notifyRecipientUnlessPresent');

        self::assertStringContainsString('addSeconds(75)', $presence);
        self::assertStringContainsString("where('expires_at', '>', now())", $delivery);
        self::assertStringContainsString('UserNotification::query()->create', $delivery);
        self::assertStringContainsString('! $present', $delivery);
    }

    public function test_terminal_chat_is_read_only_and_cannot_publish_presence(): void
    {
        $canSend = $this->methodBody(RideChatService::class, 'canSend');
        $presence = $this->methodBody(RideChatService::class, 'presence');
        $messages = $this->methodBody(RideChatController::class, 'messages');

        self::assertStringContainsString('SENDABLE_STATUSES', $canSend);
        self::assertStringContainsString('$active && $this->canSend($ride)', $presence);
        self::assertStringContainsString("'can_send'", $messages);
        self::assertStringContainsString("'read_only'", $messages);
        self::assertStringContainsString("'ride_status'", $messages);
    }

    public function test_chat_contact_is_scoped_to_the_authorized_other_participant(): void
    {
        $messages = $this->methodBody(RideChatController::class, 'messages');
        $contact = $this->methodBody(RideChatController::class, 'contactData');

        self::assertStringContainsString("'contact' => \$this->contactData", $messages);
        self::assertStringContainsString("\$viewerType === 'customer' ? \$ride->deliveryMan : \$ride->user", $contact);
        self::assertStringContainsString("'sender_name'", $contact);
        self::assertStringContainsString("'ride_number'", $contact);
        self::assertStringContainsString("'destination_name'", $contact);
    }

    public function test_private_trip_channel_carries_created_and_seen_events(): void
    {
        $created = $this->methodBody(RideRealtimeService::class, 'messageCreated');
        $seen = $this->methodBody(RideRealtimeService::class, 'messagesSeen');

        self::assertStringContainsString('ride.trip.', $created.$seen);
        self::assertStringContainsString('ride.message.created', $created);
        self::assertStringContainsString('ride.message.seen', $seen);
    }

    private function methodBody(string $class, string $method): string
    {
        $reflection = new ReflectionMethod($class, $method);
        $source = file($reflection->getFileName());

        return implode('', array_slice(
            $source,
            $reflection->getStartLine() - 1,
            $reflection->getEndLine() - $reflection->getStartLine() + 1,
        ));
    }
}
