<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ride_cancellation_reasons', function (Blueprint $table) {
            $table->id();
            $table->string('code', 80)->unique();
            $table->string('title', 255);
            $table->enum('user_type', ['customer', 'captain', 'admin']);
            $table->json('ride_statuses');
            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['user_type', 'status', 'display_order'], 'ride_cancel_reason_lookup');
        });

        Schema::table('ride_requests', function (Blueprint $table) {
            $table->foreignId('cancellation_reason_id')->nullable()->after('cancelled_by')
                ->constrained('ride_cancellation_reasons')->nullOnDelete();
            $table->string('cancellation_reason_code', 80)->nullable()->after('cancellation_reason_id');
            $table->string('cancellation_reason_user_type', 20)->nullable()->after('cancellation_reason_code');
        });

        $statuses = json_encode(['searching', 'negotiating', 'rider_selected', 'captain_arriving', 'arrived']);
        $now = now();
        DB::table('ride_cancellation_reasons')->insert([
            ['code' => 'customer_plans_changed', 'title' => 'My plans changed', 'user_type' => 'customer', 'ride_statuses' => $statuses, 'display_order' => 10, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'customer_captain_too_far', 'title' => 'Captain is too far away', 'user_type' => 'customer', 'ride_statuses' => $statuses, 'display_order' => 20, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'captain_unable_to_continue', 'title' => 'Unable to continue this Ride', 'user_type' => 'captain', 'ride_statuses' => $statuses, 'display_order' => 10, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['code' => 'admin_operational_cancellation', 'title' => 'Cancelled by operations', 'user_type' => 'admin', 'ride_statuses' => $statuses, 'display_order' => 10, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('cancellation_reason_id');
            $table->dropColumn(['cancellation_reason_code', 'cancellation_reason_user_type']);
        });
        Schema::dropIfExists('ride_cancellation_reasons');
    }
};
