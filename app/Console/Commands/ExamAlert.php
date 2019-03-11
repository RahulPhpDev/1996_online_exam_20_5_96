<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailable;
use Config;
// use Mail;
use stdClass;
use App\Model\Alert;
use App\User;
class ExamAlert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:exam';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Exam Create';

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

     "Put your knowledge to the test and prove your mastery by taking the Quiz..."
     by taking this helpful Quiz!

     php artisan alert:exam

     */
    public function handle()
    {
         $examAttemptToday = \DB::table('exams as r')
                            ->where('id', 42)
                            ->first();
         
        $emailParams = new stdClass;
        $emailParams->alert_id = 5;
        /*
            Subject :New Exam (==exam==) created
            Message: (==user==),(==exam==),(==totalQuestion==),(==time==),(==exam==)
        

        */
        $alertObj = new Alert();
        $allUser = User::where(array(
                ['user_type' ,'<>', 1 ],
                ['status', '=' , 1]
                )
            )->get(['email', 'fname','lname', 'id']);
        foreach($allUser as $user){    
             $userName = $user->getFullName(($user->id));    
            $emailParams->user_id = $user->id;
            $emailParams->user_email =  $user->email;    
            $emailParams->subject_params = [$examAttemptToday->exam_name];

            $emailParams->msg_params = [$userName,$examAttemptToday->exam_name,$examAttemptToday->total_question,$examAttemptToday->time,$examAttemptToday->exam_name];

            $outputData =  $alertObj->sendEmail($emailParams);
            $data = array(
                   'email'   =>  $emailParams->user_email,
                   'subject' =>  $outputData['subject'],
                   'msg'     =>  $outputData['msg'],
                );

            Mail::send('mail', $data, function( $message ) use ($data)
            {
                $message->to( $data['email'] )
                ->from( Config::get('mail.from.address'), Config('app.name'))
                ->subject( $data['subject']);
            });
        }
    }
}
