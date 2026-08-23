<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delivery_histories', function (Blueprint $table) {
            $table->decimal('heading', 6, 2)->nullable();
            $table->decimal('speed_mps', 8, 2)->nullable();
            $table->decimal('accuracy_meters', 8, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('delivery_histories', function (Blueprint $table) {
            $table->dropColumn(['heading', 'speed_mps', 'accuracy_meters']);
        });
    }
};
