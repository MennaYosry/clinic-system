<?php

namespace App\Http\Controllers;

use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    use ApiResponseTrait;
    //Admin show departments list 
    public function adminshow(){
        try{
        $departments=Department::all();
        return $this->apiResponse($departments,
        'show successfully',200);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
    //Admin Insertion
    public function adminstore(Request $request){
        try{
        $validator=Validator::make($request->all(),[
            'department_name'=>'required|string',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $department=Department::create($request->all());
        if($department){
            return $this->apiResponse(new DepartmentResource($department),
            'insertion successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
         } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    } 
    //Admin Update
    public function adminupdate(Request $request,$id){
        try{
        $validator=Validator::make($request->all(),[
            'department_name'=>'required|string',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $department=Department::find($id);
        if(!$department){return $this->apiResponse(null,'Department Not Found',404);}
        $department->update($request->all());
        if($department){
            return $this->apiResponse(new DepartmentResource($department),
            'Department Updated successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
    //Admin Deletion
    public function admindestroy($id){
        try{
        $department=Department::find($id);
        if(!$department){return $this->apiResponse(null,'Department Not Found',404);}
        $department->delete($id);
        if($department){
            return $this->apiResponse(new DepartmentResource($department),
            'Department deleted successfully',200);
        }
        return $this->apiResponse(null,'failed',400);
        } catch (\Throwable $th) {
            return $this->apiResponse(null,'failed',400);
        }
    }
}
