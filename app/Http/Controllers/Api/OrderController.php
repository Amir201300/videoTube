<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\OrderResource;
use App\Interfaces\UserInterface;
use App\Models\Employee;
use App\Models\Employee_exprince;
use App\Models\Order;
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

}
