<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(){
    	Mail::send(['text' => 'mail'],['name','MaaRula Online Test'],function($message){
    		$message->to('mrrahul2016@gmail.com','To Amrish')->subject('Test Email');
    		$message->from('admin@maarulaonlinetest.com','Rahul');
    	});
    }
}
