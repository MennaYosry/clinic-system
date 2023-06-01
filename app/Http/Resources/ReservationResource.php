<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,'reserved_doctor_id'=>$this ->reserved_doctor_id ,
        'reserved_patient_id'=>$this ->reserved_patient_id,'symptoms'=>$this ->symptoms,
        'reservation_time'=>$this ->reservation_time,'reservation_symptoms'=>$this ->reservation_symptoms,
        'urgent'=>$this ->urgent];
    }
}