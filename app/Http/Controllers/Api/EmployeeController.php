<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EmployeeResource;
use App\Interfaces\UserInterface;
use App\Models\Employee;
use App\Models\Employee_exprince;
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

}
