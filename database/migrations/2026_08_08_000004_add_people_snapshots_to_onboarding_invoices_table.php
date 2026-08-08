<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table) {
            $table->string('store_owner_name')->nullable()->after('store_name');
            $table->string('generated_by_name')->nullable()->after('created_by');
        });
    }

    public function down(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table) {
            $table->dropColumn(['store_owner_name', 'generated_by_name']);
        });
    }
};
