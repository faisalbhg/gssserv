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
        Schema::table('customer_service_carts', function (Blueprint $table) {
            $table->boolean('isWarranty')->nullable()->after('ceramic_wash_discount_count');
            $table->integer('warrantyPeriod')->nullable()->after('isWarranty');
            $table->text('warrantyTerms')->nullable()->after('warrantyPeriod');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_service_carts', function (Blueprint $table) {
            //
        });
    }
};
