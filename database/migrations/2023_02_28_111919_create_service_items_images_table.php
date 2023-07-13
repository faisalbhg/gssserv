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
        Schema::create('service_items_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_item_id');
            $table->string('images')->nullable();
            $table->timestamps();
            $table->foreign('service_item_id')->references('id')->on('service_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_items_images');
    }
};
