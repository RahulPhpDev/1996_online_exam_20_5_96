<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;
use DB;


use App\Model\Exam;
use App\Model\Subscription;
use App\Model\ExamSubscription;
use App\Model\ExamQuestion;
use App\Model\QuestionOption;
use App\Model\QuestionRightAnswer;
use App\Model\Question;
use App\User;

use Excel;

use Redirect;

class FileController extends Controller
{
    public function importQuestion(Request $request){
      // dd('hello');
      // echo $eid;
    // dd($request);
      dd($request->all());
        if($request->hasFile('sample_file')){
            $path = $request->file('sample_file')->getRealPath();
            $data = Excel::load($path)->get();
            // $id =  Crypt::decrypt($eid);
            $examData =   Exam::Find($id);
            $counter = $negativeCounter =  0;
            dd($data);
            if($data->count()){
             foreach ($data as $key => $value) { #check if  excel has data
                $counter++;
                $total_mark_array[]     =    $value->mark;   
                $negative_mark_array[]  =      $value->negative_mark;   
                $isNegative             =   0;  
                    if($value->negative_mark > 0){
                        $isNegative         =  1;
                        $negativeCounter++;
                    }
                
                    $arr = array(
                        'question'      => htmlentities($value->question),
                        'type'          => 1,
                        'marks'         => $value->mark,
                        'is_required'   => 0,
                        'is_negative_marking' => $isNegative,
                        'negative_marks' => $value->negative_mark,
                        'status'        => 1,
                        'add_date'      => date("Y-m-d"),
                        'add_by'        => 1,
                    );
                    // $arr[] = ['name' => $value->name, 'details' => $value->details];
                $questionId     =  Question::create($questionData)->id;
                $rightAnserKey  = explode('_', $arr['right_anser_option']);
                $optionArray    = array($arr['option_1'],$arr['option_2'],$arr['option_3'],$arr['option_4']);

               foreach($optionArray as $opK => $opV){    
                    $optionData = array(
                        'question_id'     => $questionId ,
                        'question_option' => htmlentities($opV),
                        'option_type'     =>  1,
                        'add_date'        =>  date("Y-m-d"),
                      );
                    $optId =  QuestionOption::create($optionData)->id;
                    if($opK == --$rightAnserKey){
                        $answerData = array(
                            'question_id'  => $questionId,
                            'option_id'    =>  $optId,
                            'status'       => 1,
                        ); 
                     QuestionRightAnswer::create($answerData); 
                    }
                }

                $examQuestionData  = array(
                    'exam_id'       => $id,
                    'question_id'   => $questionId,
                    'status'        => 1,
              );
             ExamQuestion::create($examQuestionData);
            //  DB::commit();
            $total_mark  = (($examData->total_marks) > 0) ? $examData->total_marks : 0;
            $is_required = 0;
          //   (($examData->is_required) > 0) ? $examData->is_required : 0;
            $totalQuestion     = (($examData->total_question) >0 ) ? $examData->total_question  :  0;
            $negative_question = (($examData->negative_question) >0 ) ? $examData->negative_question :  0;
            $negative_marks    =  (($examData->negative_marks) >0 ) ? $examData->negative_marks  :  0;
            // $totalQuestion =  $request['total_mark'];$is_required = $totalQuestion = 0;
             if(isset($request['total_mark'])){ 
              $total_mark   = $examData->total_marks + array_sum($total_mark_array);
             }
             if(isset($request['question'])){ 
              $totalQuestion = $examData->total_question   + $counter;
            }
  
              $negative_question = $examData->negative_question   + $negativeCounter;
              $negative_marks    = $examData->negative_marks   + array_sum($negative_mark_array);
              $examData->total_marks        = $total_mark;
              $examData->required_question  =   $is_required ;
              $examData->total_question     = $totalQuestion;
              $examData->negative_question  = $negative_question;
              $examData->negative_marks     = $negative_marks;
              $examData->save();
            }

            dd('Insert Record successfully.');
                // if(!empty($arr)){
                //     \DB::table('products')->insert($arr);
                //     dd('Insert Record successfully.');
                // }
            }
        }
        dd('Request data does not have any files to import.');      
    } 
    
}
