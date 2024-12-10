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
        Schema::create('customer_job_card_services', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->unsignedBigInteger('job_id');
            $table->integer('item_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('company_code')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('brand_id')->nullable();
            $table->string('bar_code')->nullable();
            $table->string('item_name')->nullable();
            $table->text('description')->nullable();
            $table->string('division_code')->nullable();
            $table->string('department_code')->nullable();
            $table->string('section_code')->nullable();
            $table->string('station');
            $table->integer('customer_discount_id')->nullable();
            $table->integer('discount_id')->nullable();
            $table->integer('discount_unit_id')->nullable();
            $table->string('discount_code')->nullable();
            $table->string('discount_title')->nullable();
            $table->string('discount_percentage')->nullable();
            $table->double('discount_amount', 8, 2)->nullable();
            $table->integer('coupon_used')->nullable();
            $table->integer('coupon_type')->nullable();
            $table->string('coupon_code')->nullable();
            $table->double('coupon_amount', 8, 2)->nullable();
            $table->double('total_price', 8, 2);
            $table->integer('quantity')->nullable();
            $table->double('vat', 8, 2)->nullable();
            $table->double('grand_total', 8, 2);
            $table->integer('job_status')->nullable();
            $table->integer('job_departent')->nullable();
            $table->integer('is_added')->nullable();
            $table->integer('is_removed')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('customer_job_cards');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_job_card_services');
    }
};
