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
            $table->integer('is_package')->nullable()->after('section_name');
            $table->string('package_code')->nullable()->after('is_package');
            $table->string('package_number')->nullable()->after('package_code');
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
