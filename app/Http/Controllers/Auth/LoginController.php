<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Auth;
use App\User;
use Illuminate\Http\Request;

use Socialite;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    public $maxAttempts = 5;


    public $decayMinutes = 3; #mintues

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout(){
        $userId = Auth::user()->id;
        $ip = \Request::ip();
        $data = ['last_login_ip' => $ip,'last_login' => date('Y-m-d H:i:s')];
        User::where('id',$userId)->update($data);

    //      $rememberMeCookie = Auth::getRecallerName();
    // // Tell Laravel to forget this cookie
    // $cookie = Cookie::forget($rememberMeCookie);


    //     Session::flush(); 
         Auth::logout();
        return redirect('/');
    }


  public function login(\Illuminate\Http\Request $request) {
    $this->validateLogin($request);

    // If the class is using the ThrottlesLogins trait, we can automatically throttle
    // the login attempts for this application. We'll key this by the username and
    // the IP address of the client making these requests into this application.
    if ($this->hasTooManyLoginAttempts($request)) {
        $this->fireLockoutEvent($request);
        return $this->sendLockoutResponse($request);
    }

    // This section is the only change
    if ($this->guard()->validate($this->credentials($request))) {
        $user = $this->guard()->getLastAttempted();

        // Make sure the user is active
        if ($user->status  && $this->attemptLogin($request)) {
            // Send the normal successful login response
            return $this->sendLoginResponse($request);
        } else {
            Session::flash('login_status_message', 'Please Give Us Time To Approve your Credentials!'); 

            // Increment the failed login attempts and redirect back to the
            // login form with an error message.
            $this->incrementLoginAttempts($request);
            return redirect('/');
                // ->back()
                // ->withInput($request->only($this->username(), 'remember'))
                // ->withErrors(['active' => 'You must be active to login.']);
        }
    }


    // If the login attempt was unsuccessful we will increment the number of attempts
    // to login and redirect the user back to the login form. Of course, when this
    // user surpasses their maximum number of attempts they will get locked out.
    $this->incrementLoginAttempts($request);

    return $this->sendFailedLoginResponse($request);
}

// protected function hasTooManyLoginAttempts(Request $request)
//         {
//          return $this->limiter()->tooManyAttempts(
//                 $this->throttleKey($request), 2, 50
//             );

//         }

 public function redirectToProvider()
    {
        // return Socialite::driver('github')->redirect();
        return Socialite::driver('google')->redirect();
    }

     public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();
        $authUser = $this->findOrCreateUser($user, 'google');
        Auth::login($authUser, true);

        return redirect()->route('home');
    }


     private function findOrCreateUser($google, $from)
    {
        // dd($google->name);
       $nameArr =  explode(' ', $google->name);
       // dd(count($nameArr));

        $lastName = "";
        if(count($nameArr) > 1){
            $firstName = $nameArr[0];
            for($i = 1; $i < count($nameArr); $i++){
                $lastName = $lastName . $nameArr[$i].' ';
            }
        }
     $firstName ?? 'Not';
     $lastName ?? ' Found';
        $register_id = 2;
        if($from == 'google'){
            $register_id = 1;
        }else{
          $register_id = 2;
        }
        $authUser = User::where('register_id', $google->id)->first();

        if ($authUser){
            return $authUser;
        }
        if(is_null($google->email)){ 
            $google->email = $google->id.'fb@fb.com';
        }
        $userArray = array(
                'fname' => $firstName,
                'lname' => $lastName,
                'email' => $google->email,
                'register_id' => $google->id,
                'register_from' =>   $register_id,
                'password' =>bcrypt(12345),
                'profile_image' => $google->avatar,
                'user_type' => 3,
                'status' => 1,
                'add_date' => date("Y-m-d"),
            );

        return User::create($userArray);
    }


    public function redirectToProviderFb()
    {
        return Socialite::driver('facebook')->redirect();
    }

     public function handleProviderCallbackFb()
    {
        $user = Socialite::driver('facebook')->user();
        $authUser = $this->findOrCreateUser($user, 'facebook');
        Auth::login($authUser, true);
        return redirect()->route('home');
        
    }

}
