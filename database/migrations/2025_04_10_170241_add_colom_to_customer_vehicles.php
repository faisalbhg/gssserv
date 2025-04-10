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
            $table->text('vehicle_image_base64')->nullable()->after('plate_number_image_base64');
            $table->text('chaisis_image_base64')->nullable()->after('vehicle_image_base64');

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
