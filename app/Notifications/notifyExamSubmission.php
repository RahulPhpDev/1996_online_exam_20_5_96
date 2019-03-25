<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class notifyExamSubmission extends Notification
{
    use Queueable;

   
    public function __construct()
    {
        //
    }

    public $details;
    public function __construct($details)
    {
        $this->details = $details;
    }
   
    public function via($notifiable)
    {
        return [ 'database'];
    }

  
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    public function toArray($notifiable)
    {
       return [
            'message' =>  $this->details['message'],
            'email' => $this->details['email'] 
        ];
    }
}
