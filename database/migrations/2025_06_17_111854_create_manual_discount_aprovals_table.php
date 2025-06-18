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
        Schema::create('manual_discount_aprovals', function (Blueprint $table) {
            $table->id();
            $table->double('manual_discount_value',  8, 2)->nullable()->after('warrantyTerms');
            $table->string('manual_discount_percentage')->nullable()->after('manual_discount_value');
            $table->integer('manual_discount_applied_by')->nullable()->after('manual_discount_percentage');
            $table->datetime('manual_discount_applied_datetime')->nullable()->after('manual_discount_applied_by');
            $table->integer('customer_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('customer_name')->nullable();
            $table->string('customer_mobile')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_trn')->nullable();
            $table->string('make')->nullable();
            $table->string('vehicle_image')->nullable();
            $table->string('model')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('station');
            $table->integer('discount_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->timestamps();
            $table->foreign('vehicle_id')->references('id')->on('customer_vehicles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manual_discount_aprovals');
    }
};
