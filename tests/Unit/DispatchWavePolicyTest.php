<?php

namespace Tests\Unit;

use App\Jobs\SendCommerceOrderRequestPush;
use App\Jobs\SendRideRequestPush;
use App\Models\CommerceOrderNotificationDelivery;
use App\Models\DeliveryMan;
use App\Models\Order;
use App\Models\RideNotificationDelivery;
use App\Models\RideRequest;
use App\Services\CommerceOrderDispatchService;
use App\Services\CommerceOrderEligibilityService;
use App\Services\RideCaptainEligibilityService;
use App\Services\RideDispatchService;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Support\Collection;
use Tests\TestCase;

class DispatchWavePolicyTest extends TestCase
{
    public function test_commerce_and_ride_waves_keep_earlier_captains_in_the_open_set(): void
    {
        $captains = collect(range(1, 7))->map(
            fn (int $id) => (new DeliveryMan)->forceFill(['id' => $id])
        );

        $commerce = new class(new CommerceOrderEligibilityService, $captains) extends CommerceOrderDispatchService
        {
            public function __construct(CommerceOrderEligibilityService $eligibility, private Collection $captains)
            {
                parent::__construct($eligibility);
            }

            public function rankedCaptains(Order $order): Collection
            {
                return $this->captains;
            }

            public function waveSize(): int
            {
                return 3;
            }
        };
        $ride = new class(new RideCaptainEligibilityService, $captains) extends RideDispatchService
        {
            public function __construct(RideCaptainEligibilityService $eligibility, private Collection $captains)
            {
                parent::__construct($eligibility);
            }

            public function rankedCaptains(RideRequest $ride): Collection
            {
                return $this->captains;
            }

            public function waveSize(): int
            {
                return 3;
            }
        };

        self::assertSame([1, 2, 3], $commerce->captainsVisibleThroughWave(new Order, 0)->pluck('id')->all());
        self::assertSame([1, 2, 3, 4, 5, 6], $commerce->captainsVisibleThroughWave(new Order, 1)->pluck('id')->all());
        self::assertSame([1, 2, 3, 4, 5, 6], $ride->captainsVisibleThroughWave(new RideRequest, 1)->pluck('id')->all());
        self::assertSame(range(1, 7), $ride->captainsVisibleThroughWave(new RideRequest, 2)->pluck('id')->all());
    }

    public function test_request_push_jobs_use_one_unique_queue_key_per_recipient_record(): void
    {
        $commerce = new SendCommerceOrderRequestPush(41, []);
        $ride = new SendRideRequestPush(73, []);

        self::assertInstanceOf(ShouldBeUnique::class, $commerce);
        self::assertSame('41', $commerce->uniqueId());
        self::assertInstanceOf(ShouldBeUnique::class, $ride);
        self::assertSame('73', $ride->uniqueId());
    }

    public function test_successful_or_exhausted_recipient_records_do_not_start_another_push_chain(): void
    {
        foreach ([CommerceOrderNotificationDelivery::class, RideNotificationDelivery::class] as $modelClass) {
            self::assertFalse((new $modelClass)->forceFill(['push_status' => 'accepted'])->canQueuePush());
            self::assertFalse((new $modelClass)->forceFill([
                'push_status' => 'failed',
                'push_attempts' => 1,
            ])->canQueuePush());
            self::assertTrue((new $modelClass)->forceFill([
                'push_status' => 'failed',
                'push_attempts' => 0,
            ])->canQueuePush());
        }
    }
}
