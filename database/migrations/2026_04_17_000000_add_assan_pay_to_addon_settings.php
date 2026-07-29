<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Register AssanPay in addon_settings for admin payment configuration.
     */
    public function up(): void
    {
        if (!Schema::hasTable('addon_settings')) {
            return;
        }

        if (DB::table('addon_settings')->where('key_name', 'assan_pay')->where('settings_type', 'payment_config')->exists()) {
            return;
        }

        $now = now();
        $values = json_encode([
            'gateway' => 'assan_pay',
            'mode' => 'test',
            'status' => '0',
            'merchant_id' => '',
            'api_key' => '',
            'decryption_key' => '',
            'checkout_url' => 'https://api.assanpay.com',
            'callback_url' => '',
        ]);

        DB::table('addon_settings')->insert([
            'id' => (string) Str::uuid(),
            'key_name' => 'assan_pay',
            'live_values' => $values,
            'test_values' => $values,
            'settings_type' => 'payment_config',
            'mode' => 'test',
            'is_active' => 0,
            'created_at' => $now,
            'updated_at' => $now,
            'additional_data' => json_encode([
                'gateway_title' => 'AssanPay',
                'gateway_image' => '',
                'storage' => 'public',
            ]),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasTable('addon_settings')) {
            return;
        }

        DB::table('addon_settings')->where('key_name', 'assan_pay')->where('settings_type', 'payment_config')->delete();
    }
};
