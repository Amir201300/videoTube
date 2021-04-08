<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;


class OrderSocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'facebook' => $this->facebook,
            'snap' => $this->snap,
            'youtube' => $this->youtube,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
        ];
    }
}
