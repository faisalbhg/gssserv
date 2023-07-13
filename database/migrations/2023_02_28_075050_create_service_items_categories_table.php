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
        Schema::create('service_items_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_item_id');
            $table->unsignedBigInteger('category_id');
            $table->foreign('service_item_id')->references('id')->on('service_items')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('service_item_categories')->onDelete('cascade');
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
        Schema::dropIfExists('service_items_categories');
    }
};
