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

use Redirect;
use DB;
use Image; 
use PDF;
use Dompdf\Dompdf;
use Mpdf;
use stdClass;
use App\helpers\helper;
class UserExamController extends Controller
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
  	    return view('permit/userExam.exam-question',compact('resultData'));
	}
}