<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ride_request_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
            $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
            $table->timestamp('viewed_at');
            $table->timestamps();
            $table->unique(['ride_request_id', 'delivery_man_id'], 'ride_request_captain_view_unique');
            $table->index(['ride_request_id', 'viewed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_request_views');
    }
};
