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
        Schema::create('service_item_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_code');
            $table->string('category_name');
            $table->string('category_description')->nullable();
            $table->integer('parent_id')->default(0);;
            $table->string('category_image')->nullable();
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
        Schema::dropIfExists('service_item_categories');
    }
};
