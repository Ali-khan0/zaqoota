<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_vehicle_types', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_vehicle_types', 'image')) {
                $table->string('image')->nullable()->after('slug');
                $table->string('image_storage', 20)->default('public')->after('image');
            }
        });
        Schema::table('ride_categories', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_categories', 'image')) {
                $table->string('image')->nullable()->after('slug');
                $table->string('image_storage', 20)->default('public')->after('image');
            }
        });
        Schema::table('ride_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_requests', 'quote_expires_at')) {
                $table->timestamp('quote_expires_at')->nullable()->after('offer_expiry_seconds');
            }
            if (! Schema::hasColumn('ride_requests', 'customer_offer_updated_at')) {
                $table->timestamp('customer_offer_updated_at')->nullable()->after('quote_expires_at');
            }
        });
        Schema::table('ride_offers', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_offers', 'rejected_by')) {
                $table->string('rejected_by', 20)->nullable()->after('status');
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
        });

        if (! Schema::hasTable('ride_setting_audits')) {
            Schema::create('ride_setting_audits', function (Blueprint $table) {
                $table->id();
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('setting_key');
                $table->text('old_value')->nullable();
                $table->text('new_value')->nullable();
                $table->string('ip_address', 64)->nullable();
                $table->timestamps();
                $table->index(['setting_key', 'created_at']);
            });
        }

        $defaults = [
            'ride_hailing_customer_enabled' => '1',
            'ride_hailing_customer_rebid_enabled' => '1',
            'ride_hailing_customer_offer_rejection_enabled' => '1',
            'ride_hailing_customer_rebid_cooldown_seconds' => '10',
            'ride_hailing_nearby_availability_enabled' => '0',
            'ride_hailing_nearby_marker_precision' => '2',
            'ride_hailing_nearby_marker_limit' => '20',
            'ride_hailing_nearby_refresh_seconds' => '20',
        ];
        foreach ($defaults as $key => $value) {
            if (! DB::table('business_settings')->where('key', $key)->exists()) {
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
        Schema::dropIfExists('ride_setting_audits');
        Schema::table('ride_offers', fn (Blueprint $table) => $table->dropColumn(['rejected_by', 'rejected_at']));
        Schema::table('ride_requests', fn (Blueprint $table) => $table->dropColumn(['quote_expires_at', 'customer_offer_updated_at']));
        Schema::table('ride_categories', fn (Blueprint $table) => $table->dropColumn(['image', 'image_storage']));
        Schema::table('ride_vehicle_types', fn (Blueprint $table) => $table->dropColumn(['image', 'image_storage']));
    }
};
