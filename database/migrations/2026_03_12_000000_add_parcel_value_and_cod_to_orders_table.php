<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'parcel_value')) {
                $table->decimal('parcel_value', 16, 2)->default(0)->after('order_amount');
            }

            if (!Schema::hasColumn('orders', 'parcel_cod')) {
                $table->boolean('parcel_cod')->default(0)->after('parcel_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'parcel_value')) {
                $table->dropColumn('parcel_value');
            }

            if (Schema::hasColumn('orders', 'parcel_cod')) {
                $table->dropColumn('parcel_cod');
            }
        });
    }
};

