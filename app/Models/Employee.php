<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function experienceFiles(){
        return $this->hasMany(Employee_exprince::class,'employee_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service(){
        return $this->belongsTo(EmployeeService::class,'service_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function orders(){
        return $this->belongsToMany(Order::class , OrderEmp::class , "emp_id" , "order_id")->withPivot('status' , 'payment_status');
    }
}
