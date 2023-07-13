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
        Schema::create('service_item_brands', function (Blueprint $table) {
            $table->id();
            $table->string('brand_code');
            $table->string('brand_name');
            $table->string('brand_description')->nullable();
            $table->string('brand_image')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_delete')->nullable();
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
        Schema::dropIfExists('service_item_brands');
    }
};
