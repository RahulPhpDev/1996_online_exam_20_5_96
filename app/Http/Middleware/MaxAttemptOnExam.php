<?php

namespace App\Http\Middleware;

use Closure;
use Crypt;
use Auth;
use Redirect;
use Session;
use App\Model\Exam;
class MaxAttemptOnExam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $exam_data = Exam::find(Crypt::decrypt($request->id));
        $userData = Auth::user(); 
         // $route = $request->route();
         // dd($route->id);
        $userId = $userData['id'];
        $maxAttemptOfExam =  $exam_data['max_attempt'];
        if(!session()->has('exam_process')) { 
           $countOfUserAttemptExam = $exam_data->UserExamData()->where('user_id', $userId)->count();
           if($countOfUserAttemptExam >= $maxAttemptOfExam ){
            return redirect()->route('not-permit-exam',$request->id); 
           }
       }
       return $next($request);
    }
}
