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
        Schema::create('service_items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('item_name');
            $table->string('item_slug');
            $table->string('item_description')->nullable();
            $table->string('search_description')->nullable();
            $table->string('item_image')->nullable();
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('sub_category_id');
            $table->unsignedBigInteger('product_group_id');
            $table->unsignedBigInteger('product_sub_group_id');
            $table->integer('unit_messure');
            $table->integer('is_vat_include');
            $table->double('vat', 8, 2);
            $table->double('cost_price', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->string('size');
            $table->string('height');
            $table->string('width');
            $table->string('weight');
            $table->integer('stock')->default(0);
            $table->unsignedBigInteger('department_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('station_id');
            $table->integer('is_active')->nullable();
            $table->integer('is_delete')->nullable();
            $table->foreign('brand_id')->references('id')->on('service_item_brands');
            $table->foreign('product_group_id')->references('id')->on('item_product_groups');
            $table->foreign('product_sub_group_id')->references('id')->on('item_product_groups');
            $table->foreign('category_id')->references('id')->on('service_item_categories');
            $table->foreign('sub_category_id')->references('id')->on('service_item_categories');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stationcodes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_items');
    }
};
