<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->tinyInteger('userType')->nullable();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('image')->nullable();
            $table->string('socialKey')->nullable();
            $table->text('fire_base')->nullable();
            $table->smallInteger('status')->default(0)->nullable();
            $table->integer('active_code')->nullable();
            $table->integer('password_code')->nullable();
            $table->smallInteger('social')->default(0)->nullable();
            $table->string('lang',10)->default('ar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
