<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('onboarding_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->constrained('modules')->restrictOnDelete();
            $table->foreignId('store_id')->constrained('stores')->restrictOnDelete();
            $table->string('invoice_number')->unique();
            $table->string('invoice_type', 30);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->decimal('amount', 24, 2);
            $table->string('module_name');
            $table->string('store_name');
            $table->string('store_email')->nullable();
            $table->text('store_address')->nullable();
            $table->string('payment_status', 20)->default('unpaid');
            $table->string('send_status', 20)->default('not_sent');
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('last_send_error')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->index(['payment_status', 'invoice_date']);
            $table->index(['send_status', 'invoice_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('onboarding_invoices');
    }
};
