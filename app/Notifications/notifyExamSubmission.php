<?php
/* ******************************
    ***********
         This used to notify super admin when 
                exam submitted by User
    ********** 


*************************
*/
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Model\NotificationAlert;
use stdClass;
class notifyExamSubmission extends Notification
{
    use Queueable;

    public $details;
    protected $notifyDetails;
    public function __construct($details,$notifyParams)
    {
        // $inputObj = new stdClass();
        $notificationAlertObj = new NotificationAlert();
        $notifyDetails = $notificationAlertObj->getNotifictionTemplate($notifyParams);
        $this->notifyDetails = $notifyDetails;
        $this->details = $details;
    }
   
    public function via($notifiable)
    {
        return [ 'database'];
    }

    public function toArray($notifiable)
    {
       return [
            'subject' => $this->notifyDetails->subject,
            'message' =>  $this->notifyDetails->message,
            'email' => $this->details['email'] 
        ];
    }
}
