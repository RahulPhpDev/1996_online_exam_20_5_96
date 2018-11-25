<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Auth;


use App\User;
use App\Model\Subscription;
use App\Model\Question;
use App\Model\Exam;
use App\Model\UserAnswer;
use App\Model\Result;
use Session;


class UserController extends Controller
{
    public function savePackageExam($c_id){
    	 $id =  Crypt::decrypt($c_id);
    	 $userData = Auth::user();
       $userId = $userData['id'];
      
         $package =  Subscription::find($id);
         $examIdArray = array();
         foreach($package->Exam as $examId){
          	$examIdArray[] = $examId['id'];
         }

        $userDetails =  User::find($userId);
        // dd($userDetails);
		$package->User()->attach($id, [
      'user_id' => $userId,
      'status' => 1,
			'start_date' => date('Y-m-d'),
			'created_at' => date('Y-m-d') ]
		);
		
	  $extraFieldInUserExam = array(
	  	'status' => 1, 
	  	'user_id' => $userId,
	  	'start_date' => date('Y-m-d')
	  );
	  foreach($examIdArray as $eid){
	     $userDetails->Exam()->attach($eid,$extraFieldInUserExam);
	 }
    $msg = 'Congratulation !! Please Explore Package';
	 return redirect()->route('subscrption-exam',Crypt::encrypt($id))->with('success',$msg); 
    }

    public function subscrptionExam($id = ''){
       $sid =  Crypt::decrypt($id);
 		   $package =  Subscription::find($sid);
    	return view('permit.exam.package-exam',compact('package'));

    }

    public function getExam($e_id){
      if(session()->has('exam_id')) {
         session()->forget('exam_id');
       }

      if(session()->has('all_questions')) {
       session()->forget('all_questions');
     }

     if(session()->has('all_questions_class')) {
      session()->forget('all_questions_class');
    }

      if(session()->has('current_question')) {
       session()->forget('current_question');
     }
     
     if(session()->has('user_answer.question')) {
      session()->forget('user_answer.question');
    }

    $userData = Auth::user(); 
      $userId = $userData['id'];

         $id =  Crypt::decrypt($e_id);
         $examData = Exam::find($id);
         $hasUserExam = $examData->UserExamData()->where('user_id', $userId)->exists();

      if($hasUserExam == false){
        $examData->UserExamData()->attach($id, ['user_id' => $userId, 'status' => 1,
      'start_date' => date('Y-m-d')] );
      }
         $questionData = $examData->ExamQuestion;

        $allQuestionArray = array();
        foreach($questionData as $que){
          $allQuestionArray[] = $que['id'];
          $all_questions_class_array[$que['id']] = 'pending'; 
        }

        
      session(['all_questions_class' => $all_questions_class_array]);


      session(['exam_id' => $id]);
      session(['all_questions' => $allQuestionArray]);
      $questionKeys = session('all_questions');
      $current_question = $questionKeys[0];
      session(['current_question' => $current_question]);
 
         $questionDetails    = Question::find($current_question);
         // $nextQuestionId = $examData->ExamQuestion[1]['id'];
       
        //  session([
        //   'current_question' => $questionData['id'],
        //   'next_question' => $nextQuestionId,
        //   'exam_id' => $id
        // ]);
        $passArray = array(
         'examDetails' => $examData,
         'questionDetails' => $questionDetails,
       //  'nextQuestionId' => $questionKeys[1],
         'examId' => $e_id,
         'all_questions_class' => session('all_questions_class'),
        );
        return view('permit.exam.exam-questions',$passArray);
    }

   
    public function saveAnswer(Request $request){
    
      // Session::put('all_questions_class.'.$id,'answer');
      $userData = Auth::user(); 
      $userId = $userData['id'];
     $examId = session('exam_id');
     $examDetails = Exam::find($examId);
    //  all_questions_class
      if($request['save'] !==  'continue' && $request['save'] !==  'skip' ){
          $last_attempt_question = session('current_question');
          $allQuestion = session('all_questions');
          $allAttemptQuestion = session('attempt_questions.queID');
          $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
          $nextQuestionId = current($pending_questions);
      }
      // echo '<pre>';print_r($questionDetails);die();

      else if($request['save'] ==  'continue'){
        $last_attempt_question = session('current_question');
        $answerID = $request['answer'];
        $lastQuestionData =  Question::find($last_attempt_question); 
        session()->push('attempt_questions.queID', $last_attempt_question);
        $allQuestion = session('all_questions');
        $allAttemptQuestion = session('attempt_questions.queID');

        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        $rightAnswerId = ($lastQuestionData->rightAnswer->option_id);
        $status = 0;
        if($rightAnswerId ==  $answerID ){
          $status = 1;
        }
        if($rightAnswerId !=  $answerID ){
         $status = 2;
        }

     
      $lastAnswerid = UserAnswer::create([
         'user_id' => $userId,
         'exam_id' => $examId,
         'question_id' => $last_attempt_question,
         'answer_id' => $answerID,
         'status' => $status,
         'mark' => $lastQuestionData['marks'],
      ])->id;
      session()->push('user_answer.question',$lastAnswerid );

        $nextQuestionId = current($pending_questions);
        Session::put('all_questions_class.'.$last_attempt_question,'answered');
        
      }
      else if($request['save'] ==  'skip'){
          $last_attempt_question = session('current_question');
          session()->push('attempt_questions.queID', $last_attempt_question);
          $allQuestion = session('all_questions');
          $allAttemptQuestion = session('attempt_questions.queID');
          $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
          $nextQuestionId = current($pending_questions);

           $lastAnswerid = UserAnswer::create([
             'user_id' => $userId,
             'exam_id' => $examId,
             'question_id' => $last_attempt_question,
             'answer_id' =>0,
             'status' => 3,
             'mark' => 0,
          ])->id;
      session()->push('user_answer.question',$lastAnswerid );
      Session::put('all_questions_class.'.$last_attempt_question,'answered_escape');
      }

      if(empty($pending_questions)){
       $msg = "Here Is Your Result";
       return redirect()->route('view-result',Crypt::encrypt($examId))->with('success',$msg); 
      }
      
    session(['current_question' => $nextQuestionId]);
    $questionDetails    = Question::find($nextQuestionId);
     $passArray = array(
      'examDetails' => $examDetails,
      'questionDetails' => $questionDetails,
      'all_questions_class' =>  session('all_questions_class'),
    );
    return view('permit.exam.exam-questions',$passArray);
  }

