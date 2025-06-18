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
        Schema::create('manual_discount_services', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->nullable();
            $table->integer('cart_id')->nullable();
            $table->string('item_code')->nullable();
            $table->string('item_name')->nullable();
            $table->integer('service_item_type')->nullable();
            $table->string('department_code')->nullable();
            $table->string('department_name')->nullable();
            $table->string('section_code')->nullable();
            $table->string('section_name')->nullable();
            $table->double('unit_price',  8, 2)->nullable();
            $table->double('manual_discount_value',  8, 2)->nullable()->after('warrantyTerms');
            $table->string('manual_discount_percentage')->nullable()->after('manual_discount_value');
            $table->integer('manual_discount_applied_by')->nullable()->after('manual_discount_percentage');
            $table->datetime('manual_discount_applied_datetime')->nullable()->after('manual_discount_applied_by');
            $table->integer('discount_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('manual_discount_services');
    }
};
