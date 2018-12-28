<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;
use DB;

use Illuminate\Support\Facades\Input;

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
use Storage;
use Response;
class FileController extends Controller
{
    public function importQuestion(Request $request,$eid){
        $id = Crypt::decrypt($eid);
       DB::beginTransaction();
         try{ 
          if($request->hasFile('sample_file')){
            $path = $request->file('sample_file')->getRealPath();
            
            $data = Excel::load($path)->get();
            $examData =   Exam::Find($id);
            $counter = $negativeCounter =  0;
            $negative_mark_array =   $total_mark_array = array();
            if($data->count()){
             foreach ($data as $key => $value) { #check if  excel has data
               if(!is_null($value->question)){ 
                $counter++;
                $total_mark_array[]     =    $value->mark;   
                $negative_mark_array[]  =      $value->negative_mark;   
                $isNegative       =   0;  
                    if($value->negative_mark > 0){
                        $isNegative         =  1;
                        $negativeCounter++;
                    }
                
                    $questionData = array(
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
                $questionId     =  Question::create($questionData)->id;
                $rightAnserKey  = explode('_', $value['right_answer_option']);
         
                $rightAnswer = $rightAnserKey[1] - 1;
                $optionArray    = array($value['option_1'],$value['option_2'],$value['option_3'],$value['option_4']);

               foreach($optionArray as $opK => $opV){    
                    $optionData = array(
                        'question_id'     => $questionId ,
                        'question_option' => htmlentities($opV),
                        'option_type'     =>  1,
                        'add_date'        =>  date("Y-m-d"),
                      );
                    $optId =  QuestionOption::create($optionData)->id;
                    if($opK == $rightAnswer){
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
              }
            }
            $total_mark  = (($examData->total_marks) > 0) ? $examData->total_marks : 0;
            $is_required = 0;
            $negative_question = (($examData->negative_question) >0 ) ? $examData->negative_question :  0;
            $negative_marks    =  (($examData->negative_marks) >0 ) ? $examData->negative_marks  :  0;
              $total_mark   = $examData->total_marks + array_sum($total_mark_array);
         
              $totalQuestion = $examData->total_question   + $counter;
              $negative_question = $examData->negative_question   + $negativeCounter;
              $negative_marks    = $examData->negative_marks   + array_sum($negative_mark_array);
              $examData->total_marks        = $total_mark;
              $examData->required_question  =   $is_required ;
              $examData->total_question     = $totalQuestion;
              $examData->negative_question  = $negative_question;
              $examData->negative_marks     = $negative_marks;
              $examData->save();
              }
            }
            $file = $request->file('sample_file');
            $fileName = 'exam_'.$id.'.'.$file->getClientOriginalExtension();
            $originalPath = public_path('images/files');
            $file->move($originalPath, $fileName);
                DB::commit();
                $msg = "Insert Record successfully." ;
             return redirect()->route('confirm-exam',Crypt::encrypt($id))->with('success',$msg);
             }
         catch (QueryException $e) {
             $msg =  $e->getMessage();
             return redirect()->back()->with('err_success',$msg);
         } catch (Exception $e) {
             $msg =  $e->getMessage();
             return redirect()->back()->with('err_success',$msg);
         } catch (Throwable $e) {
             $msg = $e->getMessage();
             return redirect()->back()->with('err_success',$msg);
         }
        } 


        public function downloadDemoFile(){
            $file =   public_path('images/files/Dummy_Question.xlsx');
           return Response::download($file);
            $msg = 'File download please create like this format';
            return redirect()->back()->with('success',$msg);
    }

    public function upload_image(Request $request){
      $CKEditor = Input::get('CKEditor');
        $funcNum = Input::get('CKEditorFuncNum');
        $message = $url = '';
        if (Input::hasFile('upload')) {
            $file = Input::file('upload');
            if ($file->isValid()) {
                $filename = $file->getClientOriginalName();
                 $file->move(public_path().'/images/equation_icon/', $filename);
                $url = url('/')."/images/equation_icon/". $filename;
            } else {
                $message = 'An error occured while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
      $arr = array('fileName' =>  $filename, 'uploaded' => 1, "url" => "$url");

    echo json_encode($arr);
  }

  public function browserfile(){
   
  }
    
}
