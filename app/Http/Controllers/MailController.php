<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send(){
    	Mail::send(['text' => 'mail'],['name','MaaRula Online Test'],function($message){
    		$message->to('associate.rahul.chauhan@gmail.com','To Raul')
            ->subject('Test Email');
    		$message->from('mrrahul2016@gmail.com','Rahul');
    	});
        die(' check');
    }
    
     public function checkEmail(){
        $alertid = 1;
        $userId = 1;
        // (==username==),(==email==),(==password==)
        $username = 'Rahul Chauhan';
        $email = 'mrrahul2016@gmail.com';
        $password = '12345678';
        $userData = User::find($userId);
        $userEmail =  $userData->email;
        // $emailParams = new stdClass;
        $emailParams = new stdClass;
        $emailParams->user_id = $userId;
        $emailParams->user_email = $userEmail;
        $emailParams->alert_id = $alertid;
        $emailParams->msg_params = [ $username ,$email, $password ];
       $alertObj = new Alert();
       $outputData =  $alertObj->sendEmail($emailParams);
     }
}
