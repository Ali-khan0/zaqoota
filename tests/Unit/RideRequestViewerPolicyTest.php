<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CaptainRideController;
use App\Services\RideNotificationService;
use App\Services\RideRequestViewerService;
use ReflectionMethod;
use Tests\TestCase;

class RideRequestViewerPolicyTest extends TestCase
{
    public function test_acknowledgement_rechecks_eligibility_and_is_idempotent(): void
    {
        $body = $this->methodBody(RideRequestViewerService::class, 'acknowledge');

        self::assertStringContainsString('STATUS_SEARCHING', $body);
        self::assertStringContainsString('STATUS_NEGOTIATING', $body);
        self::assertStringContainsString('vehicleFor(', $body);
        self::assertStringContainsString('pickupMetrics(', $body);
        self::assertStringContainsString('maximumPickupRadiusMeters()', $body);
        self::assertStringContainsString('isVisibleTo(', $body);
        self::assertStringContainsString('insertOrIgnore(', $body);
    }

    public function test_push_delivery_does_not_record_a_view(): void
    {
        $notification = $this->methodBody(RideNotificationService::class, 'newRequest')
            .$this->methodBody(RideNotificationService::class, 'captainsEvent');

        self::assertStringNotContainsString('RideRequestView', $notification);
        self::assertStringNotContainsString('viewerService', $notification);
    }

    public function test_only_a_new_acknowledgement_emits_the_customer_update(): void
    {
        $body = $this->methodBody(CaptainRideController::class, 'acknowledgeView');

        self::assertStringContainsString("if (\$result['created'])", $body);
        self::assertStringContainsString('viewersUpdated(', $body);
    }

    public function test_customer_summary_exposes_only_count_and_avatar_urls(): void
    {
        $body = $this->methodBody(RideRequestViewerService::class, 'summary');

        self::assertStringContainsString("'count'", $body);
        self::assertStringContainsString("'avatars'", $body);
        self::assertStringContainsString("'image_url'", $body);
        self::assertStringNotContainsString("'phone'", $body);
        self::assertStringNotContainsString("'latitude'", $body);
        self::assertStringNotContainsString("'longitude'", $body);
        self::assertStringNotContainsString("'name'", $body);
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
