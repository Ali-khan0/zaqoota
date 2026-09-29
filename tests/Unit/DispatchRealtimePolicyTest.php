<?php

namespace Tests\Unit;

use App\Events\DispatchOrderCreated;
use App\Http\Controllers\Admin\DispatchRealtimeController;
use App\Services\DispatchRealtimeService;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

class DispatchRealtimePolicyTest extends TestCase
{
    public function test_dispatch_events_use_unique_private_channels_and_a_stable_name(): void
    {
        $event = new DispatchOrderCreated(
            ['admin.dispatch.module.food', 'admin.dispatch.module.food'],
            ['source' => 'commerce', 'id' => 42],
        );

        self::assertSame(['private-admin.dispatch.module.food'], array_map(
            fn ($channel) => $channel->name,
            $event->broadcastOn(),
        ));
        self::assertSame('dispatch.order.created', $event->broadcastAs());
        self::assertSame(['source' => 'commerce', 'id' => 42], $event->broadcastWith());
    }

    public function test_dispatch_broadcasts_are_zone_and_module_scoped(): void
    {
        $source = $this->methodBody(DispatchRealtimeService::class, 'send');

        self::assertStringContainsString('admin.dispatch.module.{$moduleKey}', $source);
        self::assertStringContainsString('admin.dispatch.zone.{$zoneId}.module.{$moduleKey}', $source);
        self::assertStringContainsString('DB::afterCommit', $source);
    }

    public function test_feed_and_detail_queries_apply_admin_zone_scope(): void
    {
        self::assertStringContainsString("where('zone_id', \$zoneId)", $this->methodBody(DispatchRealtimeController::class, 'commerceQuery'));
        self::assertStringContainsString("where('zone_id', \$zoneId)", $this->methodBody(DispatchRealtimeController::class, 'rideQuery'));
        self::assertStringContainsString('canViewModule', $this->methodBody(DispatchRealtimeController::class, 'item'));
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
