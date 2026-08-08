<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('ride_requests', 'wallet_paid_amount')) {
            Schema::table('ride_requests', function (Blueprint $table) {
                $table->decimal('wallet_paid_amount', 12, 2)->default(0)->after('final_payable_amount');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('ride_requests', 'wallet_paid_amount')) {
            Schema::table('ride_requests', function (Blueprint $table) {
                $table->dropColumn('wallet_paid_amount');
            });
        }
    }
};
