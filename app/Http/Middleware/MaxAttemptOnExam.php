<?php

namespace App\Http\Middleware;

use Closure;
use Crypt;
use Auth;
use Redirect;
use Session;
use App\Model\Exam;
use DB;
class MaxAttemptOnExam
{
   
    public function handle($request, Closure $next)
    {
        $exam_id = Crypt::decrypt($request->id);
        $exam_data = Exam::find($exam_id);
        $userData = Auth::user(); 
        $userId = $userData['id'];
        $maxAttemptOfExam =  $exam_data['max_attempt'];
       
        $data = DB::select("Select  sum( CASE 
                            WHEN attempt = 0 
                              THEN 999
                               ELSE attempt
                               END) as total_sum from extra_attempt where user_id = $userId && exam_id = $exam_id && status = 1 && (end_date  is null OR  end_date > CURDATE())");
        
        $extraAttempt = ( $data[0]->total_sum > 0) ?  $data[0]->total_sum : 0;
        $maxAttemptOfExam = $extraAttempt + $maxAttemptOfExam;
        if(!session()->has('exam_process') && ($maxAttemptOfExam > 0)) { 
           $countOfUserAttemptExam = $exam_data->Results()->where('user_id', $userId)->count();
// dd( $countOfUserAttemptExam );
           if($countOfUserAttemptExam >= $maxAttemptOfExam ){
            return redirect()->route('not-permit-exam',$request->id); 
           }
       }
       return $next($request);
    }
}
