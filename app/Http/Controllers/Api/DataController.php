<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\DefaultModelResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\VoiceOverResource;
use App\Interfaces\UserInterface;
use App\Models\Audience;
use App\Models\EmployeeService;
use App\Models\Goal;
use App\Models\Sector;
use App\Models\Specialty;
use App\Models\VoiceOver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth, Artisan, Hash, File, Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Manage\EmailsController;

class DataController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployeeService(){
        $service=EmployeeService::all();
        return $this->apiResponseData(DefaultModelResource::collection($service),'success',200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSpecialty(){
        $data=Specialty::all();
        return $this->apiResponseData(DefaultModelResource::collection($data),'success',200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSector(){
        $data=Sector::all();
        return $this->apiResponseData(DefaultModelResource::collection($data),'success',200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVoices(Request $request){
        $voiceOver=VoiceOver::where('type',$request->type)->get();
        return $this->apiResponseData(VoiceOverResource::collection($voiceOver),'success',200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getGoals(){
        $data=Goal::all();
        return $this->apiResponseData(DefaultModelResource::collection($data),'success',200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAudiences(){
        $data=Audience::all();
        return $this->apiResponseData(DefaultModelResource::collection($data),'success',200);
    }

}
