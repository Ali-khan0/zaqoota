<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('commerce_order_notification_deliveries')) {
            Schema::create('commerce_order_notification_deliveries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
                $table->string('event', 60);
                $table->unsignedSmallInteger('dispatch_wave')->nullable();
                $table->unsignedInteger('pickup_distance_meters')->nullable();
                $table->boolean('in_app_stored')->default(false);
                $table->string('push_status', 20)->default('pending');
                $table->unsignedSmallInteger('push_attempts')->default(0);
                $table->text('last_error')->nullable();
                $table->timestamp('last_attempted_at')->nullable();
                $table->timestamp('accepted_at')->nullable();
                $table->timestamps();

                $table->unique(
                    ['order_id', 'delivery_man_id', 'event'],
                    'commerce_order_notification_recipient_unique'
                );
                $table->index(['order_id', 'push_status'], 'commerce_order_push_status_index');
                $table->index(['order_id', 'dispatch_wave'], 'commerce_order_dispatch_wave_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('commerce_order_notification_deliveries');
    }
};
