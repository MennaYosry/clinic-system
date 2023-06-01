<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return ['id'=>$this->id,'title'=>$this ->title ,'body'=>$this ->body,'patient_id'=>$this ->patient_id,
        'doctor_id'=>$this ->doctor_id,'attatchments'=>$this ->attatchments,'status'=>$this ->status,
        'category'=>$this ->category];

    }
}
