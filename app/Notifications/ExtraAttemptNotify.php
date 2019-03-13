<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Model\EmailForward;
use App\Model\Alert;
use stdClass;
class ExtraAttemptNotify extends Notification
{
    use Queueable;
    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
         return ['database'];
        // return [ 'database'];
    }
    // public function toCustom($notifiable){
       
    // }
    public function toMail($notifiable)
    {
        // // dd('here');
        return EmailForward::create([
                'user_id' => 1,
                'email' => 'mrahu',
                'alert_id' => 4,
                'subject' => 11,
                'message' => 'accha',

            ])->id;
        // die('dekho');
        // return (new MailMessage)
        //             ->greeting('Congratulation on Getting More Attempt')
        //             ->line('Congratulation on more attempt.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our Website!');
    }


    // public function toArray($notifiable)
    // {
    //     return [
    //         'id' => 1,
    //         'read_at' => null,
    //         'data' => [
    //             'user_email' => ,
    //             'message' => $this->post->id,
    //         ],
    //     ];
    // }

  public function toDatabase($notifiable)
    {
        return [
            'message' =>  $this->details['message'],
            'email' => $this->details['email'] 
        ];
    }
  
}
