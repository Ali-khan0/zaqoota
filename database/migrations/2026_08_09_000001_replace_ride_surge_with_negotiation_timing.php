<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_fares')) {
            return;
        }

        if (! Schema::hasColumn('ride_fares', 'free_waiting_minutes')) {
            Schema::table('ride_fares', function (Blueprint $table) {
                $table->unsignedSmallInteger('free_waiting_minutes')
                    ->default(3)
                    ->after('waiting_charge_per_minute');
            });
        }

        if (! Schema::hasColumn('ride_fares', 'offer_expiry_seconds')) {
            Schema::table('ride_fares', function (Blueprint $table) {
                $table->unsignedSmallInteger('offer_expiry_seconds')
                    ->default(30)
                    ->after('negotiation_max_percent');
            });
        }

        $dropColumns = [];
        if (Schema::hasColumn('ride_fares', 'surge_enabled')) {
            $dropColumns[] = 'surge_enabled';
        }
        if (Schema::hasColumn('ride_fares', 'surge_multiplier')) {
            $dropColumns[] = 'surge_multiplier';
        }
        if ($dropColumns !== []) {
            Schema::table('ride_fares', fn (Blueprint $table) => $table->dropColumn($dropColumns));
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ride_fares')) {
            return;
        }

        if (! Schema::hasColumn('ride_fares', 'surge_enabled')) {
            Schema::table('ride_fares', function (Blueprint $table) {
                $table->boolean('surge_enabled')->default(false);
            });
        }
        if (! Schema::hasColumn('ride_fares', 'surge_multiplier')) {
            Schema::table('ride_fares', function (Blueprint $table) {
                $table->decimal('surge_multiplier', 5, 2)->default(1);
            });
        }

        $dropColumns = [];
        if (Schema::hasColumn('ride_fares', 'free_waiting_minutes')) {
            $dropColumns[] = 'free_waiting_minutes';
        }
        if (Schema::hasColumn('ride_fares', 'offer_expiry_seconds')) {
            $dropColumns[] = 'offer_expiry_seconds';
        }
        if ($dropColumns !== []) {
            Schema::table('ride_fares', fn (Blueprint $table) => $table->dropColumn($dropColumns));
        }
    }
};
