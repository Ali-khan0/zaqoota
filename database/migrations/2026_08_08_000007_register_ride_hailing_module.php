<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (!DB::table('modules')->where('module_type', 'ride_hailing')->exists()) {
            DB::table('modules')->insert([
                'module_name' => 'Ride Hailing',
                'module_type' => 'ride_hailing',
                'status' => 1,
                'stores_count' => 0,
                'theme_id' => 1,
                'description' => 'Book and manage point-to-point rides.',
                'all_zone_service' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $defaults = [
            'ride_hailing_service_name' => 'Zaqoota Ride',
            'ride_hailing_distance_unit' => 'km',
            'ride_hailing_support_email' => null,
            'ride_hailing_support_phone' => null,
        ];

        foreach ($defaults as $key => $value) {
            if (!DB::table('business_settings')->where('key', $key)->exists()) {
                DB::table('business_settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        // Preserve module registration and administrator-entered settings on rollback.
    }
};
