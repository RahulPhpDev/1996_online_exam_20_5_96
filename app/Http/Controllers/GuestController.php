<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use Illuminate\Support\Facades\Crypt;
use App\Model\Exam;

// use Session;

class GuestController extends Controller
{
    public function index(){
	    	$SubscriptionData  = Subscription::where('status', 1)->get();
	    	return view('welcome',compact('SubscriptionData'));
    }

   
     public function aboutUs()
    {
        return view('guest.about-us');
    }

    public function package($id){
        $id =  Crypt::decrypt($id);
        $package =  Subscription::find($id);
        $otherPackage = Subscription::get()->where('id', '!=', $id);
        // dd($package);
    	return view('guest.package',compact('package','otherPackage'));
    }

    public function payment(){
        return view('guest.payment');
    }

    public function sessionTest(){
       // $data = session()->all();
       // session()->flush();
        // session('exam_id', '2');
          session(['exam_id' => '2']);
        session()->push('ids', '1');
        session()->push('ids', '2');
        session()->push('ids', '3');
        // session()->push('user.teams', 'developers');
        // session(['next_question' => 'question_id_2']);
// session()->push(
        // $value = session()->pull('next_question');
        // echo $value;
        // if(session()->has('current_question')) {
        //      session('current_question');
        // }


        // session()->push('current_question.new[]', 'developers ');
        echo __LINE__.session('exam_id');
        dd(session()->all());
    }

    public function nextSession(){
        // session()->flush();
        // session(['exam_id' => '2']);
        // session()->push('ids', '1');
        // session()->push('ids', '2');
        // session()->push('ids', '3');
        dd(session()->all());
    }

    public function checkSession(){
       \Session::put('somekey', 'somevalue');

        dd(session('somekey'));
    }
}
