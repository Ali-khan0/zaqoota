<?php

namespace Tests\Unit;

use App\Models\RideCancellationReason;
use App\Models\RideRequest;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class RideCancellationReasonTest extends TestCase
{
    public function test_actor_and_lifecycle_scope_is_exact(): void
    {
        $reason = $this->reason([
            'user_type' => 'customer',
            'ride_statuses' => ['searching', 'captain_arriving'],
            'status' => true,
        ]);

        self::assertTrue($reason->appliesTo('customer', 'searching'));
        self::assertTrue($reason->appliesTo('user', 'captain_arriving'));
        self::assertFalse($reason->appliesTo('captain', 'searching'));
        self::assertFalse($reason->appliesTo('customer', 'negotiating'));
    }

    public function test_inactive_reason_never_applies(): void
    {
        $reason = $this->reason(['status' => false]);

        self::assertFalse($reason->appliesTo('customer', 'searching'));
    }

    public function test_ride_returns_immutable_structured_snapshot(): void
    {
        $ride = new RideRequest;
        $ride->setRawAttributes([
            'cancellation_reason_id' => 7,
            'cancellation_reason_code' => 'customer_plans_changed',
            'cancellation_reason_user_type' => 'customer',
            'cancellation_reason' => 'My plans changed',
            'cancelled_by' => 'customer',
        ]);

        self::assertSame([
            'id' => 7,
            'code' => 'customer_plans_changed',
            'title' => 'My plans changed',
            'user_type' => 'customer',
        ], $ride->cancellationReasonData());
    }

    public function test_legacy_free_text_cancellation_has_safe_response_shape(): void
    {
        $ride = new RideRequest;
        $ride->setRawAttributes([
            'cancellation_reason_id' => null,
            'cancellation_reason_code' => null,
            'cancellation_reason_user_type' => null,
            'cancellation_reason' => 'Legacy reason',
            'cancelled_by' => 'admin',
        ]);

        self::assertSame([
            'id' => null,
            'code' => null,
            'title' => 'Legacy reason',
            'user_type' => 'admin',
        ], $ride->cancellationReasonData());
    }

    private function reason(array $overrides = []): RideCancellationReason
    {
        $reason = new RideCancellationReason;
        $attributes = array_merge([
            'id' => 1,
            'code' => 'customer_plans_changed',
            'title' => 'My plans changed',
            'user_type' => 'customer',
            'ride_statuses' => ['searching'],
            'status' => true,
        ], $overrides);
        $attributes['ride_statuses'] = json_encode($attributes['ride_statuses']);
        $reason->setRawAttributes($attributes);
        $reason->setRelation('translations', new Collection);

        return $reason;
    }
}
