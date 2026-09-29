<?php

namespace Tests\Unit;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\RideRequest;
use ReflectionMethod;
use Tests\TestCase;

class RideExistingRulesPolicyTest extends TestCase
{
    public function test_one_active_customer_ride_is_serialized_by_the_customer_row(): void
    {
        self::assertSame([
            RideRequest::STATUS_SEARCHING,
            RideRequest::STATUS_NEGOTIATING,
            RideRequest::STATUS_RIDER_SELECTED,
            RideRequest::STATUS_CAPTAIN_ARRIVING,
            RideRequest::STATUS_ARRIVED,
            RideRequest::STATUS_IN_PROGRESS,
        ], RideRequest::ACTIVE_CUSTOMER_STATUSES);

        $store = $this->methodBody(CustomerRideController::class, 'store');
        $userLock = strpos($store, 'User::query()->whereKey($request->user()->id)->lockForUpdate()');
        $activeCheck = strpos($store, "whereIn('status', PassengerRide::ACTIVE_CUSTOMER_STATUSES)->exists()");
        $create = strpos($store, 'PassengerRide::query()->create([');

        self::assertNotFalse($userLock);
        self::assertNotFalse($activeCheck);
        self::assertNotFalse($create);
        self::assertLessThan($activeCheck, $userLock);
        self::assertLessThan($create, $activeCheck);
    }

    public function test_rating_remains_completed_owned_bounded_and_one_per_ride(): void
    {
        $rate = $this->methodBody(CustomerRideController::class, 'rate');

        self::assertStringContainsString("'rating' => 'required|integer|between:1,5'", $rate);
        self::assertStringContainsString("'comment' => 'nullable|string|max:1000'", $rate);
        self::assertStringContainsString("where('user_id', \$request->user()->id)->lockForUpdate()", $rate);
        self::assertStringContainsString('PassengerRide::STATUS_COMPLETED', $rate);
        self::assertStringContainsString("['ride_request_id' => \$ride->id]", $rate);

        $migration = file_get_contents(database_path('migrations/2026_08_15_000001_create_ride_ratings_table.php'));
        self::assertStringContainsString("foreignId('ride_request_id')->unique()", $migration);
    }

    public function test_booking_shutdown_does_not_guard_owned_account_data_or_rating(): void
    {
        foreach (['index', 'show', 'rate', 'paymentSummary', 'paymentDue', 'createPayment', 'payments', 'receipt'] as $method) {
            self::assertStringNotContainsString(
                'customerBookingEnabled()',
                $this->methodBody(CustomerRideController::class, $method),
                $method.' must remain available while new booking is disabled.',
            );
        }

        foreach (['estimate', 'estimates', 'store'] as $method) {
            self::assertStringContainsString(
                'customerBookingEnabled()',
                $this->methodBody(CustomerRideController::class, $method),
            );
        }
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
