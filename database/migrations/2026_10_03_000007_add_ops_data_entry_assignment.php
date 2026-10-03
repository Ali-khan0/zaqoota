<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboarding_applications', function (Blueprint $table): void {
            $table->foreignId('data_entry_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('data_entry_assigned_at')->nullable();
            $table->timestamp('data_entry_completed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('onboarding_applications', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('data_entry_admin_id');
            $table->dropColumn(['data_entry_assigned_at', 'data_entry_completed_at']);
        });
    }
};
