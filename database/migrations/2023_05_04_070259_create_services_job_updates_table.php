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
        Schema::create('services_job_updates', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('customer_job_service_id');
            $table->unsignedBigInteger('service_group_id')->nullable();
            $table->string('service_group_code')->nullable();
            $table->string('service_group_name')->nullable();
            $table->unsignedBigInteger('service_type_id')->nullable();
            $table->string('service_type_code')->nullable();
            $table->string('service_type_name')->nullable();
            $table->integer('service_item')->nullable();
            $table->integer('job_status')->nullable();
            $table->integer('job_departent')->nullable();
            $table->timestamp('pre_finishing_time_in')->nullable();
            $table->timestamp('pre_finishing_time_out')->nullable();
            $table->timestamp('finishing_time_in')->nullable();
            $table->timestamp('finishing_time_out')->nullable();
            $table->timestamp('glazing_time_in')->nullable();
            $table->timestamp('glazing_time_out')->nullable();
            $table->timestamp('seat_cleaning_time_in')->nullable();
            $table->timestamp('seat_cleaning_time_out')->nullable();
            $table->timestamp('interior_time_in')->nullable();
            $table->timestamp('interior_time_out')->nullable();
            $table->timestamp('oil_change_time_in')->nullable();
            $table->timestamp('oil_change_time_out')->nullable();
            $table->timestamp('wash_service_time_in')->nullable();
            $table->timestamp('wash_service_time_out')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('job_id')->references('id')->on('customerjobs');
            $table->foreign('customer_job_service_id')->references('id')->on('customerjobservices');
            $table->foreign('service_group_id')->references('id')->on('services_groups');
            $table->foreign('service_type_id')->references('id')->on('services_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services_job_updates');
    }
};
