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
        Schema::table('services_prices', function (Blueprint $table) {
            $table->string('discount_type')->nullable()->after('max_price');
            $table->string('discount_value')->nullable()->after('discount_type');
            $table->double('discount_amount', 8, 2)->nullable()->after('discount_value');
            $table->double('final_price_after_dicount', 8, 2)->nullable()->after('discount_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services_prices', function (Blueprint $table) {
            //
        });
    }
};
