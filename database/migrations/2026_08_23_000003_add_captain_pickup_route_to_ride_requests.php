<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->text('captain_pickup_route_polyline')->nullable();
            $table->unsignedInteger('captain_pickup_route_distance_meters')->nullable();
            $table->unsignedInteger('captain_pickup_route_duration_seconds')->nullable();
            $table->decimal('captain_pickup_route_origin_latitude', 10, 7)->nullable();
            $table->decimal('captain_pickup_route_origin_longitude', 10, 7)->nullable();
            $table->timestamp('captain_pickup_route_generated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->dropColumn([
                'captain_pickup_route_polyline',
                'captain_pickup_route_distance_meters',
                'captain_pickup_route_duration_seconds',
                'captain_pickup_route_origin_latitude',
                'captain_pickup_route_origin_longitude',
                'captain_pickup_route_generated_at',
            ]);
        });
    }
};
