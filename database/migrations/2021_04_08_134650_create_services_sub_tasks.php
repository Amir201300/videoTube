<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesSubTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services_sub_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("service_id")->nullable(false);
            $table->unsignedInteger("emp_service_id")->nullable(false);
            $table->tinyInteger("status")->default(0);
            $table->tinyInteger("payment_status")->default(0)->comment("0=> not_paid , 1=> paid");
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
        Schema::dropIfExists('services_sub_tasks');
    }
}
