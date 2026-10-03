<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $hasStaffType = Schema::hasColumn('admins', 'staff_type');
        $hasCommission = Schema::hasColumn('admins', 'onboarding_commission_percent');
        $hasOpsStatus = Schema::hasColumn('admins', 'ops_status');
        $hasFcmToken = Schema::hasColumn('admins', 'ops_fcm_token');
        $hasFcmPlatform = Schema::hasColumn('admins', 'ops_fcm_platform');

        Schema::table('admins', function (Blueprint $table) use ($hasStaffType, $hasCommission, $hasOpsStatus, $hasFcmToken, $hasFcmPlatform): void {
            if (! $hasStaffType) {
                $table->string('staff_type', 40)->default('admin_employee')->after('role_id')->index();
            }
            if (! $hasCommission) {
                $table->decimal('onboarding_commission_percent', 5, 2)->default(0)->after('staff_type');
            }
            if (! $hasOpsStatus) {
                $table->boolean('ops_status')->default(false)->after('onboarding_commission_percent')->index();
            }
            if (! $hasFcmToken) {
                $table->text('ops_fcm_token')->nullable()->after('ops_status');
            }
            if (! $hasFcmPlatform) {
                $table->string('ops_fcm_platform', 20)->nullable()->after('ops_fcm_token');
            }
        });

        if (! Schema::hasTable('ops_manager_audits')) {
            Schema::create('ops_manager_audits', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('manager_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('actor_admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('action', 80);
                $table->json('metadata')->nullable();
                $table->ipAddress('ip_address')->nullable();
                $table->string('user_agent', 500)->nullable();
                $table->timestamps();
                $table->index(['manager_id', 'created_at'], 'ops_manager_audit_manager_time_idx');
                $table->index(['action', 'created_at'], 'ops_manager_audit_action_time_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ops_manager_audits');
        Schema::table('admins', function (Blueprint $table): void {
            $columns = array_values(array_filter([
                'staff_type',
                'onboarding_commission_percent',
                'ops_status',
                'ops_fcm_token',
                'ops_fcm_platform',
            ], static fn (string $column): bool => Schema::hasColumn('admins', $column)));
            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
