<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Institution;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use DB;
use \Throwable ;
 use App\Services\PayUService\Exception;
use Illuminate\Database\QueryException;
use App\Model\Subscription;


use App\Model\Result;
use App\Model\Exam;
use App\User;
use Redirect;
//use Illuminate\Http\Request; #form-validation

class ResultController extends Controller
{
    public function view(){
       $title = 'Result';
       $resultObj  = new Result();
       $allData =  Result::where('status', '1')->orderBy('add_date', 'desc')->paginate(10);
       $witharray = array('allData' => $allData, 'title' =>$title);
       return view('admin.result.result_view')->with($witharray);
    }

    public function examResult($e_id){
        $title = 'Result';
        $eid =   Crypt::decrypt($e_id);
        $examDetails = Exam::find($eid);
        $resultObj  = new Result();
        $resultData =  Result::where('status', '1')->orderBy('add_date', 'desc')->where("exam_id", '=', $eid)->paginate(10);
       // dd($resultData);
        $witharray = array('resultData' => $resultData, 'title' =>$title,'examDetails' => $examDetails);
        return view('admin.result.exam-result')->with($witharray);
     }

     public function userResult($u_id){
        $title = 'Result';
        $uid =   Crypt::decrypt($u_id);
        $userDetails = User::find($uid);
        $resultObj  = new Result();
        $resultData =    Result::where('status', '1')->orderBy('add_date', 'desc')->where("user_id", '=', $uid)->paginate(10);
        // dd($allData);
        $witharray = array('resultData' => $resultData, 'title' =>$title,'userDetails'=> $userDetails);
        return view('admin.result.user-result')->with($witharray);
     }
    
     public function inspectionSheet($resultId){
      $r_id = Crypt::decrypt($resultId);
      $resultObj = new Result;
      // dd($r_id);
       $resultData = $resultObj->getResultDetailsforAdmin($r_id);
      // dd($resultData);
      $title = 'Result';
      $witharray = array('resultData' => $resultData, 'title' =>$title);
      return view('admin.result.inspection-sheet')->with($witharray);
     }

     public function resultAnswerSheet($resultId){
       $r_id = Crypt::decrypt($resultId);
       $resultObj = new Result;
       $resultData = $resultObj->getResultDetailsforAdmin($r_id);
      //  dd($resultData);
       $title = 'Result';
       $witharray = array('resultData' => $resultData, 'title' =>$title);
       return view('admin/result.result-answer-sheet')->with($witharray);
      }

      public function deleteResult($resultId){
         $r_id = Crypt::decrypt($resultId);
         // dd($r_id);
         $data = ['status'=> 0,'edit_date' => date('Y-m-d H:i:s')];
         Result::where('id',$r_id)->update($data);
         // return redirect()->back()->with('err_success',$msg);
         return redirect()->back()->with('success', 'Data removed');
      }
   

}
