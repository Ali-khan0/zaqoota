<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ops_manager_withdrawals', function (Blueprint $table): void {
            $table->string('proof_disk')->nullable();
            $table->string('proof_path')->nullable();
            $table->string('proof_mime')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('ops_manager_withdrawals', fn (Blueprint $table) => $table->dropColumn(['proof_disk', 'proof_path', 'proof_mime']));
    }
};
