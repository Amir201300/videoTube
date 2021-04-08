<?php


namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Goal;
use Yajra\DataTables\DataTables;
use Auth, File;
use Illuminate\Support\Facades\Storage;


class GoalsController extends Controller
{
    use \App\Traits\ApiResponseTrait;

    /**
     * @return mixed
     * @throws \Exception
     */
    public function allData(Request $request)
    {
        $data = Goal::get();
        return $this->mainFunction($data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        return view('Admin.Goals.index');
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
        $this->save_Goal($request,new Goal());
        return $this->apiResponseMessage(1,'تم اضافة الخدمه بنجاح',200);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $Goal = Goal::find($id);
        return $Goal;
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
                'image.required' =>'من فضلك ادخل صوره الخدمه',
                'name_ar.required' =>'من فضلك ادخل اسم الخدمه بالعربية',
                'name_en.required' =>'من فضلك ادخل اسم الخدمه بالانجليزية',
                'image.image' =>'من فضلك ادخل صورة صالحة'
            ]
        );
        $Goal = Goal::find($request->id);
        $this->save_Goal($request,$Goal);
        return $this->apiResponseMessage(1,'تم تعديل الخدمه بنجاح',200);
    }

    /**
     * @param $request
     * @param $Goal
     */
    public function save_Goal($request,$Goal){
        $Goal->name_ar=$request->name_ar;
        $Goal->name_en=$request->name_en;
        $Goal->save();
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
            $Goal = Goal::whereIn('id', $ids)->get();
            foreach($Goal as $row){
                $this->deleteRow($row);
            }
        } else {
            $Goal = Goal::find($id);
            $this->deleteRow($Goal);
        }
        return response()->json(['errors' => false]);
    }

    /**
     * @param $cat
     */
    private function deleteRow($Goal){
        deleteFile('Goal',$Goal->image);
        deleteFile('Goal',$Goal->video);
        $Goal->delete();
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
            $image = '<a href="'. getImageUrl('Goals',$data->image).'" target="_blank">'
                .'<img  src="'. getImageUrl('Goals',$data->image) . '" width="50px" height="50px"></a>';
            return $image;
        })->editColumn('video', function ($data) {
            $image = '<a href="'. getImageUrl('Goals',$data->video).'" target="_blank">اضغط هنا</a>';
            return $image;
        })->rawColumns(['action' => 'action','image' => 'image','checkBox'=>'checkBox','video' => 'video'])->make(true);
    }
}
