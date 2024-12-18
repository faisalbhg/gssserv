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
        Schema::create('plate_emirates_categories', function (Blueprint $table) {
            $table->id();
            $table->integer('plateCategoryId');
            $table->integer('plateEmiratesId');
            $table->string('plateCategoryTitle');
            $table->text('plateCategoryDesc');
            $table->integer('is_active')->nullable();
            $table->integer('is_deleted')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plate_emirates_categories');
    }
};
