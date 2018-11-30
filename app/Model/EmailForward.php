<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class EmailForward extends Model
{
    public $table = 'email_forward';
    public $timestamps = false;
    protected $guarded = [];

    public function saveEmailForward($params){
    	$data = array(
	                'user_id'   =>	$params->receiverID,
	                'email'     =>  $params->receiverEmail,
	                'alert_id'  =>  $params->alert_id,
	                'sujbect'   =>  $params->subject,
	                'message'   =>  $params->message,
	                'send_date' =>  date('Y-m-d : H:mm:s'),
                 );
      DB::table('email_forward')->insertGetId($data);

      
        // Mail::send(array(), array(), function ($message) use ($outputData->message) {
        //   $message->to($userEmail)
        //     ->subject($outputData->subject)
        //     ->from($adminEmail)
        //     ->setBody( $outputData->message, 'text/html');
        // });

    }
}


