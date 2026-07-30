<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fleet_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('primary_zone_id')->nullable()->constrained('zones')->nullOnDelete();
            $table->string('employee_id')->nullable()->unique();
            $table->string('f_name');
            $table->string('l_name')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('auth_token', 191)->nullable()->unique();
            $table->string('fcm_token')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(true);
            $table->boolean('on_leave')->default(false);
            $table->unsignedSmallInteger('rider_capacity')->default(50);
            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('contract_type', 30)->default('employee');
            $table->text('notes')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status', 'on_leave']);
        });

        Schema::create('fleet_manager_zone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->cascadeOnDelete();
            $table->foreignId('zone_id')->constrained('zones')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['fleet_manager_id', 'zone_id']);
        });

        Schema::table('delivery_men', function (Blueprint $table) {
            $table->foreignId('fleet_manager_id')
                ->nullable()
                ->after('zone_id')
                ->constrained('fleet_managers')
                ->nullOnDelete();
            $table->index(['fleet_manager_id', 'zone_id'], 'dm_fleet_manager_zone_idx');
        });

        Schema::create('fleet_manager_rider_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->restrictOnDelete();
            $table->foreignId('delivery_man_id')->constrained('delivery_men')->cascadeOnDelete();
            $table->foreignId('assigned_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('ended_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('reason')->nullable();
            $table->string('end_reason')->nullable();
            $table->timestamps();

            $table->index(['delivery_man_id', 'is_active'], 'fleet_rider_active_idx');
            $table->index(['fleet_manager_id', 'is_active'], 'fleet_manager_active_idx');
        });

        Schema::create('fleet_payment_collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fleet_manager_id')->constrained('fleet_managers')->restrictOnDelete();
            $table->foreignId('delivery_man_id')->constrained('delivery_men')->restrictOnDelete();
            $table->decimal('amount', 24, 2);
            $table->decimal('due_before', 24, 2);
            $table->decimal('due_after', 24, 2)->nullable();
            $table->string('payment_method', 30);
            $table->string('reference')->nullable();
            $table->string('proof_file')->nullable();
            $table->string('proof_disk', 20)->default('local');
            $table->text('note')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->index(['status', 'submitted_at']);
            $table->index(['fleet_manager_id', 'status']);
            $table->index(['delivery_man_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fleet_payment_collections');
        Schema::dropIfExists('fleet_manager_rider_assignments');

        Schema::table('delivery_men', function (Blueprint $table) {
            $table->dropForeign(['fleet_manager_id']);
            $table->dropIndex('dm_fleet_manager_zone_idx');
            $table->dropColumn('fleet_manager_id');
        });

        Schema::dropIfExists('fleet_manager_zone');
        Schema::dropIfExists('fleet_managers');
    }
};
