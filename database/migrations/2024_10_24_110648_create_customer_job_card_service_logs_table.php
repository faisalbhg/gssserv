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
        Schema::create('customer_job_card_service_logs', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->unsignedBigInteger('customer_job__card_service_id');
            $table->integer('job_status')->nullable();
            $table->integer('job_departent')->nullable();
            $table->text('job_description')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_blocked')->nullable();
            $table->timestamps();
            $table->foreign('customer_job__card_service_id')->references('id')->on('customer_job_card_services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_job_card_service_logs');
    }
};
