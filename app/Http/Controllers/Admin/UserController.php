<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Student;
use App\User;
use Illuminate\Database\QueryException;
use App\Service\PayUService\Exception;
use App\Http\Requests\UserRequest; #form-validation
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Crypt;
class UserController extends Controller
{



       // $allData = DB::table('users as u')->leftjoin('students as s', function ($join) {
       //      $join->where('u.user_type', '=', '2')->on('u.id', '=', 's.user_id');
       //  })->
               // ->select('organisations.*', 'organisations.title AS org_title', 'subscription_plans.*', 'subscription_plans.title AS plan_title')

       // get()->toArray();
       // echo '<pre>';print_r($allData);die();
    public function userList(){
    	$title = 'Users';
    	$allData = DB::table('users as u')
            ->leftJoin('students as s', 'u.id', '=', 's.user_id')
            ->select('s.id as stu_id','s.status as stu_status','u.id as id','fname','lname','username','email','user_type','u.status as status')
            // ->where('u.status',1)
            ->get()->toArray();
      return view('admin.user.user-list',compact('title'))->with('allData' ,$allData);  
    }

	public function addUser(){
		$title = 'Add User';
		// $allCourse = Course::where('status', 1)->get();
		$allCourse = Course::where('status', 1)->pluck('name','id')->toArray();
		
		return view('admin.user.add-user',compact('title','allCourse'));
    }

    public function saveUser(Request $request){
    	// echo '<pre>';print_r($request->all());die();
    	try{

 // $plan = 123; // some logic to decide user's 

		$userData = array(
			'password' => bcrypt('12345'),
            'status' => 1,
            'add_date' => date("Y-m-d"),
            'username' => $request['username'],
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'phone_no' => $request['phone_no'],
            'user_type' => $request['user_type'],
            );

  // $request->request->add($newInsertArray);
  // User::create($request->all());

            $user =  User::create($userData);
        	$lastInsertedId= $user->id;
	        if($request['user_type'] == 2){
	        	$stuData = array(
	        		'user_id' => $lastInsertedId,
	        		'course_id' =>  $request['course_id'],
	        		'enroll_number' => $request['enroll_number'],
	        		'status' => 1,
	        		'join_date' => $request['join_date'],
	        		'end_date' => $request['end_date'],
	        	  );
	        $user =  Student::create($stuData);
  				}
            return redirect()-> route('users')->with('success', 'Insert Successfully');
       }
       catch(Exception $e){
        return redirect()->route('add-user')->with('error', $e->getMessage());
       }

       catch(QueryException $e){
        return redirect()->route('add-user')->with('error', $e->getMessage());
       }
    }

    public function editUser($id){
    	$title = 'Edit User';
    	$id =  Crypt::decrypt($id);
        $userData = DB::table('users as u')
            ->leftJoin('students as s', 'u.id', '=', 's.user_id')
            ->select('s.id as stu_id','u.id as id','fname','lname','username','email','user_type','course_id','enroll_number','join_date','end_date','phone_no')
            ->where('u.id',$id)
            ->first();
       $allCourse = Course::where('status', 1)->pluck('name','id')->toArray();
	return view('admin.user.edit-user',compact('title','allCourse'))->with('userData', $userData);
    }

    public function updateUser(Request $request,$id){

    	$id =  Crypt::decrypt($id);

    	try{

 // $plan = 123; // some logic to decide user's 

		$userData = array(
            'username' => $request['username'],
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'phone_no' => $request['phone_no'],
            'user_type' => $request['user_type'],
            );
			// $where = ''
            $user =  new User();
            $user->where('id' , $id)->update($userData);
	        if($request['user_type'] == 2){
	        	$stuData = array(
	        		'course_id' =>  $request['course_id'],
	        		'enroll_number' => $request['enroll_number'],
	        		'status' => 1,
	        		'join_date' => $request['join_date'],
	        		'end_date' => $request['end_date'],
	        	  );
	        	 $Student =  new Student();
            $Student->where('user_id' , $id)->update($stuData);
	        // $Student =  Student::create($stuData);
  				}
            return redirect()-> route('users')->with('success', 'Insert Successfully');
       }
       catch(Exception $e){
        return redirect()->route('users')->with('error', $e->getMessage());
       }

       catch(QueryException $e){
        return redirect()->route('users')->with('error', $e->getMessage());
       }

    	// dd($request);
    }

    public function deleteUser($id){
    	$id =  Crypt::decrypt($id);
    	try{
		 $userData = array(
            'status' => 0,
            );
            $user =  new User();
            $user->where('id' , $id)->update($userData);
            $studentObj = new Student;
            $studentData = $studentObj
		      	->where('user_id',$id)
            ->first();
            // echo '<pre>';print_r($studentData);die();
            if(($studentData)){
	        	$stuData = array(
            		'status' => 0,
	        	  );
		        $Student =  new Student();
	            $Student->where('user_id' , $id)->update($stuData);
	          }
            return redirect()-> route('users')->with('success', 'Delete Successfully');
       }
       catch(Exception $e){
        return redirect()->route('users')->with('error', $e->getMessage());
       }

       catch(QueryException $e){
        return redirect()->route('users')->with('error', $e->getMessage());
       }
    }

    public function userOtherDetails($id){
    	$id =  Crypt::decrypt($id);
        $allData = DB::table('users as u')
            ->leftJoin('students as s', 'u.id', '=', 's.user_id')
            ->select('s.id as stu_id','u.id as id','fname','lname','username','email','user_type','course_id','enroll_number','join_date','end_date','phone_no')
            ->where('u.id',$id)
            ->first();
       return view('admin.user.user-other-details')->with('allData',$allData);
    }

    public function approveUser(Request $request){
       $id = $request['id'];
       $user = User::find($id);
       $user->status = 1;
       $user->save();
       $allData = DB::table('users as u')
            ->leftJoin('students as s', 'u.id', '=', 's.user_id')
            ->select('s.id as stu_id','u.id as id','fname','lname','username','email','user_type','course_id','enroll_number','join_date','end_date','phone_no')
            ->where('u.id',$id)
            ->first();
         echo '
                  <td>5</td>
                  <td>'.$allData->fname.' '.$allData->lname.' </td>
                  <td> '.$allData->email.' </td>
                  <td>
                     Student
                 </td>
                  <td>  <button type="button"  class="btn btn-info btn-sm des_details" data-toggle="modal" data-target="#myModal" data-id = "'.Crypt::encrypt($id).'">Description</button> </td>

                   <td>
                       <span class="text-success"> Approved </span>
                     </td>
                  <td>
                  <a href="">Edit <i class="fa fa-fw fa-arrow-circle-right"></i></a>
                  </td>
                  <td>
                  <a class = "text-center" > <i class="fa fa-fw fa-arrow-circle-right text-center">Delete</i></a>
                  </td>
                ';   
                exit;
    }
}
