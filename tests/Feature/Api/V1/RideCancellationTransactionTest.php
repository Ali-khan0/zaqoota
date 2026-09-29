<?php

namespace Tests\Feature\Api\V1;

use App\Http\Controllers\Api\V1\CustomerRideController;
use App\Models\RideCancellationReason;
use App\Models\RideRequest;
use App\Models\User;
use App\Services\RideCouponService;
use App\Services\RideCancellationPolicyService;
use App\Services\RideCancellationReceivableService;
use App\Services\RidePrepaymentCancellationService;
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
use ReflectionMethod;
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

    public function test_progress_qualified_cancellation_records_due_without_admin_advance(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '30',
        ]);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame(12.50, $cancelled->cancellation_charge_amount);
        self::assertSame(12.50, $cancelled->final_payable_amount);
        self::assertSame(12.50, $cancelled->captain_total_earning_amount);
        self::assertSame('due_next_ride', $cancelled->payment_status);
        self::assertNull($cancelled->cancellation_compensation_paid_at);
        self::assertSame(40.0, $cancelled->cancellation_pickup_progress_percent);
        self::assertSame('pickup_progress_threshold_met', $cancelled->cancellation_charge_rule);
        self::assertDatabaseMissing('delivery_man_wallets', ['delivery_man_id' => 14]);
        self::assertDatabaseMissing('expenses', ['ride_request_id' => $ride->id]);
        self::assertDatabaseHas('ride_cancellation_receivables', [
            'ride_request_id' => $ride->id,
            'delivery_man_id' => 14,
            'amount' => 12.50,
            'status' => 'pending',
        ]);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 1]);
    }

    public function test_disabled_cancellation_charging_creates_no_charge_or_strike(): void
    {
        $this->settings(['ride_hailing_cancellation_charge_enabled' => '0']);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame(0.0, $cancelled->cancellation_charge_amount);
        self::assertSame('disabled', $cancelled->cancellation_charge_rule);
        self::assertSame(0.0, (float) $cancelled->final_payable_amount);
        self::assertSame(0.0, (float) $cancelled->captain_total_earning_amount);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 0]);
        self::assertDatabaseMissing('ride_cancellation_receivables', ['ride_request_id' => $ride->id]);
        self::assertDatabaseMissing('delivery_man_wallets', ['delivery_man_id' => 14]);
    }

    public function test_disabling_new_charges_preserves_historical_due_and_receivable(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '0',
        ]);
        [$historicalRide, $historicalReason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        DB::transaction(fn () => $this->service()->cancel($historicalRide, 'customer', 7, $historicalReason));

        $this->settings(['ride_hailing_cancellation_charge_enabled' => '0']);
        [$newRide, $newReason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 25, 14);
        $newCancellation = DB::transaction(fn () => $this->service()->cancel($newRide, 'customer', 7, $newReason));

        self::assertSame(0.0, (float) $newCancellation->cancellation_charge_amount);
        self::assertSame(12.50, (float) $historicalRide->fresh()->cancellation_charge_amount);
        self::assertDatabaseHas('ride_cancellation_receivables', [
            'ride_request_id' => $historicalRide->id,
            'amount' => 12.50,
            'status' => 'pending',
        ]);
        self::assertDatabaseMissing('ride_cancellation_receivables', ['ride_request_id' => $newRide->id]);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 1]);

        $controller = (new ReflectionClass(CustomerRideController::class))->newInstanceWithoutConstructor();
        $previousDue = new ReflectionMethod(CustomerRideController::class, 'previousCancellationDue');
        self::assertSame(12.50, $previousDue->invoke($controller, 7));
    }

    public function test_disabling_new_charges_does_not_clear_an_active_cooldown(): void
    {
        $this->settings(['ride_hailing_cancellation_charge_enabled' => '0']);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        $blockedUntil = now()->addMinutes(30)->startOfSecond();
        DB::table('users')->where('id', 7)->update([
            'ride_cancellation_strikes' => 0,
            'ride_booking_blocked_until' => $blockedUntil,
        ]);

        DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        $user = User::query()->withoutGlobalScopes()->findOrFail(7);
        $block = (new RideCancellationPolicyService)->blockData($user);
        self::assertTrue($block['booking_blocked']);
        self::assertGreaterThan(0, $block['cooldown_seconds']);
        self::assertSame($blockedUntil->toIso8601String(), $block['blocked_until']);
    }

    public function test_cancellation_below_pickup_progress_threshold_is_not_charged(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '50',
        ]);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame(0.0, $cancelled->cancellation_charge_amount);
        self::assertSame('pickup_progress_below_threshold', $cancelled->cancellation_charge_rule);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 0]);
    }

    public function test_second_charged_cancellation_starts_configured_cooldown(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '30',
            'ride_hailing_cancellation_strike_limit' => '2',
            'ride_hailing_cancellation_strike_window_hours' => '24',
            'ride_hailing_cancellation_temporary_block_enabled' => '1',
            'ride_hailing_cancellation_cooldown_minutes' => '60',
        ]);
        [$firstRide, $firstReason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        DB::transaction(fn () => $this->service()->cancel($firstRide, 'customer', 7, $firstReason));
        [$secondRide, $secondReason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);

        DB::transaction(fn () => $this->service()->cancel($secondRide, 'customer', 7, $secondReason));

        $user = DB::table('users')->where('id', 7)->first();
        self::assertSame(0, (int) $user->ride_cancellation_strikes);
        self::assertNotNull($user->ride_booking_blocked_until);
        self::assertTrue(now()->diffInMinutes($user->ride_booking_blocked_until) >= 59);
    }

    public function test_collected_receivable_credits_original_captain_exactly_once(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '30',
        ]);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));
        $receivables = new RideCancellationReceivableService;

        $first = DB::transaction(fn () => $receivables->clear(
            $cancelled->fresh(),
            $cancelled->fresh(),
            'direct_payment',
            'digital',
        ));
        $replay = DB::transaction(fn () => $receivables->clear(
            $cancelled->fresh(),
            $cancelled->fresh(),
            'direct_payment',
            'digital',
        ));

        self::assertTrue($first);
        self::assertFalse($replay);
        self::assertDatabaseHas('delivery_man_wallets', ['delivery_man_id' => 14, 'total_earning' => 12.50]);
        self::assertSame(1, DB::table('delivery_man_wallet_ledgers')
            ->where('delivery_man_id', 14)
            ->where('transaction_type', 'ride_cancellation_earning')
            ->count());
        self::assertDatabaseHas('ride_cancellation_receivables', [
            'ride_request_id' => $ride->id,
            'status' => 'cleared',
            'collection_source' => 'direct_payment',
            'collection_method' => 'digital',
        ]);
    }

    public function test_online_prepayment_cancellation_allocates_charge_and_refunds_wallet_once(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '30',
        ]);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        DB::table('ride_payments')->insert([
            'ride_request_id' => $ride->id,
            'user_id' => 7,
            'delivery_man_id' => 14,
            'amount' => 100,
            'payment_method' => 'digital',
            'purpose' => 'ride_prepayment',
            'status' => 'paid',
            'paid_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));
        $receivables = new RideCancellationReceivableService;
        $replayed = DB::transaction(fn () => (new RidePrepaymentCancellationService($receivables))
            ->refund($cancelled->fresh(), 12.50));

        self::assertSame('recovered', $cancelled->payment_status);
        self::assertDatabaseHas('ride_cancellation_refunds', [
            'ride_request_id' => $ride->id,
            'paid_amount' => 100,
            'cancellation_allocated_amount' => 12.50,
            'wallet_refund_amount' => 87.50,
            'status' => 'completed',
        ]);
        self::assertDatabaseHas('users', ['id' => 7, 'wallet_balance' => 87.50]);
        self::assertDatabaseHas('delivery_man_wallets', ['delivery_man_id' => 14, 'total_earning' => 12.50]);
        self::assertSame(1, DB::table('wallet_transactions')
            ->where('user_id', 7)
            ->where('transaction_type', 'ride_cancellation_refund')
            ->count());
        self::assertSame(87.50, (float) $replayed->wallet_refund_amount);
        self::assertSame(87.50, (float) DB::table('users')->where('id', 7)->value('wallet_balance'));
    }

    public function test_online_prepayment_is_fully_refunded_when_charge_is_disabled(): void
    {
        $this->settings(['ride_hailing_cancellation_charge_enabled' => '0']);
        [$ride, $reason] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 12.50, 14);
        DB::table('ride_payments')->insert([
            'ride_request_id' => $ride->id,
            'user_id' => 7,
            'delivery_man_id' => 14,
            'amount' => 100,
            'payment_method' => 'digital',
            'purpose' => 'ride_prepayment',
            'status' => 'paid',
            'paid_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'customer', 7, $reason));

        self::assertSame('refunded', $cancelled->payment_status);
        self::assertDatabaseHas('ride_cancellation_refunds', [
            'ride_request_id' => $ride->id,
            'paid_amount' => 100,
            'cancellation_allocated_amount' => 0,
            'wallet_refund_amount' => 100,
            'status' => 'completed',
        ]);
        self::assertDatabaseHas('users', ['id' => 7, 'wallet_balance' => 100]);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 0]);
        self::assertDatabaseMissing('ride_cancellation_receivables', ['ride_request_id' => $ride->id]);
        self::assertDatabaseMissing('delivery_man_wallets', ['delivery_man_id' => 14]);
        self::assertSame(1, DB::table('wallet_transactions')
            ->where('user_id', 7)
            ->where('transaction_type', 'ride_cancellation_refund')
            ->where('credit', 100)
            ->count());
    }

    public function test_captain_cancellation_is_terminal_free_and_releases_pending_offers(): void
    {
        $this->settings([
            'ride_hailing_cancellation_charge_enabled' => '1',
            'ride_hailing_cancellation_progress_enabled' => '0',
            'ride_hailing_cancellation_charge_amount' => '25',
        ]);
        [$ride] = $this->rideAndReason(RideRequest::STATUS_CAPTAIN_ARRIVING, 25, 14);
        $reason = RideCancellationReason::query()->create([
            'code' => 'captain_unavailable',
            'title' => 'Captain unavailable',
            'user_type' => 'captain',
            'ride_statuses' => [RideRequest::STATUS_CAPTAIN_ARRIVING],
            'display_order' => 1,
            'status' => true,
        ]);
        DB::table('ride_offers')->insert([
            'ride_request_id' => $ride->id,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('ride_payments')->insert([
            'ride_request_id' => $ride->id,
            'user_id' => 7,
            'delivery_man_id' => 14,
            'amount' => 100,
            'payment_method' => 'digital',
            'purpose' => 'ride_prepayment',
            'status' => 'paid',
            'paid_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $cancelled = DB::transaction(fn () => $this->service()->cancel($ride, 'captain', 14, $reason));

        self::assertSame(RideRequest::STATUS_CANCELLED, $cancelled->status);
        self::assertSame('captain', $cancelled->cancelled_by);
        self::assertSame(0.0, $cancelled->cancellation_charge_amount);
        self::assertSame('actor_not_chargeable', $cancelled->cancellation_charge_rule);
        self::assertSame('refunded', $cancelled->payment_status);
        self::assertDatabaseHas('ride_offers', [
            'ride_request_id' => $ride->id,
            'status' => 'rejected',
        ]);
        self::assertDatabaseMissing('ride_cancellation_receivables', ['ride_request_id' => $ride->id]);
        self::assertDatabaseMissing('delivery_man_wallets', ['delivery_man_id' => 14]);
        self::assertDatabaseHas('ride_cancellation_refunds', [
            'ride_request_id' => $ride->id,
            'cancellation_allocated_amount' => 0,
            'wallet_refund_amount' => 100,
        ]);
        self::assertDatabaseHas('users', ['id' => 7, 'wallet_balance' => 100]);
        self::assertDatabaseHas('users', ['id' => 7, 'ride_cancellation_strikes' => 0]);
    }

    private function service(): RideTripService
    {
        $coupon = Mockery::mock(RideCouponService::class);
        $coupon->shouldReceive('release')->once();

        $receivables = new RideCancellationReceivableService;

        return new RideTripService(
            new RideTripStateMachine,
            new RideFareCalculator,
            new RideSettlementCalculator,
            $coupon,
            new RideCancellationPolicyService,
            $receivables,
            new RidePrepaymentCancellationService($receivables),
        );
    }

    private function rideAndReason(string $status, float $charge, ?int $captainId): array
    {
        DB::table('users')->insertOrIgnore(['id' => 7, 'f_name' => 'Test', 'l_name' => 'Customer']);
        if ($captainId) {
            DB::table('delivery_men')->insertOrIgnore(['id' => $captainId, 'f_name' => 'Test', 'l_name' => 'Captain']);
        }
        $reasonId = DB::table('ride_cancellation_reasons')->insertGetId([
            'code' => 'plans_changed', 'title' => 'My plans changed', 'user_type' => 'customer',
            'ride_statuses' => json_encode([$status]), 'display_order' => 1, 'status' => 1,
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $rideId = DB::table('ride_requests')->insertGetId([
            'request_number' => 'RIDE-TEST', 'user_id' => 7, 'delivery_man_id' => $captainId,
            'status' => $status, 'cancellation_charge' => $charge, 'cancellation_charge_amount' => 0,
            'captain_pickup_progress_percent' => $captainId ? 40 : null,
            'carried_cancellation_due_amount' => 0, 'coupon_discount_amount' => 0,
            'admin_coupon_expense_amount' => 0, 'rider_earning_amount' => 0,
            'platform_commission_amount' => 0, 'captain_total_earning_amount' => 0,
            'final_payable_amount' => 0, 'payment_status' => 'pending',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        return [RideRequest::query()->findOrFail($rideId), RideCancellationReason::query()->findOrFail($reasonId)];
    }

    private function settings(array $values): void
    {
        foreach ($values as $key => $value) {
            DB::table('business_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'created_at' => now(), 'updated_at' => now()],
            );
        }
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
            $table->decimal('captain_pickup_progress_percent', 5, 2)->nullable(); $table->decimal('cancellation_pickup_progress_percent', 5, 2)->nullable();
            $table->string('cancellation_charge_rule')->nullable();
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
        Schema::create('ride_cancellation_receivables', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('ride_request_id')->unique(); $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_man_id'); $table->decimal('amount', 12, 2); $table->string('status');
            $table->unsignedBigInteger('collection_ride_id')->nullable(); $table->string('collection_source')->nullable();
            $table->string('collection_method')->nullable(); $table->timestamp('cleared_at')->nullable(); $table->timestamps();
        });
        Schema::create('ride_cancellation_refunds', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('ride_request_id')->unique(); $table->unsignedBigInteger('user_id');
            $table->decimal('paid_amount', 12, 2); $table->decimal('cancellation_allocated_amount', 12, 2)->default(0);
            $table->decimal('wallet_refund_amount', 12, 2)->default(0); $table->uuid('wallet_transaction_id')->nullable()->unique();
            $table->string('status'); $table->timestamp('completed_at'); $table->timestamps();
        });
        Schema::create('ride_payments', function (Blueprint $table): void {
            $table->id(); $table->unsignedBigInteger('ride_request_id'); $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('delivery_man_id')->nullable(); $table->decimal('amount', 12, 2);
            $table->string('payment_method'); $table->string('payment_gateway')->nullable(); $table->string('status');
            $table->string('purpose')->default('ride_payment');
            $table->timestamp('paid_at')->nullable(); $table->timestamp('failed_at')->nullable();
            $table->timestamp('admin_received_at')->nullable(); $table->timestamps();
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
        Schema::create('users', function (Blueprint $table): void { $table->id(); $table->string('f_name')->nullable(); $table->string('l_name')->nullable(); $table->decimal('wallet_balance', 12, 2)->default(0); $table->unsignedSmallInteger('ride_cancellation_strikes')->default(0); $table->timestamp('ride_cancellation_last_strike_at')->nullable(); $table->timestamp('ride_booking_blocked_until')->nullable(); $table->timestamps(); });
        Schema::create('delivery_men', function (Blueprint $table): void { $table->id(); $table->string('f_name')->nullable(); $table->string('l_name')->nullable(); $table->timestamps(); });
        Schema::create('storages', function (Blueprint $table): void { $table->id(); $table->string('data_type'); $table->string('data_id', 100)->index(); $table->string('key')->nullable(); $table->string('value', 50); $table->timestamps(); });
        Schema::create('translations', function (Blueprint $table): void { $table->id(); $table->string('translationable_type'); $table->unsignedBigInteger('translationable_id'); $table->string('locale'); $table->string('key'); $table->text('value')->nullable(); });
        Schema::create('ride_coupon_usages', function (Blueprint $table): void { $table->id(); $table->unsignedBigInteger('ride_request_id'); $table->string('status'); $table->timestamps(); });
        Schema::create('wallet_transactions', function (Blueprint $table): void { $table->id(); $table->unsignedBigInteger('user_id'); $table->uuid('transaction_id')->unique(); $table->string('reference')->nullable(); $table->string('transaction_type'); $table->decimal('credit', 12, 2)->default(0); $table->decimal('debit', 12, 2)->default(0); $table->decimal('admin_bonus', 12, 2)->default(0); $table->decimal('balance', 12, 2)->default(0); $table->timestamps(); });
        Schema::create('business_settings', function (Blueprint $table): void { $table->id(); $table->string('key')->unique(); $table->text('value')->nullable(); $table->timestamps(); });
    }
}
