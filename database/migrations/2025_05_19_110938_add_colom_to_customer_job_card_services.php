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
            $table->datetime('warranty_start')->nullable()->after('warrantyTerms');
            $table->datetime('warranty_ends')->nullable()->after('warranty_start');
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
