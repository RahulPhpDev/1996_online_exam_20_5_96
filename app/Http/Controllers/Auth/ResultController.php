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
use App\Model\QuestionOption;
use Session;

use Redirect;
use DB;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use stdClass;
use App\helpers\helper;
class ResultController extends Controller
{

	public function viewExamQuestions($resultId){
	      $r_id = 2;
	    // Crypt::decrypt($resultId);
        $userData = Auth::user();
        $userId = $userData['id'];
        $userDetails =  User::find($userId);
   	  	// $resultData =     Result::find($r_id);
        $resultObj = new Result;
       $resultData =  $resultObj->getResultByUserId($r_id);
       // dd($resultData);
   		 //return view('permit.userExam.result-question',compact('resultData'));
  	    return view('permit/result.exam-question',compact('resultData'));
	}

  public function answerSheet2($resultId){
        $r_id = Crypt::decrypt($resultId);
        $resultObj = new Result;
        $resultData = $resultObj->getResultDetailsById($r_id);
        dd($resultData);
        // dd($resultData[0]->exam_name);
        return view('permit/result.answer-sheet',compact('resultData'));
  }

  public function answerSheet($resultId){
        $r_id = Crypt::decrypt($resultId);
        $resultObj = new Result;
        $resultData = Result::findorFail($r_id);
        $userData = Auth::user();
        $userId = $userData['id'];
        // dd($resultData);
    //      "pivot_exam_id" => 24
    // "pivot_question_id" => 358
    // "pivot_answer_id" => 1416
// echo '<pre>';print_r($resultData->Exam->userAnswer );
       // echo '<pre>';
      //   $i = 0;
      //   // dd($resultData->Exam->userAnswer[0]->toArray());
      // // foreach($resultData->Exam->userAnswer as $ans){
      //   echo ' ye foreach hai';
      //    foreach($resultData->Exam->userAnswer[0]->ExamQuestion as $question){
      //   // print($ans).'<br>';
      //   //    echo ++$i.'<br>';
      //   // dd( $question->toArray());
      //     echo '<span style = "background:yellow;"> Quetestion:'.'<=====>'.$question['question'].'<========></span>'.'<br>';
      //     foreach($question->Options as $options){

      //     // echo 'question_id'.$question->id.'<br>'; 
      //       // dd($question);
      //       $userAnswerStatus = $resultObj->rightAnswerByResultId($r_id, $userId, $question->id);
      //       // dd($userAnswerStatus->answer_id);

      //       if((isset($userAnswerStatus->answer_id)) &&$userAnswerStatus->answer_id == $options['id'] ){
      //           echo ' Ye User Ka Right Answer==>';
      //         }
      //         if($question->rightAnswer['option_id'] ==$options['id'] ){
      //           echo ' Ye Right Answer==>';
      //         }
      //       echo $options['question_option'].'<br>';
      //     }

      //    }
      //    break;
      // }
      
      // dd('a age');
        return view('permit/result.answer-sheet',compact('resultData','userId'));
  }
}
