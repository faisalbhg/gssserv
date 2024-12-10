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
        Schema::create('customer_service_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
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
            $table->integer('quantity_per_purchase')->nullable();
            $table->string('division_code')->nullable();
            $table->string('department_code')->nullable();
            $table->string('section_code')->nullable();
            $table->double('unit_price', 8, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('save_type')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('customer_service_carts');
    }
};
