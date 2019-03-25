<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use Mail;
use Config;
use App;
use App\Model\Alert;
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
  	                'subject'   =>  $params->subject,
  	                'message'   =>  $params->message,
  	                'send_date' =>  date("Y-m-d H:i:s"),
                    'status'    => 1,
                   );
        DB::table('email_forward')->insertGetId($data);
        $data = array(
               'email'   =>  $params->receiverEmail,
               'subject' =>  $params->subject,
               'msg'     =>  $params->message
          );
      $environment = App::environment();
      // if($environment == 'production'){       
          Mail::send( 'mail', $data, function( $message ) use ($data)
          {
            $message->to( $data['email'] )
              //->from( Config::get('mail.from.address'), Config('app.name'))
              ->subject( $data['subject']);
          });
        // }
      return $data;
  }

  public function Alert(){
    return $this->belongsTo(Alert::class);
  }
    
}


