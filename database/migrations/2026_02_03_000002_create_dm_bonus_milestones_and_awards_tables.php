<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dm_bonus_milestones', function (Blueprint $table) {
            $table->id();
            $table->string('period_type', 20);
            $table->unsignedTinyInteger('slot')->default(1);
            $table->unsignedInteger('orders_required');
            $table->decimal('bonus_amount', 24, 2);
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['period_type', 'slot']);
        });

        Schema::create('dm_bonus_awards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('delivery_man_id');
            $table->unsignedBigInteger('dm_bonus_milestone_id');
            $table->string('period_key', 32);
            $table->unsignedInteger('delivered_count')->default(0);
            $table->decimal('amount', 24, 2);
            $table->timestamp('awarded_at')->nullable();
            $table->timestamps();

            $table->unique(['delivery_man_id', 'dm_bonus_milestone_id', 'period_key'], 'dm_bonus_award_unique');
            $table->foreign('delivery_man_id')->references('id')->on('delivery_men')->onDelete('cascade');
            $table->foreign('dm_bonus_milestone_id', 'dm_bonus_awards_milestone_fk')
                ->references('id')->on('dm_bonus_milestones')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dm_bonus_awards');
        Schema::dropIfExists('dm_bonus_milestones');
    }
};
