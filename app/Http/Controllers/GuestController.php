<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Subscription;
use Illuminate\Support\Facades\Crypt;
use App\Model\Exam;

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
        // dd($otherPackage);
    	return view('guest.package',compact('package','otherPackage'));
    }

    public function payment(){
        return view('guest.payment');
    }
}
