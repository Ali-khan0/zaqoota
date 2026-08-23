<?php

namespace Tests\Feature\Api\V1;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\RideCancellationReason;
use App\Models\RideRequest;
use App\Services\RideCouponService;
use App\Services\RideFareCalculator;
use App\Services\RideSettlementCalculator;
use App\Services\RideTripService;
use App\Services\RideTripStateMachine;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Mockery;
use ReflectionClass;
use Tests\TestCase;

class RideCancellationTransactionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Ride cancellation transaction tests.');
        }

        config()->set('database.default', 'ride_cancellation_transaction_test');
        config()->set('database.connections.ride_cancellation_transaction_test', [
            'driver' => 'sqlite', 'database' => ':memory:', 'prefix' => '', 'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_cancellation_transaction_test');
        DB::setDefaultConnection('ride_cancellation_transaction_test');
        $this->createTables();
    }

    public function test_customer_cancel_rejects_missing_reason_id_with_422(): void
    {
        $request = Request::create('/api/v1/ride-hailing/customer/rides/1', 'DELETE');
        $controller = (new ReflectionClass(CustomerRideController::class))->newInstanceWithoutConstructor();

        $response = $controller->cancel($request, 1);

        self::assertSame(422, $response->getStatusCode());
        self::assertSame('cancellation_reason_id', $response->getData(true)['errors'][0]['code']);
    }

    public function test_searching_cancellation_snapshots_reason_without_fee(): void
    {
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_SEARCHING, 0, null);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame(RideRequest::STATUS_CANCELLED, $cancelled->status);
        self::assertSame(0.0, $cancelled->cancellation_charge_amount);
        self::assertSame('not_required', $cancelled->payment_status);
        self::assertSame($reason->id, $cancelled->cancellation_reason_id);
        self::assertSame($reason->code, $cancelled->cancellation_reason_code);
        self::assertSame($reason->title, $cancelled->cancellation_reason);
    }

    public function test_assigned_customer_cancellation_preserves_fee_and_captain_due(): void
    {
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame(12.50, $cancelled->cancellation_charge_amount);
        self::assertSame(12.50, $cancelled->final_payable_amount);
        self::assertSame(12.50, $cancelled->captain_total_earning_amount);
        self::assertSame('due_next_ride', $cancelled->payment_status);
        self::assertNotNull($cancelled->cancellation_compensation_paid_at);
        self::assertDatabaseHas('delivery_man_wallets', ['delivery_man_id' => 14, 'total_earning' => 12.50]);
        self::assertDatabaseHas('delivery_man_wallet_ledgers', ['delivery_man_id' => 14, 'amount' => 12.50, 'direction' => 'credit']);
        self::assertDatabaseHas('expenses', ['ride_request_id' => $ride->id, 'amount' => 12.50]);
    }

    private function service(): RideTripService
    {
        $coupon = Mockery::mock(RideCouponService::class);
        $coupon->shouldReceive('release')->once();

        return new RideTripService(
            new RideTripStateMachine,
            new RideFareCalculator,
            new RideSettlementCalculator,
            $coupon,
        );
    }

    private function rideAndReason(string $status, float $charge, ?int $captainId): array
    {
        DB::table('users')->insert(['id' => 7, 'f_name' => 'Test', 'l_name' => 'Customer']);
        if ($captainId) {
            DB::table('delivery_men')->insert(['id' => $captainId, 'f_name' => 'Test', 'l_name' => 'Captain']);
        }
        $reasonId = DB::table('ride_cancellation_reasons')->insertGetId([
            'code' => 'plans_changed', 'title' => 'My plans changed', 'user_type' => 'customer',
            'ride_statuses' => json_encode([$status]), 'display_order' => 1, 'status' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $rideId = DB::table('ride_requests')->insertGetId([
            'request_number' => 'RIDE-TEST', 'user_id' => 7, 'delivery_man_id' => $captainId,
            'status' => $status, 'cancellation_charge' => $charge, 'cancellation_charge_amount' => 0,
            'carried_cancellation_due_amount' => 0, 'coupon_discount_amount' => 0,
            'admin_coupon_expense_amount' => 0, 'rider_earning_amount' => 0,
            'platform_commission_amount' => 0, 'captain_total_earning_amount' => 0,
            'final_payable_amount' => 0, 'payment_status' => 'pending',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return [RideRequest::query()->findOrFail($rideId), RideCancellationReason::query()->findOrFail($reasonId)];
    }

    private function createTables(): void
    {
        Schema::create('ride_cancellation_reasons', function (Blueprint $table): void {
            $table->id(); $table->string('code'); $table->string('title'); $table->string('user_type');
            $table->json('ride_statuses'); $table->unsignedInteger('display_order'); $table->boolean('status'); $table->timestamps();
        });
        Schema::create('ride_requests', function (Blueprint $table): void {
            $table->id(); $table->string('request_number'); $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_man_id')->nullable(); $table->unsignedBigInteger('ride_category_id')->nullable();
            $table->unsignedBigInteger('ride_vehicle_id')->nullable(); $table->string('status');
            $table->decimal('cancellation_charge', 12, 2)->default(0); $table->decimal('cancellation_charge_amount', 12, 2)->default(0);
            $table->unsignedBigInteger('cancellation_reason_id')->nullable(); $table->string('cancellation_reason_code')->nullable();
            $table->string('cancellation_reason_user_type')->nullable(); $table->string('cancellation_reason')->nullable();
            $table->string('cancelled_by')->nullable(); $table->timestamp('cancelled_at')->nullable();
            $table->decimal('carried_cancellation_due_amount', 12, 2)->default(0); $table->decimal('coupon_discount_amount', 12, 2)->default(0);
            $table->decimal('admin_coupon_expense_amount', 12, 2)->default(0); $table->decimal('rider_earning_amount', 12, 2)->default(0);
            $table->decimal('platform_commission_amount', 12, 2)->default(0); $table->decimal('captain_total_earning_amount', 12, 2)->default(0);
            $table->decimal('final_payable_amount', 12, 2)->default(0); $table->string('payment_status')->nullable();
            $table->timestamp('cancellation_compensation_paid_at')->nullable(); $table->unsignedBigInteger('recovery_ride_id')->nullable();
            $table->timestamp('cancellation_recovered_at')->nullable(); $table->timestamps();
        });
        Schema::create('ride_status_histories', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('ride_request_id'); $table->string('from_status')->nullable();
            $table->string('to_status'); $table->string('actor_type'); $table->unsignedBigInteger('actor_id')->nullable();
            $table->text('note')->nullable(); $table->json('metadata')->nullable(); $table->timestamps();
        });
        Schema::create('ride_offers', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('ride_request_id'); $table->string('status'); $table->timestamps();
        });
        Schema::create('delivery_man_wallets', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('delivery_man_id')->unique(); $table->decimal('total_earning', 12, 2)->default(0);
            $table->decimal('total_withdrawn', 12, 2)->default(0); $table->decimal('pending_withdraw', 12, 2)->default(0);
            $table->decimal('collected_cash', 12, 2)->default(0); $table->timestamps();
        });
        Schema::create('delivery_man_wallet_ledgers', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('delivery_man_id'); $table->string('transaction_type');
            $table->string('reference'); $table->decimal('amount', 12, 2); $table->string('direction'); $table->json('meta')->nullable(); $table->timestamps();
        });
        Schema::create('expenses', function (Blueprint $table): void {
            $table->id(); $table->decimal('amount', 12, 2); $table->string('type'); $table->unsignedBigInteger('ride_request_id')->nullable();
            $table->string('created_by')->nullable(); $table->unsignedBigInteger('user_id')->nullable(); $table->text('description')->nullable(); $table->timestamps();
        });
        Schema::create('users', function (Blueprint $table): void { $table->id(); $table->string('f_name')->nullable(); $table->string('l_name')->nullable(); $table->timestamps(); });
        Schema::create('delivery_men', function (Blueprint $table): void { $table->id(); $table->string('f_name')->nullable(); $table->string('l_name')->nullable(); $table->timestamps(); });
        Schema::create('translations', function (Blueprint $table): void { $table->id(); $table->string('translationable_type'); $table->unsignedBigInteger('translationable_id'); $table->string('locale'); $table->string('key'); $table->text('value')->nullable(); });
        Schema::create('ride_coupon_usages', function (Blueprint $table): void { $table->id(); $table->unsignedBigInteger('ride_request_id'); $table->string('status'); $table->timestamps(); });
    }
}
