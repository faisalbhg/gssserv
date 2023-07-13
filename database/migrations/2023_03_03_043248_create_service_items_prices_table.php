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
        Schema::create('service_items_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_types');
            $table->unsignedBigInteger('item_id');
            $table->integer('unit_messure');
            $table->integer('is_vat_include');
            $table->double('vat', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->dateTime('start_date', $precision = 0);
            $table->dateTime('end_date', $precision = 0);
            $table->integer('is_active')->nullable();
            $table->integer('is_delete')->nullable();
            $table->timestamps();
            $table->foreign('customer_types')->references('id')->on('customertypes')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('service_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_items_prices');
    }
};
