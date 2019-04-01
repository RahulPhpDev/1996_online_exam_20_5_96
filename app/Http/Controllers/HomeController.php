<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use App\User;
use App\Model\Exam;
use App\Model\Result;
use Auth;
use Carbon\Carbon;
use DB;
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
        // dd(Auth::user()->unreadNotifications[0]);
        // dd(Auth::user()->unreadNotifications[0]['data']['subject']);
        $title = 'Dashboard';
       $userCount =  User::where(array('status' => 1, 'user_type' => 3))->count();
       $ExamCount =  Exam::where(array('status' => 1))->count();
       $packageCount =  Subscription::where(array('status' => 1))->count();
       $data = ['userCount' => $userCount, 'ExamCount' => $ExamCount, 'packageCount' => $packageCount]; 
    
        $resultData = DB::table('results as a')
                            ->select('exam_name', DB::raw('count(exam_id) as total'))
                             ->leftJoin('exams as e', 'a.exam_id', '=', 'e.id')
                            ->whereDate('a.add_date',Carbon::today())
                            ->groupBy('exam_id')
                            ->get();
                            // dd($resultData);
     // dd($resultData);
        return view('admin.dashboard', compact('title','data','resultData'));
    }

    public function index()
    {
        return redirect()->route('/');
    }
    public function result_by_date($date){

        $resultData = DB::table('results as a')
                            ->select('exam_name', DB::raw('count(exam_id) as total'))
                             ->leftJoin('exams as e', 'a.exam_id', '=', 'e.id')
                            ->whereDate('a.add_date',$date)
                            // '2019-03-19'
                            ->groupBy('exam_id')
                            ->get();
        return $resultData ;
    }
}
