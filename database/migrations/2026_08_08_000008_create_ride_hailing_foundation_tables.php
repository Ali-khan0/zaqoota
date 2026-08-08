<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('delivery_men', 'work_mode')) {
            Schema::table('delivery_men', function (Blueprint $table) {
                $table->string('work_mode', 20)->default('delivery')->index();
            });
        }

        if (!Schema::hasTable('ride_vehicle_types')) {
            Schema::create('ride_vehicle_types', function (Blueprint $table) {
                $table->id();
                $table->string('name', 80);
                $table->string('slug', 80)->unique();
                $table->boolean('status')->default(true);
                $table->unsignedSmallInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ride_categories')) {
            Schema::create('ride_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ride_vehicle_type_id')->constrained('ride_vehicle_types')->restrictOnDelete();
                $table->string('name', 100);
                $table->string('slug', 100)->unique();
                $table->string('fuel_type', 20)->nullable();
                $table->unsignedTinyInteger('passenger_capacity')->default(1);
                $table->boolean('status')->default(true);
                $table->unsignedSmallInteger('sort_order')->default(0);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('ride_vehicles')) {
            Schema::create('ride_vehicles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
                $table->foreignId('ride_vehicle_type_id')->constrained('ride_vehicle_types')->restrictOnDelete();
                $table->foreignId('ride_category_id')->constrained('ride_categories')->restrictOnDelete();
                $table->string('fuel_type', 20);
                $table->string('make', 100);
                $table->string('model', 100);
                $table->unsignedSmallInteger('model_year')->nullable();
                $table->string('color', 50);
                $table->string('registration_number', 80)->unique();
                $table->string('status', 20)->default('pending');
                $table->boolean('is_active')->default(false);
                $table->text('admin_note')->nullable();
                $table->timestamps();

                $table->index(['delivery_man_id', 'status', 'is_active'], 'ride_vehicle_rider_status_active_idx');
            });
        }

        if (!Schema::hasTable('ride_fares')) {
            Schema::create('ride_fares', function (Blueprint $table) {
                $table->id();
                $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
                $table->foreignId('ride_category_id')->constrained('ride_categories')->cascadeOnDelete();
                $table->decimal('base_fare', 12, 2)->default(0);
                $table->decimal('minimum_fare', 12, 2)->default(0);
                $table->decimal('per_km_charge', 12, 2)->default(0);
                $table->decimal('per_minute_charge', 12, 2)->default(0);
                $table->decimal('pickup_distance_charge', 12, 2)->default(0);
                $table->decimal('waiting_charge_per_minute', 12, 2)->default(0);
                $table->unsignedSmallInteger('free_waiting_minutes')->default(3);
                $table->decimal('cancellation_charge', 12, 2)->default(0);
                $table->decimal('platform_commission_percent', 5, 2)->default(0);
                $table->decimal('negotiation_min_percent', 6, 2)->default(100);
                $table->decimal('negotiation_max_percent', 6, 2)->default(100);
                $table->unsignedSmallInteger('offer_expiry_seconds')->default(30);
                $table->boolean('status')->default(true);
                $table->timestamps();

                $table->unique(['zone_id', 'ride_category_id'], 'ride_fare_zone_category_unique');
            });
        }

        $types = [
            ['name' => 'Bike', 'slug' => 'bike', 'sort_order' => 1],
            ['name' => 'Car', 'slug' => 'car', 'sort_order' => 2],
            ['name' => 'Rickshaw', 'slug' => 'rickshaw', 'sort_order' => 3],
        ];
        foreach ($types as $type) {
            DB::table('ride_vehicle_types')->updateOrInsert(['slug' => $type['slug']], [
                ...$type, 'status' => true, 'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        $typeIds = DB::table('ride_vehicle_types')->pluck('id', 'slug');
        $categories = [
            ['type' => 'bike', 'name' => 'Petrol Bike', 'slug' => 'petrol-bike', 'fuel_type' => 'petrol', 'passenger_capacity' => 1, 'sort_order' => 1],
            ['type' => 'bike', 'name' => 'EV Bike', 'slug' => 'ev-bike', 'fuel_type' => 'electric', 'passenger_capacity' => 1, 'sort_order' => 2],
            ['type' => 'car', 'name' => 'Economy', 'slug' => 'economy', 'fuel_type' => null, 'passenger_capacity' => 4, 'sort_order' => 3],
            ['type' => 'car', 'name' => 'Business', 'slug' => 'business', 'fuel_type' => null, 'passenger_capacity' => 4, 'sort_order' => 4],
            ['type' => 'car', 'name' => 'Luxury', 'slug' => 'luxury', 'fuel_type' => null, 'passenger_capacity' => 4, 'sort_order' => 5],
            ['type' => 'rickshaw', 'name' => 'Rickshaw', 'slug' => 'rickshaw', 'fuel_type' => null, 'passenger_capacity' => 3, 'sort_order' => 6],
        ];
        foreach ($categories as $category) {
            DB::table('ride_categories')->updateOrInsert(['slug' => $category['slug']], [
                'ride_vehicle_type_id' => $typeIds[$category['type']],
                'name' => $category['name'],
                'fuel_type' => $category['fuel_type'],
                'passenger_capacity' => $category['passenger_capacity'],
                'sort_order' => $category['sort_order'],
                'status' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_fares');
        Schema::dropIfExists('ride_vehicles');
        Schema::dropIfExists('ride_categories');
        Schema::dropIfExists('ride_vehicle_types');
        if (Schema::hasColumn('delivery_men', 'work_mode')) {
            Schema::table('delivery_men', fn (Blueprint $table) => $table->dropColumn('work_mode'));
        }
    }
};
