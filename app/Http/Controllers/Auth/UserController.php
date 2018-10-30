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
        
         $id =  Crypt::decrypt($e_id);
         // echo $id;die();
         // $id = 1;
         $examData = Exam::find($id);
         $questionData = $examData->ExamQuestion[0];
         $questionDetails    = Question::find($questionData['id']);
        $nextQuestionId = $examData->ExamQuestion[1]['id'];
       
        $passArray = array(
         'examDetails' => $examData,
         'questionDetails' => $questionDetails,
         'nextQuestionId' => $nextQuestionId ,
          'id' =>  $id,
        );

        // dd($examData);
        return view('permit.exam.exam-questions',$passArray);
    }

    public function saveAnswer($examId, Request $request){ 
      if($request['save'] ==  'continue'){ 
    // dd($request->all());    
        $nextQuestionId = $request['nxt'];
        $questionID = $request['questionId'];
        // echo  $questionID;
        $answerID = $request['answer'];
        
       $currentQuestionDetails =  Question::find($questionID);       
      
       $examDetails = Exam::find($examId);

       $questionData = $examDetails->ExamQuestion[0];
       $questionDetails = Question::find($nextQuestionId);

       // $questionRightAnswer =  $questionDetails->rightAnswer();
       $rightAnswerId = ($questionDetails->rightAnswer->option_id);
       $status = 0;
       if($rightAnswerId ==  $answerID ){
        $status = 1;
       }
       if($rightAnswerId !=  $answerID ){
        $status = 2;
       }


       $nextQuestionId = $examDetails->ExamQuestion[1]['id'];
     
     UserAnswer::create([
        'user_id' => 1,
        'exam_id' => $examId,
        'question_id' => $questionID,
        'answer_id' => $answerID,
        'status' => $status,
        'mark' => 1,
     ]);
}
      $passArray = array(
        'examDetails' => $examDetails,
       'questionDetails' => $questionDetails,
       'nextQuestionId' => $nextQuestionId ,
        'id' =>  $examId,
      );
     return view('permit.exam.exam-questions',$passArray);
    }
}
