<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_requests', function (Blueprint $table): void {
            $table->decimal('current_heading', 6, 2)->nullable()->after('current_longitude');
            $table->decimal('current_speed_mps', 6, 2)->nullable()->after('current_heading');
            $table->decimal('current_accuracy_meters', 8, 2)->nullable()->after('current_speed_mps');
        });
    }

    public function down(): void
    {
        Schema::table('ride_requests', function (Blueprint $table): void {
            $table->dropColumn(['current_heading', 'current_speed_mps', 'current_accuracy_meters']);
        });
    }
};
