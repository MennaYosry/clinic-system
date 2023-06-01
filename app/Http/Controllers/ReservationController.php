<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReservationResource;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    use ApiResponseTrait;

/*Doctor Activities*/ 
    // make reservation 
    public function make_reservation(Request $request){
        $validator=Validator::make($request->all(),[
            'reserved_doctor_id'=>'required',
            'reserved_patient_id'=>'required',
            'symptoms'=>'required',
            'reservation_time'=>'required',
            'reservation_symptoms'=>'required',
            'urgent'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $reservation=Reservation::create($request->all());
        if($reservation){
            return $this->apiResponse(new ReservationResource($reservation),
        'reserved successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    }
// patient - doctor activity (delete reservation)
    public function reservationdestroy($id){
        try{
        $reservation=Reservation::find($id);
        if(!$reservation){return $this->apiResponse(null,'reservation Not Found',404);}
        $reservation->delete($id);
        if($reservation){
            return $this->apiResponse(null,
        'reservation deleted successfully',200);
        }
        return $this->apiResponse(null,'failled',400);
    }catch (\Throwable $th) {
            return $this->apiResponse(null,'failled',400);
        }
    
}
}
