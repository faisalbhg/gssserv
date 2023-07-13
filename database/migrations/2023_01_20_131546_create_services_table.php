php<?php

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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_type_id');
            $table->unsignedBigInteger('customer_type');
            $table->unsignedBigInteger('vehicle_type')->nullable();
            $table->double('unit_price', 8, 2);
            $table->double('min_price', 8, 2);
            $table->double('max_price', 8, 2);
            $table->dateTime('start_date', $precision = 0);
            $table->dateTime('end_date', $precision = 0);
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('service_type_id')->references('id')->on('services_types')->onDelete('cascade');
            $table->foreign('customer_type')->references('id')->on('customertypes')->onDelete('cascade');
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
        Schema::dropIfExists('services');
    }
};
