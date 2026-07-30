<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fleet_managers', function (Blueprint $table) {
            $table->decimal('commission_percentage', 5, 2)->default(0)->after('contract_type');
        });

        Schema::create('fleet_manager_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->unique()->constrained('fleet_managers')->cascadeOnDelete();
            $table->decimal('total_earning', 24, 2)->default(0);
            $table->decimal('total_withdrawn', 24, 2)->default(0);
            $table->decimal('pending_withdraw', 24, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('fleet_manager_earning_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->restrictOnDelete();
            $table->foreignId('delivery_man_id')->nullable()->constrained('delivery_men')->nullOnDelete();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_transaction_id')->nullable();
            $table->decimal('delivery_amount', 24, 2);
            $table->decimal('admin_commission_amount', 24, 2);
            $table->decimal('fleet_commission_percentage', 5, 2);
            $table->decimal('amount', 24, 2);
            $table->string('status', 20)->default('earned');
            $table->timestamp('reversed_at')->nullable();
            $table->timestamps();

            $table->unique('order_id');
            $table->index(['fleet_manager_id', 'status', 'created_at'], 'fleet_earning_manager_status_idx');
            $table->index('delivery_man_id');
        });

        Schema::create('fleet_manager_withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->cascadeOnDelete();
            $table->foreignId('withdrawal_method_id')->constrained('withdrawal_methods')->restrictOnDelete();
            $table->string('method_name');
            $table->json('method_fields');
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->index(['fleet_manager_id', 'is_default'], 'fleet_withdraw_method_default_idx');
        });

        Schema::create('fleet_manager_withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->restrictOnDelete();
            $table->unsignedBigInteger('fleet_manager_withdrawal_method_id')->nullable();
            $table->foreign(
                'fleet_manager_withdrawal_method_id',
                'fm_withdraw_request_saved_method_fk'
            )->references('id')->on('fleet_manager_withdrawal_methods')->nullOnDelete();
            $table->foreignId('withdrawal_method_id')->nullable()->constrained('withdrawal_methods')->nullOnDelete();
            $table->decimal('amount', 24, 2);
            $table->string('method_name');
            $table->json('method_fields');
            $table->text('manager_note')->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('admin_note')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['fleet_manager_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleet_manager_withdrawal_requests');
        Schema::dropIfExists('fleet_manager_withdrawal_methods');
        Schema::dropIfExists('fleet_manager_earning_transactions');
        Schema::dropIfExists('fleet_manager_wallets');

        Schema::table('fleet_managers', function (Blueprint $table) {
            $table->dropColumn('commission_percentage');
        });
    }
};
