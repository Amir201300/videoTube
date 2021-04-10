<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProgress extends Model
{
    //

    public function order(){
        return $this->belongsTo(Order::class , "order_id");
    }

    public function emp(){
        return $this->belongsTo(Employee::class , "emp_id") ;
    }

}
