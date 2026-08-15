<?php

namespace Tests\Feature\Api\V1;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\RideRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use Tests\TestCase;

class RideCustomerRatingTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Ride rating feature tests.');
        }

        config()->set('database.default', 'ride_rating_test');
        config()->set('database.connections.ride_rating_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_rating_test');
        DB::setDefaultConnection('ride_rating_test');
        $this->createTables();
    }

    public function test_completed_owned_ride_rating_is_sanitized_and_idempotently_updated(): void
    {
        $rideId = $this->insertRide(7, RideRequest::STATUS_COMPLETED, 14);

        $first = $this->rate(7, $rideId, ['rating' => 4, 'comment' => '<b>Safe</b>']);
        $second = $this->rate(7, $rideId, ['rating' => 5, 'comment' => 'Professional']);

        self::assertSame(200, $first->getStatusCode());
        self::assertSame(200, $second->getStatusCode());
        self::assertSame(1, DB::table('ride_ratings')->count());
        self::assertDatabaseHas('ride_ratings', [
            'ride_request_id' => $rideId,
            'user_id' => 7,
            'delivery_man_id' => 14,
            'rating' => 5,
            'comment' => 'Professional',
        ]);
    }

    public function test_incomplete_owned_ride_is_rejected(): void
    {
        $rideId = $this->insertRide(7, RideRequest::STATUS_IN_PROGRESS, 14);

        $response = $this->rate(7, $rideId, ['rating' => 5]);

        self::assertSame(403, $response->getStatusCode());
        self::assertSame('rating', $response->getData(true)['errors'][0]['code']);
        self::assertSame(0, DB::table('ride_ratings')->count());
    }

    public function test_completed_unassigned_ride_is_rejected(): void
    {
        $rideId = $this->insertRide(7, RideRequest::STATUS_COMPLETED, null);

        $response = $this->rate(7, $rideId, ['rating' => 5]);

        self::assertSame(403, $response->getStatusCode());
        self::assertSame(0, DB::table('ride_ratings')->count());
    }

    public function test_unowned_ride_is_not_found(): void
    {
        $rideId = $this->insertRide(8, RideRequest::STATUS_COMPLETED, 14);

        $this->expectException(ModelNotFoundException::class);
        $this->rate(7, $rideId, ['rating' => 5]);
    }

    private function rate(int $userId, int $rideId, array $payload)
    {
        $request = Request::create('/api/v1/ride-hailing/customer/rides/'.$rideId.'/rating', 'PUT', $payload);
        $user = new User;
        $user->setRawAttributes(['id' => $userId]);
        $request->setUserResolver(fn () => $user);
        $controller = (new ReflectionClass(CustomerRideController::class))->newInstanceWithoutConstructor();

        return $controller->rate($request, $rideId);
    }

    private function insertRide(int $userId, string $status, ?int $captainId): int
    {
        return (int) DB::table('ride_requests')->insertGetId([
            'user_id' => $userId,
            'delivery_man_id' => $captainId,
            'status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createTables(): void
    {
        Schema::create('ride_requests', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_man_id')->nullable();
            $table->string('status');
            $table->timestamps();
        });
        Schema::create('ride_ratings', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('ride_request_id')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_man_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }
}
