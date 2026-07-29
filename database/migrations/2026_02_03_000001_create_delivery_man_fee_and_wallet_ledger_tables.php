<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('delivery_man_registration_fees')) {
            Schema::create('delivery_man_registration_fees', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('delivery_man_id')->unique();
                $table->decimal('total_fee', 24, 2)->default(5000);
                $table->decimal('manual_paid_amount', 24, 2)->default(0);
                $table->boolean('manual_confirmed')->default(false);
                $table->timestamp('manual_confirmed_at')->nullable();
                $table->decimal('wallet_remaining_due', 24, 2)->default(5000);
                $table->decimal('deduction_percent', 5, 2)->default(30);
                $table->string('deduction_frequency', 20)->default('weekly');
                $table->timestamp('last_wallet_deduction_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();

                $table->foreign('delivery_man_id')->references('id')->on('delivery_men')->onDelete('cascade');
            });
        }

        if (! Schema::hasTable('delivery_man_wallet_ledgers')) {
            Schema::create('delivery_man_wallet_ledgers', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('delivery_man_id');
                $table->string('transaction_type', 64);
                $table->string('reference', 191)->nullable();
                $table->decimal('amount', 24, 2);
                $table->string('direction', 10);
                $table->json('meta')->nullable();
                $table->timestamps();

                $table->index(['delivery_man_id', 'transaction_type', 'created_at'], 'dm_wallet_ledger_dm_type_created_idx');
                $table->foreign('delivery_man_id')->references('id')->on('delivery_men')->onDelete('cascade');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_man_wallet_ledgers');
        Schema::dropIfExists('delivery_man_registration_fees');
    }
};
