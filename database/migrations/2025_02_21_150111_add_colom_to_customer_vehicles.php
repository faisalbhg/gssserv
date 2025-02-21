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
            $table->integer('staff_name')->nullable()->after('chaisis_image');
            $table->integer('staff_id')->nullable()->after('staff_name');

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
