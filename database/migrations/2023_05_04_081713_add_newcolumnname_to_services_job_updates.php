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
        Schema::table('customerjobservices', function (Blueprint $table) {
            /*$table->integer('pre_finishing')->nullable();
            $table->timestamp('pre_finishing_time_in')->nullable();
            $table->timestamp('pre_finishing_time_out')->nullable();
            $table->integer('finishing')->nullable();
            $table->timestamp('finishing_time_in')->nullable();
            $table->timestamp('finishing_time_out')->nullable();
            $table->integer('glazing')->nullable();
            $table->timestamp('glazing_time_in')->nullable();
            $table->timestamp('glazing_time_out')->nullable();
            $table->integer('seat_cleaning')->nullable();
            $table->timestamp('seat_cleaning_time_in')->nullable();
            $table->timestamp('seat_cleaning_time_out')->nullable();
            $table->integer('interior')->nullable();
            $table->timestamp('interior_time_in')->nullable();
            $table->timestamp('interior_time_out')->nullable();
            $table->integer('oil_change')->nullable();
            $table->timestamp('oil_change_time_in')->nullable();
            $table->timestamp('oil_change_time_out')->nullable();
            $table->integer('wash_service')->nullable();
            $table->timestamp('wash_service_time_in')->nullable();
            $table->timestamp('wash_service_time_out')->nullable();*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customerjobservices', function (Blueprint $table) {
            //
        });
    }
};
