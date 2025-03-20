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
        Schema::create('job_card_checklists', function (Blueprint $table) {
            $table->id();
            $table->string('job_number')->nullable();
            $table->integer('job_Service_id')->nullable();
            $table->text('checklist')->nullable();
            $table->text('checklist_notes')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('job_card_checklists');
    }
};
