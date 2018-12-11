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
use App\helpers\helper;

use Redirect;
use DB;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use Response;

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
   
    public function examInstruction($e_id){
      $id = Crypt::decrypt($e_id);
      $examData = Exam::find($id);
      // dd($examData);
      return view('permit.exam.exam-instruction',compact('examData'));
    }

    public function getExam($e_id){
      // session()->flush();
      // die();
      // dd(session::all());
    //   if(session()->has('exam_id')) {
    //      session()->forget('exam_id');
    //    }

    //   if(session()->has('all_questions')) {
    //    session()->forget('all_questions');
    //  }

    //  if(session()->has('all_questions_class')) {
    //   session()->forget('all_questions_class');
    // }

    //   if(session()->has('exam_process')) {
    //    session()->forget('current_question');
    //  }
     
    //  if(session()->has('user_answer.question')) {
    //   session()->forget('user_answer.question');
    // }

    
      $userData = Auth::user(); 
      $userId = $userData['id'];
      // dd(session('start_time'));
       // session()->forget('start_time');
      $time = date('Y-m-d H:i:s');
      $difference = 0;
        if(!session()->has('start_time')) {
           session(['start_time' => $time]);
        }else{
         $difference =  timeDifference(session('start_time'));
        }
         $id =  Crypt::decrypt($e_id);
         $examData = Exam::find($id);
         if(!session()->has('exam_process')) { 
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
    }else{
      $current_question = session('current_question');
    }
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
         'difference' => $difference
        );

      //  dd($passArray);
        return view('permit.exam.exam-questions',$passArray);
    }

   
    public function saveAnswer(Request $request){
    
    session()->put('exam_process', 1);
      $userData = Auth::user(); 
      $userId = $userData['id'];
     $examId = session('exam_id');
     $examDetails = Exam::find($examId);
     $allQuestion = session('all_questions');
     
     if($request['save'] ==  'continue'){
        $last_attempt_question = session('current_question');
        $answerID = $request['answer'];
        session()->push('attempt_questions.queID', $last_attempt_question);
        $allAttemptQuestion = session('attempt_questions.queID');
        Session::put('questions_answer.'.$last_attempt_question,$answerID);
        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        $nextQuestionId = current($pending_questions);
        session(['current_question' => $nextQuestionId]);
        Session::put('all_questions_class.'.$nextQuestionId,'current');
        Session::put('all_questions_class.'.$last_attempt_question,'answered');
      }
      else if($request['save'] ==  'preview'){
        $last_attempt_question = session('current_question');
        session()->push('attempt_questions.queID', $last_attempt_question);
        $allAttemptQuestion = session('attempt_questions.queID');
        Session::put('all_questions_class.'.$last_attempt_question,'review');
        $pending_questions = array_diff($allQuestion,$allAttemptQuestion);
        $nextQuestionId = current($pending_questions);        
        Session::put('all_questions_class.'.$nextQuestionId,'current');
        session(['current_question' => $nextQuestionId]);
      }
      if(empty($pending_questions)){
        Session::save();
        die('view-result');
      }
    $questionDetails    = Question::find($nextQuestionId);
     $passArray = array(
      'examDetails' => $examDetails,
      'questionDetails' => $questionDetails,
      'all_questions_class' =>  session('all_questions_class'),
    );
    return view('permit.exam.exam_questions_ajax',$passArray);
  }

  public function getQuestion(Request $request){
    session(['current_question' => $request['que_id']]);
    $id = $request['que_id'];
    Session::put('all_questions_class.'.$id,'current');
    $questionDetails    = Question::find($id);
     $passArray = array(
      'questionDetails' => $questionDetails,
      'all_questions_class' =>  session('all_questions_class'),
    );
    return view('permit.exam.exam_questions_ajax',$passArray);
  }

  public function viewResult($exam_id  = ''){
    // dd(session()->all());
    $difference = '0';
    if(session()->has('start_time')) {
      $difference =  timeDifference(session('start_time'));
      session()->forget('start_time');
    }
    if(!session()->has('exam_id')) {
     return redirect('/');
    }
       $userData = Auth::user();
       $userId = $userData['id'];
      $false = 0;
      $sessionExamId = session('exam_id');
      $examId =$sessionExamId;
        $answerQuestionArray = session('questions_answer');
       $userAnswerData = array(); 
       $correctAnswerCount = $correctAnswerMark = $wrongAnswerCount =  $wrongAnswerMark = $totalMark =  0;
        if(!empty($answerQuestionArray)){
          foreach($answerQuestionArray as $qId => $ansId ){
            $questionData =  Question::find($qId); 
             $rightAnswerId = ($questionData->rightAnswer->option_id);
             $status = $mark = 0;
             if($rightAnswerId ==  $ansId ){
                $status = 1;
                $mark =  $questionData['marks'];
                $correctAnswerCount++;
                $correctAnswerMark += $mark; 
                $totalMark += $mark;
              }
            else if($rightAnswerId !=  $ansId ){
              $status = 2;
              $mark = '-'.$questionData['negative_marks'];
              $wrongAnswerCount++;
              $wrongAnswerMark += $questionData['negative_marks'];
              $totalMark += $mark;
            }

            $lastAnswerid = UserAnswer::create([
              'user_id' => $userId,
              'exam_id' => $examId,
              'question_id' => $qId,
              'answer_id' => $ansId,
              'status' => $status,
              'mark' =>  $mark,
           ])->id;
           $userAnswerData[] =  $lastAnswerid;
          }
        }
// here is ending of answer to show 
      if($false == 0){  
        $examUserObj = new UserAnswer();
       $examDetails =  Exam::find($examId);
       $userExamData  = $examDetails->UserExam()
                        ->where('user_exam.user_id','=',$userId)
                        ->get()->toArray();                
    }

      if($false != 1){ 
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
          'right_answer_mark' => $correctAnswerMark ,
          'negative_marks' =>  $wrongAnswerMark,
          'correct_answer' => $correctAnswerCount,
          'wrong_answer' =>  $wrongAnswerMark,
          'not_attempt' => 1,
          'time_taken' => $difference 
       );
      $id =  $resultObj::create($resultData)->id;  
     
      foreach($userAnswerData as $key => $value){
        $userAnswerDetails =  UserAnswer::find($value);
        $userAnswerDetails->result_id = $id;
        $userAnswerDetails->save();
      }

          if(session()->has('user_answer.question')) {
            session()->forget('user_answer.question');
          }
          if(session()->has('attempt_questions')) {
            session()->forget('attempt_questions');
          }
          if(session()->has('questions_answer')) {
            session()->forget('questions_answer');
          }
          
         if(session()->has('exam_id')) {
            session()->forget('exam_id');
          }
          if(session()->has('all_questions')) {
            session()->forget('all_questions');
          }
          if(session()->has('all_questions_class')) {
          session()->forget('all_questions_class');
        }

          if(session()->has('exam_process')) {
            session()->forget('current_question');
            session()->forget('exam_process');
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

     public function allResult(){
      $userData = Auth::user();
      $userId = $userData['id'];
      $examCount =   Result::where('user_id', '=',$userId) ->groupBy('exam_id')->count();

      $resultData = Result::where('user_id', '=',$userId)
                           ->groupBy('exam_id')->select('*', DB::raw('count(*) as total')) ->paginate(10);



      // // $resultData =  Result::where('user_id', '=',$userId)
      // //                        ->groupBy('exam_id')
      // //                        ->orderBy('id','DESC')
      // //                        ->paginate(10); 
      //                        dd($resultData);
      return view('permit.exam.all-result', compact('resultData','examCount'));
     }

     public function examResult($id){
        $examId = Crypt::decrypt($id);
        $userData = Auth::user();
        $userId = $userData['id'];
        $resultData =   Result::where(['user_id' => $userId, 'exam_id' => $examId]) 
                              ->orderBy('id','DESC')
                              ->paginate(10); 
      
        return view('permit.exam.exam-result', compact('resultData'));                       
     }

     public function downloadExamPdf($id){
       $resultId = Crypt::decrypt($id);
       $userData = Auth::user();
       $userId = $userData['id'];
       $data = Result::find($resultId);
        $pdf = PDF::loadView('permit.exam.download-exam-pdf',compact('data'));
        $examName = $data->Exam->exam_name;
        return $pdf->download('MaaRula_'.$examName.'_'.($resultId+15).'.pdf');
     }
   
     
    
}
