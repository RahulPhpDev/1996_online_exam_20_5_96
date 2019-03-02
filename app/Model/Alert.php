<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\EmailForward;
use DB;
use stdClass;
class Alert extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function sendEmail($params){
    	// DB::enableQueryLog();

    	$alertDatas = DB::table('alerts as a')
    		->leftJoin('email_template as et', 'a.email_template_id', '=', 'et.id')
    		->where('a.id', $params->alert_id)
    		->get();
    	$alertData  = $alertDatas[0];

    	$output =  new stdClass;

		$inputMessageObj = new stdClass;
		$emailDbParams = $alertData->email_params;
		$message = $alertData->message;

		$inputMessageObj->email_db_params = $emailDbParams;
		$inputMessageObj->message = $message;
		$inputMessageObj->msg_argument = $params->msg_params;
		$output->message = 	$this->getMessage($inputMessageObj);
// dd($messageOutput );
		// get Subject 
		$inputSubjectObj = new stdClass;
		$subjectDyamicParmas =  $params->subject_params ?? 'this';

		$subjectDbParams = $alertData->email_subject_params;
		$subject = $alertData->subject;

		$inputSubjectObj->subject_db_params = $subjectDbParams;
		$inputSubjectObj->subject = $subject;
		$inputSubjectObj->subject_argument = $subjectDyamicParmas;


		$output->subject = 	$this->getSubject($inputSubjectObj);

		$emailforwardObj = new EmailForward();
		$inputObjSendEmail = new stdClass();

		$inputObjSendEmail->receiverEmail = $params->user_email;
		$inputObjSendEmail->receiverID = $params->user_id;
		$inputObjSendEmail->alert_id = $params->alert_id;


		$inputObjSendEmail->subject = $output->subject;
		$inputObjSendEmail->message = $output->message;
		$emailforwardObj->saveEmailForward($inputObjSendEmail);

		return $output;
    }

   

    public function getMessage($inputMessage){
    	$params = $inputMessage->email_db_params;
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
