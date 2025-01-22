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
        Schema::table('temp_customer_service_carts', function (Blueprint $table) {
            $table->string('section_name')->nullable()->after('department_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('temp_customer_service_carts', function (Blueprint $table) {
            //
        });
    }
};
