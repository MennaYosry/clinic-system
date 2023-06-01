<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmrpatientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,
            'patient_id'=>$this ->patient_id,'alergies'=>$this ->alergies,'tobacco_intake'=>$this ->tobacco_intake,
            'illegal_drugs'=>$this ->illegal_drugs,'current_drugs'=>$this ->current_drugs,'alchol_intake'=>$this
            ->alchol_intake,'patient_dcm_diagnose'=>$this ->patient_dcm_diagnose,'patient_dcm_normal'=>$this
            ->patient_dcm_normal,'blood_type'=>$this ->blood_type,'history'=>$this ->history,'patient_symptoms'=>$this
            ->patient_symptoms,
        ];
    }
}
