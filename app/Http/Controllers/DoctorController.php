<?php 
namespace App\Http\Controllers;

use App\Http\Resources\DoctorpatientResource;
use App\Http\Resources\DoctorResource;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Question;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DoctorController extends Controller
{
    use ApiResponseTrait;
// Authentication and create token 
// Doctor Registration 
    public function register(Request $request)
    {
        try {
        $validator = Validator::make($request->all(), [
            'first_name'=>'required',
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'categories'=>'required',
            'department_id'=>'required',
            'image_name'=>'required',
            'reservation_phone_number'=>'required',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }

        $doctor = Doctor::create([
            'first_name'=>$request['first_name'],
            'last_name'=>$request['last_name'],
            'national_id'=>$request['national_id'],
            'email'=>$request['email'],
            'password' => Hash::make($request['password']),
            'reservation_phone_number'=>$request['reservation_phone_number'],
            'department_id'=>$request['department_id'],
            'categories'=>$request['categories'],
            'image_name'=>$request['image_name'],
            
        ]);

        $token = hash( 'sha256', Str::random(60));

       $doctor->forceFill(['api_token' => $token])->save();

       return response()->json([
           'doctor' => [
            'id'=>$doctor->id,
            'first_name'=> $doctor->first_name,
            'last_name'=> $doctor->last_name,
            'national_id'=> $doctor->national_id,
            'email'=> $doctor->email,
            'password' =>  $doctor->password,
            'reservation_phone_number'=> $doctor->reservation_phone_number,
            'department_id'=> $doctor->department_id,
            'categories'=> $doctor->categories,
            'image_name'=> $doctor->image_name,],
           'api_token' => $token
       ]);
       } catch (\Throwable $th) {
            return $this->apiResponse(null,'failled',400);
         }
    }

    //Doctor Login 
    public function login(Request $request)
    {
        try{
        $fields = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);

        //Check email

        $doctor= Doctor::where('email', $fields['email'])->first();

        //Check Password
        if(!$doctor || !Hash::check($fields['password'], $doctor->password) ){
            return response([
                'message'=>'Invalid Credentials',
                'status'=>'401'
            ], 401);
        }


        $token = hash( 'sha256', Str::random(60));

        $doctor->forceFill(['api_token' => $token])->save();

        $response= [
            'doctor' => [
                'id'=>$doctor->id,
                'email' => $doctor->email,
                'message'=>'login successfully',
            ],
            'api_token'=> $token
        ];

        return response($response, 201);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }

    //Doctor Logout
    public function logout(Request $request)
    {
        try{
        $doctor = Doctor::where('api_token', $request->api_token)->first();
        if ($doctor) {
            if ($doctor->api_token !== null) {
                $doctor->api_token = null;
                $doctor->save();
                return $this->apiResponse(null,'Logout success',200);
            } else {
                return $this->apiResponse(null,'already logged out',400);
               
            }
        }
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }



/* admin activities */   
    
//Admin show departments list 
    public function adminshow(){
    try{
        $doctor=Doctor::all();
        return $this->apiResponse($doctor,
    'show successfully',200);
    } catch (\Throwable $th) {
        return $this->apiResponse(null,'failed',400);
    }
    }

    //Admin Insertion
    public function adminstore(Request $request){
        try{
        
        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'categories'=>'required',
            'department_id'=>'required',
            'image_name'=>'required',
            'reservation_phone_number'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $doctor=Doctor::create($request->all());
        if($doctor){
            return $this->apiResponse(new DoctorResource($doctor),
        'insertion successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    } 

    //Admin Updates doctor
    public function adminupdate(Request $request,$id){
        try{
        $validator=Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'categories'=>'required',
            'department_id'=>'required',
            'image_name'=>'required',
            'reservation_phone_number'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $doctor=Doctor::find($id);
        if(!$doctor){return $this->apiResponse(null,'doctor Not Found',404);}
        $doctor->update($request->all());
        if($doctor){
            return $this->apiResponse(new DoctorResource($doctor),
        'doctor Updated successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
    
    //Admin Deletion
    public function admindestroy($id){
        try{
        $doctor=Doctor::find($id);
        if(!$doctor){return $this->apiResponse(null,'doctor Not Found',404);}
        $doctor->delete($id);
        if($doctor){
            return $this->apiResponse(null,
        'doctor deleted successfully',200);
        }
        return $this->apiResponse(null,'failled',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    } 
/* doctor can do some activities on his interface */
    //show doctor-profile
    public function show(Request $request, $id)
    {
        try{
        $doctor = Doctor ::find($id);
         if ($doctor->api_token === $request->api_token) {
            $department = Department::find($doctor->department_id);
            $doctor->department_name=$department->department_name;
            return response([ 'doctor_info'=>$doctor ,
             'message'=>'process successfully','status'=>200
            ], 200);
        } else {
            return $this->apiResponse( null,'Unauthorized',401);
        }
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
}
//updating doctor information
    public function update_doctor_info(Request $request,$id){
        try{
        $validator=Validator::make($request->all(),[
            'first_name'=>'required' ,
            'last_name'=>'required',
            'national_id'=>'required',
            'email'=>'required',
            'password'=>'required',
            'reservation_phone_number'=>'required',
            'city'=>'required',
            'gender'=>'required',
            'birth_date'=>'required',
            'image_name'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $doctor=Doctor::find($id);
        if(!$doctor){return $this->apiResponse(null,'doctor Not Found',404);}
        $doctor->update($request->all());
        if($doctor){
            return $this->apiResponse(new DoctorResource($doctor),
        ' update successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
    public function getDoctorQuestions(Request $request, $id)
    {
        try{
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'Doctor not found'], 404);
        }

        $questions = Question::where('doctor_id', $id)->get();

        return response()->json(['questions' => $questions]);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    } 
    //doctor gets his reservations
    public function getdoctorreservation(Request $request, $id)
    {
        try{
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json(['error' => 'patient not found'], 404);
        }

        $reservations = Reservation::where('reserved_doctor_id', $id)->get();

        return response()->json(['reservations' => $reservations]);
        } catch (\Throwable $th) {
            return $this ->apiResponse(null,'failed',400);
        }
    } 
// patients see doctor profile
public function show_doctor_profile($id){
    try {
    $doctor=Doctor::find($id);
    $department=Department::find($doctor->department_id);
    $data = [$doctor->id,$doctor->first_name,$doctor->last_name,$doctor->categories,$doctor->image_name,
    $doctor->reservation_phone_number,$department->department_name];
    if($doctor){
        return $this->apiResponse($data,'show successfully',200 );
    }
    
    } catch (\Throwable $th) {
        return $this->apiResponse(null,'failed',400);
    }
}
}
