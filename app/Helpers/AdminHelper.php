<?php
/**
 * @return string
 */
function getLogo(){
    return '/Admin/logo.png';
}

/**
 * @param $image
 * @return mixed|string
 */
function getAdminImage($image){
    if($image)
        return get_user_lang('Admin',$image);
    return defaultImages(2);
}


function getCurrency(){
    return 'LE';
}

function getNameInIndexPage(){
    return 'متجر النخبة';
}


function getMoneyModelType($type){
    if($type == 1)
        $name='يومية';
    if($type == 5)
        $name='فواتير';
    if($type == 4)
        $name='موظفين';

    return $name;
}

/**
 * @return array
 */
function getMoneyModelTypes(){
    return [
      [
          'يومية',
          1
      ],
        [
            'عملاء',
            2
        ],
        [
            'موردون',
            3
        ],
        [
            'موظفين',
            4
        ],
        [
            'فواتير',
            5
        ],
        [
            'بنوك',
            7
        ],
    ];
}

function getCounts($model){
    return $model->count();
}


function getRate($type)
{
    if($type == 1)
        $rate=\App\Models\Rate::where('rate','>',3)->count();
    if($type == 2)
        $rate=\App\Models\Rate::where('rate','<',2)->count();
    if($type == 3)
        $rate=\App\Models\Rate::where('rate','>',2)->where('rate','<',4)->count();
    if($type == 4)
        $rate=\App\Models\Rate::count();
    if($type == 5)
        $rate=\App\Models\Rate::whereMonth('created_at',now())->count();
    $rate_count=\App\Models\Rate::count();
    $rate_count=$rate_count== 0 ? 1 : $rate_count;
    $percntage=$rate * 100 / $rate_count;
    return [$rate,$percntage];
}

function lastUserRate()
{
    $usersIds=\App\Models\Rate::whereMonth('created_at',now())->pluck('user_id')->toArray();
    $users=\App\Models\User::whereIn('id',$usersIds)->take(5)->get();
    return $users;

}

function adminsRoleArray($admin){
    if($admin->id != 1) {
        $array = [];
        foreach ($admin->roles as $row) {
            $array[] = $row->id;
        }
    }else{
        $array=[1,2,3,4,5,6,7,8,9,10,11];
    }
    return $array;
}
