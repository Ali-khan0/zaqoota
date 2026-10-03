<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onboarding_invoice_checkout_tokens', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('onboarding_invoice_id')->constrained('onboarding_invoices')->cascadeOnDelete();
            $table->char('token_hash', 64)->unique();
            $table->text('token_secret');
            $table->timestamp('expires_at')->index();
            $table->timestamp('last_accessed_at')->nullable();
            $table->timestamp('revoked_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('onboarding_invoice_payment_attempts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('onboarding_invoice_id')->constrained('onboarding_invoices')->cascadeOnDelete();
            $table->foreignId('checkout_token_id')->nullable()->constrained('onboarding_invoice_checkout_tokens')->nullOnDelete();
            $table->uuid('payment_request_id')->unique();
            $table->string('gateway', 80);
            $table->decimal('amount', 24, 2);
            $table->string('currency', 20);
            $table->string('status', 30)->default('pending')->index();
            $table->string('transaction_reference')->nullable();
            $table->text('failure_reason')->nullable();
            $table->string('refund_reference')->nullable();
            $table->text('refund_reason')->nullable();
            $table->foreignId('refunded_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('expires_at')->index();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->timestamps();
            $table->index(['onboarding_invoice_id', 'status'], 'onboarding_invoice_payment_status_idx');
            $table->unique(['gateway', 'transaction_reference'], 'onboarding_invoice_gateway_transaction_unique');
        });

        Schema::table('onboarding_invoices', function (Blueprint $table): void {
            $table->timestamp('refunded_at')->nullable()->after('paid_at');
            $table->string('refund_reference')->nullable()->after('refunded_at');
            $table->text('refund_reason')->nullable()->after('refund_reference');
            $table->foreignId('refunded_by')->nullable()->after('refund_reason')->constrained('admins')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('refunded_by');
            $table->dropColumn(['refunded_at', 'refund_reference', 'refund_reason']);
        });
        Schema::dropIfExists('onboarding_invoice_payment_attempts');
        Schema::dropIfExists('onboarding_invoice_checkout_tokens');
    }
};
