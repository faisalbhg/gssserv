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
        Schema::create('package_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('package_number')->nullable();
            $table->string('package_name')->nullable();
            $table->string('package_code')->nullable();
            $table->integer('package_id')->nullable();
            $table->string('package_duration')->nullable();
            $table->text('package_description')->nullable();
            $table->integer('package_type')->nullable();
            $table->string('package_km')->nullable();
            $table->timestamp('package_date_time');
            $table->unsignedBigInteger('customer_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_trn')->nullable();
            $table->integer('vehicle_id');
            $table->string('vehicle_type')->nullable();
            $table->string('make')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('model')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('vehicle_km')->nullable();
            $table->string('station');
            $table->double('total_price', 8, 2);
            $table->double('vat', 8, 2)->nullable();
            $table->double('grand_total', 8, 2);
            $table->integer('payment_type')->nullable();
            $table->integer('payment_status')->nullable();
            $table->text('payment_request')->nullable();
            $table->text('payment_response')->nullable();
            $table->string('payment_link')->nullable();
            $table->integer('package_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_bookings');
    }
};
