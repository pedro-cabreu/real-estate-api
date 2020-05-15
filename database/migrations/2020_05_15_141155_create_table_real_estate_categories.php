<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRealEstateCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_categories', function (Blueprint $table) {
           
            $table->unsignedBigInteger('real_estate_id');
            $table->unsignedBigInteger('category_id');

            $table->foreign('real_estate_id')->references('id')->on('real_estate');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_categories');
    }
}
