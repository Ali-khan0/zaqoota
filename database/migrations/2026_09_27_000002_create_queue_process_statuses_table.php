<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('queue_process_statuses')) {
            Schema::create('queue_process_statuses', function (Blueprint $table) {
                $table->id();
                $table->string('process', 80)->unique();
                $table->boolean('enabled')->default(true);
                $table->unsignedBigInteger('processed_count')->default(0);
                $table->unsignedBigInteger('failed_count')->default(0);
                $table->unsignedBigInteger('skipped_count')->default(0);
                $table->timestamp('last_processed_at')->nullable();
                $table->timestamp('last_failed_at')->nullable();
                $table->timestamp('last_skipped_at')->nullable();
                $table->text('last_error')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('queue_process_statuses');
    }
};
