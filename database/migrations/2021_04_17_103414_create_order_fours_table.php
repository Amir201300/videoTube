<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderFoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_fours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('time')->nullable();
            $table->string('date')->nullable();
            $table->string('contactNumber')->nullable();
            $table->tinyInteger('sessionAreaType')->nullable();
            $table->tinyInteger('photoType')->nullable(); /**  */
            $table->integer('numOfPerson')->nullable(); /**  */
            $table->integer('numOfDays')->nullable(); /**  */
            $table->double('daysPrice')->nullable();
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
        Schema::dropIfExists('order_fours');
    }
}
