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

class UserController extends Controller
{
    public function savePackageExam($c_id){
    	 $id =  Crypt::decrypt($c_id);
    	 $userData = Auth::user();
    	 $userId = $userData['id'];
         $package =  Subscription::find($id);
      
         foreach($package->Exam as $examId){
         	$examIdArray[] = $examId['id'];
         }

        $userDetails =  User::find($userId);


		$package->User()->attach($id, ['status' => 1,
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
    	$id = 1;
 		   $package =  Subscription::find($id);

    	return view('permit.exam.package-exam',compact('package'));

    }

    public function getExam($e_id){
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

         $id =  Crypt::decrypt($e_id);
         // echo $id;die();
         // $id = 1;
         $examData = Exam::find($id);
         $questionData = $examData->ExamQuestion;

        $allQuestionArray = array();
        foreach($questionData as $que){
          $allQuestionArray[] = $que['id'];
        }

      session(['exam_id' => $id]);
      session(['all_questions' => $allQuestionArray]);
      $questionKeys = session('all_questions');
      $current_question = $questionKeys[0];
      session(['current_question' => $current_question]);
 // dd($value[0]);
         $questionDetails    = Question::find($current_question);
         // $nextQuestionId = $examData->ExamQuestion[1]['id'];
       
        //  session([
        //   'current_question' => $questionData['id'],
        //   'next_question' => $nextQuestionId,
        //   'exam_id' => $id
        // ]);

         // dd(session()->all());
       
        $passArray = array(
         'examDetails' => $examData,
         'questionDetails' => $questionDetails,
       //  'nextQuestionId' => $questionKeys[1],
         'examId' => $e_id,
        );

        // dd($examData);
        return view('permit.exam.exam-questions',$passArray);
    }

   
    public function saveAnswer(Request $request){ 
    $examId = session('exam_id');
    $examDetails = Exam::find($examId);
      if($request['save'] !==  'continue' && $request['save'] !==  'skip' ){
          
          $last_attempt_question = session('current_question');
          $allQuestion = session('all_questions');
          $allAttemptQuestion = session('attempt_questions.queID');
          $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
          $nextQuestionId = current($pending_questions);
          
      }
      // echo '<pre>';print_r($questionDetails);die();

      else if($request['save'] ==  'continue'){
        // dd($request);
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

      $userData = Auth::user();
      $userId = $userData['id'];
      UserAnswer::create([
         'user_id' => $userId,
         'exam_id' => $examId,
         'question_id' => $last_attempt_question,
         'answer_id' => $answerID,
         'status' => $status,
         'mark' => $lastQuestionData['marks'],
      ]);
      $nextQuestionId = current($pending_questions);
      }
      else if($request['save'] ==  'skip'){
          $last_attempt_question = session('current_question');
          session()->push('attempt_questions.queID', $last_attempt_question);
          $allQuestion = session('all_questions');
          $allAttemptQuestion = session('attempt_questions.queID');
          $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
          $nextQuestionId = current($pending_questions);
      }

      if(empty($pending_questions)){
       $msg = "Here Is Your Result";
       return redirect()->route('view-result',Crypt::encrypt($examId))->with('success',$msg); 
      }
      
    session(['current_question' => $nextQuestionId]);
    $questionDetails    = Question::find($nextQuestionId);
    // dd($questionDetails);
     $passArray = array(
      'examDetails' => $examDetails,
      'questionDetails' => $questionDetails,
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


         $examId =  Crypt::decrypt($exam_id);
         if($examId != $sessionExamId){
          $false = 1;
         }

        // $examId = 1;
        $examUserObj = new UserAnswer();
       $userData = Auth::user();

       $userId = $userData['id'];
       $examDetails =  Exam::find($examId);
          // dd($examDetails['exam_name']);
      $userExamData  = $examDetails->UserExam()
                        ->where('user_exam.user_id','=',$userId)
                        ->get();     
      if(!empty($userExamData)){ #user has this exam
        $getResult = $examUserObj->getUserExamAnswer($userId , $examId);
      }else{
        $false = 1;
      }
      $totalMark = 0;
      $marks = array();
      foreach($getResult as $res){
          $marks[] = $res->mark;
      }
      $totalMark = array_sum($marks);

      if($false != 1){
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
