<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedSmallInteger('ride_cancellation_strikes')->default(0);
            $table->timestamp('ride_cancellation_last_strike_at')->nullable();
            $table->timestamp('ride_booking_blocked_until')->nullable()->index();
        });

        Schema::table('ride_requests', function (Blueprint $table) {
            $table->unsignedInteger('captain_pickup_initial_distance_meters')->nullable();
            $table->decimal('captain_pickup_progress_percent', 5, 2)->nullable();
            $table->decimal('cancellation_pickup_progress_percent', 5, 2)->nullable();
            $table->string('cancellation_charge_rule', 40)->nullable();
        });

        $defaults = [
            'ride_hailing_cancellation_charge_enabled' => '0',
            'ride_hailing_cancellation_charge_amount' => '0',
            'ride_hailing_cancellation_progress_enabled' => '1',
            'ride_hailing_cancellation_progress_threshold_percent' => '30',
            'ride_hailing_cancellation_strike_limit' => '2',
            'ride_hailing_cancellation_strike_window_hours' => '24',
            'ride_hailing_cancellation_temporary_block_enabled' => '1',
            'ride_hailing_cancellation_cooldown_minutes' => '60',
        ];
        foreach ($defaults as $key => $value) {
            DB::table('business_settings')->insertOrIgnore([
                'key' => $key,
                'value' => $value,
                'updated_at' => now(),
                'created_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->dropColumn([
                'captain_pickup_initial_distance_meters',
                'captain_pickup_progress_percent',
                'cancellation_pickup_progress_percent',
                'cancellation_charge_rule',
            ]);
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'ride_cancellation_strikes',
                'ride_cancellation_last_strike_at',
                'ride_booking_blocked_until',
            ]);
        });

        DB::table('business_settings')->whereIn('key', [
            'ride_hailing_cancellation_charge_enabled',
            'ride_hailing_cancellation_charge_amount',
            'ride_hailing_cancellation_progress_enabled',
            'ride_hailing_cancellation_progress_threshold_percent',
            'ride_hailing_cancellation_strike_limit',
            'ride_hailing_cancellation_strike_window_hours',
            'ride_hailing_cancellation_temporary_block_enabled',
            'ride_hailing_cancellation_cooldown_minutes',
        ])->delete();
    }
};
