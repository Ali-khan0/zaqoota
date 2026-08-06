<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_transactions', function (Blueprint $table) {
            $table->decimal('fleet_manager_commission', 24, 2)
                ->default(0)
                ->after('delivery_fee_comission');
        });

        DB::table('fleet_manager_earning_transactions')
            ->select(['id', 'order_id', 'amount'])
            ->orderBy('id')
            ->chunkById(500, function ($earnings) {
                foreach ($earnings as $earning) {
                    DB::table('order_transactions')
                        ->where('order_id', $earning->order_id)
                        ->update(['fleet_manager_commission' => $earning->amount]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('order_transactions', function (Blueprint $table) {
            $table->dropColumn('fleet_manager_commission');
        });
    }
};
