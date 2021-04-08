<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->double('pricePerMinute')->nullable(); // سعر الدقيقة
            $table->double('textPricePerMinute')->nullable(); // سعر كتابة النص للدقيقة
            $table->double('twoLangPricePerMinuteOneVideo')->nullable(); // سعر الترجمة للدقيقة فيديو واحد
            $table->double('twoLangPricePerMinuteTwoVideo')->nullable();  // سعر الترجمة للدقيقة فيديوهين
            $table->double('voiceOverPricePerMinute')->nullable(); // سعر التعليق الصوتي للدقيقة
            $table->double('priceBySize')->nullable(); // سعر مقاس الفيديو الزائد للدقيقة
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
        Schema::dropIfExists('services');
    }
}
