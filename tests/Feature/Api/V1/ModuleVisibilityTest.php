<?php

namespace Tests\Feature\Api\V1;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ModuleVisibilityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if (!in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('The pdo_sqlite extension is required for the isolated module visibility feature tests.');
        }

        config()->set('database.default', 'module_visibility_test');
        config()->set('database.connections.module_visibility_test', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
        ]);

        DB::purge('module_visibility_test');
        DB::setDefaultConnection('module_visibility_test');
        $this->createEndpointTables();
    }

    public function test_active_ride_hailing_connected_to_requested_zone_is_returned(): void
    {
        $zoneId = $this->insertZone('Requested zone');
        $rideId = $this->insertModule('Ride Hailing', 'ride_hailing', true);
        $this->connectModuleToZone($rideId, $zoneId);

        $this->getJson('/api/v1/module', ['zoneId' => json_encode([$zoneId])])
            ->assertOk()
            ->assertJsonFragment([
                'module_name' => 'Ride Hailing',
                'module_type' => 'ride_hailing',
            ]);
    }

    public function test_active_ride_hailing_not_connected_to_requested_zone_is_not_returned(): void
    {
        $requestedZoneId = $this->insertZone('Requested zone');
        $otherZoneId = $this->insertZone('Other zone');
        $rideId = $this->insertModule('Ride Hailing', 'ride_hailing', true);
        $this->connectModuleToZone($rideId, $otherZoneId);

        $this->getJson('/api/v1/module', ['zoneId' => json_encode([$requestedZoneId])])
            ->assertOk()
            ->assertJsonMissing(['module_type' => 'ride_hailing']);
    }

    public function test_inactive_ride_hailing_connected_to_requested_zone_is_not_returned(): void
    {
        $zoneId = $this->insertZone('Requested zone');
        $rideId = $this->insertModule('Ride Hailing', 'ride_hailing', false);
        $this->connectModuleToZone($rideId, $zoneId);

        $this->getJson('/api/v1/module', ['zoneId' => json_encode([$zoneId])])
            ->assertOk()
            ->assertJsonMissing(['module_type' => 'ride_hailing']);
    }

    public function test_existing_connected_modules_remain_returned(): void
    {
        $zoneId = $this->insertZone('Requested zone');

        foreach (['food', 'grocery', 'parcel'] as $moduleType) {
            $moduleId = $this->insertModule(ucfirst($moduleType), $moduleType, true);
            $this->connectModuleToZone($moduleId, $zoneId);
        }

        $this->getJson('/api/v1/module', ['zoneId' => json_encode([$zoneId])])
            ->assertOk()
            ->assertJsonFragment(['module_type' => 'food'])
            ->assertJsonFragment(['module_type' => 'grocery'])
            ->assertJsonFragment(['module_type' => 'parcel']);
    }

    public function test_request_without_zone_header_keeps_ride_hailing_undiscoverable(): void
    {
        $this->insertModule('Ride Hailing', 'ride_hailing', true);
        $this->insertModule('Food', 'food', true);

        $this->getJson('/api/v1/module')
            ->assertOk()
            ->assertJsonMissing(['module_type' => 'ride_hailing'])
            ->assertJsonFragment(['module_type' => 'food']);
    }

    private function createEndpointTables(): void
    {
        Schema::create('modules', function (Blueprint $table): void {
            $table->id();
            $table->string('module_name');
            $table->string('module_type');
            $table->string('thumbnail')->nullable();
            $table->string('icon')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('theme_id')->default(1);
            $table->boolean('status')->default(true);
            $table->boolean('all_zone_service')->default(false);
            $table->timestamps();
        });

        Schema::create('zones', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('display_name')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('module_zone', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('zone_id');
        });

        Schema::create('items', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('module_id');
        });

        Schema::create('stores', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('module_id');
            $table->unsignedBigInteger('zone_id');
        });

        Schema::create('translations', function (Blueprint $table): void {
            $table->id();
            $table->string('translationable_type');
            $table->unsignedBigInteger('translationable_id');
            $table->string('locale');
            $table->string('key');
            $table->text('value')->nullable();
        });

        Schema::create('storages', function (Blueprint $table): void {
            $table->id();
            $table->string('data_type');
            $table->unsignedBigInteger('data_id');
            $table->string('key');
            $table->string('value')->nullable();
        });
    }

    private function insertZone(string $name): int
    {
        return (int) DB::table('zones')->insertGetId([
            'name' => $name,
            'display_name' => $name,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function insertModule(string $name, string $type, bool $active): int
    {
        return (int) DB::table('modules')->insertGetId([
            'module_name' => $name,
            'module_type' => $type,
            'status' => $active ? 1 : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    private function connectModuleToZone(int $moduleId, int $zoneId): void
    {
        DB::table('module_zone')->insert([
            'module_id' => $moduleId,
            'zone_id' => $zoneId,
        ]);
    }
}
