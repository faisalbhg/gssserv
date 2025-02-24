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
        Schema::table('customer_job_card_services', function (Blueprint $table) {
            $table->integer('pre_finishing')->nullable()->after('staff_id');
            $table->timestamp('pre_finishing_time_in')->nullable()->after('pre_finishing');
            $table->timestamp('pre_finishing_time_out')->nullable()->after('pre_finishing_time_in');
            $table->integer('finishing')->nullable()->after('pre_finishing_time_out');
            $table->timestamp('finishing_time_in')->nullable()->after('finishing');
            $table->timestamp('finishing_time_out')->nullable()->after('finishing_time_in');
            $table->integer('glazing')->nullable()->after('finishing_time_out');
            $table->timestamp('glazing_time_in')->nullable()->after('glazing');
            $table->timestamp('glazing_time_out')->nullable()->after('glazing_time_in');
            $table->integer('seat_cleaning')->nullable()->after('glazing_time_out');
            $table->timestamp('seat_cleaning_time_in')->nullable()->after('seat_cleaning');
            $table->timestamp('seat_cleaning_time_out')->nullable()->after('seat_cleaning_time_in');
            $table->integer('interior')->nullable()->after('seat_cleaning_time_out');
            $table->timestamp('interior_time_in')->nullable()->after('interior');
            $table->timestamp('interior_time_out')->nullable()->after('interior_time_in');
            $table->integer('oil_change')->nullable()->after('interior_time_out');
            $table->timestamp('oil_change_time_in')->nullable()->after('oil_change');
            $table->timestamp('oil_change_time_out')->nullable()->after('oil_change_time_in');
            $table->integer('wash_service')->nullable()->after('oil_change_time_out');
            $table->timestamp('wash_service_time_in')->nullable()->after('wash_service');
            $table->timestamp('wash_service_time_out')->nullable()->after('wash_service_time_in');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_job_card_services', function (Blueprint $table) {
            //
        });
    }
};
