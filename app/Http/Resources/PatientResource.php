<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,'first_name'=>$this ->first_name ,'last_name'=>$this ->last_name,
        'national_id'=>$this ->national_id,'email'=>$this ->email,'password'=>$this ->password,
        'phone_number'=>$this ->phone_number,'city'=>$this ->city,'gender'=>$this ->gender,
        'birth_date'=>$this ->birth_date,'image_name'=>$this ->image_name];
    }
}
