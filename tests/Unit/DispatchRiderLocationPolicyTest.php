<?php

namespace Tests\Unit;

use App\Events\DispatchRiderLocationUpdated;
use App\Http\Controllers\Admin\DispatchRealtimeController;
use App\Http\Controllers\Api\V1\DeliverymanController;
use App\Jobs\DispatchDriverLocationJob;
use App\Services\DispatchRiderLocationService;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class DispatchRiderLocationPolicyTest extends TestCase
{
    public function test_location_event_uses_unique_private_channels(): void
    {
        $event = new DispatchRiderLocationUpdated([
            'admin.dispatch.location.all',
            'admin.dispatch.location.zone.4',
            'admin.dispatch.location.zone.4',
        ], ['id' => 12, 'visible' => true]);

        self::assertSame([
            'private-admin.dispatch.location.all',
            'private-admin.dispatch.location.zone.4',
        ], array_map(fn ($channel) => $channel->name, $event->broadcastOn()));
        self::assertSame('dispatch.rider.location.updated', $event->broadcastAs());
    }

    public function test_http_heartbeat_persists_before_queueing_the_admin_broadcast(): void
    {
        $source = $this->methodBody(DeliverymanController::class, 'record_location_data');

        self::assertStringContainsString('DeliveryHistory::updateOrCreate', $source);
        self::assertStringContainsString('OperationalZoneService::class', $source);
        self::assertStringContainsString('new DispatchDriverLocationJob', $source);
        self::assertLessThan(
            strpos($source, 'new DispatchDriverLocationJob'),
            strpos($source, 'DeliveryHistory::updateOrCreate'),
        );
    }

    public function test_queued_location_job_emits_the_secure_dispatch_event(): void
    {
        $source = $this->methodBody(DispatchDriverLocationJob::class, 'handle');

        self::assertStringContainsString('DispatchRiderLocationService', $source);
        self::assertStringContainsString('dispatchLocations->broadcast', $source);
    }

    public function test_snapshot_is_zone_scoped_and_excludes_stale_or_offline_riders(): void
    {
        $source = $this->methodBody(DispatchRiderLocationService::class, 'snapshot');

        self::assertStringContainsString("where('zone_id', \$zoneId)", $source);
        self::assertStringContainsString("where('active', 1)", $source);
        self::assertStringContainsString("where('time', '>=', \$cutoff)", $source);
        self::assertStringContainsString('freshnessSeconds()', $source);
    }

    public function test_snapshot_endpoint_requires_dispatch_permission(): void
    {
        $source = $this->methodBody(DispatchRealtimeController::class, 'riders');

        self::assertStringContainsString('canViewDispatch()', $source);
        self::assertStringContainsString('adminZoneId()', $source);
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
