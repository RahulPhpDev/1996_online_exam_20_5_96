<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(){
    	Mail::send(['text' => 'mail'],['name','MaaRula Online Test'],function($message){
    		$message->to('srp.kumar888@gmail.com','To Amrish')->subject('Test Email');
    		$message->from('mrrahul***@gmail.com','Rahul');
    	});
    }
}
