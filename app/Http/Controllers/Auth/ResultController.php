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

        $resultData =  $resultObj->getDataByResultId($r_id,$userId);
        // dd($resultData);
        // echo $r_id;
        // session()->flash('res_id', $r_id);
// dd(session());
      //   dd(session()->all());
// $resultData->Exam->userAnswer;
        // dd($resultData->Exam->userAnswer->where('result_id', $r_id) );
      //   foreach($resultData->Exam->userAnswer[0]->ExamQuestion as $key => $question ){
      //     echo($question->question).'<br>';
      //   }
      // dd('a age');
        return view('permit/result/answer-sheet',compact('resultData','userId'));
  }
}
