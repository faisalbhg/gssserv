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
        Schema::create('item_product_groups', function (Blueprint $table) {
            $table->id();
            $table->string('product_group_code');
            $table->string('product_group_name');
            $table->string('product_group_description')->nullable();
            $table->integer('parent_product_group_id')->default(0);;
            $table->string('product_group_image')->nullable();
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
        Schema::dropIfExists('item_product_groups');
    }
};
