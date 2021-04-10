<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\OrderResource;
use App\Interfaces\UserInterface;
use App\Models\Employee;
use App\Models\Employee_exprince;
use App\Models\Order;
use App\Models\OrderProgress;
use App\Reposatries\OrderRepo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth, Artisan, Hash, File, Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Manage\EmailsController;

class OrderController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    public function makeOrder(Request $request,OrderRepo $orderRepo){
        $validate_order=$orderRepo->validate_order($request);
        if(isset($validate_order)){
            return $validate_order;
        }
        $order=$orderRepo->save_order($request);
        return $this->apiResponseData(new OrderResource($order),'',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function singleOrder(Request $request){
        $user=Auth::user();
        $order=Order::where('id',$request->order_id)->where('user_id',$user->id)->first();
        if(Is_null($order)){
            $msg=get_user_lang() =='en' ? 'order not found' : 'الطلب غير موجود';
            return $this->apiResponseMessage(0,$msg,200);
        }
        return $this->apiResponseData(new OrderResource($order),'',200);
    }

    public function acceptReview(Request $request){
        $lang = get_user_lang() ;
        $user = Auth::user() ;
        $task = OrderProgress::find($request->task_id);
        $empServiceId = $task->emp->service->id ;
        $check = $this->not_found($task , "الطلب" , "Order" ,$lang);
        if($check) return $check ;
        $order = Order::find($task->order_id);
        if($order->user_id != $user->id){
            $msg = $lang == "en" ? "this Order not assigned for this user" :"هذا الطلب ليس لنفس المستخدم" ;
            return  $this->apiResponseMessage(0 , $msg);
        }
        $task->status = order_task_completed ;
        $task->save();

        $order->status = getOrderStatusCompleted($empServiceId);
        $order->save() ;

        $msg = $lang == "en" ?"Task Accepted" :"تم قبول الطلب" ;
        return  $this->apiResponseMessage(1 , $msg);
    }

}
