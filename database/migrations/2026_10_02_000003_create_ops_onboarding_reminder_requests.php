<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ops_onboarding_reminder_requests')) {
            Schema::create('ops_onboarding_reminder_requests', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('onboarding_application_id')->constrained()->cascadeOnDelete();
                $table->foreignId('onboarding_manager_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->char('idempotency_key_hash', 64);
                $table->timestamp('next_allowed_at');
                $table->timestamp('created_at')->useCurrent();

                $table->unique(
                    ['onboarding_manager_id', 'idempotency_key_hash'],
                    'ops_reminders_manager_key_unique',
                );
                $table->index(
                    ['onboarding_application_id', 'created_at'],
                    'ops_reminders_application_time_idx',
                );
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ops_onboarding_reminder_requests');
    }
};
