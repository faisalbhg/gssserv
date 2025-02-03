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
        Schema::table('package_bookings', function (Blueprint $table) {
            $table->integer('otp_code')->nullable()->after('customer_id');
            $table->integer('otp_verify')->nullable()->after('otp_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('package_bookings', function (Blueprint $table) {
            //
        });
    }
};
