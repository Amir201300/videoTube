<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class DefaultModelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang=Auth::check() ? get_user_lang() : $request->header('lang');
        return [
            'id' => $this->id,
            'name' => $lang =='en' ? $this->name_en : $this->name_ar,
        ];
    }
}
