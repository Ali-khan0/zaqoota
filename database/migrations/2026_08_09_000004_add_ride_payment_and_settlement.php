<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            $table->string('payment_status', 20)->default('unpaid')->after('waiting_charge_amount');
            $table->string('payment_method', 30)->nullable()->after('payment_status');
            $table->string('payment_gateway', 80)->nullable()->after('payment_method');
            $table->string('payment_transaction_reference', 191)->nullable()->after('payment_gateway');
            $table->decimal('final_payable_amount', 12, 2)->nullable()->after('payment_transaction_reference');
            $table->decimal('captain_total_earning_amount', 12, 2)->nullable()->after('final_payable_amount');
            $table->string('receipt_number', 40)->nullable()->unique()->after('captain_total_earning_amount');
            $table->timestamp('paid_at')->nullable()->after('receipt_number');
            $table->timestamp('settled_at')->nullable()->after('paid_at');
        });

        Schema::create('ride_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_men')->nullOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method', 30);
            $table->string('payment_gateway', 80)->nullable();
            $table->uuid('payment_request_id')->nullable()->index();
            $table->string('transaction_reference', 191)->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();

            $table->index(['ride_request_id', 'status']);
        });

        DB::table('ride_requests')->where('status', 'completed')->update([
            'final_payable_amount' => DB::raw('COALESCE(final_accepted_fare, 0) + COALESCE(waiting_charge_amount, 0)'),
            'captain_total_earning_amount' => DB::raw('COALESCE(rider_earning_amount, 0) + COALESCE(waiting_charge_amount, 0)'),
        ]);
        DB::table('ride_requests')->where('status', 'cancelled')->where('cancellation_charge_amount', '>', 0)->update([
            'final_payable_amount' => DB::raw('cancellation_charge_amount'),
            'captain_total_earning_amount' => DB::raw('cancellation_charge_amount'),
            'platform_commission_amount' => 0,
            'rider_earning_amount' => DB::raw('cancellation_charge_amount'),
        ]);
        DB::table('ride_requests')->where('status', 'cancelled')->where('cancellation_charge_amount', '<=', 0)->update([
            'payment_status' => 'not_required',
            'final_payable_amount' => 0,
            'captain_total_earning_amount' => 0,
            'platform_commission_amount' => 0,
            'rider_earning_amount' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_payments');

        Schema::table('ride_requests', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status', 'payment_method', 'payment_gateway',
                'payment_transaction_reference', 'final_payable_amount',
                'captain_total_earning_amount', 'receipt_number', 'paid_at',
                'settled_at',
            ]);
        });
    }
};
