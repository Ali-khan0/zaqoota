<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_offers', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_offers', 'pickup_distance_meters')) {
                $table->unsignedInteger('pickup_distance_meters')->nullable()->after('amount');
            }
            if (! Schema::hasColumn('ride_offers', 'pickup_eta_seconds')) {
                $table->unsignedInteger('pickup_eta_seconds')->nullable()->after('pickup_distance_meters');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ride_offers', function (Blueprint $table) {
            $columns = array_values(array_filter(['pickup_distance_meters', 'pickup_eta_seconds'], fn ($column) => Schema::hasColumn('ride_offers', $column)));
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
