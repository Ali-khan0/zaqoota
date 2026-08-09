<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_notification_deliveries')) {
            Schema::create('ride_notification_deliveries', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
                $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
                $table->string('event', 60);
                $table->boolean('in_app_stored')->default(false);
                $table->string('push_status', 20)->default('pending');
                $table->unsignedSmallInteger('push_attempts')->default(0);
                $table->text('last_error')->nullable();
                $table->timestamp('last_attempted_at')->nullable();
                $table->timestamp('accepted_at')->nullable();
                $table->timestamps();

                $table->unique(
                    ['ride_request_id', 'delivery_man_id', 'event'],
                    'ride_notification_recipient_unique'
                );
                $table->index(['ride_request_id', 'push_status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_notification_deliveries');
    }
};
