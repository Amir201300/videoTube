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
            $table->unsignedInteger("order_id")->nullable(false);
            $table->foreign("emp_id")->references("id")->on("services");
            $table->foreign("status")->references("id")->on("employee_services");
            $table->tinyInteger("payment_status")->default(0);
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
