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
        Schema::table('customer_vehicles', function (Blueprint $table) {
            $table->integer('ceramic_wash_discount_count')->nullable()->after('plate_number_image');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_vehicles', function (Blueprint $table) {
            //
        });
    }
};
