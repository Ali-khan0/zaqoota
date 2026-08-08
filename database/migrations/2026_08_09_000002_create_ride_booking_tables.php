<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_requests')) {
            Schema::create('ride_requests', function (Blueprint $table) {
                $table->id();
                $table->string('request_number', 40)->nullable()->unique();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('zone_id')->constrained('zones')->restrictOnDelete();
                $table->foreignId('ride_category_id')->constrained('ride_categories')->restrictOnDelete();
                $table->foreignId('ride_fare_id')->nullable()->constrained('ride_fares')->nullOnDelete();
                $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_men')->nullOnDelete();
                $table->foreignId('ride_vehicle_id')->nullable()->constrained('ride_vehicles')->nullOnDelete();
                $table->unsignedBigInteger('accepted_offer_id')->nullable()->index();
                $table->string('status', 30)->default('searching');
                $table->string('pickup_address', 500);
                $table->decimal('pickup_latitude', 10, 7);
                $table->decimal('pickup_longitude', 10, 7);
                $table->string('destination_address', 500);
                $table->decimal('destination_latitude', 10, 7);
                $table->decimal('destination_longitude', 10, 7);
                $table->unsignedInteger('distance_meters');
                $table->unsignedInteger('duration_seconds');
                $table->text('route_polyline')->nullable();
                $table->decimal('base_fare', 12, 2);
                $table->decimal('minimum_fare', 12, 2);
                $table->decimal('per_km_charge', 12, 2);
                $table->decimal('per_minute_charge', 12, 2);
                $table->decimal('waiting_charge_per_minute', 12, 2);
                $table->unsignedSmallInteger('free_waiting_minutes');
                $table->decimal('cancellation_charge', 12, 2);
                $table->decimal('platform_commission_percent', 5, 2);
                $table->decimal('suggested_fare', 12, 2);
                $table->decimal('minimum_negotiated_fare', 12, 2);
                $table->decimal('maximum_negotiated_fare', 12, 2);
                $table->decimal('customer_offer', 12, 2);
                $table->decimal('final_accepted_fare', 12, 2)->nullable();
                $table->decimal('platform_commission_amount', 12, 2)->nullable();
                $table->decimal('rider_earning_amount', 12, 2)->nullable();
                $table->unsignedSmallInteger('offer_expiry_seconds');
                $table->timestamp('selected_at')->nullable();
                $table->timestamps();

                $table->index(['user_id', 'status']);
                $table->index(['zone_id', 'ride_category_id', 'status'], 'ride_request_matching_idx');
                $table->index(['delivery_man_id', 'status']);
            });
        }

        if (! Schema::hasTable('ride_offers')) {
            Schema::create('ride_offers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
                $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
                $table->foreignId('ride_vehicle_id')->constrained('ride_vehicles')->restrictOnDelete();
                $table->decimal('amount', 12, 2);
                $table->string('status', 20)->default('pending');
                $table->timestamp('expires_at');
                $table->timestamps();

                $table->unique(['ride_request_id', 'delivery_man_id'], 'ride_offer_request_rider_unique');
                $table->index(['ride_request_id', 'status', 'expires_at'], 'ride_offer_active_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_offers');
        Schema::dropIfExists('ride_requests');
    }
};
