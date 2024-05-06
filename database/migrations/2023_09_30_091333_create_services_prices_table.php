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
        Schema::create('services_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->string('service_code');
            $table->unsignedBigInteger('customer_type')->nullable();
            $table->unsignedBigInteger('vehicle_type')->nullable();
            $table->double('unit_price', 8, 2);
            $table->double('min_price', 8, 2)->nullable();
            $table->double('max_price', 8, 2)->nullable();
            $table->dateTime('start_date', $precision = 0)->nullable();
            $table->dateTime('end_date', $precision = 0)->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('service_masters');
            $table->foreign('customer_type')->references('id')->on('customertypes');
            $table->foreign('vehicle_type')->references('id')->on('vehicletypes');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stationcodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_prices');
    }
};
