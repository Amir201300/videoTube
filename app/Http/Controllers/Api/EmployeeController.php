<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EmployeeResource;
use App\Http\Resources\EmpOrdersResource;
use App\Http\Resources\OrderResource;
use App\Interfaces\UserInterface;
use App\Models\Employee;
use App\Models\Employee_exprince;
use App\Models\Order;
use App\Models\OrderProgress;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth, Artisan, Hash, File, Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Manage\EmailsController;



class EmployeeController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    public function apply(Request $request)
    {
        $user=Auth::user();
        $employee=Employee::where('user_id',$user->id)->first();
        if(is_null($employee)){
            $msg=get_user_lang() =='en' ? 'only employee can apply' : 'الموظفين فقط من يمكنهم التقديم';
            return $this->apiResponseMessage(0,$msg,200);
        }
        if($employee->status == 2){
            $msg=get_user_lang() =='en' ? 'Your request has already been submitted and is under review' : 'تم تقديم طلبك بالفعل وهو قيد المراجعه';
            return $this->apiResponseMessage(0,$msg,200);
        }
        $validate_apply = $this->validate_apply($request);
        if (isset($validate_apply)) {
            return $validate_apply;
        }
        $employee->name=$request->name;
        $employee->collage=$request->collage;
        $employee->bank_name=$request->bank_name;
        $employee->bank_country=$request->bank_country;
        $employee->bank_number=$request->bank_number;
        $employee->country=$request->country;
        $employee->email=$request->email;
        $employee->phone=$request->phone;
        $employee->iban_number=$request->iban_number;
        $employee->service_id=$request->service_id;
        $employee->experience=$request->experience;
        $employee->lang=$request->lang;
        if($request->cv) {
            deleteFile('Employee',$employee->cv);
            $employee->cv = saveImage('Employee', $request->cv);
        }
        if($request->id_number) {
            deleteFile('Employee',$employee->id_number);
            $employee->id_number = saveImage('Employee', $request->id_number);
        }
        $employee->status=2;
        $employee->save();
        if($request->ExperienceFiles){
            $this->ExperienceFiles($request->ExperienceFiles,$employee->id);
        }
        $msg=get_user_lang() =='en' ?'The request has been submitted successfully' : 'تم تقديم الطلب بنجاح';
        return $this->apiResponseData(new UserResource($user),$msg,200);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    private function validate_apply($request)
    {
        $lang =get_user_lang();
        $input = $request->all();
        $validationMessages = [
            'collage.required' => $lang == 'ar' ? 'من فضلك ادخل اسم الكلية' : "collage is required",
            'bank_name.required' => $lang == 'ar' ? 'من فضلك ادخل اسم البنك' : "bank name is required",
            'service_id.required' => $lang == 'ar' ? 'من فضلك ادخل نوع الخدمة' : "service type is required",
        ];

        $validator = Validator::make($input, [
            'bank_name' => 'required',
            'collage' => 'required',
            'service_id' => 'required|exists:employee_services,id',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0, $validator->messages()->first(), 2500);
        }
    }

    /**
     * @param $files
     * @param $id
     */
    private function ExperienceFiles($files,$id){
        foreach($files as $row){
            $exprinceFile=new Employee_exprince();
            $exprinceFile->employee_id=$id;
            $exprinceFile->file=saveImage('Experience',$row);
            $exprinceFile->save();
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function myApplication(Request $request){
        $user=AUth::user();
        return $this->apiResponseData(new EmployeeResource($user->employee),'success',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableTasks(Request $request){
        $lang = get_user_lang();
        $user = Auth::user() ;
        if(!is_null($user->employee->service->main_service))
        $mainServiceId  = $user->employee->service->mainService->id ;
        $serviceId = $user->employee->service->id ;
        $orders = null ;
        if($serviceId == writing) {
            $orders = Order::where("status", order_new)->where("haveText", 0);
        }elseif($serviceId == translating)
            $orders = Order::where(function ($q){
              $q->where("status" , order_new)->where("haveText" , 1 )->where("projectLang" , ">=" , 3);
        })->orWhere(function($q){
            $q->where("status" , order_writing_script_done);
            });
        elseif($serviceId == voice_over)
            $orders = Order::where(function ($q){
                $q->where('status' , order_new)->where("haveText")->where('projectLang' , "<=" , 2);
            })->orWhere("status", order_translating_done);
        else
            $orders = Order::where("status" , order_voice_over_done)->where("service_id" , $mainServiceId);
        $orders = OrderResource::collection($orders->get());
        $msg = $lang == "en" ? "data Optained Successfully" : "تم استرجاع المعلومات بنجاح" ;
        return $this->apiResponseData($orders , $msg) ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function assignUserToOrder(Request $request ){
        $lang = get_user_lang() ;
        $user = Auth::user();
        $empServiceId = $user->employee->service->id;
        $order = Order::find($request->order_id) ;
        $check = $this->not_found($order , "الطلب" , "Order" ,$lang);
        if($check)return $check;
        $orderOnProgressCunt = OrderProgress::where("emp_id",$user->id)->where("status" ,"!=" , order_task_completed)->count();
        if($orderOnProgressCunt > 0){
            $msg = $lang == "en" ? "You Can't Accept Other Order Till you finish " :"لا يمكنك قبول طلبات اخري الي ان تنتهي" ;
            return  $this->apiResponseMessage(0 , $msg);
        }
        $orderTask = new OrderProgress() ;
        $orderTask->order_id = $order->id ;
        $orderTask->emp_id = $user->employee->id ;
        $orderTask->status = order_task_on_progress ;
        $orderTask->save();

        $order->status = getOrderStatusOnProgress($empServiceId) ;
        $order->save();

        $msg = $lang == "en" ? "Order Assgined To the user" .$user->name : "تم تعيين الطلب للموظف  " .$user->name ;

        return $this->apiResponseData($orderTask , $msg);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAssignedTasks(Request $request){
        $lang = get_user_lang();
        $user = Auth::user();
        $orders = OrderProgress::where("emp_id" , $user->id)->with(['order'])->get();
        $orders = EmpOrdersResource::collection($orders) ;
        $msg = $lang == "en" ?"data Optained SuccessFully" : "تم استرجاع المعلومات بنجاح";
        return $this->apiResponseData($orders , $msg);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function submitTask(Request $request ){
        $lang = get_user_lang() ;
        $user = Auth::user();
        $task = OrderProgress::find($request->task_id) ;
        $check = $this->not_found($task , "الطلب" , "Order" ,$lang);
        if($check)return $check;
        $task->status = order_task_reviewing ;
        if($request->data_file){
            deleteFile("order_data" , $task->order_file);
            $task->data_file =  saveImage("order_data" , $request->file("data_file"));
        }
        $task->save();
        $msg = $lang == "en" ? "Order Send to Review team" : "تم ارسال التاسك للمرجعة";
        return $this->apiResponseData($task , $msg);
    }

}
