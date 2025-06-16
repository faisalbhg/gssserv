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
        /*Schema::table('customer_job_cards', function (Blueprint $table) {
            $table->text('cancellation_reson')->nullable()->after('job_departent');
            $table->integer('cancelled_by')->nullable()->after('cancellation_reson');
            $table->datetime('cancelled_date_time')->nullable()->after('cancelled_by');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_job_cards', function (Blueprint $table) {
            //
        });
    }
};
