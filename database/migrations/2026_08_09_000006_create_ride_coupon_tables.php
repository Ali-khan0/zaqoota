<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ride_coupons')) {
            Schema::create('ride_coupons', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('code', 100)->unique();
                $table->string('discount_type', 20);
                $table->decimal('discount', 12, 2);
                $table->decimal('max_discount', 12, 2)->default(0);
                $table->decimal('min_fare', 12, 2)->default(0);
                $table->json('zone_ids')->nullable();
                $table->json('ride_category_ids')->nullable();
                $table->json('payment_methods')->nullable();
                $table->boolean('first_ride_only')->default(false);
                $table->unsignedInteger('total_limit')->nullable();
                $table->unsignedInteger('per_user_limit')->default(1);
                $table->dateTime('starts_at');
                $table->dateTime('expires_at');
                $table->boolean('status')->default(true);
                $table->timestamps();
                $table->index(['status', 'starts_at', 'expires_at']);
            });
        }

        if (! Schema::hasTable('ride_coupon_usages')) {
            Schema::create('ride_coupon_usages', function (Blueprint $table) {
                $table->id();
                $table->foreignId('ride_coupon_id')->constrained('ride_coupons')->cascadeOnDelete();
                $table->foreignId('ride_request_id')->constrained('ride_requests')->cascadeOnDelete();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->decimal('discount_amount', 12, 2);
                $table->string('status', 20)->default('reserved');
                $table->timestamp('reserved_at');
                $table->timestamp('redeemed_at')->nullable();
                $table->timestamp('released_at')->nullable();
                $table->timestamps();
                $table->unique('ride_request_id');
                $table->index(['ride_coupon_id', 'status']);
                $table->index(['user_id', 'status']);
            });
        }

        $rideColumns = [
            'ride_coupon_id' => Schema::hasColumn('ride_requests', 'ride_coupon_id'),
            'coupon_code' => Schema::hasColumn('ride_requests', 'coupon_code'),
            'coupon_discount_amount' => Schema::hasColumn('ride_requests', 'coupon_discount_amount'),
            'admin_coupon_expense_amount' => Schema::hasColumn('ride_requests', 'admin_coupon_expense_amount'),
            'coupon_payment_methods' => Schema::hasColumn('ride_requests', 'coupon_payment_methods'),
        ];
        Schema::table('ride_requests', function (Blueprint $table) use ($rideColumns) {
            if (! $rideColumns['ride_coupon_id']) {
                $table->foreignId('ride_coupon_id')->nullable()->after('ride_fare_id')->constrained('ride_coupons')->nullOnDelete();
            }
            if (! $rideColumns['coupon_code']) {
                $table->string('coupon_code', 100)->nullable()->after('ride_coupon_id');
            }
            if (! $rideColumns['coupon_discount_amount']) {
                $table->decimal('coupon_discount_amount', 12, 2)->default(0)->after('coupon_code');
            }
            if (! $rideColumns['admin_coupon_expense_amount']) {
                $table->decimal('admin_coupon_expense_amount', 12, 2)->default(0)->after('coupon_discount_amount');
            }
            if (! $rideColumns['coupon_payment_methods']) {
                $table->json('coupon_payment_methods')->nullable()->after('admin_coupon_expense_amount');
            }
        });

        if (! Schema::hasColumn('expenses', 'ride_request_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->foreignId('ride_request_id')->nullable()->after('order_id')->constrained('ride_requests')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('expenses', 'ride_request_id')) {
            Schema::table('expenses', function (Blueprint $table) {
                $table->dropConstrainedForeignId('ride_request_id');
            });
        }
        if (Schema::hasColumn('ride_requests', 'ride_coupon_id')) {
            Schema::table('ride_requests', fn (Blueprint $table) => $table->dropConstrainedForeignId('ride_coupon_id'));
        }
        foreach (['coupon_code', 'coupon_discount_amount', 'admin_coupon_expense_amount', 'coupon_payment_methods'] as $column) {
            if (Schema::hasColumn('ride_requests', $column)) {
                Schema::table('ride_requests', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }
        Schema::dropIfExists('ride_coupon_usages');
        Schema::dropIfExists('ride_coupons');
    }
};
