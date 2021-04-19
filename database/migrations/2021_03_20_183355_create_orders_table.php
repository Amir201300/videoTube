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
            $table->text('projectIdea')->nullable();
            $table->text('package')->nullable();
            $table->text('specialPoint')->nullable();
            $table->string('specialties_id')->nullable();
            $table->string('goal_id')->nullable();
            $table->string('audience_id')->nullable();
            $table->string('Sector_id')->nullable();
            $table->string('color')->nullable();
            $table->string('font')->nullable();
            $table->tinyInteger('rate')->nullable();
            $table->integer('period')->nullable();
            $table->text('rateComment')->nullable();
            $table->double('price')->nullable();
            $table->double('taxPrice')->nullable();
            $table->tinyInteger('CategoryType')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
