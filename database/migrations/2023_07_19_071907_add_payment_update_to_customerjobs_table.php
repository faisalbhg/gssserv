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
        Schema::table('customerjobs', function (Blueprint $table) {
            $table->integer('payment_updated_by')->nullable()->after('payment_link');
            $table->timestamp('payment_updated_at')->nullable()->after('payment_updated_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customerjobs', function (Blueprint $table) {
            //
        });
    }
};
