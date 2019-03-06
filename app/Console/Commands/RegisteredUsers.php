<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Config;
// use Mail;
use stdClass;
use App\Model\Alert;
class RegisteredUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'registered:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Registered';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $registerUser = \DB::table('users')
                  ->whereRaw('Date(add_date) = CURDATE()-1')
                  ->get(['id', 'fname', 'lname' ,'email']);
         $table =  'No Data to display';
         if(!empty($registerUser)){
                $table = "<table  width='50%'>
                  <tr>
                    <th> Id </th>
                    <th> UserId </th>
                    <th> Name </th>
                    <th> Email </th>
                  </tr>";

              foreach($registerUser as $key =>  $user){
               $table .="
                <tr>
                    <td> ".++$key." </td>
                    <td> $user->id  </td>
                    <td> $user->fname $user->lname </td>
                    <td> $user->email </td>
                 </tr>";  
              }  
         }
        $emailParams = new stdClass;
        $emailParams->user_id = 1;
        $emailParams->user_email =  'mrrahul2016@gmail.com';
        $emailParams->alert_id = 4;
        $emailParams->subject_params = [$this->description,date('Y-m-d')];
        $emailParams->msg_params = [$this->description,date('Y-m-d'),count($registerUser), $table, $this->description,date('Y-M-d')];
        $alertObj = new Alert();
        $outputData =  $alertObj->sendEmail($emailParams, 'crone');

        $data = array(
               'email'   =>  $emailParams->user_email,
               'subject' =>  $outputData->subject,
               'msg'     =>  $outputData->message
            );

        Mail::send('mail', $data, function( $message ) use ($data)
        {
            $message->to( $data['email'] )
            ->from( Config::get('mail.from.address'), Config('app.name'))
            ->subject( $data['subject']);
        });

    }
}
