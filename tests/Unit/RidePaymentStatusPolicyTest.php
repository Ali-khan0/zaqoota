<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CaptainRideController;
use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\RideRequest;
use App\Services\RidePaymentService;
use ReflectionMethod;
use Tests\TestCase;

class RidePaymentStatusPolicyTest extends TestCase
{
    public function test_paid_recovered_and_settled_timestamp_are_settled(): void
    {
        self::assertSame(['paid', 'recovered', 'refunded'], RideRequest::SETTLED_PAYMENT_STATUSES);

        foreach (RideRequest::SETTLED_PAYMENT_STATUSES as $status) {
            $ride = new RideRequest;
            $ride->setRawAttributes(['payment_status' => $status, 'settled_at' => null]);
            self::assertTrue($ride->isPaymentSettled());
        }

        $pending = new RideRequest;
        $pending->setRawAttributes(['payment_status' => 'pending', 'settled_at' => null]);
        self::assertFalse($pending->isPaymentSettled());

        $settled = new RideRequest;
        $settled->setRawAttributes(['payment_status' => 'pending', 'settled_at' => '2026-09-27 12:00:00']);
        self::assertTrue($settled->isPaymentSettled());
    }

    public function test_customer_and_captain_responses_share_the_settled_rule(): void
    {
        $customerRideData = $this->methodBody(CustomerRideController::class, 'rideData');
        $paymentSummary = $this->methodBody(CustomerRideController::class, 'paymentSummaryData');
        $captainTripData = $this->methodBody(CaptainRideController::class, 'tripData');

        foreach ([$customerRideData, $paymentSummary, $captainTripData] as $body) {
            self::assertStringContainsString("'is_settled' => \$ride->isPaymentSettled()", $body);
            self::assertStringContainsString("\$ride->isPaymentSettled() ? 0.0", $body);
        }

        $receipt = $this->methodBody(CustomerRideController::class, 'receipt');
        $paymentDue = $this->methodBody(CustomerRideController::class, 'paymentDue');
        $assertPayable = $this->methodBody(RidePaymentService::class, 'assertPayable');

        self::assertStringContainsString('if (! $ride->isPaymentSettled())', $receipt);
        self::assertStringContainsString("whereNull('cancellation_recovered_at')", $paymentDue);
        self::assertStringContainsString('if ($ride->isPaymentSettled())', $assertPayable);
    }

    private function methodBody(string $class, string $methodName): string
    {
        $method = new ReflectionMethod($class, $methodName);
        $source = file($method->getFileName());

        return implode('', array_slice(
            $source,
            $method->getStartLine() - 1,
            $method->getEndLine() - $method->getStartLine() + 1,
        ));
    }
}
