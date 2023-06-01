<?php

namespace App\Http\Controllers;

use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Models\Question;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    use ApiResponseTrait;
    // patient registration
    public function register(Request $request)
    {try {
        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone_number'=>'required',
            'city'=>'required',
            'gender'=>'required',
            'birth_date'=>'required',
            'image_name'=>'required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $patient = Patient::create([
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'national_id'=>$request['national_id'],
            'email'=>$request['email'],
            'password' => Hash::make($request['password']),
            'phone_number'=>$request['phone_number'],
            'city'=>$request['city'],
            'gender'=>$request['gender'],
            'birth_date'=>$request['birth_date'],
            'image_name'=>$request['image_name'],
            
        ]);

        $token = hash( 'sha256', Str::random(60));

       $patient->forceFill(['api_token' => $token])->save();

       return response()->json([
           'doctor' => [
               'id'=>$patient->id, 
               'first_name'=> $patient->first_name,
               'last_name'=> $patient->last_name,
               'national_id'=> $patient->national_id,
               'email'=> $patient->email,
               'password' =>  $patient->password,
               'phone_number'=> $patient->phone_number,
               'city'=> $patient->city,
               'gender'=> $patient->gender,
               'birth_date'=> $patient->birth_date,
               'image_name'=> $patient->image_name,],
           'api_token' => $token
       ]);
    }
       catch (\Throwable $th) {
        return $this->apiResponse(null,'failled',400);
    }
    }
//patient login
    public function login(Request $request)
    {
        try{
        $fields = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        //Check email

        $patient= Patient::where('email', $fields['email'])->first();

        //Check Password
        if(!$patient || !Hash::check($fields['password'], $patient->password) ){
            return response([
                'message'=>'Invalid Credentials'
            ], 401);
        }


        $token = hash( 'sha256', Str::random(60));

        $patient->forceFill(['api_token' => $token])->save();

        $response= [
            'patient' => [
                'id'=>$patient->id,
                'email' => $patient->email,
                'message'=>'login successfully',
            ],
            'api_token'=> $token
        ];

        return response($response, 201);
    
}catch (\Throwable $th){
    return $this->apiResponse(null,'failled',400);
}
    }
    //patient logout
    public function logout(Request $request)
    {
        try{
        $patient = Patient::where('api_token', $request->api_token)->first();
        if ($patient) {
            if ($patient->api_token !== null) {
                $patient->api_token = null;
                $patient->save();
                return $this->apiResponse(null,'Logout success',200);
            } else {
                return $this->apiResponse(null,'already logged out',400);
               
            }
        }
    }catch (\Throwable $th){
        return $this->apiResponse(null,'failed',400);
    }}
/* patient can do some activities on his interface */
//show patient-profile
    public function show(Request $request, $id)
    {
        try{
        $patient = Patient::find($id);

        if ($patient->api_token === $request->api_token) {
            return $this->apiResponse( $patient,'show successfully',200);
     } else {
            return $this->apiResponse( null,'Unauthorized',401);
        }
    }catch (\Throwable $th) {
            return $this->apiResponse(null,'failled',400);
        }
    }
    

//patient gets question 
    public function getPatientQuestions(Request $request, $id)
    {
        try{
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'patient not found'], 404);
        }

        $questions = Question::where('patient_id', $id)->get();

        return response()->json(['questions' => $questions]);
    }catch (\Throwable $th){return $this->apiResponse(null,'failled',400);}
} 
//get patient reservation
    public function getPatientreservation(Request $request, $id)
    {
        try{
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json(['error' => 'patient not found'], 404);
        }

        $reservations = Reservation::where('reserved_patient_id', $id)->get();

        return response()->json(['reservations' => $reservations]);
    }catch (\Throwable $th){return $this->apiResponse(null,'failled',400);}
    } 
    //get patient info and EMR 
    public function getPatientAndEmr(Request $request, $id)
    {
        try{
        $patient = Patient::find($id);
        $emr = $patient->emr;

        return response()->json(['patient' => $patient, 'emr' => $emr]);
        }catch (\Throwable $th){return $this->apiResponse(null,'failed',400);}
    }
    //update patient info 
    public function update_patient_info(Request $request,$id){
        try{
        $validator=Validator::make($request->all(),[
            'first_name'=>'required' ,
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'phone_number'=>'required',
            'city'=>'required',
            'gender'=>'required',
            'birth_date'=>'required',
            'image_name'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $patient=Patient::find($id);
        if(!$patient){return $this->apiResponse(null,'patient Not Found',404);}
        $patient->update($request->all());
        if($patient){
            return $this->apiResponse(new PatientResource($patient),
        ' updated successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    }catch (\Throwable $th){return $this->apiResponse(null,'failed',400);}
    }
    // delete account for patients 
    public function patientdestroy($id){
        try{
        $patient=Patient::find($id);
        if(!$patient){return $this->apiResponse(null,'patient Not Found',404);}
        $patient->delete($id);
        if($patient){
            return $this->apiResponse(null,
        'patient deleted successfully',200);
        }
        return $this->apiResponse(null,'failled',400);
    }catch (\Throwable $th){return $this->apiResponse(null,'failed',400);}
    } 

}

