<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Controllers\Manage\BaseController;


class EmployeeResource extends JsonResource
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
            'name' => $this->name,
            'collage' => $this->collage,
            'country' => $this->country,
            'bank_name' => $this->bank_name,
            'bank_country' => $this->bank_country,
            'bank_number' => $this->bank_number,
            'iban_number' => $this->iban_number,
            'email' => $this->email,
            'phone' => $this->phone,
            'experience' => $this->experience,
            'lang' => (int)$this->lang,
            'status' => (int)$this->status,
            'service' => $this->service ? new DefaultModelResource($this->service) : null,
            'cv' => getImageUrl('Employee',$this->cv),
            'id_number' => getImageUrl('Employee',$this->id_number),
           'ExperienceFiles' => EmployeeExperienceResource::collection($this->experienceFiles),

        ];
    }
}
