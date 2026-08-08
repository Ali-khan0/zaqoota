<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table) {
            $table->text('public_note')->nullable()->after('amount');
            $table->text('private_note')->nullable()->after('public_note');
            $table->string('payment_method')->nullable()->after('paid_at');
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->foreignId('paid_by')->nullable()->after('payment_reference')->constrained('admins')->nullOnDelete();
            $table->timestamp('voided_at')->nullable()->after('paid_by');
            $table->text('void_reason')->nullable()->after('voided_at');
            $table->foreignId('voided_by')->nullable()->after('void_reason')->constrained('admins')->nullOnDelete();
            $table->timestamp('last_reminder_at')->nullable()->after('sent_at');
        });

        Schema::create('onboarding_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_invoice_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('quantity', 12, 2)->default(1);
            $table->decimal('unit_price', 24, 2);
            $table->decimal('line_total', 24, 2);
            $table->timestamps();
        });

        Schema::create('onboarding_invoice_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_invoice_id')->constrained()->cascadeOnDelete();
            $table->string('recipient_email');
            $table->string('delivery_type', 30);
            $table->string('status', 20);
            $table->text('error_message')->nullable();
            $table->foreignId('sent_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
            $table->index(['onboarding_invoice_id', 'created_at']);
        });

        Schema::create('onboarding_invoice_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('onboarding_invoice_id')->constrained()->cascadeOnDelete();
            $table->string('event_type', 40);
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->string('admin_name')->nullable();
            $table->timestamps();
            $table->index(['onboarding_invoice_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_invoice_events');
        Schema::dropIfExists('onboarding_invoice_deliveries');
        Schema::dropIfExists('onboarding_invoice_items');
        Schema::table('onboarding_invoices', function (Blueprint $table) {
            $table->dropConstrainedForeignId('paid_by');
            $table->dropConstrainedForeignId('voided_by');
            $table->dropColumn(['public_note', 'private_note', 'payment_method', 'payment_reference', 'voided_at', 'void_reason', 'last_reminder_at']);
        });
    }
};
