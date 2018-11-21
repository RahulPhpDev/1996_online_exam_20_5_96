<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Model\Student;

use Image;
use File;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
       
        return Validator::make($data, [
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        //    'enrollment' => 'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:255|unique:students,enroll_number',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
         $user = User::create([
            'fname' => $data['fname'],
            'lname' => $data['lname'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'user_type' => 3,
            'status' => 1,
            'add_date' => date("Y-m-d"),
        ]);
      $id = $user->id;
      Student::create([
            'user_id' => $id,
            'address' => $data['address'],
           // 'enroll_number' => $data['enrollment'],
            'status' => 1,
         ]);
        $image = $data['profile'];
        $userDetailsByID = User::find($id);
        $input['imagename'] = 'profile_'.$id.'.'.$image->getClientOriginalExtension();
        $imagesPath =  public_path().'/images';
        $profilePath =  $imagesPath.'/profile';
        if(!File::exists($profilePath)) {
            File::makeDirectory($profilePath, 0777, true, true);
       }
       $destinationPath =$profilePath.'/thumbnail';
       if(!File::exists($destinationPath)) {
          File::makeDirectory($destinationPath, 0777, true, true);
         }
       $thumb_img = Image::make($image->getRealPath())->resize(250, 200);
       $thumb_img->save($destinationPath.'/'. $input['imagename'],80);

        // first load profile page in original
        $originalPath =  $profilePath.'/original';
        if(!File::exists($originalPath)) {
                File::makeDirectory($originalPath, 0777, true, true);
        }
        $image->move($originalPath, $input['imagename']);
        
        return $user;
//        ALTER TABLE `students` CHANGE `enroll_number` `enroll_number` VARCHAR(55) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
     
    }
}
