<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ride_cancellation_receivables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->unique()->constrained('ride_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('status', 20)->default('pending');
            $table->foreignId('collection_ride_id')->nullable()->constrained('ride_requests')->nullOnDelete();
            $table->string('collection_source', 30)->nullable();
            $table->string('collection_method', 30)->nullable();
            $table->timestamp('cleared_at')->nullable();
            $table->timestamps();
            $table->index(['delivery_man_id', 'status'], 'ride_cancel_receivable_captain_status_idx');
            $table->index(['user_id', 'status'], 'ride_cancel_receivable_user_status_idx');
        });

        DB::table('ride_requests')
            ->where('status', 'cancelled')
            ->where('cancellation_charge_amount', '>', 0)
            ->whereNotNull('delivery_man_id')
            ->orderBy('id')
            ->chunkById(200, function ($rides): void {
                foreach ($rides as $ride) {
                    $clearedAt = $ride->cancellation_recovered_at ?: $ride->cancellation_compensation_paid_at;
                    DB::table('ride_cancellation_receivables')->insertOrIgnore([
                        'ride_request_id' => $ride->id,
                        'user_id' => $ride->user_id,
                        'delivery_man_id' => $ride->delivery_man_id,
                        'amount' => $ride->cancellation_charge_amount,
                        'status' => $clearedAt ? 'cleared' : 'pending',
                        'collection_ride_id' => $clearedAt ? $ride->recovery_ride_id : null,
                        'collection_source' => $clearedAt ? ($ride->recovery_ride_id ? 'next_ride' : 'direct_payment') : null,
                        'collection_method' => $clearedAt ? $ride->payment_method : null,
                        'cleared_at' => $clearedAt,
                        'created_at' => $ride->cancelled_at ?: $ride->created_at,
                        'updated_at' => $clearedAt ?: $ride->updated_at,
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_cancellation_receivables');
    }
};
