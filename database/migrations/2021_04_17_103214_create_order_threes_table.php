<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderThreesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_threes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->tinyInteger('is_motion');
            $table->tinyInteger('is_film'); /** 1=>no , 2=> . 3 => */
            $table->double('price_motion');
            $table->integer('numberOfMin');
            $table->string('dataFilm')->nullable();
            $table->string('facebookSize')->nullable();
            $table->string('snapSize')->nullable();
            $table->string('youtubeSize')->nullable();
            $table->string('instagramSize')->nullable();
            $table->string('twitterSize')->nullable();
            $table->double('timePrice')->nullable();
            $table->double('sizePrice')->nullable();
            $table->double('textPrice')->nullable();
            $table->double('langPrice')->nullable();
            $table->tinyInteger('projectLang')->nullable();
            $table->tinyInteger('showLangType')->nullable();
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
        Schema::dropIfExists('order_threes');
    }
}
