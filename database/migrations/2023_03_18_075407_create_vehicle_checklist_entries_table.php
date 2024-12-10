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
        Schema::create('vehicle_checklist_entries', function (Blueprint $table) {
            $table->id();
            $table->string('job_number');
            $table->integer('job_id');
            $table->text('checklist')->nullable();
            $table->integer('fuel')->nullable();
            $table->text('scratches_found')->nullable();
            $table->text('scratches_notfound')->nullable();
            $table->text('vehicle_image')->nullable();
            $table->text('signature')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('is_status')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();

            //$table->foreign('job_id')->references('id')->on('customerjobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_checklist_entries');
    }
};
