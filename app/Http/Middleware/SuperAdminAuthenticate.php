<?php

namespace App\Http\Middleware;
use Auth;
use Closure;

class SuperAdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = '')
    {
        $role = Auth::user();
        $r = $role['user_type'];
    
        if($r == 1){
            return $next($request);
        }else{
         return redirect('/');
        }
    }
}
