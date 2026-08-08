<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_banners')) {
            Schema::create('ride_banners', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->string('image');
                $table->string('image_storage', 20)->default('public');
                $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
                $table->foreignId('ride_category_id')->nullable()->constrained('ride_categories')->nullOnDelete();
                $table->string('action_type', 20)->default('none');
                $table->string('action_value', 1000)->nullable();
                $table->dateTime('starts_at');
                $table->dateTime('expires_at');
                $table->unsignedInteger('sort_order')->default(0);
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->index(['status', 'starts_at', 'expires_at']);
            });
        }

        if (! Schema::hasTable('ride_push_notifications')) {
            Schema::create('ride_push_notifications', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description');
                $table->string('image')->nullable();
                $table->string('image_storage', 20)->default('public');
                $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
                $table->string('action_type', 20)->default('ride_home');
                $table->string('action_value', 1000)->nullable();
                $table->boolean('status')->default(true);
                $table->string('delivery_status', 20)->default('pending');
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();
                $table->index(['status', 'sent_at']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_push_notifications');
        Schema::dropIfExists('ride_banners');
    }
};