  public function viewResult($exam_id){
      $false = 0;
      $sessionExamId = session('exam_id');
      if(session()->has('exam_id')) {
         session()->forget('exam_id');
       }

      if(session()->has('all_questions')) {
       session()->forget('all_questions');
     }
      if(session()->has('current_question')) {
       session()->forget('current_question');
     }
      if(session()->has('attempt_questions.queID')) {
       session()->forget('attempt_questions.queID');
     }
     $user_answer_question = array();
     if(session()->has('user_answer.question')) {
       $user_answer_question = session('user_answer.question');
    }

         $examId =  Crypt::decrypt($exam_id);
 
      if($false == 0){  
        $examUserObj = new UserAnswer();
       $userData = Auth::user();

       $userId = $userData['id'];
       $examDetails =  Exam::find($examId);
      
      $userExamData  = $examDetails->UserExam()
                        ->where('user_exam.user_id','=',$userId)
                        ->get()->toArray();     
      if(!empty($userExamData)){ #user has this exam
        $getResult = $examUserObj->getUserExamAnswer($userId , $examId);
      }else{
        $false = 1;
      }
    }

      if($false != 1){ 
        $totalMark = 0;
        $marks = array();
        foreach($getResult as $res){
            $marks[] = $res->mark;
        }
        $totalMark = array_sum($marks);
       
        //Check For IF Student IS Pass Or Not 
        if($examDetails['passing_marks_type'] == 1){
          $passingNumber = $examDetails['minimum_passing_marks'] ;
        }else if($examDetails['passing_marks_type']){
          $passingNumber =  ($examDetails['total_marks'] * $examDetails['minimum_passing_marks'])/100 ;
        }
// End
    $passingStatus = 2; #fail
      if($passingNumber <= $totalMark ){
        $passingStatus = 1; #pass
      }
        $resultObj = new Result();
        $resultData = array(
          'exam_id' => $sessionExamId,
          'user_id' => $userId,
          'obtain_mark' => $totalMark,
          'result_status' => $passingStatus,
          'right_answer' => 2,
          'negative_marks' =>  5,
          'correct_answer' => 2,
          'wrong_answer' =>  1,
          'not_attempt' => 1,
       );
      $id =  $resultObj::create($resultData)->id;  
      foreach($user_answer_question as $key => $value){
        $userAnswerDetails =  UserAnswer::find($value);
        $userAnswerDetails->result_id = $id;
        $userAnswerDetails->save();
      }

      if(session()->has('user_answer.question')) {
       session()->forget('user_answer.question');
     }
     
        $viewData = array(
          'examDetails' => $examDetails,
          'userExamData' => $userExamData,
          'userData' => $userData,
          'totalMark' => $totalMark,
        );
        return view('permit.exam.result', $viewData);
      }else{
        return redirect()->route('/');
      }

     }
}
