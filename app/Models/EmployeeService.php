<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeService extends Model
{
    //

//    public function services(){
//        return $this->belongsToMany(EmployeeService::class , ServicesEmpServices::class , "emp_service_id" , "service_id");
//    }

    public function mainService(){
        return $this->belongsTo(Service::class , "service_id" );
    }
}
