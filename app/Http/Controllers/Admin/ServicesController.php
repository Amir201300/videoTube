<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Service;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class ServicesController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Service::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('Admin.Services.index');
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|image|max:2000',
                'name_ar' => 'required',
                'name_en' => 'required',
            ],
            [
                'image.required' =>'من فضلك ادخل صوره الخدمه',
                'name_ar.required' =>'من فضلك ادخل اسم الخدمه بالعربية',
                'name_en.required' =>'من فضلك ادخل اسم الخدمه بالانجليزية',
                'image.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $this->save_service($request,new Service());
        return $this->apiResponseMessage(1,'تم اضافة الخدمه بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $service = Service::find($id);
        return $service;
    }

    /**
     * @param Request $request
     * @return int
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'name_ar' => 'required',
                'name_en' => 'required',
            ],
            [
                'name_ar.required' =>'من فضلك ادخل اسم الخدمه بالعربية',
                'name_en.required' =>'من فضلك ادخل اسم الخدمه بالانجليزية',
                'image.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $service = Service::find($request->id);
        $this->save_service($request,$service);
        return $this->apiResponseMessage(1,'تم تعديل الخدمه بنجاح',200);
    }

    /**
     * @param $request
     * @param $service
     */
    public function save_service($request,$service){
        $service->name_ar=$request->name_ar;
        $service->name_en=$request->name_en;
        $service->pricePerMinute=$request->pricePerMinute;
        $service->textPricePerMinute=$request->textPricePerMinute;
        $service->textPricePerMinute=$request->textPricePerMinute;
        $service->twoLangPricePerMinuteOneVideo=$request->twoLangPricePerMinuteOneVideo;
        $service->twoLangPricePerMinuteOneVideo=$request->twoLangPricePerMinuteOneVideo;
        $service->twoLangPricePerMinuteTwoVideo=$request->twoLangPricePerMinuteTwoVideo;
        $service->voiceOverPricePerMinute=$request->voiceOverPricePerMinute;
        $service->priceBySize=$request->priceBySize;
        if($request->image) {
            deleteFile('Services',$service->image);
            $service->image=saveImage('Services',$request->image);
        }

        if($request->video) {
            deleteFile('Services',$service->video);
            $service->video=saveImage('Services',$request->video);
        }
        $service->save();
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int
     */
    public function destroy($id,Request $request)
    {
        if ($request->type == 2) {
            $ids = explode(',', $id);
            $service = Service::whereIn('id', $ids)->get();
            foreach($service as $row){
                $this->deleteRow($row);
            }
        } else {
            $service = Service::find($id);
            $this->deleteRow($service);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $cat
     */
    private function deleteRow($service){
        deleteFile('Service',$service->image);
        deleteFile('Service',$service->video);
        $service->delete();
    }


    /**
     * @param $data
     * @return mixed
     * @throws \Exception
     */
    private function mainFunction($data)
    {
        return Datatables::of($data)->addColumn('action', function ($data) {
            $options = '<td class="sorting_1"><button  class="btn btn-info waves-effect btn-circle waves-light" onclick="editFunction(' . $data->id . ')" type="button" ><i class="fa fa-spinner fa-spin" id="loadEdit_' . $data->id . '" style="display:none"></i><i class="sl-icon-wrench"></i></button>';
            $options .= ' <button type="button" onclick="deleteFunction(' . $data->id . ',1)" class="btn btn-dribbble waves-effect btn-circle waves-light"><i class="sl-icon-trash"></i> </button></td>';
           if($data->level == 1)
                $options .= ' <a href="/Admin/Category/index?cat_id='.$data->id.'" title="الاقسام الفرعية" class="btn btn-success waves-effect btn-circle waves-light"><i class="icon-Add"></i> </a></td>';
            return $options;
        })->addColumn('checkBox', function ($data) {
            $checkBox = '<td class="sorting_1">' .
                '<div class="custom-control custom-checkbox">' .
                '<input type="checkbox" class="mybox" id="checkBox_' . $data->id . '" onclick="check(' . $data->id . ')">' .
                '</div></td>';
            return $checkBox;
        })->editColumn('image', function ($data) {
            $image = '<a href="'. getImageUrl('Services',$data->image).'" target="_blank">'
            .'<img  src="'. getImageUrl('Services',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->editColumn('video', function ($data) {
            $image = '<a href="'. getImageUrl('Services',$data->video).'" target="_blank">اضغط هنا</a>';
            return $image;
        })->rawColumns(['action' => 'action','image' => 'image','checkBox'=>'checkBox','video' => 'video'])->make(true);
    }
}
