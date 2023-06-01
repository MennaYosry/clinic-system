<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmrdoctorResource;
use App\Http\Resources\EmrpatientResource;
use App\Models\Emr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator ;

class EmrController extends Controller
{
    use ApiResponseTrait;
    //patient inserts EMR data 
    public function emr_insertion(Request $request){
        try {
        $validator=Validator:: make($request->all(),[
            'patient_id'=>'required',
            'alergies'=>'required',
            'tobacco_intake'=>'required',
            'illegal_drugs'=>'required',
            'current_drugs'=>'required',
            'alchol_intake'=>'required',
            'patient_dcm_diagnose'=>'required',
            'patient_dcm_normal'=>'required',
            'blood_type'=>'required',
            'history'=>'required',
            'patient_symptoms'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $emr=Emr::create($request->all());
        if($emr){
            return $this->apiResponse(new EmrpatientResource($emr),
        'insertion successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    } catch (\Throwable $th) {
        return $this->apiResponse(null,'failled',400);
    }
    }
    // insert doctor report
    public function insertdoctor_report(Request $request,$id){
        try {
        $validator=Validator::make($request->all(),[
            'doctor_report'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $emr=Emr::find($id);
        if(!$emr){return $this->apiResponse(null,'patient Not Found',404);}
        $emr->update($request->all());
        if($emr){
            return $this->apiResponse(new EmrdoctorResource($emr),
        ' insert successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
         //code...
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
    //update EMR data 
    public function update_emr(Request $request,$id){
        try{
        $validator=Validator::make($request->all(),[
            'alergies'=>'required',
            'tobacco_intake'=>'required',
            'illegal_drugs'=>'required',
            'current_drugs'=>'required',
            'alchol_intake'=>'required',
            'patient_dcm_diagnose'=>'required',
            'patient_dcm_normal'=>'required',
            'blood_type'=>'required',
            'history'=>'required',
            'patient_symptoms'=>'required',
        
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $emr=Emr::find($id);
        if(!$emr){return $this->apiResponse(null,'patient Not Found',404);}
        $emr->update($request->all());
        if($emr){
            return $this->apiResponse(new EmrpatientResource($emr),
        ' updated successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    } catch (\Throwable $th) {
         return $this->apiResponse(null,'failed',400);
    }
}
}