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
        Schema::create('temp_customer_service_carts', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('company_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->string('brand_id')->nullable();
            $table->integer('bar_code')->nullable();
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('cart_item_type')->nullable();
            $table->text('extra_note')->nullable();
            $table->integer('quantity_per_purchase')->nullable();
            $table->string('division_code')->nullable();
            $table->string('department_code')->nullable();
            $table->string('department_name')->nullable();
            $table->string('section_code')->nullable();
            $table->integer('price_id')->nullable();
            $table->integer('customer_group_id')->nullable();
            $table->string('customer_group_code')->nullable();
            $table->double('min_price',8,2)->nullable();
            $table->double('max_price',8,2)->nullable();
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('discount_perc')->nullable();
            $table->double('unit_price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('save_type')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('temp_customer_service_carts');
    }
};
