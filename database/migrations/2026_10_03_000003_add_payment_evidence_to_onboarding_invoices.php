<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table): void {
            $table->string('payment_proof_disk', 40)->nullable()->after('payment_reference');
            $table->string('payment_proof_path')->nullable()->after('payment_proof_disk');
            $table->string('payment_proof_name')->nullable()->after('payment_proof_path');
            $table->string('payment_proof_mime', 100)->nullable()->after('payment_proof_name');
            $table->unsignedBigInteger('payment_proof_size')->nullable()->after('payment_proof_mime');
        });
    }

    public function down(): void
    {
        Schema::table('onboarding_invoices', function (Blueprint $table): void {
            $table->dropColumn([
                'payment_proof_disk',
                'payment_proof_path',
                'payment_proof_name',
                'payment_proof_mime',
                'payment_proof_size',
            ]);
        });
    }
};
