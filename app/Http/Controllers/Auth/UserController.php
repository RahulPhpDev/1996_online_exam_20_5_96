<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Auth;


use App\User;
use App\Model\Subscription;

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

    }
}
