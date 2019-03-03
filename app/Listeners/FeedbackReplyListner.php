<?php

namespace App\Listeners;

use App\Events\FeedbackReply;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Feedback;

use App\Model\Alert;
use stdClass;
use Mail;
use Config;
use Session;
class FeedbackReplyListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FeedbackReply  $event
     * @return void
     */
    public function handle(FeedbackReply $eventId)
    {
        $feedbackData = Feedback::find($eventId->feedbackId);
        $oldFeedback = Feedback::find($feedbackData->id);
        $emailParams = new stdClass;
        $emailParams->user_id = 999;
        $emailParams->user_email =  $oldFeedback['email'];
        $emailParams->alert_id = 3;

        $emailParams->subject_params = [$feedbackData['subject']];
        $emailParams->msg_params = [$feedbackData['name'], $oldFeedback['add_date'] , $feedbackData['subject'],$feedbackData['message']];
        $alertObj = new Alert();
        $outputData =  $alertObj->sendEmail($emailParams);

        
        Mail::send( 'mail', $outputData, function( $message ) use ($outputData)
        {
            $message->to( $outputData['email'] )
            ->subject( $outputData['subject']);
        });
        Session::flash('success', 'Your Message has send to User!'); 
       

    }
}
