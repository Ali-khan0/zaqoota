<?php

namespace Tests\Feature\Api\V1;

use App\Models\RideCancellationReason;
use App\Services\RideCancellationReasonService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class RideCancellationReasonFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (! in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for isolated Ride cancellation reason feature tests.');
        }

        config()->set('database.default', 'ride_cancellation_reason_test');
        config()->set('database.connections.ride_cancellation_reason_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ]);
        DB::purge('ride_cancellation_reason_test');
        DB::setDefaultConnection('ride_cancellation_reason_test');
        $this->createTables();
    }

    public function test_available_reasons_are_active_actor_status_scoped_and_ordered(): void
    {
        $second = $this->insertReason('second', 'customer', ['searching'], true, 20);
        $first = $this->insertReason('first', 'customer', ['searching', 'negotiating'], true, 10);
        $this->insertReason('inactive', 'customer', ['searching'], false, 1);
        $this->insertReason('wrong_actor', 'captain', ['searching'], true, 1);
        $this->insertReason('wrong_status', 'customer', ['arrived'], true, 1);

        $reasons = app(RideCancellationReasonService::class)->available('customer', 'searching');

        self::assertSame([$first, $second], $reasons->pluck('id')->all());
    }

    public function test_localized_title_uses_request_locale_with_canonical_fallback(): void
    {
        $id = $this->insertReason('plans_changed', 'customer', ['searching'], true, 10, 'My plans changed');
        DB::table('translations')->insert([
            'translationable_type' => RideCancellationReason::class,
            'translationable_id' => $id,
            'locale' => 'ur',
            'key' => 'title',
            'value' => 'میرے منصوبے بدل گئے',
        ]);
        app()->setLocale('ur');

        $reason = app(RideCancellationReasonService::class)->available('customer', 'searching')->first();

        self::assertSame('میرے منصوبے بدل گئے', $reason->title);
    }

    public function test_wrong_actor_or_lifecycle_reason_cannot_be_resolved(): void
    {
        $captain = $this->insertReason('captain_reason', 'captain', ['searching'], true, 1);
        $customer = $this->insertReason('customer_reason', 'customer', ['arrived'], true, 2);
        $service = app(RideCancellationReasonService::class);

        self::assertNull($service->resolve($captain, 'customer', 'searching'));
        self::assertNull($service->resolve($customer, 'customer', 'searching'));
        self::assertNotNull($service->resolve($customer, 'customer', 'arrived'));
    }

    private function insertReason(string $code, string $actor, array $statuses, bool $active, int $order, ?string $title = null): int
    {
        return (int) DB::table('ride_cancellation_reasons')->insertGetId([
            'code' => $code,
            'title' => $title ?? ucfirst(str_replace('_', ' ', $code)),
            'user_type' => $actor,
            'ride_statuses' => json_encode($statuses),
            'display_order' => $order,
            'status' => $active,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function createTables(): void
    {
        Schema::create('ride_cancellation_reasons', function (Blueprint $table): void {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->string('user_type');
            $table->json('ride_statuses');
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
        Schema::create('translations', function (Blueprint $table): void {
            $table->id();
            $table->string('translationable_type');
            $table->unsignedBigInteger('translationable_id');
            $table->string('locale');
            $table->string('key');
            $table->text('value')->nullable();
        });
    }
}
