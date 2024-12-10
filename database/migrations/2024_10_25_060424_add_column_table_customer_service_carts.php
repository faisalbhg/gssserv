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
        Schema::table('customer_service_carts', function (Blueprint $table) {
            $table->integer('price_id')->nullable()->after('section_code');
            $table->integer('customer_group_id')->nullable()->after('price_id');
            $table->string('customer_group_code')->nullable()->after('customer_group_id');
            $table->double('min_price',8,2)->nullable()->after('customer_group_code');
            $table->double('max_price',8,2)->nullable()->after('section_code');
            $table->datetime('start_date')->nullable()->after('section_code');
            $table->datetime('end_date')->nullable()->after('section_code');
            $table->string('discount_perc')->nullable()->after('section_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_service_carts', function (Blueprint $table) {
            //
        });
    }
};
