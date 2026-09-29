<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_payments', function (Blueprint $table) {
            $table->timestamp('admin_received_at')->nullable()->index();
            $table->string('purpose', 30)->default('ride_payment')->index();
        });

        Schema::create('ride_cancellation_refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->unique()->constrained('ride_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('paid_amount', 12, 2);
            $table->decimal('cancellation_allocated_amount', 12, 2)->default(0);
            $table->decimal('wallet_refund_amount', 12, 2)->default(0);
            $table->uuid('wallet_transaction_id')->nullable()->unique();
            $table->string('status', 20)->default('completed');
            $table->timestamp('completed_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_cancellation_refunds');
        Schema::table('ride_payments', function (Blueprint $table) {
            $table->dropColumn(['admin_received_at', 'purpose']);
        });
    }
};
