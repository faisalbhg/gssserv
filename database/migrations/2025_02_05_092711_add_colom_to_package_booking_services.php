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
        Schema::table('package_booking_services', function (Blueprint $table) {
            $table->string('package_duration')->nullable()->after('package_code');
            $table->integer('package_type')->nullable()->after('package_description');
            $table->string('package_km')->nullable()->after('package_type');
            $table->timestamp('package_date_time')->nullable()->after('package_km');
            $table->integer('package_service_use_count')->nullable()->after('package_date_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_booking_services', function (Blueprint $table) {
            //
        });
    }
};
