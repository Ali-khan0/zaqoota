<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->text('trip_pin')->nullable()->after('offer_expiry_seconds');
            $table->timestamp('captain_arriving_at')->nullable()->after('selected_at');
            $table->timestamp('arrived_at')->nullable()->after('captain_arriving_at');
            $table->timestamp('trip_started_at')->nullable()->after('arrived_at');
            $table->timestamp('completed_at')->nullable()->after('trip_started_at');
            $table->timestamp('cancelled_at')->nullable()->after('completed_at');
            $table->string('cancelled_by', 20)->nullable()->after('cancelled_at');
            $table->string('cancellation_reason', 500)->nullable()->after('cancelled_by');
            $table->decimal('cancellation_charge_amount', 12, 2)->default(0)->after('cancellation_reason');
            $table->unsignedSmallInteger('charged_waiting_minutes')->default(0)->after('cancellation_charge_amount');
            $table->decimal('waiting_charge_amount', 12, 2)->default(0)->after('charged_waiting_minutes');
            $table->decimal('current_latitude', 10, 7)->nullable()->after('waiting_charge_amount');
            $table->decimal('current_longitude', 10, 7)->nullable()->after('current_latitude');
            $table->timestamp('location_updated_at')->nullable()->after('current_longitude');
        });

        Schema::create('ride_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30);
            $table->string('actor_type', 20);
            $table->unsignedBigInteger('actor_id')->nullable();
            $table->string('note', 500)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();

            $table->index(['ride_request_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_status_histories');

        Schema::table('ride_requests', function (Blueprint $table) {
            $table->dropColumn([
                'trip_pin', 'captain_arriving_at', 'arrived_at', 'trip_started_at',
                'completed_at', 'cancelled_at', 'cancelled_by', 'cancellation_reason',
                'cancellation_charge_amount', 'charged_waiting_minutes',
                'waiting_charge_amount', 'current_latitude', 'current_longitude',
                'location_updated_at',
            ]);
        });
    }
};
