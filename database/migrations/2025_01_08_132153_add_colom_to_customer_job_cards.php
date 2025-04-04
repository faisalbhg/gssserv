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
        Schema::table('customer_job_cards', function (Blueprint $table) {
            $table->integer('is_contract')->nullable()->after('ql_km_range');
            $table->integer('contract_id')->nullable()->after('is_contract');
            $table->string('contract_code')->nullable()->after('contract_id');
        });
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
