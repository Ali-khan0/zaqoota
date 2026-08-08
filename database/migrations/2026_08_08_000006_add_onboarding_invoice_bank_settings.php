<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private array $settings = [
        'onboarding_invoice_bank_name' => 'Askari Bank',
        'onboarding_invoice_account_title' => 'Zaqoota',
        'onboarding_invoice_iban' => 'PK02ASCM0009010200001008',
        'onboarding_invoice_account_number' => '09010200001008',
    ];

    public function up(): void
    {
        foreach ($this->settings as $key => $value) {
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
        DB::table('business_settings')->whereIn('key', array_keys($this->settings))->delete();
    }
};
