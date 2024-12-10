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
        Schema::create('customer_discount_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('vehicle_id');
            $table->integer('discount_id')->nullable();
            $table->string('discount_unit_id')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('discount_title')->nullable();
            $table->string('discount_card_imgae')->nullable();
            $table->string('discount_card_number')->nullable();
            $table->date('discount_card_validity')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_default')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->datetime('deleted_at')->nullable();
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
        Schema::dropIfExists('customer_discount_groups');
    }
};
