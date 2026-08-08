<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('delivery_men') && Schema::hasColumn('delivery_men', 'earning')) {
            DB::table('delivery_men')->where('earning', '!=', 1)->update(['earning' => 1]);
        }
    }

    public function down(): void
    {
        // Previous salary/freelancer values cannot be reconstructed safely.
    }
};
