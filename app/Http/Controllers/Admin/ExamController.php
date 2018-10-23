<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Service\PayUService\Exception;
use Illuminate\Database\QueryException;
use DB;
// MODEL 

use App\Model\Course;
use App\Model\Exam;
use App\Model\Subscription;
use App\Model\ExamSubscription;
use App\Model\ExamQuestion;
use App\Model\QuestionOption;
use App\Model\QuestionRightAnswer;
use App\Model\Question;

class ExamController extends Controller
{
   
//    var  $date =  date("Y-m-d");

    public function addExam(){
        $title = 'Exam Step 1';
        $allCourse = Course::where('status', 1)->get();
        $allSubscription = Subscription::where('status', 1)->pluck('name','id')->toArray();
        // dd($allSubscription);
        return view('admin.exam.add-exam',compact('allCourse','allSubscription'))->with('title',$title);
    }
    
    public function saveAddExam(Request $request){
        // dd($request->all());
        DB::beginTransaction();
        try{
            $exam = new Exam();
            $isPayable = $amount =  0;
            if(isset($request['payable'])){
                $isPayable =1;
                $amount = $request['amount'];
            }
            $examData = array(
                'exam_name' => $request['exam_name'],
                'is_payable' => $isPayable,
                'payable_amount' => $amount,
                'description' => $request['description'],
                'notes' => $request['notes'],
                'add_date' =>   date("Y-m-d"),
                'status' => 1,
                'exam_visible_status' =>  $request['exam_type'],
            );
            $id =  $exam::create($examData)->id;
            if(isset($request['subscription'])){
            foreach($request['subscription'] as $sub){
                if($sub == "all") { $sub = 0;}
                $subdata = array(
                        'exam_id' => $id,
                        'subscription_id' => $sub,
                        'status' => 1,
                    );
                    ExamSubscription::create($subdata);
                }
            }
          DB::commit();
          $msg = 'Inserted Successfully';
          // return \Redirect::route('regions', [$id])->with('message', 'State saved correctly!!!');

          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('err_success',$msg);     
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

       public function addExamQuestion($id){
         $id =  Crypt::decrypt($id);
         $getExamData =    Exam::findOrFail($id);
         $title = $getExamData['exam_name'];
         return view('admin.exam.add-exam-question',compact('getExamData','id'))->with('title',$title);
       }

      public function saveExamQuestion(Request $request , $id){
        // dd($request->all());
       DB::beginTransaction();
       try{

            $examData =   Exam::Find($id);
            $total_mark = $is_required = $totalQuestion = 0;
           if(isset($request['total_mark'])){ 
            $total_mark = $examData->total_marks + array_sum($request['total_mark']);
          }

           if(isset($request['is_required'])){ 
           $is_required =   $examData->required_question +  array_sum($request['is_required']);
          }
           if(isset($request['question'])){ 
            $totalQuestion = $examData->total_question   + count($request['question']);
          }
            // dd($examData->minimum_passing_marks);
// echo $totalQuestion;die();
            $examData->total_marks = $total_mark;
            $examData->required_question =   $is_required ;
            $examData->total_question = $totalQuestion;
            $examData->save();

            $questionArray = $request['question'];
            foreach($questionArray as $qk => $qv){
               $total_per_question = 0;
                if(isset($request['total_mark'][$qk])){
                  $total_per_question = 0;
                }
               $isRequired = (isset($request['is_required'][$qk])) ? 1 : 0;
               $is_negative = (isset($request['is_negative'][$qk])) ? 1 : 0;
               $negative_marks = ($is_negative == 1) ? $request['negative_mark'][$qk] : 0;
               $questionData = array(
                    'question' => htmlentities($qv[0]),
                    'type' => 1,
                    'marks' => $total_per_question,
                    'is_required' => $isRequired,
                    'is_negative_marking' => $is_negative,
                    'negative_marks' => $negative_marks,
                    'status' => 1,
                    'add_date' => date("Y-m-d"),
                    'add_by' => 1,
                );
               $questionId =  Question::create($questionData)->id;
              
              $getQuestionOptions = $request['option'][$qk];
                foreach($getQuestionOptions as $opK => $opV){
                    $optionData = array(
                        'question_id' => $questionId ,
                        'question_option' => $opV,
                        'option_type' =>  1,
                        'add_date' =>  date("Y-m-d"),
                    );
                   $optId =  QuestionOption::create($optionData)->id;
                 
                  if(isset($request['answer'][$qk])){
                    if($opK  == $request['answer'][$qk]){
                        $answerData = array(
                                'question_id' => $questionId,
                                'option_id' =>  $optId,
                                'status' => 1,
                        ); 
                        QuestionRightAnswer::create($answerData); 
                    }
                 }
               }
               $examQuestionData  = array(
                      'exam_id' => $id,
                      'question_id' => $questionId,
                      'status' => 1,
               );
               ExamQuestion::create($examQuestionData); 
            }
          DB::commit();
          $msg = 'Inserted Successfully';
         if($request['save'] == 'continue'){
          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('err_success',$msg);
         }else{ 
          return redirect()->route('confirm-exam',Crypt::encrypt($id))->with('err_success',$msg);     
          }
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

       public function confirmExam($id){
        $questionObj = new Question();
        $de_id =  Crypt::decrypt($id);
        // echo $id;die();
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($de_id);
        // dd($total_marks);
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.confirm-exam',compact('examQuestion', 'id'))->with('title',$title);
        // 
    }

     public function saveConfirmExam(Request $request , $id){
             
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::find($de_id);
         $title = 'Confirm Exam';
         // dd($examDetails);
         $examDetails->minimum_passing_marks = $request['passing_mark'];
         $examDetails->passing_marks_type = $request['passing_mark_type'];
         $examDetails->save();
         return view('admin.exam.confirm-exam-post',compact('title'));
     }

     public function examPostSuccess($id){
        $de_id =  Crypt::decrypt($id);
        $examDetails = Exam::find($de_id);
     }

     public function moreQuestion($id){
        return view('admin.exam.more-questions',compact('id'));
     }
   }

