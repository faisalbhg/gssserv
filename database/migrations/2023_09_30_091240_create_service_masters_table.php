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
        Schema::create('service_masters', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('service_code')->nullable();
            $table->text('service_description')->nullable();
            $table->double('cost_price', 8, 2);
            $table->double('sale_price', 8, 2);
            $table->integer('vat_included')->nullable();
            $table->unsignedBigInteger('service_section_group_id')->nullable();
            $table->string('service_section_group_code')->nullable();
            $table->unsignedBigInteger('service_group_id')->nullable();
            $table->string('service_group_code')->nullable();
            $table->unsignedBigInteger('vehicle_type')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->timestamps();
            $table->foreign('service_section_group_id')->references('id')->on('services_sections_groups');
            $table->foreign('service_group_id')->references('id')->on('services_groups');
            $table->foreign('vehicle_type')->references('id')->on('vehicletypes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_masters');
    }
};
