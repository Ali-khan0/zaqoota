<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_ratings')) {
            Schema::create('ride_ratings', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('ride_request_id')->unique()->constrained('ride_requests')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
                $table->unsignedTinyInteger('rating');
                $table->text('comment')->nullable();
                $table->timestamps();

                $table->index(['delivery_man_id', 'rating']);
                $table->index(['user_id', 'created_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_ratings');
    }
};
