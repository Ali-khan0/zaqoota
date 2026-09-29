<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CaptainRideController;
use ReflectionMethod;
use Tests\TestCase;

class CaptainRideHistoryPolicyTest extends TestCase
{
    public function test_history_is_captain_owned_and_terminal_only(): void
    {
        $body = $this->methodBody('rideHistory');

        self::assertStringContainsString("where('delivery_man_id', \$captain->id)", $body);
        self::assertStringContainsString('STATUS_COMPLETED', $body);
        self::assertStringContainsString('STATUS_CANCELLED', $body);
        self::assertStringContainsString('historyFilterService->apply', $body);
        self::assertStringContainsString('paginate(', $body);
        self::assertStringContainsString('tripData(', $body);
    }

    public function test_details_remain_captain_owned(): void
    {
        $body = $this->methodBody('showRide');

        self::assertStringContainsString("where('delivery_man_id', \$captain->id)", $body);
        self::assertStringContainsString('cancellationReceivable', $body);
        self::assertStringContainsString('tripData(', $body);
    }

    private function methodBody(string $method): string
    {
        $reflection = new ReflectionMethod(CaptainRideController::class, $method);
        $source = file($reflection->getFileName());

        return implode('', array_slice(
            $source,
            $reflection->getStartLine() - 1,
            $reflection->getEndLine() - $reflection->getStartLine() + 1,
        ));
    }
}
