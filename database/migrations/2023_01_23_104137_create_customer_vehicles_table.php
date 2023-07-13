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
        Schema::create('customer_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vehicle_type');
            $table->string('make');
            $table->string('vehicle_image');
            $table->string('model')->nullable();
            $table->string('plate_state')->nullable();
            $table->string('plate_code')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('plate_number_final')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('vehicle_km')->nullable();
            $table->string('plate_number_image')->nullable();
            $table->string('chaisis_image')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('vehicle_type')->references('id')->on('vehicletypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_vehicles');
    }
};
