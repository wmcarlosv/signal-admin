<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Signal;
use App\Models\Student;

class ApiController extends Controller
{
    public function categories(){
        $categories = Category::select('id','name','description','cover')->get();
        return response()->json($categories);
    }

    public function signals($category_id){
        $signals = Signal::select('id','name','description','cover','category_id')->where('category_id',$category_id)->get();
        return response()->json($signals);
    }

    public function signal($id){
        $signal = Signal::findorfail($id);
        return response()->json($signal);
    }

    public function studentStore(Request $request){
        $email = $request->email;
        $verify_student = Student::where('email',$email)->first();
        
        if($verify_student){
            $student = Student::findorfail($verify_student->id);
        }else{
            $student = new Student();
        }
    
        $student->name = $request->name;
        $student->email = $request->email;
        $response = [];

        if($student->save()){
            $response = ['success'=>1,'data'=>$student];
        }else{
            $response = ['success'=>0,'data'=>null];
        }

        return response()->json($response);
    }
}