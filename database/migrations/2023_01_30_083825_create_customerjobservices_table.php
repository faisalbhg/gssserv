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
        Schema::create('customerjobservices', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('service_group_id')->nullable();
            $table->string('service_group_code')->nullable();
            $table->string('service_group_name')->nullable();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->string('service_type_code')->nullable();
            $table->string('service_type_name')->nullable();
            $table->integer('service_item')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->integer('item_group_id')->nullable();
            $table->string('product_group_name')->nullable();
            $table->integer('coupon_used')->nullable();
            $table->integer('coupon_type')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('coupon_amount', 8, 2)->nullable();
            $table->double('total_price', 8, 2);
            $table->integer('quantity');
            $table->double('vat', 8, 2)->nullable();
            $table->double('grand_total', 8, 2);
            $table->integer('job_status')->nullable();
            $table->integer('job_departent')->nullable();
            $table->integer('is_added')->nullable();
            $table->integer('is_removed')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('customerjobs');
            $table->foreign('service_group_id')->references('id')->on('services_groups');
            $table->foreign('service_type_id')->references('id')->on('services_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customerjobservices');
    }
};
