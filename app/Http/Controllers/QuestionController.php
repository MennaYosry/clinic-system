<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    use ApiResponseTrait;
    // patient Activities - make question 
    public function make_question(Request $request){
        try{
        $validator=Validator::make($request->all(),[
            'title'=>'required',
            'body'=>'required',
            'patient_id'=>'required',
            'doctor_id'=>'required',
            'attatchments'=>'required',
            'status'=>'required',
            'category'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $question=Question::create($request->all());
        if($question){
            return $this->apiResponse(new QuestionResource($question),
        'successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    }catch (\Throwable $th){ return $this->apiResponse(null,'failled',400);}
    } 
    //patient deletes questions
    public function questiondestroy($id){
        try{
        $question=Question::find($id);
        if(!$question){return $this->apiResponse(null,'question Not Found',404);}
        $question->delete($id);
        if($question){
            return $this->apiResponse(null,
        'question deleted successfully',200);
        }
        return $this->apiResponse(null,'failled',400);
    }catch(\Throwable $th){
        return $this->apiResponse(null,'failled',400);
    }
    } 
}