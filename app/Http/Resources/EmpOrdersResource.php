<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;

class EmpOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $lang=Auth::check() ? get_user_lang() : $request->header('lang');
        return [
            'id' => $this->id,
            'status' =>(int)$this->status,
            'payment_status' => (int)$this->payment_status,
            'order_details' => new OrderResource($this->order),
            'data_file'=> $this->data_file == null ? null :getImageUrl("order_data" , $this->data_file)
        ];
    }
}
