<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_vehicles', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_vehicles', 'front_image')) {
                $table->string('front_image')->nullable()->after('registration_number');
                $table->string('front_image_storage', 20)->default('public')->after('front_image');
            }
            if (! Schema::hasColumn('ride_vehicles', 'back_image')) {
                $table->string('back_image')->nullable()->after('front_image_storage');
                $table->string('back_image_storage', 20)->default('public')->after('back_image');
            }
        });
    }

    public function down(): void
    {
        Schema::table('ride_vehicles', function (Blueprint $table) {
            $columns = array_values(array_filter(
                ['front_image', 'front_image_storage', 'back_image', 'back_image_storage'],
                fn (string $column) => Schema::hasColumn('ride_vehicles', $column)
            ));
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
