<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('onboarding_applications')) {
            Schema::create('onboarding_applications', function (Blueprint $table): void {
                $table->id();
                $table->string('reference', 40)->unique();
                $table->foreignId('onboarding_manager_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
                $table->foreignId('store_id')->nullable()->constrained('stores')->nullOnDelete();
                $table->foreignId('module_id')->nullable()->constrained('modules')->nullOnDelete();
                $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete();
                $table->char('idempotency_key_hash', 64)->nullable();
                $table->string('status', 40)->default('draft');
                $table->unsignedInteger('draft_revision')->default(1);
                $table->longText('draft_payload')->nullable();

                $table->string('manager_name_snapshot')->nullable();
                $table->string('manager_email_snapshot')->nullable();
                $table->decimal('commission_rate_snapshot', 5, 2)->default(0);
                $table->decimal('commission_base_snapshot', 24, 2)->default(0);
                $table->decimal('commission_amount_snapshot', 24, 2)->default(0);
                $table->string('currency', 3)->default('PKR');

                $table->string('owner_first_name')->nullable();
                $table->string('owner_last_name')->nullable();
                $table->string('owner_email')->nullable();
                $table->string('owner_phone', 30)->nullable();
                $table->string('owner_tin')->nullable();
                $table->date('owner_tin_expire_date')->nullable();
                $table->string('owner_tin_certificate_path')->nullable();

                $table->string('store_name')->nullable();
                $table->string('store_phone', 30)->nullable();
                $table->string('store_email')->nullable();
                $table->string('module_name_snapshot')->nullable();
                $table->string('zone_name_snapshot')->nullable();
                $table->text('formatted_address')->nullable();
                $table->decimal('latitude', 10, 7)->nullable();
                $table->decimal('longitude', 10, 7)->nullable();
                $table->string('place_id', 255)->nullable();
                $table->unsignedInteger('delivery_time_min')->nullable();
                $table->unsignedInteger('delivery_time_max')->nullable();
                $table->string('delivery_time_unit', 20)->nullable();

                $table->timestamp('submitted_at')->nullable();
                $table->timestamp('last_draft_synced_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->unique(
                    ['onboarding_manager_id', 'idempotency_key_hash'],
                    'onboarding_apps_manager_idempotency_unique',
                );
                $table->index('vendor_id', 'onboarding_apps_vendor_idx');
                $table->index('store_id', 'onboarding_apps_store_idx');
                $table->index(['onboarding_manager_id', 'status', 'created_at'], 'onboarding_apps_manager_status_idx');
                $table->index(['status', 'created_at'], 'onboarding_apps_status_idx');
                $table->index(['zone_id', 'status'], 'onboarding_apps_zone_status_idx');
            });
        }

        if (! Schema::hasTable('onboarding_application_status_histories')) {
            Schema::create('onboarding_application_status_histories', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('onboarding_application_id');
                $table->string('from_status', 40)->nullable();
                $table->string('to_status', 40);
                $table->string('actor_type', 40)->default('system');
                $table->unsignedBigInteger('actor_id')->nullable();
                $table->string('actor_name')->nullable();
                $table->text('note')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->foreign(
                    'onboarding_application_id',
                    'onboarding_status_app_fk',
                )->references('id')->on('onboarding_applications')->cascadeOnDelete();
                $table->index(
                    ['onboarding_application_id', 'created_at'],
                    'onboarding_status_app_time_idx',
                );
                $table->index(['to_status', 'created_at'], 'onboarding_status_state_time_idx');
            });
        }

        if (! Schema::hasTable('onboarding_application_media')) {
            Schema::create('onboarding_application_media', function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('onboarding_application_id')->nullable();
                $table->foreignId('onboarding_manager_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('draft_key', 100)->nullable();
                $table->string('collection', 30);
                $table->string('disk', 40)->default('public');
                $table->string('path');
                $table->string('original_name')->nullable();
                $table->string('mime_type', 100)->nullable();
                $table->unsignedBigInteger('size_bytes')->default(0);
                $table->char('checksum_sha256', 64)->nullable();
                $table->unsignedInteger('sort_order')->default(0);
                $table->string('status', 30)->default('temporary');
                $table->timestamp('uploaded_at')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->foreign(
                    'onboarding_application_id',
                    'onboarding_media_app_fk',
                )->references('id')->on('onboarding_applications')->cascadeOnDelete();
                $table->index(
                    ['onboarding_application_id', 'collection', 'sort_order'],
                    'onboarding_media_app_collection_idx',
                );
                $table->index(
                    ['onboarding_manager_id', 'draft_key', 'status'],
                    'onboarding_media_manager_draft_idx',
                );
                $table->index(['status', 'created_at'], 'onboarding_media_cleanup_idx');
            });
        }

        if (Schema::hasTable('onboarding_invoices')
            && ! Schema::hasColumn('onboarding_invoices', 'onboarding_application_id')) {
            Schema::table('onboarding_invoices', function (Blueprint $table): void {
                $table->foreignId('onboarding_application_id')
                    ->nullable()
                    ->after('id')
                    ->constrained('onboarding_applications')
                    ->nullOnDelete();
                $table->index('onboarding_application_id', 'onboarding_invoice_application_idx');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('onboarding_invoices')
            && Schema::hasColumn('onboarding_invoices', 'onboarding_application_id')) {
            Schema::table('onboarding_invoices', function (Blueprint $table): void {
                $table->dropForeign(['onboarding_application_id']);
                $table->dropIndex('onboarding_invoice_application_idx');
                $table->dropColumn('onboarding_application_id');
            });
        }

        Schema::dropIfExists('onboarding_application_media');
        Schema::dropIfExists('onboarding_application_status_histories');
        Schema::dropIfExists('onboarding_applications');
    }
};
