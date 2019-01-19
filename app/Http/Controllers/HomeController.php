<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use App\User;
use App\Model\Exam;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard(){
        $title = 'Dashboard';
       $userCount =  User::where(array('status' => 1, 'user_type' => 3))->count();
       $ExamCount =  Exam::where(array('status' => 1))->count();
       $packageCount =  Subscription::where(array('status' => 1))->count();
       $data = ['userCount' => $userCount, 'ExamCount' => $ExamCount, 'packageCount' => $packageCount]; 
       // dd($data);
        return view('admin.dashboard', compact('title','data'));
    }

    public function index()
    {
        return redirect()->route('/');
    }
}
