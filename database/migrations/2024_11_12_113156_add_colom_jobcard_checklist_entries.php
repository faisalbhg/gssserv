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
        Schema::table('jobcard_checklist_entries', function (Blueprint $table) {
            $table->text('turn_key_on_check_for_fault_codes')->nullable()->after('signature');
            $table->text('start_engine_observe_operation')->nullable()->after('turn_key_on_check_for_fault_codes');
            $table->text('reset_the_service_reminder_alert')->nullable()->after('start_engine_observe_operation');
            $table->text('stick_update_service_reminder_sticker_on_b_piller')->nullable()->after('reset_the_service_reminder_alert');
            $table->text('interior_cabin_inspection_comments')->nullable()->after('stick_update_service_reminder_sticker_on_b_piller');
            $table->text('check_power_steering_fluid_level')->nullable()->after('interior_cabin_inspection_comments');
            $table->text('check_power_steering_tank_cap_properly_fixed')->nullable()->after('check_power_steering_fluid_level');
            $table->text('check_brake_fluid_level')->nullable()->after('check_power_steering_tank_cap_properly_fixed');
            $table->text('brake_fluid_tank_cap_properly_fixed')->nullable()->after('check_brake_fluid_level');
            $table->text('check_engine_oil_level')->nullable()->after('brake_fluid_tank_cap_properly_fixed');
            $table->text('check_radiator_coolant_level')->nullable()->after('check_engine_oil_level');
            $table->text('check_radiator_cap_properly_fixed')->nullable()->after('check_radiator_coolant_level');
            $table->text('top_off_windshield_washer_fluid')->nullable()->after('check_radiator_cap_properly_fixed');
            $table->text('check_windshield_cap_properly_fixed')->nullable()->after('top_off_windshield_washer_fluid');
            $table->text('underHoodInspectionComments')->nullable()->after('check_windshield_cap_properly_fixed');
            $table->text('check_for_oil_leaks_engine_steering')->nullable()->after('underHoodInspectionComments');
            $table->text('check_for_oil_leak_oil_filtering')->nullable()->after('check_for_oil_leaks_engine_steering');
            $table->text('check_drain_lug_fixed_properly')->nullable()->after('check_for_oil_leak_oil_filtering');
            $table->text('check_oil_filter_fixed_properly')->nullable()->after('check_drain_lug_fixed_properly');
            $table->text('ubi_comments')->nullable()->after('check_oil_filter_fixed_properly');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobcard_checklist_entries', function (Blueprint $table) {
            //
        });
    }
};
