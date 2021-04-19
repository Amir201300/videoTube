<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTwosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_twos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->tinyInteger('is_motion');
            $table->tinyInteger('is_film'); /** 1=>no , 2=> . 3 => */
            $table->double('price_motion');
            $table->integer('numberOfMin');
            $table->string('dataFilm')->nullable();
            $table->double('price_film')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->string('contactNumber')->nullable();
            $table->tinyInteger('sessionAreaType')->nullable();
            $table->tinyInteger('photoType')->nullable(); /**  */
            $table->integer('numOfPerson')->nullable(); /**  */
            $table->integer('numOfDays')->nullable(); /**  */
            $table->tinyInteger('airVideoType')->nullable(); /**  */
            $table->tinyInteger('haveText')->default(0)->nullable();
            $table->longText('text')->default(0)->nullable();
            $table->tinyInteger('projectLang')->nullable();
            $table->tinyInteger('showLangType')->nullable();
            $table->tinyInteger('voiceOverGender')->nullable();
            $table->tinyInteger('isPromotionNameRequired')->nullable();
            $table->text('specialPoint')->nullable();
            $table->string('facebookSize')->nullable();
            $table->string('snapSize')->nullable();
            $table->string('youtubeSize')->nullable();
            $table->string('instagramSize')->nullable();
            $table->string('twitterSize')->nullable();
            $table->double('langPrice')->nullable();
            $table->double('sizePrice')->nullable();
            $table->double('textPrice')->nullable();
            $table->double('voicePrice')->nullable();
            $table->unsignedBigInteger('voiceModelArabic_id')->nullable();
            $table->foreign('voiceModelArabic_id')->references('id')->on('voice_over_models')->onDelete('set null');
            $table->unsignedBigInteger('voiceModelEnglish_id')->nullable();
            $table->foreign('voiceModelEnglish_id')->references('id')->on('voice_over_models')->onDelete('set null');
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
        Schema::dropIfExists('order_twos');
    }
}
