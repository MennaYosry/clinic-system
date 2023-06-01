<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReplyController extends Controller
{
    use ApiResponseTrait;
    // show reply for doctor and patient 
    public function getReply(Request $request, $questionId)
    {
        try{
        $reply = Reply::where('question_id', $questionId)->first();

        if (!$reply) {
            return response()->json(['error' => 'Reply not found'], 404);
        }

        return response()->json(['reply' => $reply]);
    }catch (\Throwable $th){return $this ->apiResponse(null,'failed',400);}
    
    }
    // doctors reply the questions
    public function make_reply(Request $request){
        try{
        $validator=Validator::make($request->all(),[
            'body'=>'required',
            'question_id'=>'required',
            'attatchments'=>'required',
        ]);
        if($validator->fails()){
            return $this->apiResponse(null,$validator->errors(),400);
        }
        $reply=Reply::create($request->all());
        if($reply){
            return $this->apiResponse(new ReplyResource($reply),
        'successfully',201);
        }
        return $this->apiResponse(null,'failled',400);
    }catch (\Throwable $th){return $this->apiResponse(null,'failed',400);}
    } 
}
