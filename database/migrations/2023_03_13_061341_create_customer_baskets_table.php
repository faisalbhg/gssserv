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
        Schema::create('customer_baskets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->integer('service_type_id')->nullable();
            $table->string('service_type_name')->nullable();
            $table->string('service_type_code')->nullable();
            $table->integer('service_group_id')->nullable();
            $table->string('service_group_name')->nullable();
            $table->string('service_group_code')->nullable();
            $table->integer('service_item')->nullable();
            $table->unsignedBigInteger('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->string('brand_name')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('category_name')->nullable();
            $table->unsignedBigInteger('item_group_id')->nullable();
            $table->string('item_group_name')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('station_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->double('price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('save_type')->nullable();
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('service_items');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('vehicle_id')->references('id')->on('customer_vehicles');
            $table->foreign('brand_id')->references('id')->on('service_item_brands');
            $table->foreign('item_group_id')->references('id')->on('item_product_groups');
            $table->foreign('category_id')->references('id')->on('service_item_categories');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('section_id')->references('id')->on('sections');
            $table->foreign('station_id')->references('id')->on('stationcodes');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_baskets');
    }
};
