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
            $table->double('manual_discount_value',  8, 2)->nullable()->after('warrantyTerms');
            $table->string('manual_discount_percentage')->nullable()->after('manual_discount_value');
            $table->integer('manual_discount_applied_by')->nullable()->after('manual_discount_percentage');
            $table->datetime('manual_discount_applied_datetime')->nullable()->after('manual_discount_applied_by');
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
