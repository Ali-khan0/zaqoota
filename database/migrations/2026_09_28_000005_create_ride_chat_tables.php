<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ride_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
            $table->string('sender_type', 16);
            $table->unsignedBigInteger('sender_id');
            $table->string('client_id', 64);
            $table->text('message');
            $table->timestamp('seen_at')->nullable();
            $table->string('seen_by_type', 16)->nullable();
            $table->unsignedBigInteger('seen_by_id')->nullable();
            $table->timestamps();

            $table->unique(['ride_request_id', 'sender_type', 'sender_id', 'client_id'], 'ride_message_client_unique');
            $table->index(['ride_request_id', 'id']);
        });

        Schema::create('ride_chat_presences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
            $table->string('participant_type', 16);
            $table->unsignedBigInteger('participant_id');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->unique(['ride_request_id', 'participant_type', 'participant_id'], 'ride_chat_presence_unique');
            $table->index('expires_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ride_chat_presences');
        Schema::dropIfExists('ride_messages');
    }
};
