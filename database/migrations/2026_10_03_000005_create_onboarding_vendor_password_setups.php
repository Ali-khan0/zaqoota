<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onboarding_vendor_password_setups', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('onboarding_application_id')->constrained('onboarding_applications')->cascadeOnDelete();
            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->char('token_hash', 64)->unique();
            $table->text('token_secret');
            $table->timestamp('expires_at')->index();
            $table->timestamp('used_at')->nullable()->index();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('used_ip', 45)->nullable();
            $table->timestamps();
            $table->index(['onboarding_application_id', 'expires_at'], 'onboarding_password_setup_application_expiry_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_vendor_password_setups');
    }
};
