<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_vehicles', function (Blueprint $table): void {
            if (! Schema::hasColumn('ride_vehicles', 'reviewed_by')) {
                $table->foreignId('reviewed_by')->nullable()->after('admin_note')->constrained('admins')->nullOnDelete();
            }
            if (! Schema::hasColumn('ride_vehicles', 'reviewed_at')) {
                $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            }
        });

        if (! Schema::hasTable('ride_vehicle_review_audits')) {
            Schema::create('ride_vehicle_review_audits', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('ride_vehicle_id')->constrained('ride_vehicles')->cascadeOnDelete();
                $table->foreignId('admin_id')->nullable()->constrained('admins')->nullOnDelete();
                $table->string('from_status', 20);
                $table->string('to_status', 20);
                $table->text('admin_note')->nullable();
                $table->timestamp('reviewed_at');
                $table->timestamps();

                $table->index(['ride_vehicle_id', 'reviewed_at'], 'ride_vehicle_review_audit_vehicle_time_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_vehicle_review_audits');

        Schema::table('ride_vehicles', function (Blueprint $table): void {
            $columns = array_values(array_filter(
                ['reviewed_by', 'reviewed_at'],
                fn (string $column) => Schema::hasColumn('ride_vehicles', $column),
            ));
            if ($columns !== []) {
                if (in_array('reviewed_by', $columns, true)) {
                    $table->dropConstrainedForeignId('reviewed_by');
                    $columns = array_values(array_diff($columns, ['reviewed_by']));
                }
                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            }
        });
    }
};
