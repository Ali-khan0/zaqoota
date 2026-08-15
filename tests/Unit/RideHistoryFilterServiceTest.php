<?php

namespace Tests\Unit;

use App\Models\RideRequest;
use App\Services\RideHistoryFilterService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RideHistoryFilterServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Ride history filter tests.');
        }

        config()->set('database.default', 'ride_history_test');
        config()->set('database.connections.ride_history_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_history_test');
        DB::setDefaultConnection('ride_history_test');
        Schema::create('ride_requests', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->timestamps();
        });
    }

    public function test_filters_remain_customer_scoped_and_newest_first(): void
    {
        $this->insertRide(7, RideRequest::STATUS_COMPLETED, '2026-08-10 10:00:00');
        $newestOwned = $this->insertRide(7, RideRequest::STATUS_COMPLETED, '2026-08-20 10:00:00');
        $this->insertRide(7, RideRequest::STATUS_CANCELLED, '2026-08-21 10:00:00');
        $this->insertRide(8, RideRequest::STATUS_COMPLETED, '2026-08-22 10:00:00');

        $query = RideRequest::query()->where('user_id', 7);
        $rides = (new RideHistoryFilterService)->apply($query, [
            'status' => RideRequest::STATUS_COMPLETED,
            'from' => '2026-08-15',
            'to' => '2026-08-31',
        ])->latest()->get();

        self::assertSame([$newestOwned], $rides->pluck('id')->all());
    }

    private function insertRide(int $userId, string $status, string $createdAt): int
    {
        return (int) DB::table('ride_requests')->insertGetId([
            'user_id' => $userId,
            'status' => $status,
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);
    }
}
