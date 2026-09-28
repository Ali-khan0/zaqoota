<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CaptainRideController;
use App\Models\RideRequest;
use ReflectionMethod;
use Tests\TestCase;

class RideCaptainPaymentRecoveryPolicyTest extends TestCase
{
    public function test_recovery_scope_only_includes_completed_unsettled_payment_states(): void
    {
        self::assertSame(
            ['unpaid', 'pending', 'partially_paid'],
            RideRequest::CAPTAIN_PAYMENT_RECOVERY_STATUSES,
        );

        $method = new ReflectionMethod(RideRequest::class, 'scopeAwaitingCaptainPaymentRecovery');
        $source = file($method->getFileName());
        $body = implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));

        self::assertStringContainsString("where('status', self::STATUS_COMPLETED)", $body);
        self::assertStringContainsString("whereNull('settled_at')", $body);
        self::assertStringContainsString("whereIn('payment_status', self::CAPTAIN_PAYMENT_RECOVERY_STATUSES)", $body);
    }

    public function test_current_ride_uses_payment_recovery_only_as_a_fallback(): void
    {
        $method = new ReflectionMethod(CaptainRideController::class, 'currentRide');
        $source = file($method->getFileName());
        $body = implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));
        $activeQuery = strpos($body, "->whereIn('status', [");
        $fallbackGuard = strpos($body, 'if (! $ride)');
        $recoveryQuery = strpos($body, '->awaitingCaptainPaymentRecovery()');

        self::assertNotFalse($activeQuery);
        self::assertNotFalse($fallbackGuard);
        self::assertNotFalse($recoveryQuery);
        self::assertLessThan($fallbackGuard, $activeQuery);
        self::assertLessThan($recoveryQuery, $fallbackGuard);
    }
}
