<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;
use stdClass;
class NotificationAlert extends Model
{
	public $table = 'notification_alerts';
    public $timestamps = false;
    protected $guarded = [];


    public function getNotifictionTemplate($params, $type = 'email'){
    	// DB::enableQueryLog();

    	$alertDatas = DB::table('notification_alerts as na')
    		->leftJoin('notification_template as nt', 'na.template_id', '=', 'nt.id')
    		->where('na.id', $params->notify_id)
    		->get();
    	$alertData  = $alertDatas[0];

    	
    	$output =  new stdClass;

		$inputMessageObj = new stdClass;
		$notifyDbParams = $alertData->notification_params;
		$message = $alertData->message;
		$inputMessageObj->notify_db_params = $notifyDbParams;
		$inputMessageObj->message = $message;
		$inputMessageObj->msg_argument = $params->msg_params;
		$output->message = 	$this->getMessage($inputMessageObj);
	

		$inputSubjectObj = new stdClass;
		$subjectDyamicParmas =  $params->subject_params ?? '';
	
		$subjectDbParams = $alertData->subject_param;
		$subject = $alertData->subject;

		$inputSubjectObj->subject_db_params = $subjectDbParams;
		$inputSubjectObj->subject = $subject;
		$inputSubjectObj->subject_argument = $subjectDyamicParmas;

		$output->subject = 	$this->getSubject($inputSubjectObj);

		// $notifyforwardObj = new notifyForward();
		// $inputObjSendnotify = new stdClass();

		// $inputObjSendnotify->receivernotify = $params->user_notify;
		// $inputObjSendnotify->receiverID = $params->user_id;
		// $inputObjSendnotify->alert_id = $params->alert_id;


		// $inputObjSendnotify->subject = $output->subject;
		// $inputObjSendnotify->message = $output->message;
		// if($type == 'crone'){
		//     return $inputObjSendEmail;
		// }	
		// $forwardEmailOutput =  $emailforwardObj->saveEmailForward($inputObjSendEmail);	
		return $output;	
    }

   

    public function getMessage($inputMessage){
    	$params = $inputMessage->notify_db_params;
    	$msgtemplate  = $inputMessage->message;
    	$inputParms  = $inputMessage->msg_argument;
		$arrParams = explode(',', $params);
		 foreach ($arrParams as $key => $p) {
            $value = $inputParms[$key] ;
            $msgtemplate = str_replace($p, trim($value), $msgtemplate);
        }	
		return $msgtemplate;
    }

    public function getSubject($inputSubjectObj){
    	$params = ($inputSubjectObj->subject_db_params) ? $inputSubjectObj->subject_db_params : '';
    	$subjecttemplate  = $inputSubjectObj->subject;
    	$inputParms  = $inputSubjectObj->subject_argument;
	    if($params ){	
			$arrParams = explode(',', $params);
			 foreach ($arrParams as $key => $p) {
	            $value = $inputParms[$key] ;
	            $subjecttemplate = str_replace($p, trim($value), $subjecttemplate);
	         }	
	        }
    	
		return $subjecttemplate;
    }
}
