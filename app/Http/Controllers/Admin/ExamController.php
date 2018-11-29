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
use App\User;

// request

use App\Http\Requests\QuestionRequest;
class ExamController extends Controller
{
   
//    var  $date =  date("Y-m-d");

    public function examList(){
        $title = 'Exam';
        $examDetails = Exam::where('status', 1)->paginate(10);
        return view('admin.exam.exam-list', compact('examDetails','title'));
    }
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
            $examData = array('exam_name' => $request['exam_name'],
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

            if( $request['exam_type'] == 2){
              foreach($request['student_id'] as $userId){
                 $extraFieldInUserExam = array(
                    'status' => 1, 
                    'user_id' => $userId,
                    'start_date' => date('Y-m-d')
                  );

                 $userDetails =  User::find($userId);
                 $userDetails->Exam()->attach($id,$extraFieldInUserExam);
               }
             }
          DB::commit();
          $msg = 'Inserted Successfully';
          // return \Redirect::route('regions', [$id])->with('message', 'State saved correctly!!!');

          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('success',$msg);     
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
         // dd($getExamData->toArray());
         $title = $getExamData['exam_name'];
         return view('admin.exam.add-exam-question',compact('getExamData','id'))->with('title',$title);
       }

      public function saveExamQuestion(Request $request , $id){
        // dd($request->all());
       DB::beginTransaction();
       try{

          $examData =   Exam::Find($id);
          $total_mark = (($examData->total_marks) > 0) ? $examData->total_marks : 0;
          $is_required = (($examData->is_required) > 0) ? $examData->is_required : 0;
          $totalQuestion = (($examData->total_question) >0 ) ? $examData->total_question  :  0;

          $negative_question = (($examData->negative_question) >0 ) ? $examData->negative_question :  0;
          $negative_marks  =  (($examData->negative_marks) >0 ) ? $examData->negative_marks  :  0;

         
          // $totalQuestion =  $request['total_mark'];$is_required = $totalQuestion = 0;
           if(isset($request['total_mark'])){ 
            $total_mark = $examData->total_marks + array_sum($request['total_mark']);
          }


           if(isset($request['is_required'])){ 
           $is_required =   $examData->required_question +  array_sum($request['is_required']);
          }
           if(isset($request['question'])){ 
            $totalQuestion = $examData->total_question   + count($request['question']);
          }

          if(isset($request['is_negative'])){ 
            $negative_question = $examData->negative_question   + count($request['is_negative']);
          }

          if(isset($request['negative_mark'])){ 
            $negative_marks = $examData->negative_marks   + array_sum($request['negative_mark']);
          }

           
            // dd($examData->minimum_passing_marks);
// echo $totalQuestion;die();
            $examData->total_marks = $total_mark;
            $examData->required_question =   $is_required ;
            $examData->total_question = $totalQuestion;
            $examData->negative_question = $negative_question;
            $examData->negative_marks = $negative_marks;
            $examData->save();

            $questionArray = $request['question'];
            foreach($questionArray as $qk => $qv){
               $total_per_question = 0;
                if(isset($request['total_mark'][$qk])){
                  $total_per_question = $request['total_mark'][$qk];
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
          return redirect()->route('add-exam-question',Crypt::encrypt($id))->with('success',$msg);
         }else{ 
          return redirect()->route('confirm-exam',Crypt::encrypt($id))->with('success',$msg);
               
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
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($de_id);
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.confirm-exam',compact('examQuestion', 'id'))->with('title',$title);
        // 
    }

     public function saveConfirmExam(Request $request , $id){
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::find($de_id);
         $title = 'Confirm Exam';
         $examDetails->minimum_passing_marks = $request['passing_mark'];
         $examDetails->passing_marks_type = $request['passing_mark_type'];
         $examDetails->save();
         return view('admin.exam.confirm-exam-post',compact('title'));
     }

     public function editExam($id){
         $de_id =  Crypt::decrypt($id);
         $examDetails = Exam::find($de_id);
        //  dd($examDetails->toArray());
         $title = 'Edit '.$examDetails['exam_name']. ' Exam';
         // dd( $title );
         return view('admin.exam.edit-exam',compact('examDetails','id', 'title'));
     }

     public function updateExam(Request $req, $id){
        //  dd($req);
        $de_id =  Crypt::decrypt($id);
        $examDetails = Exam::find($de_id);
        $input = Input::only('exam_name', 'passing_marks_type','minimum_passing_marks','description','notes');
        
        $examObj = new Exam();
        $examObj->exists = true;
        $examObj->id = 3; //already exists in database.
        $examObj->exam_name = $input['exam_name'];
        $examObj->passing_marks_type = $input['passing_marks_type'];
        $examObj->minimum_passing_marks = $input['minimum_passing_marks'];
        $examObj->description = $input['description'];
        $examObj->notes = $input['notes'];
        $examObj->save();
        return redirect()->route('exam')->with('success', 'Exam Details are updated!');

     }

     public function examPostSuccess($id){
        $de_id =  Crypt::decrypt($id);
        $examDetails = Exam::find($de_id);
     }

     public function moreQuestion($id){
        return view('admin.exam.more-questions',compact('id'));
     }


     

     public function examQuestion($id){
        // $e_id =  1;
        $e_id = Crypt::decrypt($id);
        $exam = new Exam();
        $examQuestion =  $exam->getExamDetailsById($e_id);
      //dd($examQuestion);
        $title = $examQuestion['exam_details']->exam_name;
        return view('admin.exam.exam-question',compact('examQuestion', 'id'))->with('title',$title);
     }

     public function editExamQuestion($id, $examID){
         $e_id = Crypt::decrypt($id);
         $questionData =  Question::find($e_id);
         $title =  'Edit Question';
    return view('admin.exam.edit-exam-question', compact('questionData','title','e_id','id','examID'));

     }

     public function removeExamQuestion($e_question_id, $e_examID){

         $question_id = Crypt::decrypt($e_question_id);
         $examID = Crypt::decrypt($e_examID);         
        $examData = Exam::findOrFail($examID);
        $questionData = Question::findOrFail($question_id);
        //dd($questionData);
        $examData->total_marks = $examData['total_marks'] - $questionData['marks'];
        $examData->total_question = $examData['total_question'] - 1;
        $examData->required_question = $examData['required_question'] - ($questionData['is_required'] == 1) ? 1 : 0;
         $examData->negative_question = $examData['negative_question'] - ($questionData['is_negative_marking'] == 1) ? 1 : 0;
         if($questionData['is_negative_marking'] == 1){
          $examData->negative_marks = $examData['negative_marks'] - $questionData['negative_marks'];
         } 
        $examData->save();
        $questionData->rightAnswer()->delete();
        $questionData->Options()->delete();
        $examData->ExamQuestion()->detach($question_id);
        $questionData->delete();
        return redirect()->back()->with('success', 'Question Removed!');


     }

     

     public function updateExamQuestion(Request $req, $id) {  
        
         $e_id = Crypt::decrypt($id);
        $questionData =  Question::find($e_id);

        $questionData->rightAnswer['option_id'] = $req['answer'];
        $questionData->rightAnswer->save();

        $req['is_required'] = ($req['is_required']) ? $req['is_required'] : 0;
        $questionData->question = htmlentities($req['question']);
        $questionData->is_required = $req['is_required'];
        $questionData->marks = $req['total_mark'];

        $negativeMarks = ($req['is_negative'] == 1) ? $req['negative_mark'] : '0';
        $questionData->is_negative_marking = ($req['is_negative']) ? 1 : 0;

        $questionData->negative_marks =  $negativeMarks;
        $questionData->save();
        
        foreach($questionData->Options as $key => $opData){
            $opData->question_option =  $req['option'][$opData->id];
            $opData->save();
        }
        // return redirect()->route('profile', ['id' => 1]);
        $exam_id = $req['exam_id'];
        return redirect()->route('confirm-exam',  ['id' => $exam_id]);
        // confirmExam
    }

    public function examAccessbility($id){
       $e_id = Crypt::decrypt($id);
       $examDetails =  Exam::findOrFail($e_id);

       return view('admin.exam.exam-accessbility',compact('examDetails', 'id','examAccessbilityData'));
    }

    public function removeExamUser( Request $req, $id){
       $e_id = Crypt::decrypt($id);
        $examData = Exam::find($e_id);
        foreach($req['all_ids'] as $ids){ 
          $examData->UserExamData()->updateExistingPivot(
            $ids, array('status' => 0), false);
        }
    }
   }

