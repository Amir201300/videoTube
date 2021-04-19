<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeService extends Model
{

    public function mainService(){
        return $this->belongsTo(Service::class , "service_id" );
    }
}
