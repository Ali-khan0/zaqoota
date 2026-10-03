<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboarding_invoice_deliveries', function (Blueprint $table): void {
            $table->char('idempotency_key_hash', 64)->nullable()->after('delivery_type');
            $table->unsignedSmallInteger('attempt_count')->default(0)->after('status');
            $table->timestamp('last_attempt_at')->nullable()->after('sent_at');
            $table->string('sent_by_name')->nullable()->after('sent_by');
            $table->unique(
                ['onboarding_invoice_id', 'recipient_email', 'delivery_type', 'idempotency_key_hash'],
                'onboarding_delivery_idempotency_unique',
            );
        });
        DB::table('onboarding_invoice_deliveries')->update([
            'attempt_count' => 1,
            'last_attempt_at' => DB::raw('COALESCE(sent_at, created_at)'),
        ]);

        Schema::table('ops_onboarding_reminder_requests', function (Blueprint $table): void {
            $table->string('status', 20)->default('queued')->after('idempotency_key_hash');
            $table->unsignedSmallInteger('attempt_count')->default(0)->after('status');
            $table->text('last_error')->nullable()->after('attempt_count');
            $table->timestamp('sent_at')->nullable()->after('next_allowed_at');
        });
        DB::table('ops_onboarding_reminder_requests')->update([
            'status' => 'sent',
            'attempt_count' => 1,
            'sent_at' => DB::raw('created_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('ops_onboarding_reminder_requests', function (Blueprint $table): void {
            $table->dropColumn(['status', 'attempt_count', 'last_error', 'sent_at']);
        });

        Schema::table('onboarding_invoice_deliveries', function (Blueprint $table): void {
            $table->dropUnique('onboarding_delivery_idempotency_unique');
            $table->dropColumn(['idempotency_key_hash', 'attempt_count', 'last_attempt_at', 'sent_by_name']);
        });
    }
};
