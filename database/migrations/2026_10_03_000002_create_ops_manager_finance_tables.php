<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ops_manager_payout_methods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('manager_id')->unique()->constrained('admins')->cascadeOnDelete();
            $table->string('type', 30)->default('bank_account');
            $table->string('account_title');
            $table->string('provider_name');
            $table->text('account_number');
            $table->string('account_last_four', 4);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('ops_manager_withdrawals', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('manager_id')->constrained('admins')->restrictOnDelete();
            $table->foreignId('payout_method_id')->nullable()->constrained('ops_manager_payout_methods')->nullOnDelete();
            $table->char('idempotency_key_hash', 64);
            $table->string('reference', 40)->unique();
            $table->decimal('amount', 24, 2);
            $table->string('currency', 3)->default('PKR');
            $table->text('destination_snapshot');
            $table->string('masked_destination');
            $table->string('status', 20)->default('pending');
            $table->text('admin_note')->nullable();
            $table->string('payment_reference')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->foreignId('paid_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->unique(['manager_id', 'idempotency_key_hash'], 'ops_withdraw_manager_key_unique');
            $table->index(['manager_id', 'status', 'created_at'], 'ops_withdraw_manager_status_idx');
            $table->index(['status', 'created_at'], 'ops_withdraw_status_time_idx');
        });

        Schema::create('ops_manager_finance_ledgers', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('manager_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('onboarding_application_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('onboarding_invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('withdrawal_id')->nullable()->constrained('ops_manager_withdrawals')->nullOnDelete();
            $table->string('entry_type', 50);
            $table->string('bucket', 40);
            $table->string('direction', 10);
            $table->decimal('amount', 24, 2);
            $table->string('currency', 3)->default('PKR');
            $table->string('reference', 150)->unique();
            $table->string('description');
            $table->json('metadata')->nullable();
            $table->foreignId('actor_admin_id')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['manager_id', 'bucket', 'created_at'], 'ops_finance_manager_bucket_idx');
            $table->index(['manager_id', 'entry_type', 'created_at'], 'ops_finance_manager_type_idx');
            $table->index(['onboarding_application_id', 'created_at'], 'ops_finance_application_idx');
        });

        DB::table('onboarding_applications')
            ->whereNotNull('onboarding_manager_id')
            ->where('status', '!=', 'draft')
            ->orderBy('id')
            ->each(function (object $application): void {
                $invoice = DB::table('onboarding_invoices')
                    ->where('onboarding_application_id', $application->id)
                    ->latest('id')
                    ->first();
                if (! $invoice || $invoice->voided_at) {
                    return;
                }
                $createdAt = $application->submitted_at ?? $application->created_at ?? now();
                if ($invoice->payment_status !== 'paid') {
                    DB::table('ops_manager_finance_ledgers')->insertOrIgnore([
                        'manager_id' => $application->onboarding_manager_id,
                        'onboarding_application_id' => $application->id,
                        'onboarding_invoice_id' => $invoice->id,
                        'entry_type' => 'invoice_collection_created',
                        'bucket' => 'awaiting_collection',
                        'direction' => 'credit',
                        'amount' => $invoice->amount,
                        'currency' => $application->currency ?: 'PKR',
                        'reference' => "ops-application:{$application->id}:collection-created",
                        'description' => 'Onboarding invoice awaiting collection.',
                        'created_at' => $createdAt,
                    ]);
                }
                if ((float) $application->commission_amount_snapshot > 0) {
                    DB::table('ops_manager_finance_ledgers')->insertOrIgnore([
                        'manager_id' => $application->onboarding_manager_id,
                        'onboarding_application_id' => $application->id,
                        'onboarding_invoice_id' => $invoice->id,
                        'entry_type' => $invoice->payment_status === 'paid'
                            ? 'commission_pending_release'
                            : 'commission_calculated',
                        'bucket' => $invoice->payment_status === 'paid'
                            ? 'pending_release'
                            : 'pending_commission',
                        'direction' => 'credit',
                        'amount' => $application->commission_amount_snapshot,
                        'currency' => $application->currency ?: 'PKR',
                        'reference' => $invoice->payment_status === 'paid'
                            ? "ops-application:{$application->id}:commission-pending-release"
                            : "ops-application:{$application->id}:commission-calculated",
                        'description' => $invoice->payment_status === 'paid'
                            ? 'Paid onboarding commission awaiting admin release.'
                            : 'Onboarding commission calculated and pending payment.',
                        'created_at' => $createdAt,
                    ]);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('ops_manager_finance_ledgers');
        Schema::dropIfExists('ops_manager_withdrawals');
        Schema::dropIfExists('ops_manager_payout_methods');
    }
};
