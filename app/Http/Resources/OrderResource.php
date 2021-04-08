<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;


class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang =  Auth::check() ? get_user_lang() : $request->header('lang') ;
        return [
            'id' => $this->id,
            'totalPrice' => $this->price,
            'textPrice' => $this->textPrice,
            'sizePrice' => $this->sizePrice,
            'timePrice' => $this->timePrice,
            'langPrice' => $this->langPrice,
            'voicePrice' => $this->voicePrice,
            'haveText' => (int)$this->haveText,
            'text' => $this->text,
            'projectIdea' => $this->projectIdea,
            'package' => $this->package,
            'facebookSize' => $this->facebookSize,
            'snapSize' => $this->snapSize,
            'youtubeSize' => $this->youtubeSize,
            'acceptedPriceOfText' => (int)$this->acceptedPriceOfText,
            'instagramSize' => $this->instagramSize,
            'twitterSize' => $this->twitterSize,
            'color' => $this->color ? getImageUrl('Order',$this->color) : null,
            'font' => $this->color ? getImageUrl('Order',$this->font) : null,
            'CategoryType' => $this->CategoryType,
            'isPromotionNameRequired' => $this->isPromotionNameRequired,
            'specialPoint' => $this->specialPoint,
            'showLangType' => (int)$this->showLangType,
            'projectLang' => (int)$this->projectLang,
            'voiceOverGender' => (int)$this->voiceOverGender,
            'specialties_id' => $this->specialties ?$lang =='en' ? $this->specialties->name_en : $this->specialties->name_ar : $this->specialties_id,
            'goal_id' => $this->goal ?$lang =='en' ? $this->goal->name_en : $this->goal->name_ar : $this->goal_id,
            'audience_id' => $this->audience ?$lang =='en' ? $this->audience->name_en : $this->audience->name_ar : $this->audience_id,
            'Sector_id' => $this->Sector ?$lang =='en' ? $this->Sector->name_en : $this->Sector->name_ar : $this->Sector_id,
            'numberOfMinutes' => $this->numberOfMinutes,
            'service' => new ServiceResource($this->service),
            'socialLinks' => OrderSocialResource::collection($this->socialLinks),
            'voiceModelEnglish_id' => $this->voiceModelEnglish ? new VoiceOverModelResource($this->voiceModelEnglish) : null,
            'voiceModelArabic_id' => $this->voiceModelArabic ? new VoiceOverModelResource($this->voiceModelArabic) : null,

        ];
    }
}
