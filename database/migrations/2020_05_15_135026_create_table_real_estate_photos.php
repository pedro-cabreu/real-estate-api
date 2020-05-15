<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRealEstatePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('real_estate_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('real_estate_id');
            $table->string('photo');
            $table->boolean('is_thumb');

            $table->timestamps();

            $table->foreign('real_estate_id')->references('id')->on('real_estate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('real_estate_photos');
    }
}
