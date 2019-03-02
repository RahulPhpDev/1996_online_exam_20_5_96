<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mail;
use Config;

class EmailForward extends Model
{
    public $table = 'email_forward';
    public $timestamps = false;
    protected $guarded = [];

    public function saveEmailForward($params){
        $msg = $params->message;
        $subject = $params->subject;
        $receiverEmail = $params->receiverEmail;
    	$data = array(
	                'user_id'   =>	$params->receiverID,
	                'email'     =>  $params->receiverEmail,
	                'alert_id'  =>  $params->alert_id,
	                'sujbect'   =>  $params->subject,
	                'message'   =>  $params->message,
	                'send_date' =>  date('Y-m-d : H:mm:s'),
                  'status'    => 1,
                 );
      DB::table('email_forward')->insertGetId($data);


    $data = array(
       'email' => $receiverEmail,
       'subject' => $subject,
       'msg' =>$msg
        );
// dd($data);
    Mail::send( 'mail', $data, function( $message ) use ($data)
    {
        $message->to( $data['email'] )
        ->from( Config::get('mail.from.address'), Config('app.name'))
        ->subject( $data['subject']);
    });


    }
}


