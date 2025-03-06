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
            $table->timestamp('tinting_time_in')->nullable()->after('wash_service_time_in');
            $table->timestamp('tinting_time_out')->nullable()->after('tinting_time_in');
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
