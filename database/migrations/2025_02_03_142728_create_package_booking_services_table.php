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
        Schema::create('package_booking_services', function (Blueprint $table) {
            $table->id();
            $table->string('package_number');
            $table->unsignedBigInteger('package_id');
            $table->string('package_code')->nullable();
            $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->double('unit_price',  8, 2)->nullable();
            $table->double('discounted_price',  8, 2)->nullable();
            $table->double('discount_percentage')->nullable();
            $table->string('item_type')->nullable();
            $table->string('frequency')->nullable();
            $table->string('is_default')->nullable();
            $table->string('company_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->text('extra_note')->nullable();
            $table->integer('service_item_type')->nullable();
            $table->string('division_code')->nullable();
            $table->string('department_code')->nullable();
            $table->string('section_code')->nullable();
            $table->string('section_name')->nullable();
            $table->string('department_name')->nullable();
            $table->string('station');
            $table->double('total_price', 8, 2);
            $table->integer('quantity')->nullable();
            $table->double('vat', 8, 2)->nullable();
            $table->double('grand_total', 8, 2);
            $table->integer('package_status')->nullable();
            $table->integer('is_added')->nullable();
            $table->integer('is_removed')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('package_id')->references('id')->on('package_bookings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('package_booking_services');
    }
};
