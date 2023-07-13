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
        Schema::create('customerjobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->nullable();
            $table->timestamp('job_date_time');
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('customer_type');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('vehicle_type')->nullable();
            $table->string('make')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('model')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('vehicle_km')->nullable();
            $table->unsignedBigInteger('station_id');
            $table->integer('coupon_used')->nullable();
            $table->integer('coupon_type')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('coupon_amount', 8, 2)->nullable();
            $table->double('total_price', 8, 2);
            $table->double('vat', 8, 2)->nullable();
            $table->double('grand_total', 8, 2);
            $table->integer('payment_type')->nullable();
            $table->integer('payment_status')->nullable();
            $table->text('payment_request')->nullable();
            $table->text('payment_response')->nullable();
            $table->string('payment_link')->nullable();
            $table->integer('job_create_status')->nullable();
            $table->integer('job_status')->nullable();
            $table->integer('job_departent')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('customer_type')->references('id')->on('customertypes');
            $table->foreign('vehicle_id')->references('id')->on('customer_vehicles');
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
        Schema::dropIfExists('customerjobs');
    }
};
