<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Feedback;
use DateTime;
use Session;
use Auth;
class FeedbackReplyByToken
{
   
    public function handle($request, Closure $next)
    {
        $userId = 0;
        if(Auth::user()){
            $userId = Auth::user()->id;
        }
        $token = $request->route('token');
        $currentDateTime = new DateTime("now");
        $notPremit = false;
        $getFeedback =  Feedback::where('token', $token)->where('initiat_by', $userId)->first();
        if(!empty($getFeedback)){
            $expiryDateTime = new DateTime($getFeedback->expiry);
            if( $expiryDateTime < $currentDateTime){
                $notPremit = true;
                Session::flash('err_success', 'Token is Expire Log In for Reply!'); 
            }
        }else{
            Session::flash('err_success', 'Token is invalid!'); 
            $notPremit = true; 
        }
        if($notPremit == true){
             return redirect('feedback/create');
        }
        Session::flash('success', 'You can reply at once !');
        return $next($request);
    }
}
