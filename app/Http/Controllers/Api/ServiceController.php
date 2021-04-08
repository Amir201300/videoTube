<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\ServiceResource;
use App\Interfaces\UserInterface;
use App\Models\Employee;
use App\Models\Employee_exprince;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator, Auth, Artisan, Hash, File, Crypt;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Http\Controllers\Manage\EmailsController;

class ServiceController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getService(Request $request){
        $service=Service::all();
        return $this->apiResponseData(ServiceResource::collection($service),'success',200);
    }

}
