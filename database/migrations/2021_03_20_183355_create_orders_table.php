<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numberOfMinutes',30)->nullable();
            $table->tinyInteger('haveText')->default(0)->nullable();
            $table->tinyInteger('acceptedPriceOfText')->default(0)->nullable();
            $table->integer('countOfTextWord')->nullable();
            $table->text('projectIdea')->nullable();
            $table->text('package')->nullable();
            $table->text('specialPoint')->nullable();
            $table->tinyInteger('projectLang')->nullable();
            $table->tinyInteger('showLangType')->nullable();
            $table->tinyInteger('voiceOverGender')->nullable();
            $table->string('facebookSize')->nullable();
            $table->string('snapSize')->nullable();
            $table->string('youtubeSize')->nullable();
            $table->string('instagramSize')->nullable();
            $table->string('twitterSize')->nullable();
            $table->string('specialties_id')->nullable();
            $table->tinyInteger('isPromotionNameRequired')->nullable();
            $table->string('goal_id')->nullable();
            $table->string('audience_id')->nullable();
            $table->string('Sector_id')->nullable();
            $table->string('color')->nullable();
            $table->string('font')->nullable();
            $table->double('price')->nullable();
            $table->double('langPrice')->nullable();
            $table->double('timePrice')->nullable();
            $table->double('sizePrice')->nullable();
            $table->double('textPrice')->nullable();
            $table->tinyInteger('CategoryType')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
