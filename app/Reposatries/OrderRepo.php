<?php

namespace App\Reposatries;

use App\Models\Order;
use App\Models\OrderSocial;
use Illuminate\Http\Request;
use Validator,Auth,Artisan,Hash,File,Crypt;

class OrderRepo  {
    use \App\Traits\ApiResponseTrait;

    /***
     * @param $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function validate_order($request)
    {
        $lang =  Auth::check() ? get_user_lang() : $request->header('lang') ;

        $input = $request->all();
        $validationMessages = [
            'service_id.required' => $lang == 'ar' ?  'من فضلك ادخل الخدمة' :"Service is required" ,
            'text.required' => $lang == 'ar' ?  'من فضلك ادخل النص' :"text is required" ,
            'projectIdea.required' => $lang == 'ar' ?  'من فضلك ادخل فكرة المشروع' :"project idea is required" ,
            'projectLang.required' => $lang == 'ar' ?  'من فضلك ادخل لغة الفيديو' :"project language is required" ,
            'service_id.exists' => $lang == 'ar' ?  'الخدمة غير موجودة' :"Service not found" ,
        ];

        $validator = Validator::make($input, [
            'service_id' => 'required|exists:services,id',
            'voiceModelArabic_id' => $request->voiceModelArabic_id ? 'exists:voice_over_models,id' : '',
            'voiceModelEnglish_id' =>$request->voiceModelEnglish_id ? 'exists:voice_over_models,id' : '',
            'haveText' => 'required|in:1,0',
            'text' =>  $request->haveText == 1 ? 'required' : '',
            //'projectIdea' =>   'required' ,
            'numberOfMinutes' => 'required|between:0,99.99',
            'projectLang' => 'required|in:1,2,3,4',
            'CategoryType' => 'in:1,2',
        ], $validationMessages);

        if ($validator->fails()) {
            return $this->apiResponseMessage(0,$validator->messages()->first(), 200);
        }
    }

    /**
     * @param $request
     * @return Order
     */
    public function save_order($request){
        $user=Auth::user();
        $order=new Order();
        $order->service_id=$request->service_id;
        $order->numberOfMinutes=$request->numberOfMinutes;
        $order->haveText=$request->haveText;
        $order->acceptedPriceOfText=$request->acceptedPriceOfText;
        $order->text=$request->text;
        $order->projectIdea=$request->projectIdea;
        $order->package=$request->package;
        $order->specialPoint=$request->specialPoint;
        $order->acceptedPriceOfText=$request->acceptedPriceOfText;
        $order->projectLang=$request->projectLang;
        $order->showLangType=$request->showLangType;
        $order->youtubeSize=$request->youtubeSize;
        $order->voiceOverGender=$request->voiceOverGender;
        $order->snapSize=$request->snapSize;
        $order->facebookSize=$request->facebookSize;
        $order->instagramSize=$request->instagramSize;
        $order->twitterSize=$request->twitterSize;
        $order->specialties_id=$request->specialties_id;
        $order->isPromotionNameRequired=$request->isPromotionNameRequired;
        $order->goal_id=$request->goal_id;
        $order->audience_id=$request->audience_id;
        $order->Sector_id=$request->Sector_id;
        $order->CategoryType=$request->CategoryType;
        $order->voiceModelArabic_id=$request->voiceModelArabic_id;
        $order->voiceModelEnglish_id=$request->voiceModelEnglish_id;
        $order->status=1;
        $order->user_id=$user->id;
        if($request->color)
            $order->color=saveImage('Order',$request->color);
        if($request->font)
            $order->font=saveImage('Order',$request->font);
        $order->save();
        $this->cal_price($order);
        $this->saveSocial($request,$order->id);
        return $order;
    }

    /**
     * @param $reauest
     * @param $order_id
     */
    private function saveSocial($reauest,$order_id){
        $orderSocial=new OrderSocial();
        $orderSocial->facebook=$reauest->facebook;
        $orderSocial->instagram=$reauest->instagram;
        $orderSocial->youtube=$reauest->youtube ;
        $orderSocial->snap=$reauest->snap;
        $orderSocial->twitter=$reauest->twitter;
        $orderSocial->order_id=$order_id;
        $orderSocial->save();
    }

    /**
     * @param $order
     */
    public function cal_price($order){
        $service=$order->service;
        $timePrice=$service->pricePerMinute * $order->numberOfMinutes;
        $price=$timePrice ;
        $order->timePrice=$timePrice;
        if($order->projectLang == 3) {
            $langPrice=$service->twoLangPricePerMinuteOneVideo;
            $price += $langPrice;
            $order->langPrice=$langPrice;
        }
        if($order->projectLang == 4) {
            $langPrice=$service->twoLangPricePerMinuteTwoVideo;
            $price += $langPrice;
            $order->langPrice=$langPrice;
        }
        $price+= $this->sizeCounts($order) * $service->priceBySize;
        $order->sizePrice=$this->sizeCounts($order) * $service->priceBySize;
        if($order->voiceModelEnglish_id) {
            $price += $service->voiceOverPricePerMinute * $order->numberOfMinutes;
            $order->voicePrice = $service->voiceOverPricePerMinute * $order->numberOfMinutes;
        }
        if($order->voiceModelArabic_id) {
            $price += $service->voiceOverPricePerMinute * $order->numberOfMinutes;
            $order->voicePrice += $service->voiceOverPricePerMinute * $order->numberOfMinutes;
        }
        if($order->haveText == 1) {
            $textPrice=$service->textPricePerMinute * $order->numberOfMinutes;
            $order->textPrice=$textPrice;
            $price += $textPrice;
        }
        $order->price=$price;
        $order->save();
    }

    /***
     * @param $order
     * @return int
     */
    private function sizeCounts($order){
        $sizeCounts=0;
        if($order->twitterSize)
            $sizeCounts +=1;
        if($order->snapSize)
            $sizeCounts +=1;
        if($order->facebookSize)
            $sizeCounts +=1;
        if($order->youtubeSize)
            $sizeCounts +=1;
        if($order->instagramSize)
            $sizeCounts+= 1;
        return $sizeCounts > 2 ? $sizeCounts -2 : 0;
    }

}
