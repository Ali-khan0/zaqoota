<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('ride_requests', 'carried_cancellation_due_amount')) {
                $table->decimal('carried_cancellation_due_amount', 12, 2)->default(0)->after('cancellation_charge_amount');
            }
            if (! Schema::hasColumn('ride_requests', 'cancellation_compensation_paid_at')) {
                $table->timestamp('cancellation_compensation_paid_at')->nullable()->after('cancelled_at');
            }
            if (! Schema::hasColumn('ride_requests', 'cancellation_recovered_at')) {
                $table->timestamp('cancellation_recovered_at')->nullable()->after('cancellation_compensation_paid_at');
            }
            if (! Schema::hasColumn('ride_requests', 'recovery_ride_id')) {
                $table->foreignId('recovery_ride_id')->nullable()->after('cancellation_recovered_at')->constrained('ride_requests')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ride_requests', function (Blueprint $table) {
            if (Schema::hasColumn('ride_requests', 'recovery_ride_id')) {
                $table->dropConstrainedForeignId('recovery_ride_id');
            }
            foreach (['carried_cancellation_due_amount', 'cancellation_compensation_paid_at', 'cancellation_recovered_at'] as $column) {
                if (Schema::hasColumn('ride_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
