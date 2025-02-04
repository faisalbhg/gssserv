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
        Schema::create('package_booking_service_logs', function (Blueprint $table) {
            $table->id();
            $table->string('package_number');
            $table->unsignedBigInteger('customer_package_service_id');
            $table->integer('package_status')->nullable();
            $table->text('package_description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('customer_package_service_id')->references('id')->on('package_booking_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_booking_service_logs');
    }
};
