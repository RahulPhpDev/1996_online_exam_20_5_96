<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Config;
// use Mail;
use stdClass;
use App\Model\Alert;
class ExamAttempt extends Command
{
    /**
     php artisan make:command ExamAlert --command alert:exam

     * The name and signature of the console command.
     *
     * @var string
     */
     // /usr/local/bin/php /home/ofdgxkwnaxeq/public_html/artisan examattempt:users >> /dev/null 2>&1   
    protected $signature = 'examattempt:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User who attempt Exam';

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
        $examAttemptToday = \DB::table('results as r')
                            ->whereRaw('Date(r.add_date) = CURDATE()-1')
                            ->groupBy('exam_id')
                            ->join('exams as e', 'e.id','=', 'r.exam_id')
                            ->get(['r.exam_id','exam_name']);
         $table =  '';
        foreach($examAttemptToday  as $keyd =>  $exam){                          
             $table.$keyd = "<p> $exam->exam_name </p>";        
              $table.$keyd .= "<table  width='50%'>
                  <tr>
                    <th> Id </th>
                    <th> ResultId </th>
                    <th> UserId </th>
                    <th> Name </th>
                    <th> Email </th>
                    <th> Obtain Mark </th>
                  </tr>";
            $registerUser = \DB::table('results as r')
                                ->whereRaw('Date(r.add_date) = CURDATE()-1')
                                ->where('r.exam_id','=', $exam->exam_id)
                               ->join('users', 'users.id', '=', 'r.user_id')
                              ->get(['r.id','users.id as user_id', 'fname', 'lname' ,'email','obtain_mark']);
                              
              foreach($registerUser as $key =>  $user){
               $table.$keyd .="
                <tr>
                    <td> ".++$key." </td>
                    <td> $user->id  </td>
                    <td> $user->user_id  </td>
                    <td> $user->fname $user->lname </td>
                    <td> $user->email </td>
                    <td> $user->obtain_mark  </td>
                 </tr>";  
              }  
             $table.$keyd .= '</table>';
             $table  =    $table.$keyd  ; 
          }
        // (==crone==) on (==date==) 
         //(==crone==),(==date==),(==count==),(==userlist==),(==crone==),(==date==)
        $emailParams = new stdClass;
        $emailParams->user_id = 1;
        $emailParams->user_email =  'mrrahul2016@gmail.com';
        $emailParams->alert_id = 4;
        $emailParams->subject_params = [$this->description,date('Y-m-d')];
        $emailParams->msg_params = [$this->description,date('Y-m-d'),count($examAttemptToday), $table, $this->description,date('Y-M-d')];
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
