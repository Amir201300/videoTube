<?php

/**
 * @return string
 */
function get_baseUrl()
{
    return url('/');
}

/**
 * @return mixed
 */
function get_user_lang()
{
    return Auth::user()->lang;
}
//order_progress Table Status Values
define('order_task_not_selected', 0);
define('order_task_on_progress', 1);
define('order_task_reviewing', 2);
define('order_task_completed', 3);
define('order_task_rejected', 4);

//order Status
define("order_new"  , 1);
define("order_writing_script"  , 2);
define("order_writing_script_done"  ,3);
define("order_translating"  , 4);
define("order_translating_done"  , 5);
define("order_voice_over"  , 6);
define("order_voice_over_done"  , 7);
define("order_real_task"  , 8);
define("order_real_task_done"  ,9);

//Base Services
define("writing" , 1 );
define("translating" , 2 );
define("voice_over" , 3 );


 function getOrderStatus($empServiceId){
     switch ($empServiceId){
         case writing :
             return order_writing_script;
         case translating:
             return order_translating ;
         case voice_over:
             return order_voice_over ;
         default:
             return order_real_task;
     }
 }
//order Functions
function is_service_base_service($serviceId){
    return $serviceId <= 3 ;
}


