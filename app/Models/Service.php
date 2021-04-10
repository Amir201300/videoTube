<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //

    public function subTasks(){
        return $this->belongsToMany(EmployeeService::class , ServicesEmpServices::class , "service_id" , "emp_service_id");
    }
}
