<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Signal;
use App\Models\Student;
use App\Models\Question;
use App\Models\Answer;
use DB;

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

    public function get_questions(){
        $questions = Question::all();
        $data = [];
        $cont = 0;
        foreach($questions as $question){
            $signal = Signal::where('id',$question->signal_id)->first();
            $data[$cont]['question_id'] =  $question->id;
            $data[$cont]['question_cover'] =  $signal->cover;
            $data[$cont]['question_answers'] = $this->answers($question->id);
            $cont++;
        }

        return response()->json($data);
    }

    public function answers($questions_id){
        $data = [];
        $aswers = Answer::select('signal_id','is_correct','id')->where('question_id',$questions_id)->get();
        $cont = 0;
        foreach($aswers as $aswer){
            $signal = Signal::where('id',$aswer->signal_id)->first();
            $data[$cont]['id'] = $aswer->id;
            $data[$cont]['name'] = $signal->name;
            $data[$cont]['is_correct'] = $aswer->is_correct;
            $cont++;
        }

        return $data;
    }

    public function student_answers(Request $request){
        $student = Student::where('email',$request->email)->first();
        $practical = DB::table('student_aswers')->where('student_id',$student->id)->get();

        $data = [
            'student_id'=>$student->id,
            'total_questions'=>$request->total_questions,
            'correct'=>$request->correct,
            'incorrect'=>$request->incorrect,
            'percentage'=>$request->percentage,
            'is_fine'=>$request->is_fine
        ];

        $message = [];


        if(count($practical) > 0){
            if(DB::table('student_aswers')->where('student_id',$practical[0]->student_id)->update($data)){
                $message = [
                    'success'=> true,
                    'messages'=>'Practica Insertada Con Exito!!'
                ];
            }else{
                $message = [
                        'success'=> false,
                        'messages'=>'Error al insertar las practicas!!'
                ];
            }
        }else{
            if(DB::table('student_aswers')->insert($data)){
                $message = [
                    'success'=> true,
                    'messages'=>'Practica Insertada Con Exito!!'
                ];
            }else{
                $message = [
                    'success'=> false,
                    'messages'=>'Error al insertar las practicas!!'
                ];
            }
        }

        return response()->json($message);
    }
}